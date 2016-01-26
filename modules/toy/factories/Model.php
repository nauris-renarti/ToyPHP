<?php
/**
 * ToyPHP
 *
 * An open source application development framework for PHP 4 or newer
 *
 * @package		ToyPHP
 * @author		Nauris Dambis <nauris.renarti@gmail.com>
 * @copyright	Copyright (c) 20015 - 2016, Nauris Dambis
 * @license		https://github.com/nauris-renarti/ToyPHP/blob/master/LICENSE
 * @link		https://github.com/nauris-renarti/ToyPHP
 * @since		Version 1.0
 */

namespace toy\factories;

use \toy;
use \PDO;
use \PDOStatement;

/**
 * Class Model 
 *
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 * @created 01-jun-2015 9:55:44
 * 
 */
abstract class Model
{
	const HAS_ONE = 'has-one';
	const HAS_MANY = 'has-many';
	
	const JOIN = 'JOIN';
	const JOIN_LEFT = 'LEFT JOIN';
	const JOIN_RIGHT = 'RIGHT JOIN';
	
	/**
	 * 
	 * @param system $classname
	 * @return Model
	 */
	public static function create($classname = __CLASS__)
	{
		if ( !is_subclass_of($classname, __CLASS__) )
		{
			return null;
		}		
		$o = new $classname;
		return $o;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function fields()
	{
		return array();
	}
	
	public function metadata()
	{
		return array();
	}
	
	public function tableName()
	{
		return '';
	}
	
	/**
	 * 
	 * @return array
	 */
	public function pk()
	{
		return array();
	}
	
	public function relations()
	{
		return array();
	}
	
	public function relate()
	{
		static $map = false;
		if ($map === false) 
		{
			$map = toy::module()->config->valueOf('classmap','tables');
		}
		$table_name = $this->tableName();		
		$relations = $this->relations();		
		foreach (func_get_args() as $bind_property) {
			if (!isset($relations[$bind_property])) { 
				throw new Exception("Relation between ".get_class($this)." and {$bind_property} is not defined!");
			}			
			foreach ($relations[$bind_property] as $relation_type => $related_tables) {
				foreach ($related_tables as $related_table => $on) {
					$on_assoc = array();			
					$related_alias = $related_table.(($table_name == $related_table)? '1' : '');
					foreach ($on as $source_field => $related_field) {
						$on_assoc[] = "{$table_name}.{$source_field}={$related_alias}.{$related_field}";
					}					
					$params = array();					
					foreach ($this->pk() as $field) {
						$on_assoc[] = "{$table_name}.{$field}=:{$field}";
						$params[":{$field}"] = $this->$field;
					}					
					$sql = "SELECT {$related_alias}.* FROM  {$related_table} AS {$related_alias} JOIN {$table_name} AS {$table_name} ON (".join(' AND ', $on_assoc).");";
					//$relatedClassname = ucfirst($related_table).'Model';
					$relatedClassname = isset($map[$related_table])? $map[$related_table] : ucfirst($related_table).'Model';
					$stm = toy::module()->db->prepare($sql);
					$stm->execute($params);
					if ($relation_type == self::HAS_ONE) {
						$this->$bind_property = $stm->fetchObject($relatedClassname);
					}
					else {
						$this->$bind_property = $stm->fetchAll(PDO::FETCH_CLASS, $relatedClassname);
					}					
				}
			}			
		} 
	}
	
	public function insert()
	{
    	$this->beforeInsert();
    	
    	$insertable_fields = $this->fields();
    	$fields = array();
    	$params = array();
    	
    	foreach ($insertable_fields as $field) 
    	{
    		if (is_null($this->$field)) continue;    		
   			$fields[$field] = ":{$field}";
   			$params[":{$field}"] = $this->$field;
    	}
    	
    	$sql = sprintf("INSERT INTO %s (%s) VALUES (%s);", $this->tableName(), join(',', array_keys($fields)), join(',', array_values($fields)));
    	
    	$stm = toy::module()->db->prepare($sql);
    	$stm->execute($params);
    	$result = $stm->rowCount();

    	if ($result > 0) 
    	{
    		$this->afterInsert();
    	}
    	
    	return $result;
	}
	
	public function update()
	{
    	$this->beforeUpdate();
    	
    	$pk_fields = $this->pk();
    	$updateable_fields = array_diff($this->fields(), $pk_fields);
    	$fields = array();
    	$params = array();
    	$where = array();
    	
    	foreach ($updateable_fields as $field)
    	{
   			$fields[$field] = "{$field}=:{$field}";
   			$params[":{$field}"] = $this->$field;
    	}
    	
    	foreach ($pk_fields as $field)
    	{
    		$where[$field] = "{$field}=:{$field}";
    		$params[":{$field}"] = $this->$field;
    	}
    	
    	$sql = sprintf("UPDATE %s SET %s WHERE %s;", $this->tableName(), join(",", array_values($fields)), join(" AND ", array_values($where)));
    	 
    	$stm = toy::module()->db->prepare($sql);
    	$stm->execute($params);
    	$result = $stm->rowCount();

    	if ($result > 0) 
    	{
    		$this->afterUpdate();
    	}
    	
    	return $result;
	}
	
	public function delete()
	{
    	$this->beforeDelete();
    	
    	$pk_fields = $this->pk();
    	$params = array();
    	$where = array();
    	
    	foreach ($pk_fields as $field)
    	{
    		$where[$field] = "{$field}=:{$field}";
    		$params[":{$field}"] = $this->$field;
    	}
    	 
    	$sql = sprintf("DELETE FROM %s WHERE %s;", $this->tableName(), join(' AND ', array_values($where)));
    	
    	$stm = toy::module()->db->prepare($sql);
    	$stm->execute($params);
    	$result = $stm->rowCount();
    	 
    	if ($result > 0) 
    	{
    		$this->afterUpdate();
    	}
    	
    	return $result;
	}
	
	public function find($criteria = false, $like = false, $groupby = false, $orderby = false, $limit = 10)
	{
		$where = array();
		$params = array();
		
		if (is_array($criteria))
		{
			foreach ($criteria as $f => $v)
			{
				if ($like === false)
				{
					$where[] = "{$f} = :{$f}";
					$params[":{$f}"] = $v;
				}
				else 
				{
					$where[] = "{$f} LIKE :{$f}";
					$params[":{$f}"] = "%{$v}%";
				}
			}
		}
		
		$sql = sprintf("SELECT * FROM %s", $this->tableName());
		
		if (!empty($where)) {
			if ($like === false)
			{
				$sql.= sprintf(" WHERE %s", join(' AND ', $where));
			}
			else 
			{
				$sql.= sprintf(" WHERE %s", join(' OR ', $where));
			}
		}
		
		if ($groupby !== false) {
			$sql.= sprintf(" GROUP BY %s", $groupby);
		}
			
		if ($orderby !== false) {
			$sql.= sprintf(" ORDER BY %s", $orderby);
		}
		
		if ($limit !== false) {
			$sql.= sprintf(" LIMIT %d", (int) $limit);
		}
		
		$sql.= ';';
		
		$stm = toy::module()->db->prepare($sql);
		
		if (empty($params)) 
		{
			$stm->execute();
		}
		else 
		{
			$stm->execute($params);
		}
		
		if ($limit == 1)
		{
			return $stm->fetchObject(get_class($this));
		}
		else
		{
			return $stm->fetchAll(PDO::FETCH_CLASS, get_class($this));
		}
	}
	
	public function beforeInsert()
	{
		
	}
	
	public function afterInsert()
	{
		
	}
	
	public function beforeUpdate()
	{
		
	}
	
	public function afterUpdate()
	{
		
	}
	
	public function beforeDelete()
	{
		
	}
	
	public function afterDelete()
	{
		
	}
	
	public function findOne($criteria)
	{
		return $this->find($criteria, false, false, false, 1);
	}
	
	public function findByPk()
	{
		$criteria = array_combine($this->pk(), func_get_args());
		return $this->findOne($criteria);
	}
	
	public function findAll($groupby = false, $like = false, $orderby = false, $limit = 10)
	{
		return $this->find(false, $like, $groupby, $orderby, $limit);
	}
}

/* End of file Model.php */
/* Location: ./modules/toy/factories/Model.php */

