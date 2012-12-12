<?php
/**
 * ActionFixture
 *
 */
class ActionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2),
		'time' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'module_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'time_ix' => array('column' => 'time', 'unique' => 0),
			'user_ix' => array('column' => 'user_id', 'unique' => 0),
			'group_ix' => array('column' => 'group_id', 'unique' => 0),
			'module_ix' => array('column' => 'module_id', 'unique' => 0),
			'user_time_ix' => array('column' => array('user_id', 'time'), 'unique' => 0),
			'group_time_ix' => array('column' => array('group_id', 'time'), 'unique' => 0),
			'module_time_ix' => array('column' => array('module_id', 'time'), 'unique' => 0)
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
			'type' => 1,
			'time' => 1,
			'user_id' => 1,
			'group_id' => 1,
			'module_id' => 1
		),
	);

}
