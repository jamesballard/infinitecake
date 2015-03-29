<?php
/**
 * CustomerStatusFixture
 *
 */
class CustomerStatusFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'customer_status';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'time' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'startid' => array('type' => 'integer', 'null' => true, 'default' => null),
		'endid' => array('type' => 'integer', 'null' => true, 'default' => null),
		'customer_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rule_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'customer_proc_ix' => array('column' => array('customer_id', 'type'), 'unique' => 1),
			'customer_ix' => array('column' => 'customer_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'type' => 1,
			'time' => '2013-08-01 04:13:16',
			'startid' => 1,
			'endid' => 1,
			'customer_id' => 1,
			'rule_id' => 1
		),
	);

}
