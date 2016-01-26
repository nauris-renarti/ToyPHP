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

/**
 * Class Encoder
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 *
 */
class Encoder
{
	/**
	 * 
	 * @var unknown
	 */
	public $key = 'My Supper Secret Key 1234567890';

	/**
	 * 
	 * @var unknown
	 */
	public $mode = MCRYPT_MODE_CFB;

	/**
	 * 
	 * @var unknown
	 */
	public $chiper = MCRYPT_BLOWFISH;

	/**
	 * 
	 * @var unknown
	 */
	private $_shakey;
	
	/**
	 * 
	 * @var unknown
	 */
	private $_iv_size;
	
	/**
	 * 
	 * @param unknown $args
	 */
	public function __construct()
	{
		foreach (toy::module('toy')->config->valueOf(__CLASS__) as $k => $v) 
		{
			$this->$k = $v;
		}
		
		$this->_shakey = hash('sha256', $this->key, true);
		
		$this->_iv_size = mcrypt_get_iv_size($this->chiper, $this->mode);
	}

	/**
	 *
	 * @param unknown $value
	 * @return mixed
	 */
	public function encrypt($value)
	{
		$iv = mcrypt_create_iv($this->_iv_size, MCRYPT_RAND);
		$ciphertext = mcrypt_encrypt($this->chiper, $this->_shakey, @serialize($value), $this->mode, $iv);
		return str_replace(array('+', '/'), array('-', '_'), base64_encode($iv.$ciphertext));
	}

	/**
	 *
	 * @param unknown $value
	 */
	public function decrypt($value)
	{
		$ciphertext_dec = base64_decode( str_replace(array('-', '_'), array('+', '/'), $value) );
		$iv_dec = substr($ciphertext_dec, 0, $this->_iv_size);
		$ciphertext_dec = substr($ciphertext_dec, $this->_iv_size);
		return @unserialize(mcrypt_decrypt($this->chiper, $this->_shakey, $ciphertext_dec, $this->mode, $iv_dec));
	}

}

/* End of file Encoder.php */
/* Location: ./modules/toy/services/Encoder.php */