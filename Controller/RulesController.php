<?php
App::uses('AppController', 'Controller');
/**
 * Rules Controller
 *
 * @property Rule $Rule
 */
class RulesController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'configManage';
        $this->set('rule_types', $this->Rule->rule_types);
        $this->set('rule_cats', $this->Rule->rule_cats);
        $this->set('rule_subs', $this->Rule->rule_subs);
		// conditional ensures only actions that need the vars will receive them
		if (in_array($this->action, array('add', 'edit'))) {
			$conditions = $this->getCustomerConditions();
			$customers = $this->getCustomersList();
        	$this->set(compact('conditions', 'customers'));
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$currentUser = $this->get_currentUser();
		
		if($this->is_admin()):
			$this->paginate = array(
				'contain' => array(
					'Customer' => array(
						'fields' => array(
                            'Customer.id',
							'Customer.name'
						)
					)
				)
			);
		else:
			$this->paginate = array(
				'conditions' => array(
					'Rule.customer_id' => array(
						$this->get_allCustomersID(),
						$currentUser['Member']['customer_id']
					)
				)	
			);
		endif;
		
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
		$this->check_allcustomerID($rule['Rule']['customer_id']);		
		$this->set('rule', $rule);		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Rule->create();
			if ($this->Rule->save($this->request->data)) {
				$this->Session->setFlash(__('The rule has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rule could not be saved. Please, try again.'));
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
			$this->request->data = $this->Rule->find('first',array(
                'contain' => array(
                    'Condition' => array(
                        'fields' => array(
                            'Condition.id',
                            'Condition.name'
                        )
                    ),
                    'RuleCondition'
                ),
                'conditions' => array('id' => $id)
            ));
		}
		$this->check_customerID($this->request->data['Rule']['customer_id']); 		
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

    public function help() {

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
