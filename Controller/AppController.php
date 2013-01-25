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

    public $helpers = array('Html', 'Form', 'Session', 'Chosen.Chosen');
    
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
    
    public function get_currentUser() {
    	return $this->Session->read('current_user');
    }
    
    public function get_allCustomersID() {
    	//This returns the database value for 'All Customers' (should be 1)
    	return 1;
    }
    
    public function get_customerSystems() {
    	$current_user = $this->get_currentUser();
    	$system = new System();
    	$systems = $system->find('list', array(
    			'conditions' => array('customer_id' => $current_user['Member']['customer_id'])
    		));
    	return $systems;
    }
}
