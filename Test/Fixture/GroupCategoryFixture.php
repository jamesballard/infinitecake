<?php
/**
 * GroupCategoryFixture
 *
 */
class GroupCategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'sysid' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'idnumber' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'depth' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'path' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'system_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'group_categories_unique_ix' => array('column' => array('system_id', 'sysid'), 'unique' => 1),
			'left_ix' => array('column' => 'depth', 'unique' => 0),
			'right_ix' => array('column' => 'path', 'unique' => 0),
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
			'sysid' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'idnumber' => 'Lorem ipsum dolor sit amet',
			'parent_id' => 1,
			'depth' => 1,
			'path' => 'Lorem ipsum dolor sit amet',
			'system_id' => 1,
			'created' => '2014-10-20 08:02:21',
			'modified' => '2014-10-20 08:02:21'
		),
	);

}
