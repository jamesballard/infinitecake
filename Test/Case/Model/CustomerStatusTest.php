<?php
App::uses('CustomerStatus', 'Model');

/**
 * CustomerStatus Test Case
 *
 */
class CustomerStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.customer_status',
		'app.customer',
		'app.person',
		'app.department',
		'app.course',
		'app.group',
		'app.system',
		'app.module',
		'app.artefact',
		'app.condition',
		'app.rule',
		'app.rule_condition',
		'app.action',
		'app.user',
		'app.dimension_verb',
		'app.fact_summed_actions_datetime',
		'app.dimension_date',
		'app.fact_user_actions_date',
		'app.dimension_time',
		'app.fact_user_actions_time',
		'app.dimension_verb_condition',
		'app.action_condition',
		'app.artefact_condition',
		'app.course_condition',
		'app.module_condition',
		'app.person_course'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CustomerStatus = ClassRegistry::init('CustomerStatus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CustomerStatus);

		parent::tearDown();
	}

}
