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

namespace toy\services;

use \toy;
use \Exception;

/**
 * Class Translator
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 * @created 01-jun-2015 9:55:46
 * 
 */
class Translator
{
	/**
	 * 
	 * @var string
	 */
    public $csvDelimiter = "\t";
    
    /**
     *
     * @var array
     */
    public $data = array();
    
    public function __destruct()
    {
    	//rti::app()->event()->fire(self::I18N_EVENT_UPDATE);
    }
    
    /**
     *
     * @param string|array $filename
     * @throws Exception
     * @return boolean
     */
    public function read($language, $filename) 
    {
    	if (is_array($filename))
    	{
    		foreach ($filename as $file) 
    		{
    			$this->read($language, $file);
    		}
    	}
    	else
    	{
    		$pathes = array(
    				$filename,
    				$filename.'.php',
    				APPPATH.'i18n/'.$language.'/'.$filename.'.php',
    				APPPATH.'i18n/'.$language.'/'.$filename,
    				APPPATH.'i18n/'.$filename.'.php',
    				APPPATH.'i18n/'.$filename,
    		);
    		 
            foreach ($pathes as $fname)
            {                
                if (!is_file($fname)) continue;   

                $translations = @require $fname;
                
                foreach ($translations as $k => $v)
                {
                	$this->data[$k] = $v;
                }
                
				return true;
            }      
            
            throw new Exception("Unable to load requested translation file $filename");
    	}
    }
    
    /**
     *
     * @param string|array $filename
     * @throws Exception
     * @return boolean
     */
    public function readCsv($language, $filename)
    {
        if (is_array($filename))
        {
            foreach ($filename as $file) 
            {
                $this->readCsv($language, $file);
            }
        }
        else
        {
            $pathes = array(
                        $filename,
                        $filename.'.csv',
                        APPPATH.'i18n/'.$language.'/'.$filename.'.csv',
                        APPPATH.'i18n/'.$language.'/'.$filename,
                        APPPATH.'i18n/'.$filename.'.csv',
                        APPPATH.'i18n/'.$filename,
            ); 
                       
            foreach ($pathes as $fname)
            {                
                if (!is_file($fname)) continue;   
                             
                if ($handle = fopen($fname,'r'))
                {
                    while (($row = fgetcsv($handle, 2048, $this->csvDelimiter) ) !== false)
                    {
                        if (empty($row[0])) continue;
                        $k = $row[0];
                        $v = isset($row[1])? $row[1] : $row[0];
                        $this->data[$k] = $v;
                    }  
                    
                    fclose($handle);
                } 
                
				return true;
            }      
            
            throw new Exception("Unable to load requested translation CSV file $filename");
        }
    }
    
    function addArray($value)
    {
    	$this->data = array_merge($this->data, $value);
    	return $this;
    }
    
    /**
     * 
     * @param string $key
     * @return multitype:
     */
    function get($key)
    {
        if (!isset($this->data[$key])) 
        {
            $this->data[$key] = $key;
        }
        return $this->data[$key];
    }
    
    
}

/* End of file Translator.php */
/* Location: ./modules/toy/services/Translator.php */