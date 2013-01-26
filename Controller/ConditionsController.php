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

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$currentUser = $this->get_currentUser();
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
		$this->set('condition', $condition);
		
		$this->set('rule_types', $this->Rule->rule_types);
	}

/**
 * add method
 *
 * @return void
 */
	public function add($type='verb') {
		$currentUser = $this->get_currentUser();
		
		if ($this->request->is('post')) {
			$this->Condition->create();
			if ($this->Condition->save($this->request->data)) {
				$this->Session->setFlash(__('The condition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The condition could not be saved. Please, try again.'));
			}
		}
		
		//JB - this needs to be called to use constants 
		//TODO see if it can be removed.
		$this->Rule;
		
		switch($type) {
			case 'action':
				$rule_type = Rule::RULE_TYPE_ACTION;
				/*$conditionRecords = $this->Condition->Action->find('all', array(
						'contain' => false,
						'fields' => array('Action.id as id', 'Action.name as name')
				));
				$conditionItems = Set::combine($conditionRecords, '{n}.Artefact.id', '{n}.Artefact.name');*/
				$this->set('formid', 'Action');
				break;
			case 'artefact':
				$rule_type = Rule::RULE_TYPE_ARTEFACT;
				$conditionRecords = $this->Condition->Artefact->find('all', array(
					'contain' => false,
					'fields' => array('Artefact.id as id', 'Artefact.name as name')
					));
				$conditionItems = Set::combine($conditionRecords, '{n}.Artefact.id', '{n}.Artefact.name');
				$this->set('formid', 'Artefact');
				break;
        	case 'group':
        		$rule_type = Rule::RULE_TYPE_GROUP;
       			$conditionRecords = $this->Condition->Group->find('all', array(
       				'contain' => false,
       				'fields' => array('Group.id as id', 'CONCAT(Group.name, " (",Group.idnumber,")") as name')
       				));
       			$conditionItems = Set::combine($conditionRecords, '{n}.Group.id', '{n}.Group.name');
       			$this->set('formid', 'Group');
       			break;
       		case 'module':
       			$rule_type = Rule::RULE_TYPE_MODULE;
       			$conditionRecords = $this->Condition->Module->find('all', array(
  					'contain' => false,
       	    		'fields' => array('Module.id as id', 'Module.sysid as name')
       				));
       			$conditionItems = Set::combine($conditionRecords, '{n}.Module.id', '{n}.Module.name');
       			$this->set('formid', 'Module');
       			break;
       		case 'verb':
       			$rule_type = Rule::RULE_TYPE_VERB;
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
       			$conditionItems = Set::combine($conditionRecords, '{n}.DimensionVerb.id', '{n}.0.name');
       			$this->set('formid', 'DimensionVerb');
       			break;
		}
		
        $rulesRecords = $this->Condition->Rule->find('all', array(
        		'conditions' => array(
        				'Rule.customer_id' => $currentUser['Member']['customer_id'],
        				'Rule.type' => $rule_type
        			),
        		'fields' => array('id', 'CONCAT(Rule.name, ": ",Rule.value) as name'),
        		'contain' => false,
        		));
        $rules = Set::combine($rulesRecords, '{n}.Rule.id', '{n}.0.name');

		$this->set(compact('rules', 'conditionItems'));
		$this->set('label', $this->Rule->rule_types[$rule_type]);
				
		$this->set('types', $this->Condition->condition_types);
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
		
		if($this->request->data['Condition']['customer_id'] != $currentUser['Member']['customer_id']) {
			throw new LogicException(__('You do not have permission to edit this.'));
		} 
		
		$this->set('condition', $this->request->data);
		
		switch($rule_type) {
			case Rule::RULE_TYPE_ACTION:
				$rule_type = Rule::RULE_TYPE_ACTION;
				/*$conditionRecords = $this->Condition->Action->find('all', array(
				 'contain' => false,
						'fields' => array('Action.id as id', 'Action.name as name')
				));
				$conditionItems = Set::combine($conditionRecords, '{n}.Artefact.id', '{n}.Artefact.name');*/
				$this->set('formid', 'Action');
				break;
			case Rule::RULE_TYPE_ARTEFACT:
				$conditionRecords = $this->Condition->Artefact->find('all', array(
						'contain' => false,
						'fields' => array('Artefact.id as id', 'Artefact.name as name')
				));
				$conditionItems = Set::combine($conditionRecords, '{n}.Artefact.id', '{n}.Artefact.name');
				$this->set('formid', 'Artefact');
				break;
			case Rule::RULE_TYPE_GROUP:
				$conditionRecords = $this->Condition->Group->find('all', array(
						'contain' => false,
						'fields' => array('Group.id as id', 'CONCAT(Group.name, " (",Group.idnumber,")") as name')
				));
				$conditionItems = Set::combine($conditionRecords, '{n}.Group.id', '{n}.Group.name');
				$this->set('formid', 'Group');
				break;
			case Rule::RULE_TYPE_MODULE:
				$conditionRecords = $this->Condition->Module->find('all', array(
						'contain' => false,
						'fields' => array('Module.id as id', 'Module.sysid as name')
				));
				$conditionItems = Set::combine($conditionRecords, '{n}.Module.id', '{n}.Module.name');
				$this->set('formid', 'Module');
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
				$conditionItems = Set::combine($conditionRecords, '{n}.DimensionVerb.id', '{n}.0.name');
				$this->set('formid', 'DimensionVerb');
				break;
		}
		
        $rulesRecords = $this->Condition->Rule->find('all', array(
        		'conditions' => array(
        				'Rule.customer_id' => $currentUser['Member']['customer_id'],
        				'Rule.type' => $rule_type
        			),
        		'fields' => array('id', 'CONCAT(Rule.name, ": ",Rule.value) as name'),
        		'contain' => false,
        		));
        $rules = Set::combine($rulesRecords, '{n}.Rule.id', '{n}.0.name');
        
		$this->set(compact('rules', 'conditionItems', 'selected'));
		$this->set('label', $this->Rule->rule_types[$rule_type]);
        $this->set('types', $this->Condition->condition_types);
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
