<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Action', 'Person', 'Course', 'Report');
    public $helpers = array('zingCharts.zingCharts');
/**
 * Displays a view
 *
 * @param string What page to display
 */
	public function display() {
		$path = func_get_args();

        $current_user = $this->get_currentUser();
        $actions = $this->Action->countCustomerActions($current_user['Member']['customer_id']);
        $persons = $this->Person->countCustomerPeople($current_user['Member']['customer_id']);
        $courses = $this->Course->countCustomerCourses($current_user['Member']['customer_id']);
        $latest = $this->Action->getLatest($current_user['Member']['customer_id']);
        $latest = new DateTime($latest[0]['latest']);

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}

        // Change templates based on Config/templates.php
        $this->layout = Configure::read('layout.'.$page);

        $this->set(compact('page', 'subpage', 'actions', 'persons', 'courses', 'latest'));
		$this->set('title_for_layout', $title);
		$this->render(implode('/', $path));
	}

}
