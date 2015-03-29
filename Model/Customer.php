<?php
App::uses('AppModel', 'Model');
/**
 * Customer Model
 *
 * @property Community $Community
 * @property Person $Person
 * @property System $System
 */
class Customer extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

    /**
     * Service level constants
     */
    const SERVICE_RESEARCH = 1;
    const SERVICE_INSTITUTION = 2;
    const SERVICE_ENTERPRISE = 3;

    /**
     * Service level descriptions
     * @var array
     */
    public $service_levels = array(
        self::SERVICE_RESEARCH => 'Researcher',
        self::SERVICE_INSTITUTION => 'Institution',
        self::SERVICE_ENTERPRISE => 'Enterprise'
    );

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
        'Course' => array(
            'className' => 'Course',
            'foreignKey' => 'customer_id',
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
        'Person' => array(
			'className' => 'Person',
			'foreignKey' => 'customer_id',
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
		'System' => array(
			'className' => 'System',
			'foreignKey' => 'customer_id',
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
        'Rule' => array(
            'className' => 'Rule',
            'foreignKey' => 'customer_id',
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

    public $hasOne = array(
        'CustomerKey' => array(
            'className' => 'CustomerKey',
            'foreignKey' => 'customer_id',
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

    public $hasAndBelongsToMany = array(
        'Artefact' => array(
            'className' => 'Artefact',
            'joinTable' => 'customer_artefacts',
            'foreignKey' => 'customer_id',
            'associationForeignKey' => 'artefact_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

}
