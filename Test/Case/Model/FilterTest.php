<?php
App::uses('Filter', 'Model');

/**
 * Filter Test Case
 *
 */
class FilterTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.filter',
		'app.report'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Filter = ClassRegistry::init('Filter');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Filter);

		parent::tearDown();
	}

}
