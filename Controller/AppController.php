<?php
App::uses('Member', 'Model');
App::uses('System', 'Model');
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers', 'userModel' => 'Member'),
            )
        ),
        'Session'
    );

    public $helpers = array('Html', 'Form', 'Session', 'Permissions', 'Chosen.Chosen');
    
    // $uses is where you specify which models this controller uses
    var $uses = array('FactSummedActionsDatetime', 'FactSummedVerbRuleDatetime');
    
    function beforeFilter() {
        //Configure AuthComponent
        $this->Auth->loginAction = array('controller' => 'members', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'members', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => '', 'action' => '');
        
        //Make the logged in member available to all views
		# load current_user
		$currentMember = new Member();
		$currentMember->username = AuthComponent::user('username');
		$current_user = $currentMember->find();
		$this->Session->write('current_user', $current_user);
		$this->set('current_user', $current_user);
    }
    
/**
  * Returns details of the currently logged in user
  *
  * @return array
  */
    
    public function get_currentUser() {
    	return $this->Session->read('current_user');
    }
    
/**
  * Returns the ID of the special 'all customers' account.  
  * Typically used to filter results in WHERE conditions that require results
  * available to all customers.
  *
  * @return integer
  */
    
    public function get_allCustomersID() {
    	//This returns the database value for 'All Customers' (should be 1)
    	return 1;
    }
 
/**
  * Returns a list formatted array of a customer's system for multi-select lists
  *
  * @return array
  */
    
    public function get_customerSystems() {
    	$current_user = $this->get_currentUser();
    	$system = new System();
    	$systems = $system->find('list', array(
    			'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
    		));
    	return $systems;
    }

/**
 * Checks that the record belongs to the customer.
 * Used to check the user is not accessing a record for another customer
 *
 * @param string $customer_id 
 * @throws MethodNotAllowedException
 */
    
    public function check_customerID($customer_id) {
    	$currentUser = $this->get_currentUser();
    	if($customer_id != $currentUser['Member']['customer_id'] && !$this->is_admin()) {
    		throw new LogicException(__('You do not have permission to view this.'));
    	}
    }
    
/**
  * Checks that the record belongs to the customer or is available to all customers.
  * Used to check the user is not accessing a record for another customer
  *
  * @param string $customer_id
  * @throws MethodNotAllowedException
  */
    
    public function check_allcustomerID($customer_id) {
    	$currentUser = $this->get_currentUser();
    	//Combine customer ID with all customers ID
    	$validCustomers = array($currentUser['Member']['customer_id'], $this->get_allCustomersID());
    	if(!in_array($customer_id, $validCustomers) && !$this->is_admin()) {
    		throw new LogicException(__('You do not have permission to view this.'));
    	}
    }
    
/**
 * Checks that the current user has Administrator privileges.
 *
 * @param array $current_user
 * @return boolean
 */
    
    public function is_admin() {
    	$currentUser = $this->get_currentUser();
    	if($currentUser['Membership']['id'] != 1) {
    		throw new LogicException(__('You do not have permission to view this.'));	
    	}
    }
}
