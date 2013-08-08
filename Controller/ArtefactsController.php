<?php
App::uses('AppController', 'Controller');
/**
 * Artefacts Controller
 *
 * @property Artefact $Artefact
 */
class ArtefactsController extends AppController {

	function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'adminManage';
		$this->set('artefact_types', $this->Artefact->artefact_types);
		// conditional ensures only actions that need the vars will receive them
		if (in_array($this->action, array('add', 'edit'))) {
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->paginate = array(
				'contain' => false
			);
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
		$artefact = $this->Artefact->find('first',array(
				'contain' => false,
				'conditions' => array('Artefact.id' => $id)
		));
		$this->set('artefact', $artefact);
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

    public function help() {

    }
}
