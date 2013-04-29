<?php
/**
 * DepartmentFixture
 *
 */
class DepartmentFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'idnumber' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'left_ix' => array('column' => 'lft', 'unique' => 0),
			'right_ix' => array('column' => 'rght', 'unique' => 0),
			'parent_ix' => array('column' => 'parent_id', 'unique' => 0)
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
			'name' => 'Lorem ipsum dolor sit amet',
			'idnumber' => 'Lorem ipsum dolor sit amet',
			'active' => 1,
			'lft' => 1,
			'rght' => 1,
			'parent_id' => 1
		),
	);

}
