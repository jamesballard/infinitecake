<?php
App::uses('AppModel', 'Model');
/**
 * Status Model
 *
 * @property Customer $Customer
 * @property Rule $Rule
 */
class CustomerStatus extends AppModel {

//Define stored procedures
    const PROC_USER_TO_PEOPLE = 1;
    const PROC_GROUP_TO_COURSE = 2;
    const PROC_SUM_ACTION = 3;
    const PROC_SUM_RULE = 4;
    const PROC_SUM_IP = 5;

    public $rule_types = array(
        Rule::PROC_USER_TO_PEOPLE=>'Users to People',
        Rule::PROC_GROUP_TO_COURSE=>'Groups to Course',
        Rule::PROC_SUM_ACTION=>'Sum Actions',
        Rule::PROC_SUM_RULE=>'Sum Rule',
        Rule::PROC_SUM_IP=>'Sum IP Address'
    );

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'customer_status';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'procedure';


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
