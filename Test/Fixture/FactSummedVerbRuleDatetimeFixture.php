<?php
/**
 * FactSummedVerbRuleDatetimeFixture
 *
 */
class FactSummedVerbRuleDatetimeFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'fact_summed_verb_rule_datetime';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'system_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'rule_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'condition_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'dimension_date_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'dimension_time_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'total' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => array('system_id', 'group_id', 'user_id', 'rule_id', 'condition_id', 'dimension_date_id', 'dimension_time_id'), 'unique' => 1)
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
			'rule_id' => 1,
			'condition_id' => 1,
			'dimension_date_id' => 1,
			'dimension_time_id' => 1,
			'total' => 1
		),
	);

}
