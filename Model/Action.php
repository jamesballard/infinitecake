<?php
App::uses('AppModel', 'Model');
App::uses('Course', 'Model');
App::uses('Filter', 'Model');
App::uses('Module', 'Model');
App::uses('Person', 'Model');
/**
 * Action Model
 *
 * @property User $User
 * @property Group $Group
 * @property Module $Module
 */
class Action extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
    public $useTable = 'actions';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/*
 * Acts as behaviours.
 *
 * @var array
 */
    public $actsAs = array('Academicperiod', 'chartData');

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'module_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'DimensionVerb' => array(
            'className' => 'DimensionVerb',
            'foreignKey' => 'dimension_verb_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'System' => array(
            'className' => 'System',
            'foreignKey' => 'system_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'DimensionDate' => array(
            'className' => 'DimensionDate',
            'foreignKey' => 'dimension_date_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'DimensionTime' => array(
            'className' => 'DimensionTime',
            'foreignKey' => 'dimension_time_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);

    public $hasAndBelongsToMany = array(
        'Condition' => array(
            'className' => 'Condition',
            'joinTable' => 'action_conditions',
            'foreignKey' => 'action_id',
            'associationForeignKey' => 'condition_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

    public $joins = array(
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
                        'table' => 'courses',
                        'alias' => 'Course',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Course.id = Group.course_id'
                        )
                    ),
                    array(
                        'table' => 'artefacts',
                        'alias' => 'Artefact',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Artefact.id = Module.artefact_id'
                        )
                    ),
                    array(
                        'table' => 'systems',
                        'alias' => 'System',
                        'type' => 'INNER',
                        'conditions' => array(
                            'System.id = Action.system_id'
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
                        'table' => 'dimension_date',
                        'alias' => 'DimensionDate',
                        'type' => 'INNER',
                        'conditions' => array(
                            'DimensionDate.id = Action.dimension_date_id'
                        )
                    ),
                    array(
                        'table' => 'dimension_time',
                        'alias' => 'DimensionTime',
                        'type' => 'INNER',
                        'conditions' => array(
                            'DimensionTime.id = Action.dimension_time_id'
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
                        'type' => 'INNER',
                        'conditions' => array(
                            'Person.id = User.person_id'
                        )
                    ),
                );

    public $order = array(
        'DimensionDate.id DESC',
        'DimensionTime.id DESC'
    );

    /**
     * Get the x-axis array for the course dimension.
     *
     * @param $dimensions
     * @param $report
     * @return array
     *
     */
    public function getAxis($dimensions, $report) {
        $axis = array();
        $group = $report['ReportDimension'][0]['model'];
        $groupModel = new $group();
        $Filter = new Filter();

        $cacheName = "Axis.Action.$group.id";

        // SELECT SQL.
        $sql = "SELECT $group.id, ";
        $sql .= "$group.".$groupModel->displayField.", ";
        $sql .= "COUNT(".$report['ReportValue'][0]['Value']['field'].") AS total ";

        // FROM SQL.
        $sql .= "FROM actions AS `Action`, systems AS System, groups AS `Group`, modules AS Module, ";
        $sql .= "dimension_verb AS DimensionVerb, courses AS Course, artefacts AS Artefact ";

        // WHERE SQL.
        $sql .= "WHERE Action.system_id = System.id ";
        $sql .= "AND Action.group_id = Group.id ";
        $sql .= "AND Action.module_id = Module.id ";
        $sql .= "AND Action.dimension_verb_id = DimensionVerb.id ";
        $sql .= "AND Group.course_id = Course.id ";
        $sql .= "AND Module.artefact_id = Artefact.id ";

        // Add System WHERE clauses with IN array.
        $systems = array();
        foreach ($report['System'] as $system) {
            $systems[] = $system['id'];
            $cacheName .= ".S".$system['id'];
        }
        $sql .= "AND System.id IN (".implode(',', $systems).") ";

        // Add Custom filter WHERE clauses.
        foreach ($report['Filter'] as $filter) {
            $sql .= $Filter->getFilterSQL($filter);
            $cacheName .= ".F".$filter['model'].".".$filter['value'];
        }

        // GROUP BY.
        $sql .= "GROUP BY ".$report['ReportDimension'][0]['model'].".id ";


        // ORDER.
        if ($report['Report']['rankorder']) {
            $sql .= "ORDER BY total ".$report['Report']['rankorder']." ";
            $cacheName .= ".O".$report['Report']['rankorder'];
        }

        // LIMIT.
        if ($report['Report']['ranklimit']) {
            $sql .= "LIMIT ".$report['Report']['ranklimit'];
            $cacheName .= ".L".$report['Report']['ranklimit'];
        }
        $points = Cache::read($cacheName, 'long');
        if (!$points) {
            $points = $this->query($sql);
            Cache::write($cacheName, $points, 'long');
        }
        foreach ($points as $point) {
            $axis[] = array(
                'conditions' => array("$group.id" => $point[$group]['id']),
                'name' => $point[$group][$groupModel->displayField],
                'cache' => 'short',
                'contain' => false,
                'joins' => array(),
                'order' => ''
            );
        }
        return $axis;
    }

    public function getListData($select, $report, $conditions) {
        $group = $report['ReportDimension'][0]['model'];
        $Filter = new Filter();

        // SELECT SQL.
        $sql = "SELECT * ";

        // FROM SQL.
        $sql .= "FROM actions AS `Action`, systems AS System, groups AS `Group`, modules AS Module, ";
        $sql .= "dimension_verb AS DimensionVerb, courses AS Course, artefacts AS Artefact ";

        // WHERE SQL.
        $sql .= "WHERE Action.system_id = System.id ";
        $sql .= "AND Action.group_id = Group.id ";
        $sql .= "AND Action.module_id = Module.id ";
        $sql .= "AND Action.dimension_verb_id = DimensionVerb.id ";
        $sql .= "AND Group.course_id = Course.id ";
        $sql .= "AND Module.artefact_id = Artefact.id ";

        // Add System WHERE clauses with IN array.
        $systems = array();
        foreach ($report['System'] as $system) {
            $systems[] = $system['id'];
        }
        $conditions = array_merge($conditions, array('System.id' => $systems));
        $sql .= "AND System.id IN (".implode(',', $systems).") ";

        // Add Custom filter WHERE clauses.
        foreach ($report['Filter'] as $filter) {
            $sql .= $Filter->getFilterSQL($filter);
        }

        if(!empty($report['Report']['datewindow'])) {
            $sql .= "AND time > ".date("Y-m-d", strtotime($report['Report']['datewindow']));
            $conditions = array_merge($conditions,
                array('time >'  => date("Y-m-d", strtotime($report['Report']['datewindow'])))
            );
        }

        // ORDER.
        $sql .= "ORDER BY time DESC ";


        // LIMIT.
        if ($report['Report']['ranklimit']) {
            $sql .= "LIMIT ".$report['Report']['ranklimit'];
        }

        $cacheName = 'stream_actions.'.$this->formatCacheConditions($conditions);
        $actions = Cache::read($cacheName, 'short');
        if (!$actions) {
            $actions = $this->query($sql);
            Cache::write($cacheName, $actions, 'short');
        }
        return $actions;
    }

    /**
     * Get the x-axis array for the course dimension.
     *
     * @param $dimensions
     * @param $report
     * @return array
     *
     */
    public function getLabelledAxis($dimensions, $report) {
        $model = new $dimensions->label['model']();
        $labels = $model->getLabels($dimensions->label['id'], $report);

        $axis = array();
        foreach ($labels as $label) {
            $axis[$label['name']][] = array(
                'conditions' => $conditions,
                'name' => (string)$date->format($this->interval_formats[$dimensions->axis['id']]),
                'contain' => array('DimensionDate'),
                'cache' => $cache,
                'joins' => array(),
                'order' => ''
            );
        }
    }

    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getPeriodCount($dateWindow, $filter, $interval, $dateFormat) {
        $interval = new DateInterval($interval);
        $start = strtotime($dateWindow);
        $daterange = $this->getAcademicPeriod($start, $interval);

        $data = array();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                //In a leap year this creates an irreconcilable offset so skip this day
                if($date->format("d-M") != '29-Feb') {
                    $conditions = array('DimensionDate.date >='=>$date->format("Y-m-d"));
                    $date->add($interval);
                    $conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
                    $conditions = array_merge($conditions,$filter);
                    $cacheName = 'period_count.'.$this->formatCacheConditions($conditions);
                    $value = Cache::read($cacheName, 'long');
                    if (!$value) {
                        $value = $this->find('count', array(
                                'conditions' => $conditions, //array of conditions
                                'contain' => array(
                                    'DimensionDate',
                                    'System'
                                )
                            )
                        );
                        // Cache if all dates are in the past - otherwise new data will be incremented on import.
                        if ($date->format('U') < time()) {
                            Cache::write($cacheName, $value, 'long');
                        }
                    }
                    $date->sub($interval);
                    $data[$year][] = array((string)$date->format($dateFormat) => $value);
                }
            }
        }
        return $data;
    }

    public function getSessionLength() {

    }

    public function getTimeOnline($person_id) {
        $actions = $this->find('all', array(
           'contain' => array('DimensionDate', 'DimensionTime', 'DimensionVerb'),
           'joins' => array(
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
                    'type' => 'INNER',
                    'conditions' => array(
                        'Person.id = User.person_id'
                    )
                ),
           ),
           'conditions' => array(
               'Person.id' => $person_id
           ),
           'order' => array(
               'DimensionDate.id ASC',
               'DimensionTime.id ASC'
           )
        ));
        $sessions = array();
        $timestart = 0;
        $timeend = 0;
        $lastaction = 0;
        foreach ($actions as $action) {
            $time = new datetime($action['Action']['time']);
            if(empty($timestart)) {
                $timestart = $time;
            }
            if(!empty($lastaction)) {
                $sessionend = $time;
                $sessionend->add(new DateInterval("PT2H"));
                debug($time);
                debug($sessionend);
                if ($time > $sessionend) {
                    $timeend = $lastaction;
                }
                if(!empty($timeend)) {
                    $sessions[] = array(
                        'start' => $timestart,
                        'end' => $timeend
                    );
                    $timestart = $time;
                    $timeend = 0;
                }
            }
            $lastaction = $time;
        }
        $sessions[] = array(
            'start' => $timestart,
            'end' => $timeend
        );
        debug($sessions);
        die;
    }

    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getReportCount($report) {
        $interval = new DateInterval($interval);
        $start = strtotime($dateWindow);
        $daterange = $this->getAcademicPeriod($start, $interval);

        $data = array();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                //In a leap year this creates an irreconcilable offset so skip this day
                if($date->format("d-M") != '29-Feb') {
                    $conditions = array('DimensionDate.date >='=>$date->format("Y-m-d"));
                    $date->add($interval);
                    $conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
                    $conditions = array_merge($conditions,$filter);
                    $cacheName = 'period_count.'.$this->formatCacheConditions($conditions);
                    $value = Cache::read($cacheName, 'long');
                    if (!$value) {
                        $value = $this->find('count', array(
                                'conditions' => $conditions, //array of conditions
                                'contain' => array(
                                    'DimensionDate',
                                    'System'
                                )
                            )
                        );
                        // Cache if all dates are in the past - otherwise new data will be incremented on import.
                        if ($date->format('U') < time()) {
                            Cache::write($cacheName, $value, 'long');
                        }
                    }
                    $date->sub($interval);
                    $data[$year][] = array((string)$date->format($dateFormat) => $value);
                }
            }
        }
        return $data;
    }

    /**
     * Returns a Count for selected interval for the years available in GChart format
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getPeriodCountGchart($dateWindow, $filter, $interval, $dateFormat) {
        $results = $this->getPeriodCount($dateWindow, $filter, $interval, $dateFormat);
        $data = $this->transformGchartArray($results);
        return $data;
    }

    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getModuleCount($dateWindow, $filter) {
        $start = strtotime($dateWindow);
        $interval = new DateInterval('P1Y');
        $daterange = $this->getAcademicPeriod($start, $interval);

        $data = array();
        $artefacts = $this->Artefact->getArtefacts();
        foreach ($daterange as $year=>$range) {
            foreach($range as $date) {
                $conditions = array('DimensionDate.date >='=>$date->format("Y-m-d"));
                $date->add($interval);
                $conditions = array_merge($conditions,array('DimensionDate.date <'=>$date->format("Y-m-d")));
                $conditions = array_merge($conditions,$filter);
                $date->sub($interval);
                //Iterate through modules to get count of each per category
                foreach ($artefacts as $artefact) {
                    $conditions = array_merge($conditions, array('FactSummedActionsDatetime.artefact_id' => $artefact['Artefact']['id']));
                    $cacheName = 'module_count.'.$this->formatCacheConditions($conditions);
                    $value = Cache::read($cacheName, 'long');
                    if (!$value) {
                        $value = $this->find('count', array(
                                'conditions' => $conditions, //array of conditions
                                'contain' => array(
                                    'DimensionDate',
                                    'Artefact',
                                    'System'
                                )
                            )
                        );
                        if ($date->format('U') < time()) {
                            Cache::write($cacheName, $value, 'long');
                        }
                    }
                    $data[$year][] = array($artefact['Artefact']['name'] => $value);
                }
            }
        }
        return $data;
    }

    /**
     * Returns a Count for selected interval for the years available in GChart format
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */

    function getModuleCountTreemap($dateWindow, $filter) {
        $results = $this->getModuleCount($dateWindow, $filter);
        $data = $this->transformModuleTreemap($results);
        return $data;
    }

    private $dayHours = array(13,14,15,16,17,18,19,8,9,10,11,12);
    private $nightHours = array(1,2,3,4,5,6,7,20,21,22,23,0);

    public function getHourStats($dateWindow, $period, $report, $filter) {
        $start = strtotime($dateWindow);

        switch($period) {
            case 'day':
                $hours = $this->dayHours;
                break;
            case 'night':
                $hours = $this->nightHours;
                break;
        }

        switch($report) {
            case 'sum':
                $fields = "SUM(FactSummedActionsDatetime.total) as total";
                break;
            case 'avg':
                $fields = "AVG(FactSummedActionsDatetime.total) as total";
                break;
            case 'min':
                $fields = "MIN(FactSummedActionsDatetime.total) as total";
                break;
            case 'max':
                $fields = "MAX(FactSummedActionsDatetime.total) as total";
                break;
        }

        $data =array();
        $conditions = array('DimensionDate.date >='=>date("Y-m-d", $start));
        foreach ($hours as $hour) {
            $conditions = array_merge($conditions,array('DimensionTime.hour'=>$hour));
            $conditions = array_merge($conditions,$filter);
            $cacheName = 'hour_stats.'.$this->formatCacheConditions($conditions);
            $value = Cache::read($cacheName, 'long');
            if (!$value) {
                $value = $this->find('count', array(
                        'conditions' => $conditions, //array of conditions
                        'contain' => array(
                            'DimensionTime',
                            'DimensionDate',
                            'System'
                        )
                    )
                );
                Cache::write($cacheName, $value, 'long');
            }
            $data[] = $value;
        }
        return $data;
    }
}
