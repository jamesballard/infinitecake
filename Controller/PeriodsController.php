<?php
App::uses('AppController', 'Controller');
/**
 * Courses Controller
 *
 * @property Period $Period
 */
class PeriodsController extends AppController {

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'configManage';
        // conditional ensures only actions that need the vars will receive them
        if (in_array($this->action, array('add', 'edit'))) {
            $this->set('intervals', $this->Period->interval_types);
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
                'contain' => array(
                    'Customer' => array(
                        'fields' => array(
                            'Customer.id',
                            'Customer.name'
                        )
                    )
                ),
                'conditions' => array(
                    'Customer.id' => array(
                        $currentUser['Member']['customer_id']
                    )
                ),
            );
        endif;
		$this->set('periods', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
        $period = $this->Course->find('first',array(
            'contain' => false,
            'conditions' => array('Period.id' => $id)
        ));
        $this->check_customerID($period['Period']['customer_id']);
        $this->set('period', $period);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Period->create();
			if ($this->Period->save($this->request->data)) {
				$this->Session->setFlash(__('The period has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The period could not be saved. Please, try again.'));
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
		$this->Period->id = $id;
		if (!$this->Period->exists()) {
			throw new NotFoundException(__('Invalid period'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Period->save($this->request->data)) {
				$this->Session->setFlash(__('The period has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The period could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Period->find('first', array(
                    'contain' => false,
                    'conditions' => array(
                        'Period.id' => $id
                    )
                )
            );
		}
        $this->check_customerID($this->request->data['Period']['customer_id']);
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
		$this->Period->id = $id;
		if (!$this->Period->exists()) {
			throw new NotFoundException(__('Invalid period'));
		}
		if ($this->Period->delete()) {
			$this->Session->setFlash(__('Period deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Period was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function help() {

    }
}
