<?php
/**
 * CustomerUpdateFixture
 *
 */
class CustomerUpdateFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'index'),
		'time' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'startid' => array('type' => 'integer', 'null' => true, 'default' => null),
		'endid' => array('type' => 'integer', 'null' => true, 'default' => null),
		'numrows' => array('type' => 'integer', 'null' => true, 'default' => null),
		'processedrows' => array('type' => 'integer', 'null' => true, 'default' => null),
		'customer_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rule_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'customer_ix' => array('column' => 'customer_id', 'unique' => 0),
			'customer_proc_ix' => array('column' => array('type', 'customer_id'), 'unique' => 0)
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
			'time' => '2013-07-31 08:08:08',
			'startid' => 1,
			'endid' => 1,
			'numrows' => 1,
			'processedrows' => 1,
			'customer_id' => 1,
			'rule_id' => 1
		),
	);

}
