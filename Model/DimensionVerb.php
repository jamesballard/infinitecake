<?php
App::uses('AppModel', 'Model');
/**
 * DimensionVerb Model
 *
 * @property Artefact $Artefact
 * @property Action $Action
 * @property FactUserActionsDate $FactUserActionsDate
 */
class DimensionVerb extends AppModel {

    //Define verb Types
    const VERB_TYPE_PRODUCE = 1;
    const VERB_TYPE_CONSUME = 2;
    const VERB_TYPE_EXCHANGE = 3;
    const VERB_TYPE_DISTRIBUTE = 4;
    const VERB_TYPE_OPERATE = 5;

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'dimension_verb';

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
		'Artefact' => array(
			'className' => 'Artefact',
			'foreignKey' => 'artefact_id',
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
		'Action' => array(
			'className' => 'Action',
			'foreignKey' => 'dimension_verb_id',
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
		'FactUserActionsDate' => array(
			'className' => 'FactUserActionsDate',
			'foreignKey' => 'dimension_verb_id',
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
