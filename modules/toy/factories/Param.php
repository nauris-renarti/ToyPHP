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

/**
 * Class Param
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 * @created 01-jun-2015 9:55:44
 * 
 */
class Param
{
	/**
	 *
	 * @var string
	 */
	public $name = '';
	
	/**
	 * 
	 * @var unknown
	 */
	public $source;
	/**
	 *
	 * @var array
	 */
	private $_stream;

	/**
	 * Class constructor
	 *
	 * @param string $name
	 * @param string $stream
	 */
	public function __construct($name, $stream, $data)
	{
		$this->name =  $name;
		$this->source = $stream;
		$this->_stream =& $data;
	}

	/**
	 *
	 * @return null|string
	 */
	public function asString() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return filter_var($this->_stream[$this->name], FILTER_SANITIZE_STRING);
	}

	/**
	 * @return null|array
	 */
	public function asStringArray() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return preg_split('/(?<!^)(?!$)/u', filter_var($this->_stream[$this->name], FILTER_SANITIZE_STRING));
	}

	/**
	 * @return null|int
	 */
	public function asInteger() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return (int) filter_var($this->_stream[$this->name], FILTER_SANITIZE_NUMBER_INT);
	}

	/**
	 *
	 * @return null|boolean
	 */
	public function asBoolean() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return filter_var($this->_stream[$this->name], FILTER_VALIDATE_BOOLEAN);
	}

	/**
	 * Returns the input filtered as a float
	 *
	 * Use this property to get the value from the input as a float value.
	 * The input is sanitized to remove anything that might not be part of
	 * a float number.
	 *
	 * @param integer $flags Flags to be sent when getting the value asfloat
	 * @return null|float
	 */
	public function asFloat($flags = 0) 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return filter_var($this->_stream[$this->name], FILTER_SANITIZE_NUMBER_FLOAT, $flags);
	}

	/**
	 * Returns the input filtered as an email address
	 *
	 * Use this property to get the value from the input as an email.
	 * The input is sanitized to remove anything that might not be part of
	 * an email.
	 *
	 * @return null|string
	 */
	public function asEmail() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		if (filter_var($this->_stream[$this->name], FILTER_VALIDATE_EMAIL)) 
		{
			return filter_var($this->_stream[$this->name], FILTER_SANITIZE_EMAIL);
		}
		else 
		{
			return false;
		}
	}

	/**
	 * Returns the input filtered as an IP address
	 *
	 * Use this property to get the value from the input as an IP number.
	 * The input is validated to see if it's a valid IP and if not, an empty
	 * string is returned.
	 *
	 * @return null|string
	 */
	public function asIP() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return filter_var($this->_stream[$this->name], FILTER_VALIDATE_IP);
	}

	/**
	 * Returns the input filtered as an string
	 *
	 * Use this property to get the value from the input as string.
	 * The input is sanitized to remove anything that may cause a security
	 * issue.
	 *
	 * @return null|string
	 */
	public function asStripped() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return filter_var($this->_stream[$this->name], FILTER_SANITIZE_STRIPPED);
	}

	/**
	 *
	 * @return null|array
	 */
	public function asArray() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return is_array($this->_stream[$this->name])? $this->_stream[$this->name] : fasle;
	}

	/**
	 * HTML-escape '"<>& and characters with ASCII value less than 32, optionally
	 * strip or encode other special characters.
	 *
	 * @return null|string
	 */
	public function asSpecialChars() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return filter_var($this->_stream[$this->name], FILTER_SANITIZE_SPECIAL_CHARS);
	}

	/**
	 * Do nothing with the input
	 *
	 * Use it to get the input as-is, use it when you know, for sure, the
	 * input is safe.
	 *
	 * @return null|string
	 */
	public function asUnsafeRaw() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return filter_var($this->_stream[$this->name], FILTER_UNSAFE_RAW);
	}

	/**
	 *
	 * @return null|stdClass
	 */
	public function asObject() {
		if (!isset($this->_stream[$this->name])) return false;
		return rti::app()->encoder()->decrypt( $this->asString() );
	}
	
	/**
	 * 
	 * @param string $format
	 * @return string
	 */
	public function asDate($format = 'Y-m-d H:i:s') 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return date($format, $this->asInteger());
	}
	
	/**
	 * 
	 * @return number
	 */
	public function asUnixTime() 
	{
		if (!isset($this->_stream[$this->name])) return false;
		return strtotime($this->asString(), 0);
	}



}

/* End of file Param.php */
/* Location: ./modules/toy/factories/Param.php */