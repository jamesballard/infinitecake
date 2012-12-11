<?php
/**
 * ModuleFixture
 *
 */
class ModuleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'sysid' => array('type' => 'integer', 'null' => true, 'default' => null),
		'idnumber' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'artefact_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'system_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'artefact_ix' => array('column' => 'artefact_id', 'unique' => 0),
			'group_ix' => array('column' => 'group_id', 'unique' => 0),
			'system_ix' => array('column' => 'system_id', 'unique' => 0)
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
			'idnumber' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'artefact_id' => 1,
			'group_id' => 1,
			'system_id' => 1
		),
	);

}
