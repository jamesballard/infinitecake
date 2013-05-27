<?php
App::uses('AppController', 'Controller');
/**
 * Modules Controller
 *
 * @property Module $Module
 */
class ModulesController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'configManage';
		// conditional ensures only actions that need the vars will receive them
		if (in_array($this->action, array('add'))) {
			$artefacts = $this->Module->Artefact->find('list');
			$groups = $this->Module->Group->find('list');
			$systems = $this->Module->System->find('list');
			$this->set(compact('artefacts', 'groups', 'systems'));
		}
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
						'Artefact' => array(
								'fields' => array(
										'Artefact.name'
									)	
							),
						'Group' => array(
								'fields' => array(
										'Group.id',
										'Group.idnumber'
									)
							)
					),
				'conditions' => array(
						'System.customer_id' => array(
								$currentUser['Member']['customer_id']
						)
				),
		);
		$this->set('modules', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid module'));
		}
		$module = $this->Module->find('first',array(
				'contain' => array(
						'System' => array(
								'fields' => array(
										'System.id',
										'System.name',
										'System.customer_id'
									)
							),
						'Artefact' => array(
								'fields' => array(
										'Artefact.name'
									)	
							),
						'Group' => array(
								'fields' => array(
										'Group.id',
										'Group.idnumber'
									)
							)
					),
				'conditions' => array('Module.id' => $id)
				)
		);
		$this->check_customerID($module['System']['customer_id']);
		$this->set('module', $module);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Module->create();
			if ($this->Module->save($this->request->data)) {
				$this->Session->setFlash(__('The module has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The module could not be saved. Please, try again.'));
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
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid module'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Module->save($this->request->data)) {
				$this->Session->setFlash(__('The module has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The module could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Module->find('first',array(
				'contain' => array(
						'System' => array(
								'fields' => array(
										'System.id',
										'System.name',
										'System.customer_id'
									)
							)
					),
				'conditions' => array('Module.id' => $id)
				)
		);
		}
		$this->check_customerID($this->request->data['System']['customer_id']);
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
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid module'));
		}
		if ($this->Module->delete()) {
			$this->Session->setFlash(__('Module deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Module was not deleted'));
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
		$this->Module->recursive = 0;
		$this->set('modules', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid module'));
		}
		$this->set('module', $this->Module->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Module->create();
			if ($this->Module->save($this->request->data)) {
				$this->Session->setFlash(__('The module has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The module could not be saved. Please, try again.'));
			}
		}
		$artefacts = $this->Module->Artefact->find('list');
		$groups = $this->Module->Group->find('list');
		$systems = $this->Module->System->find('list');
		$this->set(compact('artefacts', 'groups', 'systems'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid module'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Module->save($this->request->data)) {
				$this->Session->setFlash(__('The module has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The module could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Module->read(null, $id);
		}
		$artefacts = $this->Module->Artefact->find('list');
		$groups = $this->Module->Group->find('list');
		$systems = $this->Module->System->find('list');
		$this->set(compact('artefacts', 'groups', 'systems'));
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
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid module'));
		}
		if ($this->Module->delete()) {
			$this->Session->setFlash(__('Module deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Module was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
