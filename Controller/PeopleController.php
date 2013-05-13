<?php
App::uses('AppController', 'Controller');
/**
 * People Controller
 *
 * @property Person $Person
 */
class PeopleController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'configManage';
		// conditional ensures only actions that need the vars will receive them
		if (in_array($this->action, array('add', 'edit'))) {
			$users = $this->getUsersList();
			$customers = $this->getCustomersList();
            $courses = $this->getCustomerCourses();
            $departments = $this->getCustomerDepartments();
            $this->set(compact('users', 'customers', 'courses', 'departments'));
		}
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$currentUser = $this->get_currentUser();
		if($this->is_admin()):
			$this->paginate = array(
					'contain' => array(
							'Customer' => array(
									'fields' => array(
											'Customer.name'
									)
							)
					)
			);
		else:
			$this->paginate = array(
					'contain' => false,
					'conditions' => array(
							'Person.customer_id' => array(
									$currentUser['Member']['customer_id']
							)
					),
			);
		endif;
		$this->set('people', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$currentUser = $this->get_currentUser();
		
		$this->Person->id = $id;
		if (!$this->Person->exists()) {
			throw new NotFoundException(__('Invalid person'));
		}
		$person = $this->Person->find('first',array(
            'contain' => array(
                'User' => array(
                    'System' => array(
                        'fields' => array(
                            'System.id',
                            'System.name'
                        )
                    ),
                    'fields' => array(
                        'User.id',
                        'User.idnumber',
                        'User.sysid'
                    )
                ),
                'Department' => array(
                    'fields' => array(
                        'Department.id',
                        'Department.name'
                    )
                ),
                'Course' => array(
                    'fields' => array(
                        'Course.id',
                        'Course.idnumber',
                        'Course.name'
                    )
                )
            ),
            'conditions' => array('Person.id' => $id)
        ));
		$this->check_customerID($person['Person']['customer_id']);
		$this->set('person', $person);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Person->create();
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash(__('The person has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$currentUser = $this->get_currentUser();
		
		$this->Person->id = $id;
		if (!$this->Person->exists()) {
			throw new NotFoundException(__('Invalid person'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash(__('The person has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Person->find('first',array(
                'contain' => array(
                    'User' => array(
                        'System' => array(
                            'fields' => array(
                                'System.id',
                                'System.name'
                            )
                        ),
                        'fields' => array(
                            'User.id',
                            'User.idnumber',
                            'User.sysid'
                        )
                    ),
                    'Department' => array(
                        'fields' => array(
                            'Department.id',
                            'Department.name'
                        )
                    ),
                    'Course' => array(
                        'fields' => array(
                            'Course.id',
                            'Course.idnumber'
                        )
                    )
                ),
                'conditions' => array('Person.id' => $id)
            ));
		}
		$this->check_customerID($this->request->data['Person']['customer_id']);
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Person->id = $id;
		if (!$this->Person->exists()) {
			throw new NotFoundException(__('Invalid person'));
		}
		if ($this->Person->delete()) {
			$this->Session->setFlash(__('Person deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Person was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * Provides a JSON feed of users for auto-complete entry
 *
 * @return json
 */
	
	public function jsonfeed() {
		$current_user = $this->Session->read('current_user');
		$users = $this->Person->find('all',array(
					    'conditions' => array('Person.idnumber LIKE'=>'%'.$_GET['term'].'%',
					    		'customer_id' => $current_user['Member']['customer_id']), //array of conditions
					    'contain' => false, //int
					    'fields' => array('Person.idnumber AS label','Person.id AS value'), //array of field names
					)
				);
		$users = Set::extract('/Person/.', $users);		
	
		return new CakeResponse(array('body' => json_encode($users)));
	}
	
/**
 * Returns a list formatted array of users for multi-select form
 *
 * @return array 
 */
	
	private function getUsersList() {
		$currentUser = $this->get_currentUser();
		$userRecords = $this->Person->User->find('all', array(
				'contain' => array(
						'System' => array(
								'fields' => array(
										'System.id',
										'System.name',
										'System.customer_id'
									)
							)
					),
				'fields' => array('id', 'CONCAT(User.idnumber, " (",System.name,": ",User.sysid,")") as name'),
				'conditions' => array(
						'System.customer_id' => array(
                            $this->get_allCustomersID(),
							$currentUser['Member']['customer_id']
						)
				),
		));
		return Set::combine($userRecords, '{n}.User.id', '{n}.0.name');
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Person->recursive = 0;
		$this->set('people', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Person->id = $id;
		if (!$this->Person->exists()) {
			throw new NotFoundException(__('Invalid person'));
		}
		$this->set('person', $this->Person->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Person->create();
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash(__('The person has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Person->id = $id;
		if (!$this->Person->exists()) {
			throw new NotFoundException(__('Invalid person'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash(__('The person has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Person->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Person->id = $id;
		if (!$this->Person->exists()) {
			throw new NotFoundException(__('Invalid person'));
		}
		if ($this->Person->delete()) {
			$this->Session->setFlash(__('Person deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Person was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
