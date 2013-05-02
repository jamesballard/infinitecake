<?php
App::uses('AppModel', 'Model');
/**
 * DimensionVerbCondition Model
 *
 * @property DimensionVerb $DimensionVerb
 * @property Condition $Condition
 */
class DimensionVerbCondition extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'DimensionVerb' => array(
			'className' => 'DimensionVerb',
			'foreignKey' => 'dimension_verb_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Condition' => array(
			'className' => 'Condition',
			'foreignKey' => 'condition_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
