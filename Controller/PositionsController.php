<?php
App::uses('AppController', 'Controller');
/**
 * Positions Controller
 *
 * @property Position $Position
 */
class PositionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Position->recursive = 0;
		$this->set('positions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Position->id = $id;
		if (!$this->Position->exists()) {
			throw new NotFoundException(__('Invalid position'));
		}
		$this->set('position', $this->Position->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Position->create();
			if ($this->Position->save($this->request->data)) {
				$this->Session->setFlash(__('The position has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The position could not be saved. Please, try again.'));
			}
		}
		$people = $this->Position->Person->find('list');
		$communities = $this->Position->Community->find('list');
		$this->set(compact('people', 'communities'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Position->id = $id;
		if (!$this->Position->exists()) {
			throw new NotFoundException(__('Invalid position'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Position->save($this->request->data)) {
				$this->Session->setFlash(__('The position has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The position could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Position->read(null, $id);
		}
		$people = $this->Position->Person->find('list');
		$communities = $this->Position->Community->find('list');
		$this->set(compact('people', 'communities'));
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
		$this->Position->id = $id;
		if (!$this->Position->exists()) {
			throw new NotFoundException(__('Invalid position'));
		}
		if ($this->Position->delete()) {
			$this->Session->setFlash(__('Position deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Position was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Position->recursive = 0;
		$this->set('positions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Position->id = $id;
		if (!$this->Position->exists()) {
			throw new NotFoundException(__('Invalid position'));
		}
		$this->set('position', $this->Position->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Position->create();
			if ($this->Position->save($this->request->data)) {
				$this->Session->setFlash(__('The position has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The position could not be saved. Please, try again.'));
			}
		}
		$people = $this->Position->Person->find('list');
		$communities = $this->Position->Community->find('list');
		$this->set(compact('people', 'communities'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Position->id = $id;
		if (!$this->Position->exists()) {
			throw new NotFoundException(__('Invalid position'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Position->save($this->request->data)) {
				$this->Session->setFlash(__('The position has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The position could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Position->read(null, $id);
		}
		$people = $this->Position->Person->find('list');
		$communities = $this->Position->Community->find('list');
		$this->set(compact('people', 'communities'));
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
		$this->Position->id = $id;
		if (!$this->Position->exists()) {
			throw new NotFoundException(__('Invalid position'));
		}
		if ($this->Position->delete()) {
			$this->Session->setFlash(__('Position deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Position was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
