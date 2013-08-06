<?php
App::uses('AppController', 'Controller');
/**
 * Departments Controller
 *
 * @property Department $Department
 */
class DepartmentsController extends AppController {

    public $helpers = array('RecursiveDepartments');

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'configManage';
        if (in_array($this->action, array('add', 'edit'))) {
            $customers = $this->getCustomersList();
            $departments = $this->getCustomerDepartments();
            $this->set(compact('customers', 'departments'));
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
            $options = array(
                'contain' => array(
                    'Customer' => array(
                        'fields' => array(
                            'Customer.name',
                        )
                    )
                ),
                'order' => array('Department.lft')
            );
        else:
            $options = array(
                'contain' => array(
                    'Customer' => array(
                        'fields' => array(
                            'Customer.name',
                        )
                    )
                ),
                'conditions' => array(
                    'Department.customer_id' => array(
                        $currentUser['Member']['customer_id']
                    )
                ),
                'order' => array('Department.lft')
            );
        endif;
        $departments = $this->Department->find('threaded', $options);
        $this->set('departments', $departments);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Department->id = $id;
		if (!$this->Department->exists()) {
			throw new NotFoundException(__('Invalid department'));
		}
        $department = $this->Department->read(null, $id);
        $this->check_customerID($department['Department']['customer_id']);
		$this->set('department', $department);

        $parent = $this->Department->getParentNode($id);
        $this->set(compact('parent'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Department->create();
            if ($this->Department->save($this->request->data)) {
                $this->Session->setFlash(__('The department has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The department could not be saved. Please, try again.'));
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
		$this->Department->id = $id;
		if (!$this->Department->exists()) {
			throw new NotFoundException(__('Invalid department'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Department->save($this->request->data)) {
                $this->Session->setFlash(__('The department has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The department could not be saved. Please, try again.'));
            }
		} else {
            $this->data = $this->Department->read(null, $id);
		}
        $this->check_customerID($this->request->data['Department']['customer_id']);
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
		$this->Department->id = $id;
		if (!$this->Department->exists()) {
			throw new NotFoundException(__('Invalid department'));
		}
		if ($this->Department->delete()) {
			$this->Session->setFlash(__('Department deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Department was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function help() {

    }

/**
 * move up hierarchy method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @param integer $delta
 * @return void
 */

    public function moveup($id = null, $delta = 1) {
        $this->Department->id = $id;
        if (!$this->Department->exists()) {
            throw new NotFoundException(__('Invalid Department'));
        }

        if ($delta > 0) {
            $this->Department->moveUp($this->Department->id, abs($delta));
            $this->Session->setFlash(__("The Department was moved up $delta."));
        } else {
            $this->Session->setFlash('Please provide a number of positions the department should be moved up.');
        }

        $this->redirect(array('action' => 'index'), null, true);
    }

/**
 * move down hierarchy method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @param integer $delta
 * @return void
 */

    public function movedown($id = null, $delta = 1) {
        $this->Department->id = $id;
        if (!$this->Department->exists()) {
            throw new NotFoundException(__('Invalid Department'));
        }

        if ($delta > 0) {
            $this->Department->moveDown($this->Department->id, abs($delta));
            $this->Session->setFlash(__("The Department was moved down $delta."));
        } else {
            $this->Session->setFlash('Please provide the number of positions the department should be moved down.');
        }

        $this->redirect(array('action' => 'index'), null, true);
    }

/**
 * remove node from hierarchy method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

    function removeNode($id=null){
        $this->Department->id = $id;
        if (!$this->Department->exists()) {
            throw new NotFoundException(__('Invalid department'));
        }
        if($this->Department->removeFromTree($id)) {
            $this->Session->setFlash('The Department was removed.');
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash('The Department could not be removed.');
    }
}
