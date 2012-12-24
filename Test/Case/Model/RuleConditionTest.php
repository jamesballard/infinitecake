<?php
App::uses('RuleCondition', 'Model');

/**
 * RuleCondition Test Case
 *
 */
class RuleConditionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.rule_condition',
		'app.rule',
		'app.artefact',
		'app.community',
		'app.customer',
		'app.person',
		'app.user',
		'app.system',
		'app.group',
		'app.action',
		'app.module',
		'app.condition',
		'app.material',
		'app.role',
		'app.position',
		'app.dirobject'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RuleCondition = ClassRegistry::init('RuleCondition');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RuleCondition);

		parent::tearDown();
	}

}
