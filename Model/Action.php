<?php
App::uses('AppModel', 'Model');
App::uses('FactModel','Model');
App::uses('Course', 'Model');
App::uses('Group', 'Model');
App::uses('Filter', 'Model');
App::uses('Module', 'Model');
App::uses('Person', 'Model');
App::uses('User', 'Model');
App::uses('Department', 'Model');
/**
 * Action Model
 *
 * @property User $User
 * @property Group $Group
 * @property Module $Module
 */
class Action extends FactModel {

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
            'type' => 'LEFT',
            'conditions' => array(
                'Course.id = Group.course_id'
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
            'type' => 'LEFT',
            'conditions' => array(
                'Person.id = User.person_id'
            )
        ),
        array(
            'table' => 'ips',
            'alias' => 'Ip',
            'type' => 'INNER',
            'conditions' => array(
                'Ip.id = Action.ip_id'
            )
        )
    );

    public $extraJoins = array(
        array(
            'table' => 'courses',
            'alias' => 'Course',
            'type' => 'LEFT',
            'conditions' => array(
                'Course.id = Group.course_id'
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
            'table' => 'persons',
            'alias' => 'Person',
            'type' => 'LEFT',
            'conditions' => array(
                'Person.id = User.person_id'
            )
        ),
    );

    // setup paginate to page 2 posts at a time
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'DimensionDate.id DESC',
            'DimensionTime.id DESC'
        )
    );

    /**
     * The default sort order for the Model.
     *
     * @var array
     */
    public $order = array(
        'DimensionDate.id DESC',
        'DimensionTime.id DESC'
    );

    /**
     * Get a count of the total actions for a customer.
     *
     * @param $customer_id
     * @return array|mixed
     */
    public function countCustomerActions($customer_id) {
        $conditions = array('Customer.id' => $customer_id);
        $cacheName = 'customer_actions_count.'.$this->formatCacheConditions($conditions);
        $actions = Cache::read($cacheName, 'short');
        if (!$actions) {
            $actions = $this->find('count', array(
                    'contain' => false,
                    'joins' => array(
                        array(
                            'table' => 'systems',
                            'alias' => 'System',
                            'ctype' => 'INNER',
                            'conditions' => array(
                                'System.id = Action.system_id'
                            )
                        ),
                        array(
                            'table' => 'customers',
                            'alias' => 'Customer',
                            'type' => 'INNER',
                            'conditions' => array(
                                'Customer.id = System.customer_id'
                            )
                        ),
                    ),
                    'conditions' => $conditions
                )
            );
            Cache::write($cacheName, $actions, 'short');
        }
        return $actions;
    }

    /**
     * Get the first record for a customer to use as a start date for reports.
     * @param $customer_id
     */
    public function getCustomerStart($customer_id) {
        $this->find('all', array(
            'joins' => array(
                array(
                    'table' => 'systems',
                    'alias' => 'System',
                    'ctype' => 'INNER',
                    'conditions' => array(
                        'System.id = Action.system_id'
                    )
                ),
                array(
                    'table' => 'customers',
                    'alias' => 'Customer',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Customer.id = System.customer_id'
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
            ),
           'fields' => array(
               'MIN(dimension_date_id) as Date, MIN(dimension_time_id) as Time'
           ),
           'conditions' => array(
               'Customer.id' => $customer_id
           )
        ));
    }

    /**
     * Calculates an ordered ranked list of point (e..g top 10)
     * This is quite expensive and resource intensive to calculate.
     *
     * @param $group
     * @param $report
     * @return mixed
     */
    protected function getRankedPoints($group, $report) {
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

        $points = Cache::read($cacheName, 'medium');
        if (!$points) {
            $points = $this->query($sql);
            Cache::write($cacheName, $points, 'medium');
        }
        return $points;
    }

    protected function getNormalSql($group, $report) {
        $groupModel = new $group();
        return $groupModel->getAxisPoints($report);
    }

    protected function getPoints($group, $report) {

        if ($report['Report']['ranklimit']) {
            //TODO: this is slow - needs to do groups.
            $points = $this->getRankedPoints($group, $report);
        } else {
            $points = $this->getNormalSql($group, $report);
        }
        return $points;
    }

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
        $points = $this->getPoints($group, $report);
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
        $group = $report['ReportDimension'][0]['model'];
        $groupModel = new $group();
        $points = $this->getPoints($group, $report);
        foreach ($labels as $label) {
            $conditions = $label['conditions'];
            $joins = $label['joins'];
            foreach($points as $point) {
                $conditions = array_merge($conditions, array("$group.id" => $point[$group]['id']));
                $axis[$label['name']][] = array(
                    'conditions' => $conditions,
                    'name' => $point[$group][$groupModel->displayField],
                    'cache' => false,
                    'contain' => false,
                    'joins' => $joins,
                    'order' => ''
                );
            }
        }
        return $axis;
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

    public function getLatest($customer_id) {
        $conditions = array('Customer.id' => $customer_id);
        $cacheName = 'customer_actions_latest.'.$this->formatCacheConditions($conditions);
        $actions = Cache::read($cacheName, 'short');
        if (!$actions) {
            $actions = $this->find('first', array(
                    'contain' => false,
                    'fields' => array(
                        'MAX(Action.time) as latest'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'systems',
                            'alias' => 'System',
                            'ctype' => 'INNER',
                            'conditions' => array(
                                'System.id = Action.system_id'
                            )
                        ),
                        array(
                            'table' => 'customers',
                            'alias' => 'Customer',
                            'type' => 'INNER',
                            'conditions' => array(
                                'Customer.id = System.customer_id'
                            )
                        ),
                    ),
                    'conditions' => $conditions,
                    'order' => false
                )
            );
            Cache::write($cacheName, $actions, 'short');
        }
        return $actions;
    }
}
