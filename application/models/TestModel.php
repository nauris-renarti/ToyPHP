<?php

namespace models;

use \toy;
use \toy\factories\Model;

/**
 * Class TestModel
 * @autor RENARTI model auto generator
 * @created 2016-01-25 11:35:39
 * @version 1.0		
 */
class TestModel extends Model 
{
	public $id; // PRI int(11) NULL NO DEFAULT NULL EXTRA auto_increment
	public $dateCreate; //  datetime NULL NO DEFAULT NULL EXTRA 
	public $textField; //  varchar(64) NULL YES DEFAULT NULL EXTRA 

    /**
     * @param string $classname
     * @return \models\TestModel
     */
    public static function create($classname = __CLASS__) 
    {
        return parent::create($classname);
    } 
    
    /**
     * @return string Table name
     */
    public function tableName() 
    {
    	return 'test';
    }
    
    /**
     * @return array PK columns
     */
    public function pk() 
    {
    	return array('id');
    }
    
    /**
     * @return array Table columns
     */
    public function fields() 
    {
    	return array('id','dateCreate','textField');
    }    
    
    /**
     * 
     * @return array
     */
    public function relations() 
    {
		$relations = array();
    	return $relations;
    }
    
    /**
     * 
     */
    public function beforeInsert() 
    {
    	
    }
    
    /**
     * 
     */
    public function afterInsert() 
    {

    }
    
    /**
     * 
     */
    public function beforeUpdate() 
    {
    	
    }
    
    /**
     * 
     */
    public function afterUpdate() 
    {
    	
    }
    
    /**
     * 
     */
    public function beforeDelete() 
    {
    	
    }
    
    /**
     * 
     */
    public function afterDelete() 
    {
    	
    }
	
}

/* End of file TestModel.php */
/* Location: <application>/models/TestModel.php */
     		     						