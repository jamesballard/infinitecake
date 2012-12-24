<?php
/**
 * FactUserVerbRuleDateFixture
 *
 */
class FactUserVerbRuleDateFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'fact_user_verb_rule_date';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'rule_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'condition_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'dimension_date_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'total' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => array('user_id', 'rule_id', 'condition_id', 'dimension_date_id'), 'unique' => 1),
			'user_ix' => array('column' => 'user_id', 'unique' => 0),
			'date_ix' => array('column' => 'dimension_date_id', 'unique' => 0),
			'condition_ix' => array('column' => 'condition_id', 'unique' => 0),
			'rule_ix' => array('column' => 'rule_id', 'unique' => 0)
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
			'rule_id' => 1,
			'condition_id' => 1,
			'dimension_date_id' => 1,
			'total' => 1
		),
	);

}
