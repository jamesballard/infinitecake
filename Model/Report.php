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
        self::VISUALISATION_TREEMAP => 'Treemap',
        //self::VISUALISATION_LIST => 'Activity List',
        self::VISUALISATION_RADAR => 'Radar graph',
    );

    public static $visualisation_display = array(
        self::VISUALISATION_BAR => 'hbar',
        self::VISUALISATION_COLUMN => 'bar',
        self::VISUALISATION_PIE => 'pie',
        self::VISUALISATION_LINE => 'line',
        self::VISUALISATION_TABLE => 'grid',
        self::VISUALISATION_TREEMAP => 'treemap',
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
        $type = $report['ReportValue'][0]['Value']['type'];
        $field = $report['ReportValue'][0]['Value']['field'];
        return $model->getValueSql($type, $field);
    }
    /*
     * Get the fact table for a report.
     *
     * $param stdClass $report
     * $return string
     */
    public function getFactTable($report) {
        return $report['ReportValue'][0]['Value']['model'];
    }

    /*
     * Get the dimension for a report.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function getDimensions($report) {
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
    function getDateRange($report) {
        if (!empty($report['Report']['startdate'])) {
            $begin = DateTime::createFromFormat('U', $report['Report']['startdate']);
        } else {
            $begin = new DateTime(date("Y-m-01", strtotime("-2 Years")));
        }
        if (!empty($report['Report']['enddate'])) {
            $end = DateTime::createFromFormat('U', $report['Report']['enddate']);
        } else {
            $end = new DateTime(date("Y-m-d", strtotime(time())));
        }
        $interval = new DateInterval('P1M');
        return new DatePeriod($begin, $interval, $end);
    }
    /*
     * Get the dimension x-axis values.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function getAxis($dimensions, $report) {
        if (in_array($dimensions->axis['model'], array('DimensionDate', 'DimensionTime'))) {
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
     * Get additional filter conditions.
     *
     * $param stdClass $report
     * $return array
     */
    function getConditions($report) {
        $conditions = array();
        // Add custom filters.
        $Filter = new Filter();
        foreach ($report['Filter'] as $filter) {
            $conditions  = array_merge($conditions, $Filter->getFilterCondition($filter));
        }
        return $conditions;
    }
    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getLabelledReportData($select, $factTable, $dates=null, $axis, $filters) {
        $model = new $factTable();
        $data = array();
        foreach ($axis as $label => $points) {
            foreach ($points as $point) {
                $conditions = array_merge($point['conditions'], $filters);
                $contain = array_merge($point['contain'], array('System'));
                $cacheName = "labelled_report.$select.$factTable".$this->formatCacheConditions($conditions);
                $value = false;
                if ($point['cache']) {
                    $value = Cache::read($cacheName, $point['cache']);
                }
                if (!$value) {
                    $result = $model->find('all', array(
                            'conditions' => $conditions, //array of conditions
                            'contain' => $contain,
                            'joins' => $point['joins'],
                            'fields' => array($select),
                            'order' => $point['order']
                        )
                    );
                    $value = $result[0][0][$select];
                    if ($point['cache']) {
                        Cache::write($cacheName, $value, $point['cache']);
                    }
                }
                $data[$label][] = array($point['name'] => $value);
            }
        }
        return $data;
    }

    /**
     * Returns unlabelled report data -
     *
     * @param $select
     * @param $factTable
     * @param null $dates
     * @param $axis
     * @param $filters
     * @return array
     */
    function getCountData($select, $factTable, $dates=null, $axis, $filters) {
        $model = new $factTable();
        $data = array();
        foreach ($axis as $point) {
            $conditions = array_merge($point['conditions'], $filters);
            $contain = $point['contain'];
            $cacheName = "report.$select.$factTable".$this->formatCacheConditions($conditions);
            $value = false;
            if ($point['cache']) {
                $value = Cache::read($cacheName, $point['cache']);
            }
            if (!$value) {
                $result = $model->find('all', array(
                        'conditions' => $conditions, //array of conditions
                        'contain' => $contain,
                        'joins' => $point['joins'],
                        'fields' => array($select),
                        'order' => $point['order']
                    )
                );
                $value = $result[0][0][$select];
                if ($point['cache']) {
                    Cache::write($cacheName, $value, $point['cache']);
                }
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
    public function getReportCountGchart($id) {
        $report = $this->getReport($id);
        // Set the select aggregation SQL.
        $select = $this->getValue($report);
        // Set the fact table used for aggregation.
        $table = $this->getFactTable($report);
        // Set any additional filter conditions.
        $conditions = $this->getConditions($report);
        // Get the report dimensions.
        $dimensions = $this->getDimensions($report);
        // If not using dates for x-axis then set a date range for caching.
        if ($dimensions->axis['model'] == 'DimensionDate') {
            $dates = null;
        } else {
            $dates = $this->getDateRange($report);
        }
        // Set the report labels.
        $labels = $this->useLabels($dimensions->label, $report);
        if ($labels) {
            // Set the x-axis values.
            $axis = $this->getLabelledAxis($dimensions, $report);
            // Get the results.
            $results = $this->getLabelledReportData($select, $table, $dates, $axis, $conditions);
        } else {
            // Set the x-axis values.
            $axis = $this->getAxis($dimensions, $report);
            // Get the results.
            $results = $this->getCountData($select, $table, $dates, $axis, $conditions);
        }
        // Format as a Google Chart array.
        //$data = $this->transformGchartArray($results);

        return $results;
    }

}
