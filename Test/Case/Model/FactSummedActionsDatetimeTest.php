<?php
App::uses('FactSummedActionsDatetime', 'Model');

/**
 * FactSummedActionsDatetime Test Case
 *
 */
class FactSummedActionsDatetimeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.fact_summed_actions_datetime',
		'app.system',
		'app.customer',
		'app.person',
		'app.user',
		'app.action',
		'app.group',
		'app.module',
		'app.artefact',
		'app.condition',
		'app.rule',
		'app.rule_condition',
		'app.action_condition',
		'app.dimension_verb',
		'app.fact_user_actions_date',
		'app.dimension_date',
		'app.dimension_verb_condition',
		'app.artefact_condition',
		'app.material',
		'app.module_condition',
		'app.role',
		'app.group_condition',
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
		$this->FactSummedActionsDatetime = ClassRegistry::init('FactSummedActionsDatetime');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FactSummedActionsDatetime);

		parent::tearDown();
	}

}
