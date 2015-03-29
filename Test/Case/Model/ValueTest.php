<?php
App::uses('Value', 'Model');

/**
 * Value Test Case
 *
 */
class ValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Value = ClassRegistry::init('Value');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Value);

		parent::tearDown();
	}

}
