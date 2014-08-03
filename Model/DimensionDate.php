<?php
App::uses('AppModel', 'Model');
App::uses('Rule', 'Model');
/**
 * DimensionDate Model
 *
 * @property FactUserActionsDate $FactUserActionsDate
 */
class DimensionDate extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'dimension_date';


/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'date';

//Define Filter Types
    const DATE_INTERVAL_DAY = 1;
    const DATE_INTERVAL_WEEK = 2;
    const DATE_INTERVAL_MONTH = 3;
    const DATE_INTERVAL_YEAR = 4;

    public $interval_types = array(
        DimensionDate::DATE_INTERVAL_DAY=>'Day',
        DimensionDate::DATE_INTERVAL_WEEK=>'Week',
        DimensionDate::DATE_INTERVAL_MONTH=>'Month',
        DimensionDate::DATE_INTERVAL_YEAR=>'Year'
    );

    public $interval_values = array(
        DimensionDate::DATE_INTERVAL_DAY=>'P1D',
        DimensionDate::DATE_INTERVAL_WEEK=>'P1W',
        DimensionDate::DATE_INTERVAL_MONTH=>'P1M',
        DimensionDate::DATE_INTERVAL_YEAR=>'P1Y'
    );

    public $interval_formats_grouped = array(
        DimensionDate::DATE_INTERVAL_DAY=>'d-M',
        DimensionDate::DATE_INTERVAL_WEEK=>'d-M',
        DimensionDate::DATE_INTERVAL_MONTH=>'M',
        DimensionDate::DATE_INTERVAL_YEAR=>'Y'
    );

    public $interval_formats = array(
        DimensionDate::DATE_INTERVAL_DAY=>'d-M-y',
        DimensionDate::DATE_INTERVAL_WEEK=>'d-M-y',
        DimensionDate::DATE_INTERVAL_MONTH=>'M-y',
        DimensionDate::DATE_INTERVAL_YEAR=>'Y'
    );

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'FactUserActionsDate' => array(
			'className' => 'FactUserActionsDate',
			'foreignKey' => 'dimension_date_id',
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
        'Action' => array(
            'className' => 'Action',
            'foreignKey' => 'dimension_date_id',
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
     * Get the sub list of dimension options when this model is used.
     *
     * @return array a list formatted array
     */
    public function getDimensionParameters() {
        return $this->interval_types;
    }

    /**
     * Returns the parameter conditions when configuring a report.
     *
     * @param $key
     * @return mixed
     */
    public function getConditions($key) {
        switch ($key) {
            case DimensionDate::DATE_INTERVAL_DAY:
                return $this->interval_values[DimensionDate::DATE_INTERVAL_DAY];
            case DimensionDate::DATE_INTERVAL_WEEK:
                return $this->interval_values[DimensionDate::DATE_INTERVAL_WEEK];
            case DimensionDate::DATE_INTERVAL_MONTH:
                return $this->interval_values[DimensionDate::DATE_INTERVAL_MONTH];
            case DimensionDate::DATE_INTERVAL_YEAR:
                return $this->interval_values[DimensionDate::DATE_INTERVAL_YEAR];
            default:
                return $this->interval_values[DimensionDate::DATE_INTERVAL_MONTH];
        }

    }

    /**
     * @param $report
     * @param $interval
     * @return DateTime
     */
    protected function getStartDate($report, $interval=null) {
        if(!empty($report['Report']['startdate'])) {
            $date = new DateTime($report['Report']['startdate']);
        } else if (!empty($report['Report']['datewindow'])) {
            $date = new DateTime(date('Y-m-d', strtotime($report['Report']['datewindow'])));
        } else {
            $date = new DateTime(date('Y-01-01', strtotime("-2 years")));
        }
        return $date;
    }

    /**
     * @param $report
     * @return DateTime
     */
    protected function getEndDate($report) {
        if(!empty($report['Report']['enddate'])) {
            return new DateTime($report['Report']['enddate']);
        } else {
            return new DateTime();
        }
    }

    /**
     * Gets years as a label.
     *
     * @param $report
     * @return array
     */
    protected function getDays($report) {
        $days = array(
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            0 => 'Sunday'
        );

        $labels = array();
        foreach ($days as $key => $day) {
            $labels[] = array(
                'name' => $day,
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'DimensionDate.day_of_week =' => "$key"
                )
            );
        }
        return $labels;
    }

    /**
     * Gets years as a label.
     *
     * @param $report
     * @return array
     */
    protected function getWeeks($report) {
        $labels = array();
        $x=1;
        while($x <= 52) {
            $labels[] = array(
                'name' => $x,
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'DimensionDate.week_starting_monday =' => "$x"
                )
            );
        }
        return $labels;
    }

    /**
     * Gets years as a label.
     *
     * @param $report
     * @return array
     */
    protected function getMonths($report) {
        $months = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );

        $labels = array();
        foreach ($months as $key => $month) {
            $labels[] = array(
                'name' => $month,
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'DimensionDate.month =' => "$key"
                )
            );
        }
        return $labels;
    }

    /**
     * Gets years as a label.
     *
     * @param $report
     * @return array
     */
    protected function getYears($report) {
        $begin = $this->getStartDate($report);
        $end = $this->getEndDate($report);
        $interval = new DateInterval($this->interval_values[DimensionDate::DATE_INTERVAL_YEAR]);
        $daterange = new DatePeriod($begin, $interval, $end);

        $labels = array();
        foreach ($daterange as $date) {
            $year = $date->format("Y");
            $labels[] = array(
                'name' => $year,
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'DimensionDate.year =' => "$year"
                )
            );
        }
        return $labels;
    }

    /**
     * Returns record as labels for report.
     *
     * @param integer $id
     * @param mixed $report
     * @return array
     */
    public function getLabels($id, $report) {
        switch ($this->interval_values[$id]) {
            case 'P1D':
                return $this->getDays($report);
                break;
            case 'P1W':
                return $this->getWeeks($report);
                break;
            case 'P1M':
                return $this->getMonths($report);
                break;
            case 'P1Y':
                return $this->getYears($report);
                break;
            default:
                return false;
                break;
        }
        $labels = array();
        foreach ($courses as $course) {
            $labels[] =array(
                'name' => $course['Course']['name'],
                'start' => '',
                'end' => '',
                'joins' => array(),
                'conditions' => array(
                    'Course.id' => $course['Course']['id']
                ),
            );
        }
        return $labels;
    }

    /**
     * Get the x-axis array for the date dimension.
     *
     * @param $dimensions
     * @param $report
     * @return array
     */
    public function getAxis($dimensions, $report) {
        $interval = new DateInterval($this->interval_values[$dimensions->axis['id']]);

        $aeon = $this->getStartDate($report, $interval);
        $today = $this->getEndDate($report);

        $axis = array();
        $range = new DatePeriod($aeon, $interval, $today);
        foreach ($range as $date) {
            //In a leap year this creates an irreconcilable offset so skip this day
            if($date->format("d-M") != '29-Feb') {
                $conditions = array('DimensionDate.date >=' => $date->format("Y-m-d"));
                $date->add($interval);
                $conditions = array_merge($conditions, array('DimensionDate.date <'  =>$date->format("Y-m-d")));
                // Cache if all dates are in the past.
                $cache = false;
                if ($date->format('U') < time()) {
                    $cache = 'long';
                }
                $axis[] = array(
                    'conditions' => $conditions,
                    'name' => (string)$date->format($this->interval_formats[$dimensions->axis['id']]),
                    'contain' => array('DimensionDate'),
                    'cache' => $cache,
                    'joins' => array(),
                    'order' => ''
                );
            }
        }
        return $axis;
    }

    /**
     * Get a labelled x-axis array for the date dimension.
     *
     * @param $dimensions
     * @param $report
     * @return array
     */
    public function getLabelledAxis($dimensions, $report) {
        $labelModel = $dimensions->label['model'];
        $model = new $labelModel();
        $labels = $model->getLabels($dimensions->label['id'], $report);

        if ($labelModel == 'Period') {
            $format = $this->interval_formats_grouped[$dimensions->axis['id']];
        } else {
            $format = $this->interval_formats[$dimensions->axis['id']];
        }

        $interval = new DateInterval($this->interval_values[$dimensions->axis['id']]);

        $aeon = $this->getStartDate($report, $interval);
        $today = $this->getEndDate($report);

        $axis = array();
        foreach ($labels as $label) {
            $conditions = $label['conditions'];
            $joins = $label['joins'];
            $begin = (!empty($label['start']) ? new DateTime($label['start']) : $aeon);
            $end = (!empty($label['end']) ? new DateTime($label['end']) : $today);
            $range = new DatePeriod($begin, $interval, $end);
            foreach ($range as $date) {
                //In a leap year this creates an irreconcilable offset so skip this day
                if($date->format("d-M") != '29-Feb') {
                    $conditions = array_merge($conditions, array('DimensionDate.date >=' => $date->format("Y-m-d")));
                    $date->add($interval);
                    $conditions = array_merge($conditions, array('DimensionDate.date <'  =>$date->format("Y-m-d")));
                    // Cache if all dates are in the past.
                    $cache = false;
                    if ($date->format('U') < time()) {
                        $cache = 'long';
                    }
                    $axis[$label['name']][] = array(
                        'conditions' => $conditions,
                        'name' => (string)$date->format($format),
                        'contain' => array('DimensionDate'),
                        'cache' => $cache,
                        'joins' => $joins,
                        'order' => ''
                    );
                }
            }
        }
        return $axis;
    }

}
