<?php
App::uses('AppModel', 'Model');
/**
 * FactUserActionsTime Model
 *
 * @property User $User
 * @property DimensionTime $DimensionTime
 */
class FactUserActionsTime extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'fact_user_actions_time';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'user_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'total';


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
		'DimensionTime' => array(
			'className' => 'DimensionTime',
			'foreignKey' => 'dimension_time_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    private $dayHours = array(13,14,15,16,17,18,19,8,9,10,11,12);
    private $nightHours = array(1,2,3,4,5,6,7,20,21,22,23,0);

    public function getHourStats($period, $report, $filter) {

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
                $fields = "SUM(FactUserActionsTime.total) as total";
                break;
            case 'avg':
                $fields = "AVG(FactUserActionsTime.total) as total";
                break;
            case 'min':
                $fields = "MIN(FactUserActionsTime.total) as total";
                break;
            case 'max':
                $fields = "MAX(FactUserActionsTime.total) as total";
                break;
        }

        $data =array();
        foreach ($hours as $hour) {
            $conditions = array('DimensionTime.hour'=>$hour);
            $conditions = array_merge($conditions,$filter);
            //$cacheName = $reportType.'-'.$this->get_academic_year_name($start).'-'.$date->format($periodFormat);
            //$value = Cache::read($cacheName, 'long');
            //if (!$value) {
            $value = $this->find('first', array(
                    'conditions' => $conditions, //array of conditions
                    'recursive' => 0, //int
                    'fields' => $fields, //array of field names
                )
            );
            //Cache::write($cacheName, $value, 'long');
            //}
            if($value[0]['total']) {
                $count = $value[0]['total'];
            }else{
                $count = 0;
            }

            $data[] = $count;
        }
        return $data;
    }
}
