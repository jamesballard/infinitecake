<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	function beforeFilter() {
		parent::beforeFilter();
        $this->layout = 'config';
        $this->set('menu', 'configure');
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$currentUser = $this->get_currentUser();
		$this->paginate = array(
				'contain' => array(
						'System' => array(
								'fields' => array(
										'System.id',
										'System.name',
										'System.customer_id'
									)
							),
						'Person' => array(
								'fields' => array(
										'Person.id',
										'Person.idnumber'
									)
							)
					),
				'conditions' => array(
						'System.customer_id' => array(
								$currentUser['Member']['customer_id']
						)
				),
		);
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$user = $this->User->find('first',array(
				'contain' => array(
						'System' => array(
								'fields' => array(
										'System.id',
										'System.name',
										'System.customer_id'
									)
							),
						'Person' => array(
								'fields' => array(
										'Person.id',
										'Person.idnumber'
									)
							)
					),
				'conditions' => array(
						'User.id' => $id
				),
		));
		$this->check_admin();
		$this->set('user', $user);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$this->check_admin();
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$this->check_admin();
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function help() {

    }
}
