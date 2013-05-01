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
		)
	);
}
