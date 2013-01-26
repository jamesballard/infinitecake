<?php
App::uses('AppController', 'Controller');
/**
 * Rules Controller
 *
 * @property Rule $Rule
 */
class RulesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$currentUser = $this->get_currentUser();
		$this->paginate = array(
				'conditions' => array(
					'Rule.customer_id' => array(
						$this->get_allCustomersID(),
						$currentUser['Member']['customer_id']
					)
				)	
		);
		$this->set('rules', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Rule->id = $id;
		if (!$this->Rule->exists()) {
			throw new NotFoundException(__('Invalid rule'));
		}
		$rule = $this->Rule->find('first',array(
				'contain' => array(
					'Condition' => array(
						'fields' => array(
							'Condition.id',
							'Condition.name'
						)
					)
				),
				'conditions' => array('id' => $id)
		));
		$this->set('rule', $rule);
		
		$this->set('types', $this->Rule->rule_types);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$currentUser = $this->get_currentUser();
		if ($this->request->is('post')) {
			$this->Rule->create();
			if ($this->Rule->save($this->request->data)) {
				$this->Session->setFlash(__('The rule has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rule could not be saved. Please, try again.'));
			}
		}
        $conditionsRecords = $this->Rule->Condition->find('all', array(
                'fields' => array('id', 'CONCAT(Condition.name, ": ",Condition.value) as name'),
                'conditions' => array(
					'Condition.type !=' => 2,
					'Condition.customer_id' => array(
							$this->get_allCustomersID(),
							$currentUser['Member']['customer_id']
						)
				),
            )
        );
        $conditions = Set::combine($conditionsRecords, '{n}.Condition.id', '{n}.0.name');
        $this->set(compact('conditions'));

        $this->set('types', $this->Rule->rule_types);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$currentUser = $this->get_currentUser();
		$this->Rule->id = $id;
		if (!$this->Rule->exists()) {
			throw new NotFoundException(__('Invalid rule'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rule->save($this->request->data)) {
				$this->Session->setFlash(__('The rule has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rule could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Rule->read(null, $id);
		}
		
		if($this->request->data['Rule']['customer_id'] != $currentUser['Member']['customer_id']) {
			throw new LogicException(__('You do not have permission to edit this.'));
		}
		
        $conditionsRecords = $this->Rule->Condition->find('all', array(
        		'fields' => array('id', 'CONCAT(Condition.name, ": ",Condition.value) as name'),
        		'conditions' => array(
					'Condition.type !=' => 2,
					'Condition.customer_id' => array(
							$this->get_allCustomersID(),
							$currentUser['Member']['customer_id']
						)
					),
        		));
        $conditions = Set::combine($conditionsRecords, '{n}.Condition.id', '{n}.0.name');
		$this->set(compact('conditions'));
		
		$this->set('types', $this->Rule->rule_types);
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
		$this->Rule->id = $id;
		if (!$this->Rule->exists()) {
			throw new NotFoundException(__('Invalid rule'));
		}
		if ($this->Rule->delete()) {
			$this->Session->setFlash(__('Rule deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rule was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Rule->recursive = 0;
		$this->set('rules', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Rule->id = $id;
		if (!$this->Rule->exists()) {
			throw new NotFoundException(__('Invalid rule'));
		}
		$this->set('rule', $this->Rule->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Rule->create();
			if ($this->Rule->save($this->request->data)) {
				$this->Session->setFlash(__('The rule has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rule could not be saved. Please, try again.'));
			}
		}
		$artefacts = $this->Rule->Artefact->find('list');
		$communities = $this->Rule->Community->find('list');
		$conditions = $this->Rule->Condition->find('list');
		$this->set(compact('artefacts', 'communities', 'conditions'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Rule->id = $id;
		if (!$this->Rule->exists()) {
			throw new NotFoundException(__('Invalid rule'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rule->save($this->request->data)) {
				$this->Session->setFlash(__('The rule has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rule could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Rule->read(null, $id);
		}
		$artefacts = $this->Rule->Artefact->find('list');
		$communities = $this->Rule->Community->find('list');
		$conditions = $this->Rule->Condition->find('list');
		$this->set(compact('artefacts', 'communities', 'conditions'));
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
		$this->Rule->id = $id;
		if (!$this->Rule->exists()) {
			throw new NotFoundException(__('Invalid rule'));
		}
		if ($this->Rule->delete()) {
			$this->Session->setFlash(__('Rule deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rule was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
