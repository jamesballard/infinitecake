<?php
App::uses('AppController', 'Controller');
/**
 * Conditions Controller
 *
 * @property Condition $Condition
 */
class ConditionsController extends AppController {
	
// $uses is where you specify which models this controller uses
var $uses = array('Condition', 'Rule', 'User');

function beforeFilter() {
	parent::beforeFilter();
	$this->layout = 'configManage';
	$this->set('rule_types', $this->Rule->rule_types);
	// conditional ensures only actions that need the vars will receive them
	if (in_array($this->action, array('add', 'edit'))) {
		$customers = $this->getCustomersList();
		$this->set(compact('customers'));
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
							'Customer.name'
						)
					)
				),
				'conditions' => array(
					'Condition.type !=' => 2
				)
			);
		else:
			$this->paginate = array(
				'contain' => false,
				'conditions' => array(
						'Condition.type !=' => 2,
						'Condition.customer_id' => array(
								$this->get_allCustomersID(),
								$currentUser['Member']['customer_id']
							)
					),
			);
		endif;
		$this->set('conditions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {		
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		$condition = $this->Condition->find('first',array(
				'contain' => array(
						'Action' => array(
							'fields' => array(
								'Action.name'
							)
						),
						'Artefact' => array(
							'fields' => array(
								'Artefact.name'
							)
						),
						'Module' => array(
							'fields' => array(
								'Module.sysid'
							)
						),
						'Group' => array(
							'fields' => array(
								'Group.idnumber',
								'Group.name'
							)
						),
						'DimensionVerb' => array(
							'Artefact' => array(
								'fields' => array(
									'Artefact.name'
								)
							),
							'fields' => array(
								'DimensionVerb.name'
							)
						),
						'Rule' => array(
							'fields' => array(
								'Rule.id',
								'Rule.type',
								'Rule.name',
								'Rule.value'
							)
						)
				),
				'conditions' => array('id' => $id)
		));
		$this->check_allcustomerID($condition['Condition']['customer_id']);
		$this->set('condition', $condition);
	}

