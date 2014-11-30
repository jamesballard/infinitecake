<?php
/**
 * UserGroupFixture
 *
 */
class UserGroupFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'sysid' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'role' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'sysid', 'unique' => 1),
			'person_ix' => array('column' => 'group_id', 'unique' => 0),
			'course_ix' => array('column' => 'user_id', 'unique' => 0)
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
			'sysid' => 1,
			'user_id' => 1,
			'group_id' => 1,
			'role' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-10-20 08:00:56',
			'modified' => '2014-10-20 08:00:56'
		),
	);

}
