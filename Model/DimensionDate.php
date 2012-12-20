<?php
App::uses('AppModel', 'Model');
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
		)
	);

}
