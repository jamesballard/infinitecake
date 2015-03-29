<?php
App::uses('AppModel', 'Model');
/**
 * Ip Model
 *
 * @property Action $Action
 */
class Ip extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'ip';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Action' => array(
			'className' => 'Action',
			'foreignKey' => 'ip_id',
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
