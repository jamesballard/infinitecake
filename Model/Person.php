<?php
App::uses('AppModel', 'Model');
/**
 * Person Model
 *
 * @property Customer $Customer
 * @property Position $Position
 * @property Rule $Rule
 * @property User $User
 */
class Person extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'persons';

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'idnumber';
    
    public $virtualFields = array(
    		'jsonlabel' => 'CONCAT("Label", ":", "Person.username")',
    		'jsonvalue' => 'CONCAT("Value", ":", "Person.id")'
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'person_id',
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
