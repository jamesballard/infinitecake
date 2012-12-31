<?php
App::uses('AppController', 'Controller');
/**
 * Artefacts Controller
 *
 * @property Artefact $Artefact
 */
class ArtefactsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Artefact->recursive = 0;
		$this->set('artefacts', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Artefact->id = $id;
		if (!$this->Artefact->exists()) {
			throw new NotFoundException(__('Invalid artefact'));
		}
		$this->set('artefact', $this->Artefact->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Artefact->create();
			if ($this->Artefact->save($this->request->data)) {
				$this->Session->setFlash(__('The artefact has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artefact could not be saved. Please, try again.'));
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
		$this->Artefact->id = $id;
		if (!$this->Artefact->exists()) {
			throw new NotFoundException(__('Invalid artefact'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Artefact->save($this->request->data)) {
				$this->Session->setFlash(__('The artefact has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artefact could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Artefact->read(null, $id);
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
		$this->Artefact->id = $id;
		if (!$this->Artefact->exists()) {
			throw new NotFoundException(__('Invalid artefact'));
		}
		if ($this->Artefact->delete()) {
			$this->Session->setFlash(__('Artefact deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Artefact was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Artefact->recursive = 0;
		$this->set('artefacts', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Artefact->id = $id;
		if (!$this->Artefact->exists()) {
			throw new NotFoundException(__('Invalid artefact'));
		}
		$this->set('artefact', $this->Artefact->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Artefact->create();
			if ($this->Artefact->save($this->request->data)) {
				$this->Session->setFlash(__('The artefact has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artefact could not be saved. Please, try again.'));
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
		$this->Artefact->id = $id;
		if (!$this->Artefact->exists()) {
			throw new NotFoundException(__('Invalid artefact'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Artefact->save($this->request->data)) {
				$this->Session->setFlash(__('The artefact has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artefact could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Artefact->read(null, $id);
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
		$this->Artefact->id = $id;
		if (!$this->Artefact->exists()) {
			throw new NotFoundException(__('Invalid artefact'));
		}
		if ($this->Artefact->delete()) {
			$this->Session->setFlash(__('Artefact deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Artefact was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
