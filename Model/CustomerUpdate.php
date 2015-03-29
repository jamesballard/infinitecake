<?php
App::uses('AppModel', 'Model');
/**
 * CustomerUpdate Model
 *
 * @property Customer $Customer
 * @property Rule $Rule
 */
class CustomerUpdate extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'type';


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
		),
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'rule_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
