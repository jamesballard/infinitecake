<?php
App::uses('DimensionVerbCondition', 'Model');

/**
 * DimensionVerbCondition Test Case
 *
 */
class DimensionVerbConditionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.dimension_verb_condition',
		'app.dimension_verb',
		'app.artefact',
		'app.community',
		'app.customer',
		'app.person',
		'app.rule',
		'app.condition',
		'app.rule_condition',
		'app.action',
		'app.user',
		'app.system',
		'app.group',
		'app.module',
		'app.material',
		'app.role',
		'app.action_condition',
		'app.position',
		'app.dirobject',
		'app.fact_user_actions_date',
		'app.dimension_date'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DimensionVerbCondition = ClassRegistry::init('DimensionVerbCondition');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DimensionVerbCondition);

		parent::tearDown();
	}

}
