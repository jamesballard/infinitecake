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

    /*
     * Get the sub list of dimension options when this model is used.
     *
     * @return array a list formatted array
     */
    public function getDimensionParameters($customer_id) {
        return array(0 => __('No option required'));
    }
}
