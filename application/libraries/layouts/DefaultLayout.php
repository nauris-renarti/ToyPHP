<?php

namespace libraries\layouts;

use \toy;
use \toy\factories\Layout;

/**
 * Class DefaultLayout
 * 
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 *
 */
class DefaultLayout extends Layout
{
	/**
	 * (non-PHPdoc)
	 * @see \toy\factories\Layout::render()
	 */
	public function render($return = false)
	{
		require APPPATH . 'welcome.html.php';
	}
}