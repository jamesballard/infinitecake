<?php
App::uses('AppModel', 'Model');
/**
 * Rule Model
 *
 * @property Artefact $Artefact
 * @property Community $Community
 * @property Person $Person
 */
class Rule extends AppModel {

//Define Rule Types
    const RULE_TYPE_ACTION = 1;
    const RULE_TYPE_DIMENSION_VERB = 2;
    const RULE_TYPE_MODULE = 3;
    const RULE_TYPE_ARTEFACT = 4;
    const RULE_TYPE_GROUP = 5;
    
    public $rule_types = array(
    		Rule::RULE_TYPE_ACTION=>'Action',
    		Rule::RULE_TYPE_DIMENSION_VERB=>'Verb',
    		Rule::RULE_TYPE_MODULE=>'Module',
    		Rule::RULE_TYPE_ARTEFACT=>'Artefact',
    		Rule::RULE_TYPE_GROUP=>'Group'
    	);

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $actsAs = array('Containable');

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

    public $hasAndBelongsToMany = array(
        'Condition' => array(
            'className' => 'Condition',
            'joinTable' => 'rule_conditions',
            'foreignKey' => 'rule_id',
            'associationForeignKey' => 'condition_id',
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
