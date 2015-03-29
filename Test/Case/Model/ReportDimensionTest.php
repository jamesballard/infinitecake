<?php
App::uses('ReportDimension', 'Model');

/**
 * ReportDimension Test Case
 *
 */
class ReportDimensionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.report_dimension',
		'app.report',
		'app.dimension'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ReportDimension = ClassRegistry::init('ReportDimension');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ReportDimension);

		parent::tearDown();
	}

}
