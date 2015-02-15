<?php
App::uses('AppController', 'Controller');
/**
 * Systems Controller
 *
 * @property System $System
 */
class SystemsController extends AppController {

    function beforeFilter() {
    	parent::beforeFilter();
        $this->layout = 'config';
        $this->set('menu', 'configure');
    	$this->set('system_types', $this->System->system_types);
        // conditional ensures only actions that need the vars will receive them
        if (in_array($this->action, array('index', 'add', 'edit'))) {
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
					)
			);
		else:
			$this->paginate = array(
					'contain' => false,
					'conditions' => array(
							'System.customer_id' => array(
									$currentUser['Member']['customer_id']
							)
					),
			);
		endif;
		$this->set('systems', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->System->id = $id;
		$this->System->recursive = 0;
		if (!$this->System->exists()) {
			throw new NotFoundException(__('Invalid system'));
		}
		$system = $this->System->read(null, $id);
		$this->check_customerID($system['System']['customer_id']);
		$this->set('system', $system);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->System->create();
			if ($this->System->save($this->request->data)) {
				$this->Session->setFlash(__('The system has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system could not be saved. Please, try again.'));
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
		$this->System->id = $id;
		$this->System->recursive = -1;
		if (!$this->System->exists()) {
			throw new NotFoundException(__('Invalid system'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->System->save($this->request->data)) {
				$this->Session->setFlash(__('The system has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->System->read(null, $id);
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
		$this->System->id = $id;
		if (!$this->System->exists()) {
			throw new NotFoundException(__('Invalid system'));
		}
		if ($this->System->delete()) {
			$this->Session->setFlash(__('System deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('System was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function help() {

    }
}
