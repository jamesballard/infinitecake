<?php
App::uses('AppModel', 'Model');
/**
 * DimensionTime Model
 *
 * @property FactUserActionsTime $FactUserActionsTime
 */
class DimensionTime extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'dimension_time';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'fulltime';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

    //TODO: day and night should be configurable by customer.
    private $dayHours = array(
        '12' => 12,
        '1' => 13,
        '2' => 14,
        '3' => 15,
        '4' => 16,
        '5' => 17,
        '6' => 18,
        '7' => 19,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        '11' => 11
    );
    private $nightHours = array(
        '12' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 20,
        '9' => 21,
        '10' => 22,
        '11' => 23
    );

    private $twentyFourHours = array(
        '0' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        '11' => 11,
        '12' => 12,
        '13' => 13,
        '14' => 14,
        '15' => 15,
        '16' => 16,
        '17' => 17,
        '18' => 18,
        '19' => 19,
        '20' => 20,
        '21' => 21,
        '22' => 22,
        '23' => 23,
    );

    //Define Filter Types
    const TIME_ALL = 1;
    const TIME_DAY = 2;
    const TIME_NIGHT = 3;

    public $interval_types = array(
        DimensionTime::TIME_ALL=>'All',
        DimensionTime::TIME_DAY=>'Day',
        DimensionTime::TIME_NIGHT=>'Night',
    );

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'FactUserActionsTime' => array(
			'className' => 'FactUserActionsTime',
			'foreignKey' => 'dimension_time_id',
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
            'foreignKey' => 'dimension_time_id',
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
     * @param integer $customer_id
     * @return array a list formatted array
     */
    public function getDimensionParameters($customer_id) {
        return array(0 => __('No option required'));
    }

    /**
     * Get the x-axis array for the date dimension.
     *
     * @param $dimensions
     * @param $report
     * @return array
     *
     */
    public function getLabelledAxis($dimensions, $report) {
        $axis = array();

        $conditions = array();
        if (!empty($report['Report']['datewindow'])) {
            $conditions = array(
                'DimensionDate.date >' => date('Y-m-d', strtotime($report['Report']['datewindow']))
            );
        }
        $cache = 'short';

        foreach ($this->dayHours as $key => $hour) {
            $conditions = array_merge($conditions, array('DimensionTime.hour' => $hour));
            $axis[$this->interval_types[self::TIME_DAY]][] = array(
                'conditions' => $conditions,
                'name' => (string)$key,
                'contain' => array('DimensionTime'),
                'joins' => array(),
                'order' => '',
                'cache' => $cache,
            );
        }

        foreach ($this->nightHours as $key => $hour) {
            $conditions = array_merge($conditions, array('DimensionTime.hour' => $hour));
            $axis[$this->interval_types[self::TIME_NIGHT]][] = array(
                'conditions' => $conditions,
                'name' => (string)$key,
                'contain' => array('DimensionTime'),
                'joins' => array(),
                'order' => '',
                'cache' => $cache,
            );
        }
        return $axis;
    }

    /**
     * Get the x-axis array for the date dimension.
     *
     * @param $dimensions
     * @param $initial
     * @return array
     *
     */
    public function getAxis($dimensions, $initial) {
        $axis = array();

        $conditions = array();
        if (!empty($report['Report']['datewindow'])) {
            $conditions = array(
                'DimensionDate.date >' => date('Y-m-d', strtotime($report['Report']['datewindow']))
            );
        }

        foreach ($this->twentyFourHours as $hour) {
            $conditions = array_merge($conditions, array('DimensionTime.hour' => $hour));
            $cache = false;
            $axis[] = array(
                'conditions' => $conditions,
                'name' => (string)$hour,
                'contain' => false,
                'joins' => array(),
                'order' => '',
                'cache' => $cache,
            );
        }
        return $axis;
    }
}
