<?php
App::uses('AppController', 'Controller');
/**
 * Members Controller
 *
 * @property Member $Member
 */
class MembersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('login', 'logout'));
    }

    public $helpers = array('Html', 'Form');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Member->recursive = 0;
		$this->set('members', $this->paginate());
	}

    function register(){
        if(!empty($this->data)){
            // Here you should validate the username (min length, max length, to not include special chars, not existing already, etc)
            // As well as the password
            if($this->Member->validates()){
                $this->Member->save($this->data);
                // Let's read the data we just inserted
                $data = $this->Member->read();
                // Use it to authenticate the user
                $this->Auth->login($data);
                // Then redirect
                $this->redirect('/');
            }
        }
    }

    public function login() {
        if ($this->Session->read('Auth.Member')) {
            $this->Session->setFlash('You are logged in!');
            $this->redirect('/', null, false);
        }
        if(!empty($this->data)){
            $membership = $this->Member->getMembership($this->data['Member']['username']);
            $this->request->data['Member']['membership_id'] = $membership['Member']['membership_id'];

            // If the username/password match
            if($this->Auth->login($this->request->data)){
                $this->redirect('/');
            } else {
                $this->Member->invalidate('username', 'Username and password combination is incorrect!');
            }
        }
    }

    public function logout() {
        //Leave empty for now.
        $this->Session->setFlash('Good-Bye');
        $this->redirect($this->Auth->logout());
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Member->id = $id;
		if (!$this->Member->exists()) {
			throw new NotFoundException(__('Invalid member'));
		}
		$this->set('member', $this->Member->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Member->create();
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('The member has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The member could not be saved. Please, try again.'));
			}
		}
		$memberships = $this->Member->Membership->find('list');
		$this->set(compact('memberships'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Member->id = $id;
		if (!$this->Member->exists()) {
			throw new NotFoundException(__('Invalid member'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash(__('The member has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The member could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Member->read(null, $id);
		}
		$memberships = $this->Member->Membership->find('list');
		$this->set(compact('memberships'));
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
		$this->Member->id = $id;
		if (!$this->Member->exists()) {
			throw new NotFoundException(__('Invalid member'));
		}
		if ($this->Member->delete()) {
			$this->Session->setFlash(__('Member deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Member was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
