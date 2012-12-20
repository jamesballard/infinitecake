<?php
App::uses('DimensionTime', 'Model');

/**
 * DimensionTime Test Case
 *
 */
class DimensionTimeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		$this->DimensionTime = ClassRegistry::init('DimensionTime');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DimensionTime);

		parent::tearDown();
	}

}
