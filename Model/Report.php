<?php
App::uses('AppModel', 'Model');
App::uses('Action', 'Model');
App::uses('Dimension', 'Model');
App::uses('DimensionDate', 'Model');
App::uses('DimensionTime', 'Model');
App::uses('Filter', 'Model');
App::uses('Period', 'Model');
App::uses('Value', 'Model');
/**
 * Report Model
 *
 * @property Customer $Customer
 * @property Filter $Filter
 * @property ReportDimension $ReportDimension
 * @property ReportValue $ReportValue
 */
class Report extends AppModel {

    // Define visualisation type.
    const VISUALISATION_BAR = 1;
    const VISUALISATION_COLUMN = 2;
    const VISUALISATION_PIE = 3;
    const VISUALISATION_LINE = 4;
    const VISUALISATION_TABLE = 5;
    const VISUALISATION_TREEMAP = 6;
    //const VISUALISATION_LIST = 7;
    const VISUALISATION_RADAR = 8;

    public $visualisation_types = array(
        self::VISUALISATION_BAR => 'Bar chart',
        self::VISUALISATION_COLUMN => 'Column chart',
        self::VISUALISATION_PIE => 'Pie chart',
        self::VISUALISATION_LINE => 'Line graph',
        self::VISUALISATION_TABLE => 'Data table',
        //self::VISUALISATION_TREEMAP => 'Treemap',
        //self::VISUALISATION_LIST => 'Activity List',
        self::VISUALISATION_RADAR => 'Radar graph',
    );