/**
 * add method
 *
 * @return void
 */
	public function add($rule_type=Rule::RULE_TYPE_VERB) {
		if ($this->request->is('post')) {
			$this->Condition->create();
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		}
		$conditionItems = $this->getConditionsList($rule_type);
        $rules = $this->getRulesList($rule_type);

		$this->set(compact('rules', 'conditionItems'));
		$this->set('label', $this->Rule->rule_types[$rule_type]);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Condition->read(null, $id);
		}
			
		$ruleType = $this->Rule->Condition->find('first', array(
				'contain' => array(
							'Rule' => array(
										'fields' => array('Rule.id', 'Rule.type')
									)
						),
				'conditions' => array('Condition.id' => $this->Condition->id),
			));
		
		$rule_type = $ruleType['Rule'][0]['type'];
		
		$this->check_customerID($this->request->data['Condition']['customer_id']); 		
		 
		$conditionItems = $this->getConditionsList($rule_type);	
        $rules = $this->getRulesList($rule_type);
        
        $this->set('condition', $this->request->data);        
		$this->set(compact('rules', 'conditionItems'));
		$this->set('label', $this->Rule->rule_types[$rule_type]);
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
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		if ($this->Condition->delete()) {
			$this->Session->setFlash(__('Condition deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Condition was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * Given a rule type, will return a list formatted array of associated 
 * conditions for multi-select form.
 * 
 * Uses switch case fall through to allow integer or string to be passed.
 *
 * @param $type integer
 * @return array
 */
	
	private function getConditionsList($rule_type) {
		$currentUser = $this->get_currentUser();
		
		//JB - this needs to be called to use constants
		//TODO see if it can be removed.
		$this->Rule;
		
		switch($rule_type) {
			case Rule::RULE_TYPE_ACTION:
				/*$conditionRecords = $this->Condition->Action->find('all', array(
				 'contain' => false,
						'fields' => array('Action.id as id', 'Action.name as name')
				));
				$conditionItems = Set::combine($conditionRecords, '{n}.Artefact.id', '{n}.Artefact.name');*/
				$this->set('formid', 'Action');
				return false;
				break;
			case Rule::RULE_TYPE_ARTEFACT:
				$conditionRecords = $this->Condition->Artefact->find('all', array(
						'contain' => false,
						'fields' => array('Artefact.id as id', 'Artefact.name as name')
				));
				$this->set('formid', 'Artefact');
				return Set::combine($conditionRecords, '{n}.Artefact.id', '{n}.Artefact.name');
				break;
			case Rule::RULE_TYPE_GROUP:
				$conditionRecords = $this->Condition->Group->find('all', array(
						'contain' => array(
								'System' => array(
										'fields' => array(
												'System.id',
												'System.name',
												'System.customer_id'
											)
									)
							),
						'conditions' => array(
								'System.customer_id' => array(
										$currentUser['Member']['customer_id']
								)
						),
						'fields' => array('Group.id as id', 'CONCAT(Group.name, " (",Group.idnumber,")") as name')
				));
				$this->set('formid', 'Group');
				return Set::combine($conditionRecords, '{n}.Group.id', '{n}.Group.name');				
				break;
			case Rule::RULE_TYPE_MODULE:
				$conditionRecords = $this->Condition->Module->find('all', array(
						'contain' => array(
								'System' => array(
										'fields' => array(
												'System.id',
												'System.name',
												'System.customer_id'
											)
									),
							),
						'conditions' => array(
								'System.customer_id' => array(
										$currentUser['Member']['customer_id']
								)
						),
						'fields' => array('Module.id as id', 'Module.sysid as name')
				));
				$this->set('formid', 'Module');
				return Set::combine($conditionRecords, '{n}.Module.id', '{n}.Module.name');
				break;
			case Rule::RULE_TYPE_VERB:
				$conditionRecords = $this->Condition->DimensionVerb->find('all', array(
						'contain' => array(
								'Artefact' => array(
										'fields' => array(
												'Artefact.name'
										)
								),
						),
						'fields' => array('id', 'CONCAT(Artefact.name, ": ",DimensionVerb.sysname) as name')
				));
				$this->set('formid', 'DimensionVerb');
				return $conditionItems = Set::combine($conditionRecords, '{n}.DimensionVerb.id', '{n}.0.name');
				break;
		}
	}	
	
/**
 * Returns a list formatted array of rules for multi-select form
 *
 * @param $rule_type integer 
 * @return array
 */
	
	private function getRulesList($rule_type) {
		$currentUser = $this->get_currentUser();
		$rulesRecords = $this->Condition->Rule->find('all', array(
        		'conditions' => array(
        				'Rule.customer_id' => $currentUser['Member']['customer_id'],
        				'Rule.type' => $rule_type
        			),
        		'fields' => array('id', 'CONCAT(Rule.name, ": ",Rule.value) as name'),
        		'contain' => false,
        		));
        return Set::combine($rulesRecords, '{n}.Rule.id', '{n}.0.name');
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Condition->recursive = 0;
		$this->set('conditions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		$this->set('condition', $this->Condition->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Condition->create();
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		}
		$rules = $this->Condition->Rule->find('list');
		$actions = $this->Condition->Action->find('list');
		$dimensionVerbConditions = $this->Condition->DimensionVerbCondition->find('list');
		$this->set(compact('rules', 'actions', 'dimensionVerbConditions'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Condition->read(null, $id);
		}
		$rules = $this->Condition->Rule->find('list');
		$actions = $this->Condition->Action->find('list');
		$dimensionVerbConditions = $this->Condition->DimensionVerbCondition->find('list');
		$this->set(compact('rules', 'actions', 'dimensionVerbConditions'));
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
		$this->Condition->id = $id;
		if (!$this->Condition->exists()) {
			throw new NotFoundException(__('Invalid condition'));
		}
		if ($this->Condition->delete()) {
			$this->Session->setFlash(__('Condition deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Condition was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
