<?php
App::uses('AppController', 'Controller');
/**
 * Dirobjects Controller
 *
 * @property Dirobject $Dirobject
 */
class DirobjectsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Dirobject->recursive = 0;
		$this->set('dirobjects', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Dirobject->id = $id;
		if (!$this->Dirobject->exists()) {
			throw new NotFoundException(__('Invalid dirobject'));
		}
		$this->set('dirobject', $this->Dirobject->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Dirobject->create();
			if ($this->Dirobject->save($this->request->data)) {
				$this->Session->setFlash(__('The dirobject has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dirobject could not be saved. Please, try again.'));
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
		$this->Dirobject->id = $id;
		if (!$this->Dirobject->exists()) {
			throw new NotFoundException(__('Invalid dirobject'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Dirobject->save($this->request->data)) {
				$this->Session->setFlash(__('The dirobject has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dirobject could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Dirobject->read(null, $id);
		}
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
		$this->Dirobject->id = $id;
		if (!$this->Dirobject->exists()) {
			throw new NotFoundException(__('Invalid dirobject'));
		}
		if ($this->Dirobject->delete()) {
			$this->Session->setFlash(__('Dirobject deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Dirobject was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Dirobject->recursive = 0;
		$this->set('dirobjects', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Dirobject->id = $id;
		if (!$this->Dirobject->exists()) {
			throw new NotFoundException(__('Invalid dirobject'));
		}
		$this->set('dirobject', $this->Dirobject->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Dirobject->create();
			if ($this->Dirobject->save($this->request->data)) {
				$this->Session->setFlash(__('The dirobject has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dirobject could not be saved. Please, try again.'));
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
		$this->Dirobject->id = $id;
		if (!$this->Dirobject->exists()) {
			throw new NotFoundException(__('Invalid dirobject'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Dirobject->save($this->request->data)) {
				$this->Session->setFlash(__('The dirobject has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dirobject could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Dirobject->read(null, $id);
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
		$this->Dirobject->id = $id;
		if (!$this->Dirobject->exists()) {
			throw new NotFoundException(__('Invalid dirobject'));
		}
		if ($this->Dirobject->delete()) {
			$this->Session->setFlash(__('Dirobject deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Dirobject was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
