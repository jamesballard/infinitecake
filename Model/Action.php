<?php
App::uses('AppModel', 'Model');
/**
 * Action Model
 *
 * @property User $User
 * @property Group $Group
 * @property Module $Module
 */
class Action extends AppModel {

//Define Action Types
    const ACTION_TYPE_PRODUCE = 1;
    const ACTION_TYPE_CONSUME = 2;
    const ACTION_TYPE_EXCHANGE = 3;
    const ACTION_TYPE_DISTRIBUTE = 4;
    const ACTION_TYPE_OPERATE = 5;

/**
 * Use table
 *
 * @var mixed False or table name
 */
    public $useTable = 'actions';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


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
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'module_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
