<?php
App::uses('AppModel', 'Model');
/**
 * CustomerKey Model
 *
 * @property Customer $Customer
 */
class CustomerKey extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'accesskey';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'accesskey' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
}
