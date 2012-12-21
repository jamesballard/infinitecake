<?php
App::uses('FactUserVerbRuleDate', 'Model');

/**
 * FactUserVerbRuleDate Test Case
 *
 */
class FactUserVerbRuleDateTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.fact_user_verb_rule_date',
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
		'app.position'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FactUserVerbRuleDate = ClassRegistry::init('FactUserVerbRuleDate');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FactUserVerbRuleDate);

		parent::tearDown();
	}

}
