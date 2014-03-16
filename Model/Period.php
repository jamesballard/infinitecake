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

    /*
     * Returns a formatted start date.
     *
     * $param string $start
     * @return DateTime http://php.net/manual/en/class.datetime.php
     */
    private function getBeginTime($start, $initial) {
        $dateArray = explode('-', $start);
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
        return new DateTime(date('Y-m-'.$dateArray[2], $yearStart));
    }

    /*
     * Returns a formatted end date.
     *
     * $param string $end
     * @return DateTime http://php.net/manual/en/class.datetime.php
     */
    private function getEndTime($end) {
        $dateArray = explode('-', $end);
        // Work out offset from next January.
        $offset = 13 - $dateArray[1];
        // Return the end date based on day in record.
        return new DateTime(date('Y-m-'.$dateArray[2], strtotime("+$offset months")));
    }

    /**
     * Returns the year in format YYYY/yy based on start year
     *
     * @param   integer $year  format YYYY
     * @return  string  $year  format YYYY/yy
     */
    private function nameOffsetYear($startYear) {
        $year = $startYear. '/'. substr(($startYear + 1),-2);
        return $year;
    }

    /**
     * Returns a DatePeriod for the provided record.
     *
     * @param   string  $start
     * @param   string  $end
     * @param   integer $initial    Start date as timestamp, 0 = go back 1 year
     * @return  DatePeriod  $daterange  http://php.net/manual/en/class.dateperiod.php
     */
    private function getYears($record, $initial) {
        $begin = $this->getBeginTime($record['Period']['start'], $initial);
        $end = $this->getEndTime($record['Period']['end']);
        $interval = new DateInterval($record['Period']['interval']);
        $daterange = new DatePeriod($begin, $interval, $end);

        $labels = array();
        foreach ($daterange as $date) {
            $start = $date->format("Y");
            $conditions = array(
                'name' => $this->nameOffsetYear($start),
                'start' => $date->format($record['Period']['start']),
            );
            $date->add($interval);
            $conditions = array_merge($conditions, array('end' => $date->format($record['Period']['end'])));
            $labels[] = $conditions;
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
        switch ($record['Period']['interval']) {
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
}
