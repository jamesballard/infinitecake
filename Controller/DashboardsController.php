<?php
App::uses('AppController', 'Controller');
/**
 * Dashboards Controller
 *
 * @property Dashboard $Dashboard
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DashboardsController extends AppController {

    public $uses = array('Dashboard', 'Person', 'User', 'Course', 'Group', 'Report', 'Action');
	public $components = array('Paginator', 'Session');
    public $helpers = array('dynamicForms.dynamicForms', 'zingCharts.zingCharts');

    /**
 * user method
 *
 * @param integer $id
 * @return void
 */
    public function user($id = null) {
        if($id){
            $this->Session->write('Dashboard.user', $id);
        }
        //Create selected user as session variable.
        $userid = $this->Session->read('Dashboard.user');
        if ($this->request->is('post')) {
            $userid = $this->request->data['Dashboard']['userid'];
            $this->set('userid', $userid);
            $this->set('userdefault', $userid);
            $this->Session->write('Dashboard.user', $userid);
        }
        if ($userid) {
            $selecteduser = $this->Person->find('first',array(
                    'conditions' => array('id' => $userid),
                    'contain' => false,
                    'fields' => array('idnumber'),
                )
            );
            $this->set('userid', $userid);
            $this->set('userdefault', $selecteduser['Person']['idnumber']);
        } else {
            $this->set('userid','');
            $this->set('userdefault','');
        }
    }

    /**
     * Return JSON chart details for user weekly activity dashboard chart
     * @param $userid
     * @return CakeResponse
     */
    public function userweekly($userid) {

        // Set the Report.
        $report = array(
            'Report' => array(
                'name' => 'User Activity',
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-3 months',
                'rankorder' => '',
                'ranklimit' => null,
                'sortorder' => null,
            ),
            'Filter' => array(),
            'ReportDimension' => array(
                array(
                    'model' => 'DimensionDate',
                    'parameter' => '2',
                    'type' => '1',
                    'Dimension' => array()
                ),
                array(
                    'model' => '',
                    'parameter' => '',
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
            ),
            'where' => array(
                'Person.id' => $userid
            )
        );

        $current_user = $this->get_currentUser();

        $systems = $this->System->find('all', array(
            'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
        ));
        $systems = Set::extract($systems, '{n}.System');

        $report['System'] = $systems;

        $dimensions = $this->Report->getDimensions($report);

        $data = $this->Report->getReportDataFlat(
            'COUNT(*)', // Select
            'Action', // From
            false, // Date cache
            $this->Report->getAxis($dimensions, $report), // x-Axis
            $report['where'],
            $systems
        );

        $max = max(array_values($data));

        $chart = array(
            'graphset' => array(
                array(
                    'id' => 'userweekly',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '100%',
                    'type' => 'hbar',
                    'scale-x' => array(
                        'values' => array_keys($data),
                        'line-color' => 'none',
                        'item' => array(
                            'width' => 200,
                            'text-align' => 'left',
                            'offset-x' => 206,
                            'offset-y' => -10,
                            'font-color' => '#8391a5',
                            'font-family' => 'Arial',
                            'font-size' => '11px',
                            'padding-bottom' => '8px'
                        ),
                        'tick' => array(
                            'visible' => false
                        ),
                        'guide' => array(
                            'visible' => false
                        )
                    ),
                    'scale-y' => array(
                        'line-color' => 'none',
                        'tick' => array(
                            'visible' => false,
                        ),
                        'item' => array(
                            'visible' => false,
                        ),
                        'guide' => array (
                            'visible' => false,
                        )
                    ),
                    'plotarea' => array(
                        'margin' => '5 5 10 5',
                        'padding' => 0,
                    ),
                    'plot' => array(
                        'bars-overlap' => '100%',
                        'bar-width' => '12px',
                        'thousands-separator' => ',',
                        'tooltip' => array(
                            'font-color' => '#ffffff',
                            'background-color' => '#707e94',
                            'font-family' => 'Arial',
                            'font-size' => '11px',
                            'border-radius' => '6px',
                            'shadow' => false,
                            'padding' => '5px 10px',
                        ),
                        'hover-state' => array(
                            'background-color' => '#118e94'
                        )
                    ),
                    'series' => array(
                        array(
                            'values' => array_values($data),
                            '-animation' => array(
                                'method' => 0,
                                'effect' => 4,
                                'speed' => 2000,
                                'sequence' => 0
                            ),
                            'z-index' => 2,
                            'styles' => array(
                                'background-color' => array_values(array_fill_keys(array_keys($data), "#4dbac0"))
                            ),
                            'tooltip-text' => '%node-value'
                        ),
                        array(
                            'max-trackers' => 0,
                            'values' => array_values(array_fill_keys(array_keys($data), $max)),
                            'data-rvalues' => array_values($data),
                            'background-color' => '#d9e4eb',
                            'z-index' => 1,
                            'value-box' => array(
                                'visible' => true,
                                'offset-y' => '-10px',
                                'offset-x' => '-64px',
                                'text-align' => 'right',
                                'font-color' => '#8391a5',
                                'font-family' => 'Arial',
                                'font-size' => '11px',
                                'text' => 'Total: %data-rvalues',
                                'padding-bottom' => '8px'
                            )
                        )
                    )
                )
            )
        );
        return new CakeResponse(array('body' => json_encode($chart)));
    }

    /**
     * Return JSON chart details for user weekly activity dashboard chart
     * @param $userid
     * @return CakeResponse
     */
    public function usertypes($userid) {

        // Set the Report.
        $report = array(
            'Report' => array(
                'name' => 'Task Types',
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-3 months',
                'rankorder' => '',
                'ranklimit' => null,
                'sortorder' => null,
            ),
            'Filter' => array(),
            'ReportDimension' => array(
                array(
                    'model' => 'Rule',
                    'parameter' => '1',
                    'type' => '1',
                    'Dimension' => array()
                ),
                array(
                    'model' => '',
                    'parameter' => '',
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
            ),
            'where' => array(
                'Person.id' => $userid
            )
        );

        $current_user = $this->get_currentUser();

        $systems = $this->System->find('all', array(
            'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
        ));
        $systems = Set::extract($systems, '{n}.System');

        $report['System'] = $systems;

        $dimensions = $this->Report->getDimensions($report);

        $data = $this->Report->getReportDataFlat(
            'COUNT(*)', // Select
            'Action', // From
            false, // Date cache
            $this->Report->getAxis($dimensions, $report), // x-Axis
            $report['where'],
            $systems
        );

        $pie = array();
        foreach ($data as $k => $v) {
            $pie[] = array(
                'text' => $k,
                'values' => array($v)
            );
        }

        $chart = array(
            'graphset' => array(
                array(
                    'id' => 'usertypes',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '100%',
                    'type' => 'pie3d',
                    'series' => $pie,
                    'plot-area' => array(
                        'margin' => '5px',
                    ),
                    'tooltip' => array(
                        'text' => "%t: %v (%npv%)",
                    )
                )
            )
        );
        return new CakeResponse(array('body' => json_encode($chart)));
    }


    /**
     * Return JSON chart details for user weekly activity dashboard chart
     * @param $userid
     * @return CakeResponse
     */
    public function usertime($userid) {

        // Set the Report.
        $report = array(
            'Report' => array(
                'name' => 'Task Types',
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-3 months',
                'rankorder' => '',
                'ranklimit' => null,
                'sortorder' => null,
            ),
            'Filter' => array(),
            'ReportDimension' => array(
                array(
                    'model' => 'DimensionTime',
                    'parameter' => '0',
                    'type' => '1',
                    'Dimension' => array()
                ),
                array(
                    'model' => 'DimensionTime',
                    'parameter' => '0',
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
            ),
            'where' => array(
                'Person.id' => $userid
            )
        );

        $current_user = $this->get_currentUser();

        $systems = $this->System->find('all', array(
            'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
        ));
        $systems = Set::extract($systems, '{n}.System');

        $report['System'] = $systems;

        $dimensions = $this->Report->getDimensions($report);

        $data = $this->Report->getLabelledReportData(
            'COUNT(*)', // Select
            'Action', // From
            false, // Date cache
            $this->Report->getLabelledAxis($dimensions, $report), // x-Axis
            $report['where'],
            $systems
        );

        $series = array();
        foreach($data as $label => $values) {
            $scaleK = array_keys($values);
            $series[] = array(
                'text' => $label,
                'values' => array_values($values)
            );
        }

        $chart = array(
            'graphset' => array(
                array(
                    'id' => 'usertime',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '100%',
                    'type' => 'radar',
                    'legend' => array(
                        'layout' => 'x4',
                        'marker' => array(
                            'type' => 'circle'
                        )
                    ),
                    'tooltip' => array(
                        'text' => "%v"
                    ),
                    'plot' => array(
                        'aspect' => 'rose'
                    ),
                    'scale-k' => array(
                        'aspect' => 'circle',
                        'values' => $scaleK
                    ),
                    'series' => $series
                )
            )
        );
        return new CakeResponse(array('body' => json_encode($chart)));
    }

/**
 * user method
 *
 * @param integer $id
 * @return void
 */
    public function course($id=null) {
        if($id){
            $this->Session->write('Dashboard.course', $id);
        }
        //Create selected user as session variable.
        $courseid = $this->Session->read('Dashboard.course');
        if ($this->request->is('post')) {
            $courseid = $this->request->data['Dashboard']['courseid'];
            $this->set('courseid', $courseid);
            $this->set('coursedefault', $courseid);
            $this->Session->write('Dashboard.course', $courseid);
        }
        if ($courseid) {
            $selectedcourse = $this->Group->find('first', array(
                    'conditions' => array('id' => $courseid),
                    'contain' => false,
                    'fields' => array('idnumber'),
                )
            );
            $this->set('courseid', $courseid);
            $this->set('coursedefault', $selectedcourse['Group']['idnumber']);
        } else {
            $this->set('courseid','');
            $this->set('coursedefault','');
        }
    }

    /**
     * Return JSON chart details for groups dashboard chart
     * @param $courseid
     * @return CakeResponse
     */
    public function groups($courseid) {

        // Set the Report.
        $report = array(
            'Report' => array(
                'name' => 'User Activity',
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-3 months',
                'rankorder' => '',
                'ranklimit' => null,
                'sortorder' => null,
            ),
            'UserGroup' => array(
                'groupid' => $courseid
            ),
            'Filter' => array(),
            'ReportDimension' => array(
                array(
                    'model' => 'User',
                    'parameter' => '0',
                    'type' => '1',
                    'Dimension' => array()
                ),
                array(
                    'model' => '',
                    'parameter' => '',
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
            ),
            'where' => array(
                'Group.id' => $courseid
            )
        );

        $current_user = $this->get_currentUser();

        $systems = $this->System->find('all', array(
            'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
        ));
        $systems = Set::extract($systems, '{n}.System');

        $report['System'] = $systems;

        $dimensions = $this->Report->getDimensions($report);

        $data = $this->Report->getReportDataFlat(
            'COUNT(*)', // Select
            'Action', // From
            false, // Date cache
            $this->Report->getAxis($dimensions, $report), // x-Axis
            $report['where'],
            $systems
        );

        $chart = array(
            'graphset' => array(
                array(
                    'id' => 'group',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '50%',
                    'type' => 'bar',
                    'scale-x' => array(
                        'values' => array_keys($data),
                        'zooming' => true,
                        'zoom-to' => '[0,50]',
                        'item' => array(
                            'visible' => false
                        )
                    ),
                    'scroll-x' => array(),
                    'plotarea' => array(
                        'margin' => '5px 20px 100px 50px'
                    ),
                    'preview' => array(
                        'position' => "50% 95%",
                        'background-color' => 'transparent'
                    ),
                    'plot' => array(
                        'tooltip' => array(
                            'text' => '%k: %v'
                        )
                    ),
                    'series' => array(
                        array(
                            'values' => array_values($data),
                            'url' => '/Dashboards/groupuser/%k',
                            'target' => 'graph=groupUser'
                        )
                    )
                ),
                array(
                    'id' => 'groupUser',
                    'x' => '0%',
                    'y' => '50%',
                    'width' => '100%',
                    'height' => '50%',
                    'type' => 'null',
                    'labels' => array(
                        array(
                            'text' => 'Click on a user above to view stats for that user',
                            'width' => 400,
                            'height' => 40,
                            'margin' => '20px 0',
                            'border-width' => 2,
                            'border-radius' => 10,
                            'padding' => 20,
                            'background-color' => '#fff'
                        )
                    )
                )
            )
        );
        return new CakeResponse(array('body' => json_encode($chart)));
    }

    public function groupuser($userid) {

        $user = $this->User->find('first', array(
            'conditions' => array('idnumber' => $userid),
            'contain' => false,
            'fields' => array('id')
        ));

        $report = array(
            'Report' => array(
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-2 months',
                'rankorder' => '',
                'ranklimit' => null,
                'sortorder' => null,

            ),
            'Filter' => array(),
            'ReportDimension' => array(
                array(
                    'model' => 'DimensionDate',
                    'parameter' => '2',
                    'type' => '1',
                    'Dimension' => array()
                ),
                array(
                    'model' => '',
                    'parameter' => '',
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
            ),
            'where' => array(
                'User.id' => $user['User']['id']
            )
        );

        $current_user = $this->get_currentUser();

        $systems = $this->System->find('all', array(
            'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
        ));
        $systems = Set::extract($systems, '{n}.System');

        $report['System'] = $systems;

        $dimensions = $this->Report->getDimensions($report);

        if ($this->Report->useLabels($dimensions->label, $report)) {
            $data = $this->Report->getLabelledReportData(
                'COUNT(*)', // Select
                'Action', // From
                false, // Date cache
                $this->Report->getLabelledAxis($dimensions, $report), // x-Axis
                $report['where'],
                $systems
            );
        } else {
            $data = $this->Report->getReportDataFlat(
                'COUNT(*)', // Select
                'Action', // From
                false, // Date cache
                $this->Report->getAxis($dimensions, $report), // x-Axis
                $report['where'],
                $systems
            );
        }

        $max = max(array_values($data));

        $chart = array(
            'graphset' => array(
                array(
                    'id' => 'groupUser',
                    'x' => '0%',
                    'y' => '50%',
                    'width' => '100%',
                    'height' => '50%',
                    'type' => 'hbar',
                    'title' => array(
                        'text' => "Activity for $userid during last 2 months"
                    ),
                    'plotarea' => array(
                        'margin' => '40px 20px 30px 50px',
                    ),
                    'scale-y' => array(
                        'line-color' => 'none',
                        'tick' => array(
                            'visible' => false,
                        ),
                        'item' => array(
                            'visible' => false,
                        ),
                        'guide' => array(
                            'visible' => false,
                        )
                    ),
                    'scale-x' => array(
                        'values' => array_keys($data),
                        'line-color' => 'none',
                        'item' => array(
                            'width' => 200,
                            'text-align' => 'left',
                            'offset-x' => 206,
                            'offset-y' => -10,
                            'font-color' => '#8391a5',
                            'font-family' => 'Arial',
                            'font-size' => '11px',
                            'padding-bottom' => '8px'
                        ),
                        'tick' => array(
                            'visible' => false
                        ),
                        'guide' => array(
                            'visible' => false
                        )
                    ),
                    'plot' => array(
                        'bars-overlap' => '100%',
                        'bar-width' => '12px',
                        'border-radius-top-right' => 0,
                        'border-radius-top-left' => 0,
                        'hover-state' => array(
                            'background-color' => '#118e94'
                        )
                    ),
                    'series' => array(
                        array(
                            'values' => array_values($data),
                            '-animation' => array(
                                'method' => 0,
                                'effect' => 4,
                                'speed' => 2000,
                                'sequence' => 0
                            ),
                            'z-index' => 2,
                            'styles' => array(
                                'background-color' => "#4dbac0"
                            ),
                            'tooltip-text' => '%node-value'
                        ),
                        array(
                            'max-trackers' => 0,
                            'values' => array_values(array_fill_keys(array_keys($data), $max)),
                            'data-rvalues' => array_values($data),
                            'background-color' => '#d9e4eb',
                            'z-index' => 1,
                            'value-box' => array(
                                'visible' => true,
                                'offset-y' => '-10px',
                                'offset-x' => '-64px',
                                'text-align' => 'right',
                                'font-color' => '#8391a5',
                                'font-family' => 'Arial',
                                'font-size' => '11px',
                                'text' => 'Total: %data-rvalues',
                                'padding-bottom' => '8px'
                            )
                        )
                    )
                )
            )
        );
        return new CakeResponse(array('body' => json_encode($chart)));
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Dashboard->recursive = 0;
		$this->set('dashboards', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Dashboard->exists($id)) {
			throw new NotFoundException(__('Invalid dashboard'));
		}
		$options = array('conditions' => array('Dashboard.' . $this->Dashboard->primaryKey => $id));
		$this->set('dashboard', $this->Dashboard->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Dashboard->create();
			if ($this->Dashboard->save($this->request->data)) {
				$this->Session->setFlash(__('The dashboard has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dashboard could not be saved. Please, try again.'));
			}
		}
		$customers = $this->Dashboard->Customer->find('list');
		$reports = $this->Dashboard->Report->find('list');
		$this->set(compact('customers', 'reports'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Dashboard->exists($id)) {
			throw new NotFoundException(__('Invalid dashboard'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Dashboard->save($this->request->data)) {
				$this->Session->setFlash(__('The dashboard has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dashboard could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Dashboard.' . $this->Dashboard->primaryKey => $id));
			$this->request->data = $this->Dashboard->find('first', $options);
		}
		$customers = $this->Dashboard->Customer->find('list');
		$reports = $this->Dashboard->Report->find('list');
		$this->set(compact('customers', 'reports'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Dashboard->id = $id;
		if (!$this->Dashboard->exists()) {
			throw new NotFoundException(__('Invalid dashboard'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Dashboard->delete()) {
			$this->Session->setFlash(__('The dashboard has been deleted.'));
		} else {
			$this->Session->setFlash(__('The dashboard could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
