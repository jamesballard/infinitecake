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

        $summary = array();
        // Overall activity per week.
        $summary['ov'] = array(
            'config' => array(
                'Report' => array(
                    'name' => 'Weekly Activity',
                    'visualisation' => Report::VISUALISATION_LINE,
                    'height' => 400,
                    'startdate' => null,
                    'enddate' => null,
                    'datewindow' => '-3 years',
                    'rankorder' => '',
                    'ranklimit' => null,
                    'sortorder' => null,
                    'background-color' => '#ffffff',
                    'border-color' => '#dae5ec',
                    'border-width' => '1px',
                    'title' => array(
                        ),
                    ),
                    'plot-area' => array(
                        'margin' => '5px',
                    ),
                'Filter' => array(),
                'ReportDimension' => array(
                    array(
                        'model' => 'DimensionDate',
                        'parameter' => '3',
                        'type' => '1',
                        'Dimension' => array()
                    ),
                    array(
                        'model' => 'Period',
                        'parameter' => '1',
                        'type' => '2',
                        'Dimension' => array()
                    )
                ),
                'ReportValue' => array(
                    array(
                        'value_id' => '1',
                        'parameter' => '1',
                        'Value' => array(
                            'name' => 'Count activity',
                            'model' => 'Action',
                            'field' => '*',
                            'type' => '1',
                        )
                    )
                )
            )
        );

        $current_user = $this->get_currentUser();

        $systems = $this->System->find('all', array(
            'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
        ));
        $systems = Set::extract($systems, '{n}.System');

        $summary['ov']['config']['System'] = $systems;

        $report = $summary['ov']['config'];

        $dimensions = $this->Report->getDimensions($report);

        if ($this->Report->useLabels($dimensions->label, $report)) {
            $summary['ov']['data'] = $this->Report->getLabelledReportData(
                'COUNT(*)', // Select
                'Action', // From
                false, // Date cache
                $this->Report->getLabelledAxis($dimensions, $report), // x-Axis
                array(),
                $systems
            );
        }
        $this->set('summary', $summary);
        $this->set(compact('page', 'subpage', 'actions', 'persons', 'courses', 'latest'));
		$this->set('title_for_layout', $title);
		$this->render(implode('/', $path));
	}

}
