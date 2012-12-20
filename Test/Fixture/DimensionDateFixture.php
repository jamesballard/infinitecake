<?php
/**
 * DimensionDateFixture
 *
 */
class DimensionDateFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'dimension_date';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'date' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'unique'),
		'timestamp' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'day_of_week' => array('type' => 'integer', 'null' => false, 'default' => null),
		'day_of_week_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'day_of_month' => array('type' => 'integer', 'null' => false, 'default' => null),
		'day_of_year' => array('type' => 'integer', 'null' => false, 'default' => null),
		'weekend' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2),
		'month' => array('type' => 'integer', 'null' => false, 'default' => null),
		'month_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'month_day' => array('type' => 'integer', 'null' => false, 'default' => null),
		'year' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'week_starting_monday' => array('type' => 'integer', 'null' => false, 'default' => null),
		'week_starting_sunday' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'date' => array('column' => 'date', 'unique' => 1),
			'year_week' => array('column' => array('year', 'week_starting_monday'), 'unique' => 0)
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
			'date' => '2012-12-19',
			'timestamp' => 1,
			'day_of_week' => 1,
			'day_of_week_name' => 'Lorem ip',
			'day_of_month' => 1,
			'day_of_year' => 1,
			'weekend' => 1,
			'month' => 1,
			'month_name' => 'Lorem ip',
			'month_day' => 1,
			'year' => 1,
			'week_starting_monday' => 1,
			'week_starting_sunday' => 1
		),
	);

}