    public static $visualisation_display = array(
        self::VISUALISATION_BAR => 'hbar',
        self::VISUALISATION_COLUMN => 'bar',
        self::VISUALISATION_PIE => 'pie',
        self::VISUALISATION_LINE => 'line',
        self::VISUALISATION_TABLE => 'grid',
        //TODO: Needs a hierarchy definition to work self::VISUALISATION_TREEMAP => 'treemap',
        //TODO: Action view should facilitate this view: self::VISUALISATION_LIST => 'list',
        self::VISUALISATION_RADAR => 'radar',
    );

// Define the dashboards for the report to display - TODO: subsume into dashboard feature in future
    const DASHBOARD_SYSTEM = 1;
    const DASHBOARD_COURSE = 2;
    const DASHBOARD_USER   = 3;

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

//The Associations below have been created with all possible keys, those that are not needed can be removed.

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Filter' => array(
			'className' => 'Filter',
			'foreignKey' => 'report_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ReportDimension' => array(
			'className' => 'ReportDimension',
			'foreignKey' => 'report_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ReportValue' => array(
			'className' => 'ReportValue',
			'foreignKey' => 'report_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Dashboard' => array(
            'className' => 'Dashboard',
            'joinTable' => 'dashboard_reports',
            'foreignKey' => 'report_id',
            'associationForeignKey' => 'dashboard_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'System' => array(
            'className' => 'System',
            'joinTable' => 'report_systems',
            'foreignKey' => 'report_id',
            'associationForeignKey' => 'system_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
    );

    /*
     * Returns the report object
     *
     * @param integer $id
     * @return stdClass
     */
    function getReport($id)  {
        return $this->find('first', array(
            'contain' => array(
                'ReportDimension' => array(
                    'Dimension'
                ),
                'ReportValue' => array(
                    'Value'
                ),
                'System',
                'Filter'
            ),
            'conditions' => array(
                'id' => $id
            )
        ));
    }
    /**
     * Returns a list of reports for a customer.
     *
     * @param $customer_id
     * @return array
     */
    public function getCustomerReports($customer_id) {
        return $this->find('list', array(
            'conditions' => array(
                'customer_id' => $customer_id
            )
        ));
    }
    /*
     * Get the aggregation sql for a report.
     *
     * $param stdClass $report
     * $return string
     */
    function getValue($report) {
        $model = new Value();
        /* TODO: currently only COUNT(*) is supported.
         * $type = $report['ReportValue'][0]['Value']['type'];
         * $field = $report['ReportValue'][0]['Value']['field'];
         * */
        $type = Value::VALUE_TYPE_COUNT;
        $field = '*';
        return $model->getValueSql($type, $field);
    }
    /*
     * Get the fact table for a report.
     *
     * $param stdClass $report
     * $return string
     */
    public function getFactTable($report) {
        /*
         * TODO: currently only Action is supports.
         * $report['ReportValue'][0]['Value']['model'];
         */
        return 'Action';
    }

    /*
     * Get the dimension for a report.
     *
     * $param stdClass $report
     * $return stdClass
     */
    public function getDimensions($report) {
        $dimensions = new stdClass();
        foreach ($report['ReportDimension'] as $reportDimension) {
            switch ($reportDimension['type']) {
                case 1:
                    $dimensions->axis = array('id' => $reportDimension['parameter'],
                        'model' => $reportDimension['model']);
                    break;
                case 2:
                    $dimensions->label = array('id' => $reportDimension['parameter'],
                        'model' => $reportDimension['model']);
                    break;
                default:
                    break;
            }
        }
        return $dimensions;
    }
    /**
     * Get the dimension labels for a report.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function useLabels($label) {
        if (isset($label['model']) and !empty($label['model'])) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Get a date range for caching if not a time-series report.
     *
     * $param stdClass $report
     * $return DatePeriod
     */
    function getDateRange($table, $uselabels, $dimensions, $report) {

        if (!empty($report['Report']['startdate'])) {
            $begin = DateTime::createFromFormat('U', $report['Report']['startdate']);
        } else {
            //TODO: calculate start time as first record from customer.
            /*$model = new $table();
            $start = $model->getCustomerStart($report['Report']['customer_id']);
            debug($start);*/
            $begin = new DateTime(date("Y-m-01", strtotime("-2 Years")));
        }

        if (!empty($report['Report']['enddate'])) {
            $end = DateTime::createFromFormat('U', $report['Report']['enddate']);
        } else {
            $end = new DateTime();
        }

        $interval = new DateInterval('P1M');

        if ($uselabels) {
            $dates = array();
            $model = new $dimensions->label['model']();
            $labels = $model->getLabels($dimensions->label['id'], $report);
            foreach ($labels as $label) {
                $begin = (!empty($label['start']) ? new DateTime($label['start']) : $begin);
                $end = (!empty($label['end']) ? new DateTime($label['end']) : $end);
                $dates[$label['name']] = new DatePeriod($begin, $interval, $end);
            }
            return $dates;
        } else {
            return new DatePeriod($begin, $interval, $end);
        }
    }
    /*
     * Get the dimension x-axis values.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function getAxis($dimensions, $report) {
        if (in_array($dimensions->axis['model'], array('DimensionDate', 'DimensionTime', 'Rule'))) {
            $model = new $dimensions->axis['model']();
        } else {
            $factTable = $this->getFactTable($report);
            $model = new $factTable();
        }
        return $model->getAxis($dimensions, $report);
    }
    /*
     * Get the dimension x-axis values.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function getLabelledAxis($dimensions, $report) {
        if (in_array($dimensions->axis['model'], array('DimensionDate', 'DimensionTime'))) {
            $model = new $dimensions->axis['model']();
        } else {
            $factTable = $this->getFactTable($report);
            $model = new $factTable();
        }
        return $model->getLabelledAxis($dimensions, $report);
    }
    /*
     * Get the dimension x-axis values.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function getHierarchyAxis($dimensions, $report) {
        if (in_array($dimensions->axis['model'], array('DimensionDate', 'DimensionTime'))) {
            $model = new $dimensions->axis['model']();
        } else {
            $factTable = $this->getFactTable($report);
            $model = new $factTable();
        }
        return $model->getHierarchyAxis($dimensions, $report);
    }
    /*
     * Get additional filter conditions.
     *
     * $param stdClass $report
     * $return array
     */
    function getConditions($report) {
        $conditions = array();
        // Get for date Windows.
        if(!empty($report['Report']['datewindow'])) {

        }
        // Add custom filters.
        $Filter = new Filter();
        foreach ($report['Filter'] as $filter) {
            $conditions  = array_merge($conditions, $Filter->getFilterCondition($filter));
        }
        return $conditions;
    }

    /**
     * Returns a Count for selected parameters.
     *
     * @param $select
     * @param $factTable
     * @param null $dates
     * @param $axis
     * @param $filters
     * @param $systems
     * @return array
     */
    function getLabelledReportData($select, $factTable, $dates=null, $axis, $filters, $systems) {
        $data = array();
        foreach ($axis as $label => $points) {
            foreach ($points as $point) {
                if ($dates) {
                    $value = $this->getPointCountWithDate($select, $factTable, $dates, $point, $filters, $systems, $label);
                } else {
                    $value = $this->getPointCount($select, $factTable, $point, $filters, $systems);
                }
                $data[$label][$point['name']] = $value;
            }
        }
        return $data;
    }

    /**
     * @param $select
     * @param $factTable
     * @param $dates
     * @param $point
     * @param $filters
     * @param $systems
     * @return bool|int|mixed
     */
    protected function getPointCountWithDate($select, $factTable, $dates, $point, $filters, $systems, $label=null) {
        $model = new $factTable();
        $joins = $model->extraJoins;
        $count = 0;

        if($label) {
            $range = $dates[$label];
        } else {
            $range = $dates;
        }

        foreach ($range as $date) {
            foreach ($systems as $system) {
                set_time_limit(0);
                $conditions = array('DimensionDate.date >=' => $date->format("Y-m-d"));
                $conditions = array_merge($conditions, array('System.id' => $system['id']));
                $date->add(new DateInterval("P1M"));
                $conditions = array_merge($conditions, array('DimensionDate.date <'  =>$date->format("Y-m-d")));
                $conditions = array_merge($conditions, $point['conditions'], $filters);
                $cacheName = "report.".$this->formatCacheConditions($conditions, $select, $factTable);
                $value = Cache::read($cacheName, 'long');
                if ($value === false) {
                    $result = $model->findFacts($select, array(
                            'conditions' => $conditions, //array of conditions
                            'joins' => array_merge($joins, $point['joins']),
                            'order' => $point['order']
                        )
                    );
                    $value = Set::classicExtract($result, '0.0.'.'FactModel__fact');
                    if ($date->format('U') < time()) {
                        Cache::write($cacheName, $value, 'long');
                    }
                }
                $count = $count + $value;
            }
        }
        return $count;
    }

    /**
     * @param $select
     * @param $factTable
     * @param $point
     * @param $filters
     * @param $systems
     * @return bool|mixed
     */
    protected function getPointCount($select, $factTable, $point, $filters, $systems) {
        $model = new $factTable();
        $joins = $model->extraJoins;
        $conditions = array_merge($point['conditions'], $filters);

        $count = 0;
        foreach ($systems as $system) {
            $conditions = array_merge($conditions, array('System.id' => $system['id']));
            $cacheName = "report.".$this->formatCacheConditions($conditions, $select, $factTable);
            $value = false;
            if ($point['cache']) {
                $value = Cache::read($cacheName, $point['cache']);
            }
            if ($value === false) {
                $result = $model->findFacts($select, array(
                        'conditions' => $conditions,
                        'joins' => array_merge($joins, $point['joins']),
                        'order' => $point['order']
                    )
                );
                $value = Set::classicExtract($result,'0.0.FactModel__fact');
                if ($point['cache']) {
                    Cache::write($cacheName, $value, $point['cache']);
                }
            }
            $count = $count + $value;
        }
        return $count;
    }

    /**
     * Returns unlabelled report data -
     *
     * @param $select
     * @param $factTable
     * @param null $dates
     * @param $axis
     * @param $filters
     * @param $systems
     * @return array
     */
    function getReportData($select, $factTable, $dates=null, $axis, $filters, $systems) {
        $data = array();
        foreach ($axis as $point) {
            if ($dates) {
                $value = $this->getPointCountWithDate($select, $factTable, $dates, $point, $filters, $systems);
            } else {
                $value = $this->getPointCount($select, $factTable, $point, $filters, $systems);
            }
            $data[] = array($point['name'] => $value);
        }
        return $data;
    }

    /**
     * @param $select
     * @param $table
     * @param $report
     * @param $conditions
     * @return mixed
     */
    function getListData($select, $table, $report, $conditions) {
        $model = new $table();
        $data = $model->getListData($select, $report, $conditions);
        return $data;
    }

    /**
     * Returns a Count for selected interval for the years available in GChart format
     *
     * @param string $id Report ID
     * @return array $data Academic Year => Period => Count
     */
    public function getReportChartData($id) {
        $report = $this->getReport($id);
        // Set the select aggregation SQL.
        $select = $this->getValue($report);
        // Set the fact table used for aggregation.
        $table = $this->getFactTable($report);
        // Set any additional filter conditions.
        $conditions = $this->getConditions($report);
        // Get the report dimensions.
        $dimensions = $this->getDimensions($report);
        // Get systems.
        $systems = $report['System'];
        // Set the report labels.
        $labels = $this->useLabels($dimensions->label, $report);
        // If not using dates for x-axis then set a date range for caching.
        if ($dimensions->axis['model'] == 'DimensionDate') {
            $dates = null;
        } else {
            $dates = $this->getDateRange($table, $labels, $dimensions, $report);
        }
        /*if ($report['Report']['visualisation'] == self::VISUALISATION_TREEMAP) {
            // Set the x-axis values.
            $axis = $this->getLabelledAxis($dimensions, $report);
            // Get the results.
            $results = $this->getHierarchicalReportData($select, $table, $dates, $axis, $conditions, $systems);
        } else */
        if ($labels) {
            // Set the x-axis values.
            $axis = $this->getLabelledAxis($dimensions, $report);
            // Get the results.
            $results = $this->getLabelledReportData($select, $table, $dates, $axis, $conditions, $systems);
        } else {
            // Set the x-axis values.
            $axis = $this->getAxis($dimensions, $report);
            // Get the results.
            $results = $this->getReportData($select, $table, $dates, $axis, $conditions, $systems);
        }
        // Format as a Google Chart array.
        //$data = $this->transformGchartArray($results);

        return $results;
    }

}
