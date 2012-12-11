<?php
App::uses('AppController', 'Controller');
/**
 * Communities Controller
 *
 * @property Community $Community
 */
class CommunitiesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Community->recursive = 0;
		$this->set('communities', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Community->id = $id;
		if (!$this->Community->exists()) {
			throw new NotFoundException(__('Invalid community'));
		}
		$this->set('community', $this->Community->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Community->create();
			if ($this->Community->save($this->request->data)) {
				$this->Session->setFlash(__('The community has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The community could not be saved. Please, try again.'));
			}
		}
		$customers = $this->Community->Customer->find('list');
		$people = $this->Community->Person->find('list');
		$this->set(compact('customers', 'people'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Community->id = $id;
		if (!$this->Community->exists()) {
			throw new NotFoundException(__('Invalid community'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Community->save($this->request->data)) {
				$this->Session->setFlash(__('The community has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The community could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Community->read(null, $id);
		}
		$customers = $this->Community->Customer->find('list');
		$people = $this->Community->Person->find('list');
		$this->set(compact('customers', 'people'));
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
		$this->Community->id = $id;
		if (!$this->Community->exists()) {
			throw new NotFoundException(__('Invalid community'));
		}
		if ($this->Community->delete()) {
			$this->Session->setFlash(__('Community deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Community was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Community->recursive = 0;
		$this->set('communities', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Community->id = $id;
		if (!$this->Community->exists()) {
			throw new NotFoundException(__('Invalid community'));
		}
		$this->set('community', $this->Community->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Community->create();
			if ($this->Community->save($this->request->data)) {
				$this->Session->setFlash(__('The community has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The community could not be saved. Please, try again.'));
			}
		}
		$customers = $this->Community->Customer->find('list');
		$people = $this->Community->Person->find('list');
		$this->set(compact('customers', 'people'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Community->id = $id;
		if (!$this->Community->exists()) {
			throw new NotFoundException(__('Invalid community'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Community->save($this->request->data)) {
				$this->Session->setFlash(__('The community has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The community could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Community->read(null, $id);
		}
		$customers = $this->Community->Customer->find('list');
		$people = $this->Community->Person->find('list');
		$this->set(compact('customers', 'people'));
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
		$this->Community->id = $id;
		if (!$this->Community->exists()) {
			throw new NotFoundException(__('Invalid community'));
		}
		if ($this->Community->delete()) {
			$this->Session->setFlash(__('Community deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Community was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
