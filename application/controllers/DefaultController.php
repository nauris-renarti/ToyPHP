<?php

namespace controllers;

use \toy;
use \ToyController;

/**
 * Class DefaultController
 * @author Nauris Dambis <nauris.renarti@gmail.com>
 *
 */
class DefaultController extends ToyController
{
	/**
	 * Controller default action
	 */
	public function actionIndex()
	{
		// include HTML file		
		require APPPATH . 'welcome.html.php';
	}
}

/* End of file DefaultController.php */
/* Location: ./application/controllers/Calendar.php */
