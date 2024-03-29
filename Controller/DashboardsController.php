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

    public $uses = array('Dashboard', 'Person', 'User', 'Course', 'Group', 'GroupCategory', 'Report', 'Action');
	public $components = array('Paginator');
    public $helpers = array('dynamicForms.dynamicForms', 'zingCharts.zingCharts');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('menu', 'customise');
        $current_user = $this->get_currentUser();
        $actions = $this->Action->countCustomerActions($current_user['Member']['customer_id']);
        $persons = $this->Person->countCustomerPeople($current_user['Member']['customer_id']);
        $courses = $this->Course->countCustomerCourses($current_user['Member']['customer_id']);
        $this->set(compact('actions', 'persons', 'courses'));
    }
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
                    'type' => 'pie',
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
                    'height' => '40%',
                    'type' => 'bar',
                    'scale-x' => array(
                        'values' => array_keys($data),
                        'zooming' => true,
                        'zoom-to' => array(0,30),
                        'item' => array(
                            'visible' => false
                        )
                    ),
                    'scroll-x' => array(),
                    'plotarea' => array(
                        'margin' => '20px 20px 100px 50px'
                    ),
                    'preview' => array(
                        'position' => "50% 95%",
                        'background-color' => 'transparent'
                    ),
                    'plot' => array(
                        'value-box' => array(
                            'text' => '%k<br />%v',
                            'font-angle' => -85,
                            'auto-align' => true,
                            'offset-y' => '-8px',
                            'offset-x' => '2px',
                            'font-size' => '8px'
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
                    'y' => '40%',
                    'width' => '100%',
                    'height' => '60%',
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
                    'y' => '40%',
                    'width' => '100%',
                    'height' => '60%',
                    'type' => 'hbar',
                    'title' => array(
                        'text' => 'Activity for $userid during last 3 months'
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
     * Return JSON chart details for user weekly activity dashboard chart
     * @param $courseid
     * @return CakeResponse
     */
    public function coursetypes($courseid) {

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
                    'id' => 'coursetypes',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '100%',
                    'type' => 'pie',
                    'series' => $pie,
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
     * @param $courseid
     * @return CakeResponse
     */
    public function coursemodules($courseid) {
        $current_user = $this->get_currentUser();
        // Set the Report.
        $report = array(
            'Report' => array(
                'name' => 'Module Use',
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-3 months',
                'rankorder' => '',
                'ranklimit' => null,
                'sortorder' => null,
                'customer_id' => $current_user['Member']['customer_id']
            ),
            'Filter' => array(),
            'ReportDimension' => array(
                array(
                    'model' => 'Artefact',
                    'parameter' => '',
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
                    'id' => 'coursemodules',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '100%',
                    'type' => 'radar',
                    'tooltip' => array(
                        'text' => "%v"
                    ),
                    'plot-area' => array(
                        'margin' => 0
                    ),
                    'plot' => array(
                        'aspect' => 'rose'
                    ),
                    'scale-k' => array(
                        'values' => array_keys($data)
                    ),
                    'series' => array(array('values' => array_values($data)))
                )
            )
        );
        return new CakeResponse(array('body' => json_encode($chart)));
    }

    /**
     * category method
     *
     * @param integer $id
     * @return void
     */
    public function category($id=null) {
        if($id){
            $this->Session->write('Dashboard.category', $id);
        }
        //Create selected user as session variable.
        $categoryid = $this->Session->read('Dashboard.category');
        if ($this->request->is('post')) {
            $categoryid = $this->request->data['Dashboard']['categoryid'];
            $this->set('categoryid', $categoryid);
            $this->set('categorydefault', $categoryid);
            $this->Session->write('Dashboard.course', $categoryid);
        }
        if ($categoryid) {
            $selectedcategory = $this->GroupCategory->find('first', array(
                    'conditions' => array('id' => $categoryid),
                    'contain' => false,
                    'fields' => array('name'),
                )
            );
            $this->set('categoryid', $categoryid);
            $this->set('categorydefault', $selectedcategory['GroupCategory']['name']);
        } else {
            $this->set('categoryid','');
            $this->set('categorydefault','');
        }
    }

    /**
     * Return JSON chart details for groups dashboard chart
     * @param $categoryid
     * @return CakeResponse
     */
    public function categories($categoryid) {

        $current_user = $this->get_currentUser();

        // Set the Report.
        $report = array(
            'Report' => array(
                'name' => 'Heat Map',
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-3 months',
                'rankorder' => '',
                'ranklimit' => null,
                'sortorder' => null,
                'customer_id' => $current_user['Member']['customer_id']
            ),
            'GroupCategory' => array(
                'group_category_id' => $categoryid
            ),
            'Filter' => array(),
            'ReportDimension' => array(
                array(
                    'model' => 'Group',
                    'parameter' => '0',
                    'type' => '1',
                    'Dimension' => array()
                ),
                array(
                    'model' => 'Rule',
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
            ),
            'where' => array(
                'GroupCategory.id' => $categoryid
            )
        );

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
            $scaleX = array_keys($values);
            $series[] = array(
                'text' => $label,
                'values' => array_values($values)
            );
        }

        $chart = array(
            'graphset' => array(
                array(
                    'id' => 'categories',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '100%',
                    'type' => 'piano',
                    'scale-x' => array(
                        'values' => $scaleX,
                        'zooming' => true,
                        'zoom-to' => array(0,30),
                        'items-overlap' => true,
                        'item' => array(
                            'font-angle' => -65
                        )
                    ),
                    'scroll-x' => array(),
                    'plotarea' => array(
                        'margin' => '20px 20px 150px 100px'
                    ),
                    'preview' => array(
                        'position' => "50% 95%",
                        'background-color' => 'transparent'
                    ),
                    'plot' => array(
                        'border-radius-top-right' => 0,
                        'border-radius-top-left' => 0,
                    ),
                    'series' => $series
                )
            )
        );
        return new CakeResponse(array('body' => json_encode($chart)));
    }

    /**
     * Return JSON chart details for user weekly activity dashboard chart
     * @param $categoryid
     * @return CakeResponse
     */
    public function categorytypes($categoryid) {

        // Set the Report.
        $report = array(
            'Report' => array(
                'name' => 'Task Types',
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-2 years',
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
                'GroupCategory.id' => $categoryid
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
                    'id' => 'coursetypes',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '100%',
                    'type' => 'pie',
                    'series' => $pie,
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
     * @param $categoryid
     * @return CakeResponse
     */
    public function categorymodules($categoryid) {
        $current_user = $this->get_currentUser();
        // Set the Report.
        $report = array(
            'Report' => array(
                'name' => 'Module Use',
                'startdate' => null,
                'enddate' => null,
                'datewindow' => '-3 months',
                'rankorder' => '',
                'ranklimit' => null,
                'sortorder' => null,
                'customer_id' => $current_user['Member']['customer_id']
            ),
            'Filter' => array(),
            'ReportDimension' => array(
                array(
                    'model' => 'Artefact',
                    'parameter' => '',
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
                'GroupCategory.id' => $categoryid
            )
        );

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
                    'id' => 'coursemodules',
                    'x' => '0%',
                    'y' => '0%',
                    'width' => '100%',
                    'height' => '100%',
                    'type' => 'radar',
                    'tooltip' => array(
                        'text' => "%v"
                    ),
                    'plot-area' => array(
                        'margin' => 0
                    ),
                    'plot' => array(
                        'aspect' => 'rose'
                    ),
                    'scale-k' => array(
                        'values' => array_keys($data)
                    ),
                    'series' => array(array('values' => array_values($data)))
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
    public function usertimeline($id = null) {
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

        if(!empty($userid)) {
            $conditions = array('Person.id' => $userid);
            $this->Paginator->settings = array(
                'joins' => array(
                    array(
                        'table' => 'groups',
                        'alias' => 'Group',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Group.id = Action.group_id'
                        )
                    ),
                    array(
                        'table' => 'modules',
                        'alias' => 'Module',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Module.id = Action.module_id'
                        )
                    ),
                    array(
                        'table' => 'artefacts',
                        'alias' => 'Artefact',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Artefact.id = Module.artefact_id'
                        )
                    ),
                    array(
                        'table' => 'dimension_verb',
                        'alias' => 'DimensionVerb',
                        'type' => 'INNER',
                        'conditions' => array(
                            'DimensionVerb.id = Action.dimension_verb_id'
                        )
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'User',
                        'type' => 'INNER',
                        'conditions' => array(
                            'User.id = Action.user_id'
                        )
                    ),
                    array(
                        'table' => 'persons',
                        'alias' => 'Person',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Person.id = User.person_id'
                        )
                    )
                ),
                'fields' => array(
                    'Action.name', 'Action.time', 'Module.name', 'Artefact.name',
                    'Group.name', 'Group.idnumber'
                ),
                'conditions' => $conditions,
                'limit' => 10,
                'order' => 'Action.time DESC'
            );
            $actions = $this->Paginator->paginate('Action');
            $this->set('actions', $actions);
        }
    }

    public function overall_activity() {
        $report = array(
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
                array(),
                $systems
            );
        }

        $chart = array(
            'graphset' => array(
                array(
                    'type' => 'line',
                    'plot-area' => array(
                        'margin' => '5px'
                    ),
                    'series' => array(array('values' => array_values($data)))
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
        $this->layout = 'config';
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
        $this->layout = 'config';
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
        $this->layout = 'config';
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
        $this->layout = 'config';
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
