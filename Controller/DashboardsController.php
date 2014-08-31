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

    public $uses = array('Dashboard', 'Person', 'Course', 'Report', 'Action');
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

            $dashboards = array();
            // Overall activity per week.
            $dashboards['wk'] = array(
                'config' => array(
                    'Report' => array(
                        'name' => 'Weekly Activity',
                        'visualisation' => Report::VISUALISATION_BAR,
                        'startdate' => null,
                        'enddate' => null,
                        'datewindow' => '-3 months',
                        'rankorder' => '',
                        'ranklimit' => null,
                        'sortorder' => null,
                        'background-color' => '#ffffff',
                        'border-color' => '#dae5ec',
                        'border-width' => '1px',
                        'title' => array(
                            'text' => 'Weekly Activity',
                            'margin-top' => '7px',
                            'margin-left' => '9px',
                            'background-color' => 'none',
                            'shadow' => 0,
                            'text-align' => 'left',
                            'font-family' => 'Arial',
                            'font-size' => '11px',
                            'font-color' => '#707d94'
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
                        'scale-x' => array(
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
                        'plot-area' => array(
                            'margin' => '5px',
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
                                'values' => 'plot',
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
                                'values' => 'max',
                                'data-rvalues' => 'raw',
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
                        ),
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
                    )
                )
            );
            // Overall activity per week.
            $dashboards['module'] = array(
                'config' => array(
                    'Report' => array(
                        'name' => 'Task types',
                        'visualisation' => Report::VISUALISATION_PIE,
                        'startdate' => null,
                        'enddate' => null,
                        'datewindow' => '-2 months',
                        'rankorder' => '',
                        'ranklimit' => null,
                        'sortorder' => null,
                        'background-color' => '#ffffff',
                        'border-color' => '#dae5ec',
                        'border-width' => '1px',
                        'title' => array(
                            'text' => 'Task types',
                            'margin-top' => '7px',
                            'margin-left' => '9px',
                            'background-color' => 'none',
                            'shadow' => 0,
                            'text-align' => 'left',
                            'font-family' => 'Arial',
                            'font-size' => '11px',
                            'font-color' => '#707d94'
                        ),
                        'plot-area' => array(
                            'margin' => '5px',
                        ),
                        'plot' => array(
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
                        ),
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
                    )
                )
            );
            // Overall activity per week.
            $dashboards['hour'] = array(
                'config' => array(
                    'Report' => array(
                        'name' => 'Time of day',
                        'visualisation' => Report::VISUALISATION_RADAR,
                        'startdate' => null,
                        'enddate' => null,
                        'datewindow' => '-4 months',
                        'rankorder' => '',
                        'ranklimit' => null,
                        'sortorder' => null,
                        'background-color' => '#ffffff',
                        'border-color' => '#dae5ec',
                        'border-width' => '1px',
                        'title' => array(
                            'text' => 'Time of day',
                            'margin-top' => '7px',
                            'margin-left' => '9px',
                            'background-color' => 'none',
                            'shadow' => 0,
                            'text-align' => 'left',
                            'font-family' => 'Arial',
                            'font-size' => '11px',
                            'font-color' => '#707d94'
                        ),
                        'plot-area' => array(
                            'margin' => '5px',
                        ),
                        'plot' => array(
                            'thousands-separator' => ',',
                            'tooltip' => array(
                                'font-color' => '#ffffff',
                                'background-color' => '#707e94',
                                'font-family' => 'Arial',
                                'font-size' => '11px',
                                'border-radius' => '6px',
                                'shadow' => false,
                                'padding' => '5px 10px',
                            )
                        )
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
                    )
                )
            );

            $current_user = $this->get_currentUser();

            $systems = $this->System->find('all', array(
                'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
            ));
            $systems = Set::extract($systems, '{n}.System');

            foreach($dashboards as $key => $config) {
                $dashboards[$key]['config']['System'] = $systems;

                $report = $dashboards[$key]['config'];

                $dimensions = $this->Report->getDimensions($report);

                if ($this->Report->useLabels($dimensions->label, $report)) {
                    $dashboards[$key]['data'] = $this->Report->getLabelledReportData(
                        'COUNT(*)', // Select
                        'Action', // From
                        false, // Date cache
                        $this->Report->getLabelledAxis($dimensions, $report), // x-Axis
                        array( // Conditions.
                            'Person.id' => $userid
                        ),
                        $systems
                    );
                } else {
                    $dashboards[$key]['data'] = $this->Report->getReportData(
                        'COUNT(*)', // Select
                        'Action', // From
                        false, // Date cache
                        $this->Report->getAxis($dimensions, $report), // x-Axis
                        array( // Conditions.
                            'Person.id' => $userid
                        ),
                        $systems
                    );
                }
            }

            $this->set('dashboards', $dashboards);

        } else {
            $this->set('userid','');
            $this->set('userdefault','');
        }
    }

/**
 * user method
 *
 * @param integer $id
 * @return void
 */
    public function course($id) {
        $this->Dashboard->recursive = 0;
        $this->set('dashboards', $this->Paginator->paginate());
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
