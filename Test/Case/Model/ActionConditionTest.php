<?php
App::uses('ActionCondition', 'Model');

/**
 * ActionCondition Test Case
 *
 */
class ActionConditionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.action_condition',
		'app.action',
		'app.user',
		'app.person',
		'app.customer',
		'app.community',
		'app.artefact',
		'app.module',
		'app.group',
		'app.system',
		'app.condition',
		'app.role',
		'app.material',
		'app.dirobject',
		'app.rule',
		'app.position'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ActionCondition = ClassRegistry::init('ActionCondition');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ActionCondition);

		parent::tearDown();
	}

}
