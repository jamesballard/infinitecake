<?php
App::uses('Membership', 'Model');

/**
 * Membership Test Case
 *
 */
class MembershipTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.membership'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Membership = ClassRegistry::init('Membership');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Membership);

		parent::tearDown();
	}

}
