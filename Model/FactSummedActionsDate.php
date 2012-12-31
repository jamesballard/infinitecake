<?php
App::uses('AppModel', 'Model');
/**
 * FactSummedActionsDate Model
 *
 * @property System $System
 * @property Group $Group
 * @property User $User
 * @property Artefact $Artefact
 * @property DimensionDate $DimensionDate
 */
class FactSummedActionsDate extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'fact_summed_actions_date';

    public $actsAs = array('Academicperiod', 'Gchart');

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'system_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'total';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'System' => array(
			'className' => 'System',
			'foreignKey' => 'system_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Artefact' => array(
			'className' => 'Artefact',
			'foreignKey' => 'artefact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DimensionDate' => array(
			'className' => 'DimensionDate',
			'foreignKey' => 'dimension_date_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
