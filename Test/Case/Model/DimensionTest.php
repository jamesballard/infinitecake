<?php
App::uses('Dimension', 'Model');

/**
 * Dimension Test Case
 *
 */
class DimensionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.dimension'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Dimension = ClassRegistry::init('Dimension');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Dimension);

		parent::tearDown();
	}

}
