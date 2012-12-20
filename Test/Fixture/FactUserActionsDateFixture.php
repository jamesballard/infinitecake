<?php
/**
 * FactUserActionsDateFixture
 *
 */
class FactUserActionsDateFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'fact_user_actions_date';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'artefact_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'dimension_verb_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'dimension_date_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'total' => array('type' => 'integer', 'null' => true, 'default' => null),
		'production' => array('type' => 'integer', 'null' => true, 'default' => null),
		'consumption' => array('type' => 'integer', 'null' => true, 'default' => null),
		'exchange' => array('type' => 'integer', 'null' => true, 'default' => null),
		'distribution' => array('type' => 'integer', 'null' => true, 'default' => null),
		'operation' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => array('user_id', 'artefact_id', 'dimension_verb_id', 'dimension_date_id'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'user_id' => 1,
			'artefact_id' => 1,
			'dimension_verb_id' => 1,
			'dimension_date_id' => 1,
			'total' => 1,
			'production' => 1,
			'consumption' => 1,
			'exchange' => 1,
			'distribution' => 1,
			'operation' => 1
		),
	);

}
