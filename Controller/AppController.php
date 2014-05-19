<?php
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
App::uses('MyController', 'Tools.Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends MyController {

    public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers', 'userModel' => 'Member'),
            )
        ),
        'Session'
    );

    public $helpers = array('Html', 'Form' => array('className' => 'BootstrapForm.BootstrapForm'), 'Session', 'Time', 'Permissions', 'Chosen.Chosen');
    
    // $uses is where you specify which models this controller uses
    var $uses = array('FactSummedActionsDatetime', 'FactSummedVerbRuleDatetime', 'Member', 'System',
        'Customer', 'Rule', 'Department', 'Course', 'Condition', 'Artefact', 'Report');
    
    function beforeFilter() {
        //Configure AuthComponent
        $this->Auth->loginAction = array('controller' => 'members', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'members', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'display', 'home');
        
        //Make the logged in member available to all views
		# load current_user
        if ($this->Auth->user('Member.username')):
            $current_user = $this->Member->find('first', array(
                    'contain' => array(
                        'Membership' => array(

                        )
                    ),
                    'conditions' => array(
                        'username' => $this->Auth->user('Member.username')
                    )
                )
            );
            $this->Session->write('current_user', $current_user);
			$this->set('current_user', $current_user);
		endif;

        if (isset($current_user)) {
            $customer = array(
                $this->get_allCustomersID(),
                $current_user['Member']['customer_id']
            );
            $this->set('navreports', $this->Report->getCustomerReports($customer));
        }

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
    	$systems = $this->System->find('list', array(
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
 * @throws MethodNotAllowedException
 */
    
    public function check_admin() {
    	$currentUser = $this->get_currentUser();
    	if($currentUser['Membership']['id'] != 1) {
    		throw new LogicException(__('You do not have permission to view this.'));	
    	}
    }
    
/**
 * Checks that the current user has Administrator privileges.
 *
 * @return boolean
 */
    
    public function is_admin() {
    	$currentUser = $this->get_currentUser();
    	if($currentUser['Membership']['id'] == 1) {
    		return true;
    	}else{
    		return false;
    	}
    }
    
 /**
  * Returns a list formatted array of customers for multi-select form
  *
  * @return array
  */
    
    public function getCustomersList() {
    	return $this->Customer->find('list', array(
    			'contain' => false
    	));
    }

/**
 * Returns a list formatted array of rules for multi-select form
 *
 * @return array
 */
    
    public function getCustomerRules() {
    	$currentUser = $this->get_currentUser();
    	return $this->Rule->find('list', array(
    			'contain' => false,
    			'conditions' => array(
    				'Rule.customer_id' => array(
    					$this->get_allCustomersID(),
    					$currentUser['Member']['customer_id']
    				)
    			)
    		)
    	);
    }

/**
 * Returns a list formatted array of rules for multi-select form
 *
 * @return array
 */

    public function getCustomerDepartments() {
        $currentUser = $this->get_currentUser();
        $departmentRecords = $this->Department->find('all', array(
                'contain' => false,
                'fields' => array('Department.id', 'CONCAT(Department.name, " (",Department.idnumber,")") as name'),
                'conditions' => array(
                    'Department.customer_id' => array(
                        $this->get_allCustomersID(),
                        $currentUser['Member']['customer_id']
                    )
                ),
                'order' => array('Department.lft')
            )
        );
        return Set::combine($departmentRecords, '{n}.Department.id', '{n}.0.name');
    }

/**
 * Returns a list formatted array of rules for multi-select form
 *
 * @return array
 */

    public function getCustomerCourses() {
        $currentUser = $this->get_currentUser();
        $courseRecords = $this->Course->find('all', array(
                'contain' => array(
                    'Department' => array(
                        'fields' => array(
                            'Department.id',
                            'Department.name',
                            'Department.customer_id'
                        )
                    )
                ),
                'fields' => array('Course.id', 'CONCAT(Course.name, " (",Course.idnumber,")") as name'),
                'conditions' => array(
                    'Department.customer_id' => array(
                        $this->get_allCustomersID(),
                        $currentUser['Member']['customer_id']
                    )
                )
            )
        );
        return Set::combine($courseRecords, '{n}.Course.id', '{n}.0.name');
    }

    /**
     * Returns a list formatted array of conditions for multi-select form
     *
     * @param $rule_type integer
     * @return array
     */

    public function getCustomerConditions() {
        $currentUser = $this->get_currentUser();
        return $this->Condition->find('list', array(
                'conditions' => array(
                    'Condition.type !=' => 2,
                    'Condition.customer_id' => array(
                        $this->get_allCustomersID(),
                        $currentUser['Member']['customer_id']
                    )
                )
            )
        );
    }

    /**
     * Returns a list formatted array of rules for multi-select form
     *
     * @return array
     */

    public function getCustomerArtefacts() {
        $currentUser = $this->get_currentUser();
        return $this->Artefact->getArtefactsByCustomerId($currentUser['Member']['customer_id']);
    }

    /*
     * Takes a conditions array (2-dimensional), flattens it to 1, and implodes to create unique cache reference.
     *
     * @var array $conditions
     * return string
     */
    public function formatCacheConditions($conditions) {
        return implode('.', array_map(function($value) {
            if (is_array($value)) {
                return implode('.', $value);
            } else {
                return $value;
            }
        }, $conditions));
    }
}
