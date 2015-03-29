<?php
/**
 * StatusFixture
 *
 */
class StatusFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'status';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'procedure' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'time' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'starttime' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'endtime' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'customer_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rule_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'customer_rule_ix' => array('column' => array('customer_id', 'rule_id'), 'unique' => 1),
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
			'procedure' => 'Lorem ipsum dolor sit amet',
			'time' => '2013-07-30 09:27:10',
			'starttime' => '2013-07-30 09:27:10',
			'endtime' => '2013-07-30 09:27:10',
			'customer_id' => 1,
			'rule_id' => 1
		),
	);

}
