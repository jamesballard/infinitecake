<?php
App::uses('AppController', 'Controller');
/**
 * DimensionVerbs Controller
 *
 * @property DimensionVerb $DimensionVerb
 */
class DimensionVerbsController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'adminManage';
		$this->set('verb_types', $this->DimensionVerb->verb_types);
		// conditional ensures only actions that need the vars will receive them
		if (in_array($this->action, array('add', 'edit'))) {
			$artefacts = $this->DimensionVerb->Artefact->find('list');
			$this->set(compact('artefacts'));
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->paginate = array(
				'contain' => array(
					'Artefact' => array(
						'fields' => array(
							'Artefact.id',
							'Artefact.name'
						)
					)
				)
			);
		$this->set('dimensionVerbs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->DimensionVerb->id = $id;
		if (!$this->DimensionVerb->exists()) {
			throw new NotFoundException(__('Invalid dimension verb'));
		}
		$dimensionVerbs = $this->DimensionVerb->find('first',array(
				'contain' => array(
						'Artefact' => array(
								'fields' => array(
										'Artefact.id',
										'Artefact.name'
								)
						)
				),
				'conditions' => array('DimensionVerb.id' => $id)
		));
		$this->set('dimensionVerb', $dimensionVerbs);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DimensionVerb->create();
			if ($this->DimensionVerb->save($this->request->data)) {
				$this->Session->setFlash(__('The dimension verb has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dimension verb could not be saved. Please, try again.'));
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
		$this->DimensionVerb->id = $id;
		if (!$this->DimensionVerb->exists()) {
			throw new NotFoundException(__('Invalid dimension verb'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DimensionVerb->save($this->request->data)) {
				$this->Session->setFlash(__('The dimension verb has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dimension verb could not be saved. Please, try again.'));
			}
		} else {
            $this->DimensionVerb->recursive = -1;
			$this->request->data = $this->DimensionVerb->read(null, $id);
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
		$this->DimensionVerb->id = $id;
		if (!$this->DimensionVerb->exists()) {
			throw new NotFoundException(__('Invalid dimension verb'));
		}
		if ($this->DimensionVerb->delete()) {
			$this->Session->setFlash(__('Dimension verb deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Dimension verb was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function help() {

    }

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->DimensionVerb->recursive = 0;
		$this->set('dimensionVerbs', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->DimensionVerb->id = $id;
		if (!$this->DimensionVerb->exists()) {
			throw new NotFoundException(__('Invalid dimension verb'));
		}
		$this->set('dimensionVerb', $this->DimensionVerb->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->DimensionVerb->create();
			if ($this->DimensionVerb->save($this->request->data)) {
				$this->Session->setFlash(__('The dimension verb has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dimension verb could not be saved. Please, try again.'));
			}
		}
		$artefacts = $this->DimensionVerb->Artefact->find('list');
		$this->set(compact('artefacts'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->DimensionVerb->id = $id;
		if (!$this->DimensionVerb->exists()) {
			throw new NotFoundException(__('Invalid dimension verb'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DimensionVerb->save($this->request->data)) {
				$this->Session->setFlash(__('The dimension verb has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dimension verb could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->DimensionVerb->read(null, $id);
		}
		$artefacts = $this->DimensionVerb->Artefact->find('list');
		$this->set(compact('artefacts'));
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
		$this->DimensionVerb->id = $id;
		if (!$this->DimensionVerb->exists()) {
			throw new NotFoundException(__('Invalid dimension verb'));
		}
		if ($this->DimensionVerb->delete()) {
			$this->Session->setFlash(__('Dimension verb deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Dimension verb was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
