<?php
/**
 * ReportValueFixture
 *
 */
class ReportValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'report_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'value_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'parameter' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'report_ix' => array('column' => 'report_id', 'unique' => 0),
			'value_ix' => array('column' => 'value_id', 'unique' => 0)
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
			'report_id' => 1,
			'value_id' => 1,
			'parameter' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-11-22 15:07:58',
			'modified' => '2013-11-22 15:07:58'
		),
	);

}
