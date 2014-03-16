<?php
/**
 * ReportDimensionFixture
 *
 */
class ReportDimensionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'report_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'dimension_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'parameter' => array('type' => 'string', 'null' => true, 'default' => '1', 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2),
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
			'parameter' => 'Lorem ipsum dolor sit amet',
			'type' => 1,
			'created' => '2013-11-22 15:07:19',
			'modified' => '2013-11-22 15:07:19'
		),
	);

}
