<?php
/**
 * DimensionTimeFixture
 *
 */
class DimensionTimeFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'dimension_time';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'fulltime' => array('type' => 'time', 'null' => false, 'default' => null, 'key' => 'unique'),
		'hour' => array('type' => 'integer', 'null' => false, 'default' => null),
		'minute' => array('type' => 'integer', 'null' => false, 'default' => null),
		'second' => array('type' => 'integer', 'null' => false, 'default' => null),
		'ampm' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fulltime' => array('column' => 'fulltime', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'fulltime' => '13:16:51',
			'hour' => 1,
			'minute' => 1,
			'second' => 1,
			'ampm' => ''
		),
	);

}
