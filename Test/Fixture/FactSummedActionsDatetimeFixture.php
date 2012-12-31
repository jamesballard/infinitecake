<?php
/**
 * FactSummedActionsDatetimeFixture
 *
 */
class FactSummedActionsDatetimeFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'fact_summed_actions_datetime';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'system_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'artefact_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'dimension_date_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'dimension_time_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'total' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => array('user_id', 'artefact_id', 'dimension_date_id', 'system_id', 'group_id', 'dimension_time_id'), 'unique' => 1),
			'user_ix' => array('column' => 'user_id', 'unique' => 0),
			'artefact_ix' => array('column' => 'artefact_id', 'unique' => 0),
			'date_ix' => array('column' => 'dimension_date_id', 'unique' => 0),
			'system_ix' => array('column' => 'system_id', 'unique' => 0),
			'group_ix' => array('column' => 'group_id', 'unique' => 0),
			'time_ix' => array('column' => 'dimension_time_id', 'unique' => 0)
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
			'system_id' => 1,
			'group_id' => 1,
			'user_id' => 1,
			'artefact_id' => 1,
			'dimension_date_id' => 1,
			'dimension_time_id' => 1,
			'total' => 1
		),
	);

}
