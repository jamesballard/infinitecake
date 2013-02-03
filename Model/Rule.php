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
    const RULE_TYPE_VERB = 2;
    const RULE_TYPE_MODULE = 3;
    const RULE_TYPE_ARTEFACT = 4;
    const RULE_TYPE_GROUP = 5;
       
    public $rule_types = array(
    		Rule::RULE_TYPE_ACTION=>'Action',
    		Rule::RULE_TYPE_VERB=>'Verb',
    		Rule::RULE_TYPE_MODULE=>'Module',
    		Rule::RULE_TYPE_ARTEFACT=>'Artefact',
    		Rule::RULE_TYPE_GROUP=>'Group'
    	);
    
/**
 * static enum: Model::function()
 * @access static
 */
    public static function rule_types($value = null) {
    	$options = array(
    			self::RULE_TYPE_ACTION => __('Action',true),
    			self::RULE_TYPE_VERB => __('Verb',true),
    			self::RULE_TYPE_MODULE => __('Module',true),
    			self::RULE_TYPE_ARTEFACT => __('Artefact',true),
    			self::RULE_TYPE_GROUP => __('Group',true),
    	);
    	return parent::enum($value, $options);
    }

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'value';

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
