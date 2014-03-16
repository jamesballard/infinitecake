<?php
App::uses('AppModel', 'Model');
/**
 * System Model
 *
 * @property Customer $Customer
 * @property Group $Group
 * @property Module $Module
 * @property User $User
 */
class System extends AppModel {

//Define Action Types
    const SYSTEM_TYPE_MOODLE = 1;
    const SYSTEM_TYPE_ULCCILP = 2;
    const SYSTEM_TYPE_MAHARA = 3;
    
    public $system_types = array(
    		System::SYSTEM_TYPE_MOODLE=>'Moodle',
    		System::SYSTEM_TYPE_ULCCILP=>'ULCC ILP',
    		System::SYSTEM_TYPE_MAHARA=>'Mahara',
    	);

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
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'system_id',
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
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'system_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'system_id',
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

    /**
     * hasAndBelongsTo associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Report' => array(
            'className' => 'Report',
            'joinTable' => 'report_systems',
            'foreignKey' => 'system_id',
            'associationForeignKey' => 'report_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
    );

}
