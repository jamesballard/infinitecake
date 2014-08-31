<?php
App::uses('AppModel', 'Model');
/**
 * Period Model
 *
 * @property Customer $Customer
 */
class Period extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

    //Define Intervals
    const PERIOD_INTERVAL_DAY = 1;
    const PERIOD_INTERVAL_WEEK = 2;
    const PERIOD_INTERVAL_MONTH = 3;
    const PERIOD_INTERVAL_YEAR = 4;

    public $interval_types = array(
        Period::PERIOD_INTERVAL_DAY=>'Day',
        Period::PERIOD_INTERVAL_WEEK=>'Week',
        Period::PERIOD_INTERVAL_MONTH=>'Month',
        Period::PERIOD_INTERVAL_YEAR=>'Year'
    );

    public $interval_values = array(
        Period::PERIOD_INTERVAL_DAY=>'P1D',
        Period::PERIOD_INTERVAL_WEEK=>'P1W',
        Period::PERIOD_INTERVAL_MONTH=>'P1M',
        Period::PERIOD_INTERVAL_YEAR=>'P1Y'
    );


	//The Associations below have been created with all possible keys, those that are not needed can be removed

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

    /*
     * Get the sub list of dimension options when this model is used.
     *
     * @return array a list formatted array
     */
    public function getDimensionParameters($customer_id) {
        return $this->find('list', array(
            'conditions' => array('customer_id' => $customer_id)
        ));
    }

    /**
     * Returns a formatted start date.
     *
     * @param $start
     * @param null $initial
     * @return DateTime
     */
    private function getBeginTime($start, $initial=null) {
        $dateArray = explode('/', $start);
        $initial = strtotime("-2 Years");
        // Work out offset from previous January.
        $offset = abs(1 - $dateArray[1]);
        // Check how far back the report goes from initial value or default to 1 year.
        if(!empty($initial)) {
            $yearStart = strtotime ("-$offset months" , $initial);
        }else{
            $yearStart = strtotime ("-$offset months" , strtotime("-1 year", time()));
        }
        // Return the begin date based on day in record.
        return new DateTime(date('Y-m-'.$dateArray[0], $yearStart));
    }

    /**
     * @param $end
     * @return DateTime
     */
    private function getEndTime($end) {
        $dateArray = explode('/', $end);
        // Work out offset from next January.
        $offset = 13 - $dateArray[1];
        // Return the end date based on day in record.
        return new DateTime(date('Y-m-'.$dateArray[0], strtotime("+$offset months")));
    }

    /**
     * @param $date
     * @return string
     */
    protected function getYearFormat($date) {
        $dateArray = explode('/', $date);
        return 'Y-m-'.$dateArray[0];
    }

    /**
     * @param $startYear
     * @return string
     */
    private function nameOffsetYear($startYear) {
        $year = $startYear. '/'. substr(($startYear + 1),-2);
        return $year;
    }

    /**
     * @param $record
     * @param $initial
     * @return array
     */
    private function getYears($record, $initial) {
        $begin = $this->getBeginTime($record['Period']['start'], $initial);
        $end = $this->getEndTime($record['Period']['end']);
        $interval = new DateInterval($this->interval_values[$record['Period']['interval']]);
        $daterange = new DatePeriod($begin, $interval, $end);

        $format = $this->getYearFormat($record['Period']['start']);

        $labels = array();
        foreach ($daterange as $date) {
            $start = $date->format("Y");
            $label = array(
                'name' => $this->nameOffsetYear($start),
                'start' => $date->format($format),
                'joins' => array(),
                'conditions' => array(
                    'DimensionDate.date >=' => $date->format($format)
                )
            );
            $date->add($interval);
            $label = array_merge($label, array('end' => $date->format($format)));
            $label['conditions']['DimensionDate.date <'] = $date->format($format);
            $labels[] = $label;
        }
        return $labels;
    }

    /*
     * Returns record as labels for report.
     *
     * @param integer $id
     * $return array
     */
    public function getLabels($id, $initial) {
        $record = $this->read(null, $id);
        switch ($this->interval_values[$record['Period']['interval']]) {
            case 'P1D':
                break;
            case 'P1W':
                break;
            case 'P1M':
                break;
            case 'P1Y':
                return $this->getYears($record, $initial);
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Get the x-axis array for the date dimension.
     *
     * @param $dimensions
     * @param $report
     * @return array
     */
    public function getAxis($dimensions, $report) {
        $record = $this->read(null, $dimensions->axis['id']);

        $begin = $this->getBeginTime($record['Period']['start']);
        $end = $this->getEndTime($record['Period']['end']);
        $interval = new DateInterval($this->interval_values[$record['Period']['interval']]);
        $range = new DatePeriod($begin, $interval, $end);

        $axis = array();
        foreach ($range as $date) {
            //In a leap year this creates an irreconcilable offset so skip this day
            if($date->format("d-M") != '29-Feb') {
                $name = (string)$this->nameOffsetYear($date->format("Y"));
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
                    'name' => $name,
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
     * Returns a filtered list of axis points for visualisations.
     *
     * @param $report
     * @return array|mixed
     */
    public function getAxisPoints($report) {
        $conditions = array(
            'Period.customer_id' => $report['Report']['customer_id']
        );

        $Filter = new Filter();
        // Add Custom filter WHERE clauses in case we filter out courses.
        foreach ($report['Filter'] as $filter) {
            if($filter['model'] == 'Period') {
                $conditions = array_merge($conditions, $Filter->getFilterCondition($filter));
            }
        }

        $cacheName = 'customer_periods.'.$this->formatCacheConditions($conditions);
        $periods = Cache::read($cacheName, 'short');
        if (!$periods) {
            $periods = $this->find('all', array(
                'conditions' => $conditions
            ));
            Cache::write($cacheName, $periods, 'short');
        }
        return $periods;
    }
}
