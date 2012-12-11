<?php
App::uses('AppController', 'Controller');
/**
 * Labours Controller
 *
 * @property Labour $Labour
 */
class LaboursController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Labour->recursive = 0;
		$this->set('labours', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Labour->id = $id;
		if (!$this->Labour->exists()) {
			throw new NotFoundException(__('Invalid labour'));
		}
		$this->set('labour', $this->Labour->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Labour->create();
			if ($this->Labour->save($this->request->data)) {
				$this->Session->setFlash(__('The labour has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The labour could not be saved. Please, try again.'));
			}
		}
		$people = $this->Labour->Person->find('list');
		$communities = $this->Labour->Community->find('list');
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
		$this->Labour->id = $id;
		if (!$this->Labour->exists()) {
			throw new NotFoundException(__('Invalid labour'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Labour->save($this->request->data)) {
				$this->Session->setFlash(__('The labour has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The labour could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Labour->read(null, $id);
		}
		$people = $this->Labour->Person->find('list');
		$communities = $this->Labour->Community->find('list');
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
		$this->Labour->id = $id;
		if (!$this->Labour->exists()) {
			throw new NotFoundException(__('Invalid labour'));
		}
		if ($this->Labour->delete()) {
			$this->Session->setFlash(__('Labour deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Labour was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Labour->recursive = 0;
		$this->set('labours', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Labour->id = $id;
		if (!$this->Labour->exists()) {
			throw new NotFoundException(__('Invalid labour'));
		}
		$this->set('labour', $this->Labour->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Labour->create();
			if ($this->Labour->save($this->request->data)) {
				$this->Session->setFlash(__('The labour has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The labour could not be saved. Please, try again.'));
			}
		}
		$people = $this->Labour->Person->find('list');
		$communities = $this->Labour->Community->find('list');
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
		$this->Labour->id = $id;
		if (!$this->Labour->exists()) {
			throw new NotFoundException(__('Invalid labour'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Labour->save($this->request->data)) {
				$this->Session->setFlash(__('The labour has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The labour could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Labour->read(null, $id);
		}
		$people = $this->Labour->Person->find('list');
		$communities = $this->Labour->Community->find('list');
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
		$this->Labour->id = $id;
		if (!$this->Labour->exists()) {
			throw new NotFoundException(__('Invalid labour'));
		}
		if ($this->Labour->delete()) {
			$this->Session->setFlash(__('Labour deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Labour was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
