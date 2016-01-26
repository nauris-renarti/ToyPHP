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

use \ToyModule;

/**
 * Class Layout
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 * @version 1.0
 * @created 01-jun-2015 9:55:44
 * 
 */
abstract class Layout
{
	public $title = 'ToyPHP layout page';
	/**
	 * 
	 * @var \ToyModule
	 */
	public $module = null;
	
	/**
	 * 
	 * @var array
	 */
	public $head = array(
				'meta' => array(),
				'css'  => array(),
				'js'   => array(),
		);
	
	/**
	 * Useful meta
	 * 
	 * <meta name="description" content="">
	 * <meta name="keywords" content="">
	 * <meta name="author" content="">
	 */
	public function __construct(ToyModule $module = null)
	{
		$this->module = $module;
		
		$this->head['meta']['description'] = '';
		$this->head['meta']['keywords'] = '';
		$this->head['meta']['author'] = 'Nauris Dambis, nauris.renarti@gmail.com';
		$this->head['meta']['robots'] = 'index, follow';
	}
	
	/**
	 * 
	 */
	public function beginPage() 
	{
		
	}
	
	/**
	 * 
	 */
	public function head() 
	{
		// meta
		foreach ( $this->head['meta'] as $name => $value ) 
		{
			print "<meta name=\"{$name}\" content=\"{$value}\">\n";
		}
		
		// css
		foreach ( $this->head['css'] as $value ) 
		{
			print "<link href=\"{$value}\" rel=\"stylesheet\">\n";
		}
		
		// javascript
		foreach ( $this->head['js'] as $value ) 
		{
			print "<script src=\"{$value}\" type=\"text/javascript\"></script>\n";
		}
	}
	
	/**
	 * 
	 */
	public function beginBody() 
	{
		
	}
	
	/**
	 * 
	 */
	public function endBody() 
	{
		
	}
	
	/**
	 * 
	 */
	public function endPage() 
	{
		
	}
	
	/**
	 * 
	 */
	public function render($return = false)
	{
		if ($return) return '';
	}
	
}

/* End of file Layout.php */
/* Location: ./modules/toy/factories/Layout.php */
