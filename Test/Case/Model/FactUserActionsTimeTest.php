<?php
App::uses('FactUserActionsTime', 'Model');

/**
 * FactUserActionsTime Test Case
 *
 */
class FactUserActionsTimeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.fact_user_actions_time',
		'app.user',
		'app.person',
		'app.customer',
		'app.community',
		'app.artefact',
		'app.module',
		'app.group',
		'app.system',
		'app.action',
		'app.condition',
		'app.role',
		'app.material',
		'app.dirobject',
		'app.rule',
		'app.position',
		'app.dimension_time'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FactUserActionsTime = ClassRegistry::init('FactUserActionsTime');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FactUserActionsTime);

		parent::tearDown();
	}

}
