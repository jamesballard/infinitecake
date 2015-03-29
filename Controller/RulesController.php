<?php
App::uses('AppController', 'Controller');
/**
 * Rules Controller
 *
 * @property Rule $Rule
 */
class RulesController extends AppController {

    public $components = array('Wizard.Wizard');
    public $helpers = array('dynamicForms.dynamicForms', 'formGeneration');

    function beforeFilter() {
		parent::beforeFilter();
        $this->layout = 'config';
        $this->set('menu', 'customise');
        $this->Wizard->steps = array('report', 'existing', 'element');
        $this->set('rule_types', $this->Rule->rule_types);
        $this->set('rule_cats', $this->Rule->rule_cats);
        $this->set('rule_subs', $this->Rule->rule_subs);
		// conditional ensures only actions that need the vars will receive them
		if (in_array($this->action, array('add', 'edit', 'wizard'))) {
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
                        'Course' => array(
                            'fields' => array(
                                'Course.idnumber',
                                'Course.name'
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
    /*public function add() {
      /*if ($this->request->is('post')) {
            $this->Rule->create();
            if ($this->Rule->save($this->request->data)) {
                $this->Session->setFlash(__('The rule has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The rule could not be saved. Please, try again.'));
            }
        }
    }*/

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
            $newconditions = $this->request->data['Condition'];
            unset($newconditions['Condition']);
			if ($this->Rule->save($this->request->data)) {
                if ($this->Condition->saveAll($newconditions)){
                    $this->Session->setFlash(__('The rule has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('New conditions could not be saved. Please, try again.'));
                }
			} else {
				$this->Session->setFlash(__('The rule could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Rule->find('first',array(
                'contain' => array(
                    'Condition' => array(
                        'Action' => array(
                            'fields' => array(
                                'Action.id',
                                'Action.name'
                            )
                        ),
                        'Artefact' => array(
                            'fields' => array(
                                'Artefact.id',
                                'Artefact.name'
                            )
                        ),
                        'Module' => array(
                            'fields' => array(
                                'Module.sysid',
                                'Module.sysid'
                            )
                        ),
                        'Course' => array(
                            'fields' => array(
                                'Course.id',
                                'Course.idnumber',
                                'Course.name'
                            )
                        ),
                        'DimensionVerb' => array(
                            'Artefact' => array(
                                'fields' => array(
                                    'Artefact.id',
                                    'Artefact.name'
                                )
                            ),
                            'fields' => array(
                                'DimensionVerb.id',
                                'DimensionVerb.name'
                            )
                        )
                    ),
                    'RuleCondition'
                ),
                'conditions' => array('id' => $id)
            ));
		}
		$this->check_customerID($this->request->data['Rule']['customer_id']);
        $this->prepareConditionsData($id);
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
 * wizard method - used for multi-page form process
 *
 * @return void
 */

    function wizard($step = null) {
        $this->Wizard->process($step);
    }

/**
 * [Wizard Process Callbacks]
 */
    function _processReport() {
        $this->Rule->set($this->data);

        if($this->Rule->validates()) {
            $this->Rule->save($this->data);
            $this->Session->write('report.Rule.id', $this->Rule->id);
            return true;
        }
        return false;
    }

    function _prepareExisting() {
        $this->Rule->id = $this->Session->read('report.Rule.id');
        $this->Rule->read();
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
            'conditions' => array('id' => $this->Rule->id)
        ));
    }

    function _processExisting() {
        $this->Rule->set($this->data);

        if($this->Rule->validates()) {
            $this->Rule->save($this->data);
            return true;
        }
        return false;
    }

    function _prepareElement() {
        $this->prepareConditionsData($this->Session->read('report.Rule.id'));
    }

    function _processElement() {
        $this->Condition->set($this->data);
        if ($this->Condition->saveAll($this->data['Condition'])){
            return true;
        } else {
            $this->Session->setFlash("Nope, that didn't work out quite well...");
            return false;
        }
    }

    /**
     * [Wizard Completion Callback]
     */
    function _afterComplete() {
        $this->Rule->id = $this->Session->read('report.Rule.id');
        $this->Wizard->reset();
        $this->Session->delete('report');
        $this->redirect(array('action' => 'view', $this->Rule->id));
	}

/**
 * sets up the data for creating add Condition forms within Rules forms
 *
 * @param string $ruleID
 * @return void
 */

    protected function prepareConditionsData($ruleID) {
        $currentUser = $this->get_currentUser();
        $customer_id = $currentUser['Member']['customer_id'];

        $newRule = $this->Rule->read(null, $ruleID);
        $rule_type = $newRule['Rule']['type'];

        switch($rule_type) {
            case Rule::RULE_TYPE_ACTION:
                break;
            case Rule::RULE_TYPE_ARTEFACT:
                $artefacts = $this->getCustomerArtefacts();
                $conditionItems = Set::combine($artefacts, '{n}.Artefact.id', '{n}.Artefact.name');
                break;
            case Rule::RULE_TYPE_GROUP:
                $conditionRecords = $this->Condition->getCourseConditions($customer_id);
                $conditionItems = Set::combine($conditionRecords, '{n}.Course.id', '{n}.0.name');
                break;
            case Rule::RULE_TYPE_MODULE:
                $conditionRecords = $this->Condition->getModuleConditions();
                $conditionItems = Set::combine($conditionRecords, '{n}.Module.id', '{n}.Module.name');
                break;
            case Rule::RULE_TYPE_VERB:
                $conditionRecords = $this->Condition->getVerbConditions();
                $conditionItems =  Set::combine($conditionRecords, '{n}.DimensionVerb.id', '{n}.0.name');
                break;
        }

        $rules = $this->Rule->getRulesListByCustomerAndType($customer_id, $rule_type);

        $this->set('rule_id', $ruleID);
        $this->set('formid', $rule_type);
        $this->set('customer_id', $newRule['Rule']['customer_id']);
        $this->set(compact('rules', 'conditionItems'));
        $this->set('label', $this->Rule->rule_types[$rule_type]);
    }
}
