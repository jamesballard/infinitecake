<?php
/**
 * DashboardReportFixture
 *
 */
class DashboardReportFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'report_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'dimension_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'position' => array('type' => 'integer', 'null' => false, 'default' => null),
		'parameter' => array('type' => 'string', 'null' => true, 'default' => '1', 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'report_ix' => array('column' => 'report_id', 'unique' => 0),
			'dimension_ix' => array('column' => 'dimension_id', 'unique' => 0)
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
			'dimension_id' => 1,
			'position' => 1,
			'parameter' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-02-16 00:56:15',
			'modified' => '2014-02-16 00:56:15'
		),
	);

}
