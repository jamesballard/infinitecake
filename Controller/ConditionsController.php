<?php
App::uses('AppController', 'Controller');
/**
 * Conditions Controller
 *
 * @property Condition $Condition
 */
class ConditionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Condition->recursive = 0;
		$this->set('conditions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		$this->set('condition', $this->Condition->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Condition->create();
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		}
		$modules = $this->Condition->Module->find('list');
		$groups = $this->Condition->Group->find('list');
		$users = $this->Condition->User->find('list');
		$this->set(compact('modules', 'groups', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Condition->read(null, $id);
		}
		$modules = $this->Condition->Module->find('list');
		$groups = $this->Condition->Group->find('list');
		$users = $this->Condition->User->find('list');
		$this->set(compact('modules', 'groups', 'users'));
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
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		if ($this->Condition->delete()) {
			$this->Session->setFlash(__('Condition deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Condition was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Condition->recursive = 0;
		$this->set('conditions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		$this->set('condition', $this->Condition->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Condition->create();
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		}
		$modules = $this->Condition->Module->find('list');
		$groups = $this->Condition->Group->find('list');
		$users = $this->Condition->User->find('list');
		$this->set(compact('modules', 'groups', 'users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Condition->read(null, $id);
		}
		$modules = $this->Condition->Module->find('list');
		$groups = $this->Condition->Group->find('list');
		$users = $this->Condition->User->find('list');
		$this->set(compact('modules', 'groups', 'users'));
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
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		if ($this->Condition->delete()) {
			$this->Session->setFlash(__('Condition deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Condition was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
