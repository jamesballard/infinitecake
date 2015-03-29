<?php
App::uses('GroupCourse', 'Model');

/**
 * GroupCourse Test Case
 *
 */
class GroupCourseTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.group_course',
		'app.course',
		'app.department',
		'app.customer',
		'app.person',
		'app.user',
		'app.system',
		'app.group',
		'app.action',
		'app.module',
		'app.artefact',
		'app.condition',
		'app.rule',
		'app.rule_condition',
		'app.action_condition',
		'app.dimension_verb',
		'app.fact_summed_actions_datetime',
		'app.dimension_date',
		'app.fact_user_actions_date',
		'app.dimension_time',
		'app.fact_user_actions_time',
		'app.dimension_verb_condition',
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
		$this->GroupCourse = ClassRegistry::init('GroupCourse');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->GroupCourse);

		parent::tearDown();
	}

}
