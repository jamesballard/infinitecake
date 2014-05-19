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
        DimensionDate::DATE_INTERVAL_DAY=>'P1M',
        DimensionDate::DATE_INTERVAL_WEEK=>'P1W',
        DimensionDate::DATE_INTERVAL_MONTH=>'P1M',
        DimensionDate::DATE_INTERVAL_YEAR=>'P1Y'
    );

    public $interval_formats = array(
        DimensionDate::DATE_INTERVAL_DAY=>'d-M',
        DimensionDate::DATE_INTERVAL_WEEK=>'W',
        DimensionDate::DATE_INTERVAL_MONTH=>'M',
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

    /*
     * Get the sub list of dimension options when this model is used.
     *
     * @return array a list formatted array
     */
    public function getDimensionParameters() {
        return $this->interval_types;
    }

    /*
     * TODO: is this a description?!?
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
     * Get the x-axis array for the date dimension.
     *
     * @param $dimensions
     * @param $initial
     * @return array
     *
     */
    public function getLabelledAxis($dimensions, $report) {
        $model = new $dimensions->label['model']();
        $labels = $model->getLabels($dimensions->label['id'], $report);

        $interval = new DateInterval($this->interval_values[$dimensions->axis['id']]);

        $today = new DateTime();
        $aeon = new DateTime(date('Y-01-01', strtotime("-2 years")));

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
                        'name' => (string)$date->format($this->interval_formats[$dimensions->axis['id']]),
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
