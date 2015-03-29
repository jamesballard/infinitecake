<?php
App::uses('DashboardReport', 'Model');

/**
 * DashboardReport Test Case
 *
 */
class DashboardReportTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.dashboard_report',
		'app.report',
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
		'app.customer_artefact',
		'app.person_course',
		'app.filter',
		'app.report_dimension',
		'app.dimension',
		'app.report_value',
		'app.value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DashboardReport = ClassRegistry::init('DashboardReport');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DashboardReport);

		parent::tearDown();
	}

}
