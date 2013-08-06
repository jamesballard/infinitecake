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

    public $process_types = array(
        CustomerStatus::PROC_USER_TO_PEOPLE=>'Users to People',
        CustomerStatus::PROC_GROUP_TO_COURSE=>'Groups to Course',
        CustomerStatus::PROC_SUM_ACTION=>'Sum Actions',
        CustomerStatus::PROC_SUM_RULE=>'Sum Rule',
        CustomerStatus::PROC_SUM_IP=>'Sum IP Address'
    );

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'customer_status';

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
