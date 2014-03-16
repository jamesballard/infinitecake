<?php
App::uses('AppModel', 'Model');
App::uses('Action', 'Model');
App::uses('Dimension', 'Model');
App::uses('DimensionDate', 'Model');
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

    public $visualisation_types = array(
        self::VISUALISATION_BAR => 'Bar chart',
        self::VISUALISATION_COLUMN => 'Column chart',
        self::VISUALISATION_PIE => 'Pie chart',
        self::VISUALISATION_LINE => 'Line graph',
        self::VISUALISATION_TABLE => 'Data table',
        self:: VISUALISATION_TREEMAP => 'Treemap',
    );

    public $visualisation_display = array(
        self::VISUALISATION_BAR => 'bar',
        self::VISUALISATION_COLUMN => 'column',
        self::VISUALISATION_PIE => 'pie',
        self::VISUALISATION_LINE => 'line',
        self::VISUALISATION_TABLE => 'table',
        self:: VISUALISATION_TREEMAP => 'treemap',
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
                ), 'Filter'
            ),
            'conditions' => array(
                'id' => $id
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
    function getFactTable($report) {
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
    /*
     * Get the dimension labels for a report.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function useLabels($label) {
        if (isset($label['id'])) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * Get a date range for caching if not a time-series report.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function getDateRange($initial) {
        $initial = strtotime("-2 Years");
        $begin = new DateTime(date("Y-m-01", strtotime($initial)));
        $end = new DateTime(date("Y-m-01", strtotime(time())));
        $interval = new DateInterval('P1M');
        return new DatePeriod($begin, $interval, $end);
    }
    /*
     * Get the dimension x-axis values.
     *
     * $param stdClass $report
     * $return stdClass
     */
    function getAxis($dimensions, $initial) {
        $model = new $dimensions->axis['model']();
        return $model->getAxis($dimensions, $initial);
    }
    /*
     * Get additional filter conditions.
     *
     * $param stdClass $report
     * $return array
     */
    function getConditions($report) {
        return array();
    }
    /**
     * Returns a Count for selected interval for the years available
     *
     * @param string $fields the fields intended to be counted
     * @param DateInterval $interval http://php.net/manual/en/class.dateinterval.php
     * @param string $format date format (e.g. 'M')
     * @return array Academic Year => Period => Count
     */
    function getReportData($select, $factTable, $labels=false, $dates=null, $axis, $filters) {
        $model = new $factTable();
        $data = array();
        foreach ($axis as $label => $points) {
            foreach ($points as $point) {
                $conditions = array_merge($point['conditions'], $filters);
                $contain = array_merge($point['contain'], array('System'));
                $cacheName = 'period_count.'.$this->formatCacheConditions($conditions);
                $value = Cache::read($cacheName, 'long');
                $value = false;
                if (!$value) {
                    $result = $model->find('all', array(
                            'conditions' => $conditions, //array of conditions
                            'contain' => $contain,
                            'fields' => array($select)
                        )
                    );
                    $value = $result[0][0][$select];
                    // Cache if all dates are in the past - otherwise new data will be incremented on import.
                    if ($point['cache']) {
                        Cache::write($cacheName, $value, 'long');
                    }
                }
                $data[$label][] = array($point['name'] => $value);
            }
        }
        return $data;
    }

    /**
     * Returns a Count for selected interval for the years available in GChart format
     *
     * @param string $id Report ID
     * @return array $data Academic Year => Period => Count
     */
    function getReportCountGchart($id) {
        $report = $this->getReport($id);
        // Set the initial date for when to report from.
        $initial = $report['Report']['initial'];
        // Set the select aggregation SQL.
        $select = $this->getValue($report);
        // Set the fact table used for aggregation.
        $table = $this->getFactTable($report);
        // Get the report dimensions.
        $dimensions = $this->getDimensions($report);
        // Set the report labels.
        $labels = $this->useLabels($dimensions->label, $initial);
        // If not using dates for x-axis then set a date range for caching.
        if ($dimensions->axis['model'] == 'DimensionDate') {
            $dates = null;
        } else {
            $dates = $this->getDateRange($initial);
        }
        // Set the x-axis values.
        $axis = $this->getAxis($dimensions, $initial);
        // Set any additional filter conditions.
        $conditions = $this->getConditions($report);
        // Get the data results.
        $results = $this->getReportData($select, $table, $labels, $dates, $axis, $conditions);
        // Format as a Google Chart array.
        $data = $this->transformGchartArray($results);

        return $data;
    }

}
