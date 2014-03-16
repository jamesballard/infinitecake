<?php
App::uses('ReportValue', 'Model');

/**
 * ReportValue Test Case
 *
 */
class ReportValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.report_value',
		'app.report',
		'app.value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ReportValue = ClassRegistry::init('ReportValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ReportValue);

		parent::tearDown();
	}

}
