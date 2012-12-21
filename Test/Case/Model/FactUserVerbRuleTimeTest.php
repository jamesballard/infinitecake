<?php
App::uses('FactUserVerbRuleTime', 'Model');

/**
 * FactUserVerbRuleTime Test Case
 *
 */
class FactUserVerbRuleTimeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.fact_user_verb_rule_time',
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
		'app.rule',
		'app.rule_condition',
		'app.action_condition',
		'app.dimension_verb',
		'app.fact_user_actions_date',
		'app.dimension_date',
		'app.dimension_verb_condition',
		'app.role',
		'app.material',
		'app.dirobject',
		'app.position',
		'app.dimension_time',
		'app.fact_user_actions_time'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FactUserVerbRuleTime = ClassRegistry::init('FactUserVerbRuleTime');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FactUserVerbRuleTime);

		parent::tearDown();
	}

}
