<?php
App::uses('AppModel', 'Model');
/**
 * Condition Model
 *
 * @property Module $Module
 * @property Group $Group
 * @property User $User
 */
class Condition extends AppModel {

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
    public $hasAndBelongsToMany = array(
        'Rule' => array(
            'className' => 'Rule',
            'joinTable' => 'rule_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'rule_id',
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
        'Action' => array(
            'className' => 'Action',
            'joinTable' => 'action_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'action_id',
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
        'DimensionVerb' => array(
            'className' => 'DimensionVerb',
            'joinTable' => 'dimension_verb_conditions',
            'foreignKey' => 'condition_id',
            'associationForeignKey' => 'dimension_verb_id',
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

    public function get_rule_conditions($rule_id) {
        return $this->Rule->find('all', array(
            'conditions' => array(
                'Rule.id' => $rule_id
            ),
            'contain' => array(
                'Condition' => array(
                    'fields' => array('Condition.id', 'Condition.name'),
                )
            ),
        ));
    }

}
