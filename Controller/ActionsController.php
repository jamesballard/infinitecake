<?php
App::uses('AppController', 'Controller');
/**
 * Actions Controller
 *
 * @property Action $Action
 */
class ActionsController extends AppController {

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'adminManage';
        // conditional ensures only actions that need the vars will receive them
        if (in_array($this->action, array('add', 'edit'))) {
            $users = $this->Action->User->find('list');
            $groups = $this->Action->Group->find('list');
            //$modules = $this->Action->Module->find('list');
            $dimensionVerbs = $this->Action->DimensionVerb->find('list');
            $systems = $this->Action->System->find('list');
            $conditions = $this->Action->Condition->find('list', array('conditions' => array('type !=' => 2)));
            $this->set(compact('users', 'groups', 'modules', 'dimensionVerbs', 'systems', 'conditions'));
        }
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->paginate = array(
            'contain' => false
        );
        $this->set('actions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Action->exists($id)) {
			throw new NotFoundException(__('Invalid action'));
		}
		$options = array('conditions' => array('Action.' . $this->Action->primaryKey => $id));
		$this->set('action', $this->Action->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Action->create();
			if ($this->Action->save($this->request->data)) {
				$this->Session->setFlash(__('The action has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The action could not be saved. Please, try again.'));
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
		if (!$this->Action->exists($id)) {
			throw new NotFoundException(__('Invalid action'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Action->save($this->request->data)) {
				$this->Session->setFlash(__('The action has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The action could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Action.' . $this->Action->primaryKey => $id));
			$this->request->data = $this->Action->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Action->id = $id;
		if (!$this->Action->exists()) {
			throw new NotFoundException(__('Invalid action'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Action->delete()) {
			$this->Session->setFlash(__('Action deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Action was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
