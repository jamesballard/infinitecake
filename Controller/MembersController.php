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
        $this->layout = 'configManage';
        $this->Auth->allow(array('login', 'logout'));
        // conditional ensures only actions that need the vars will receive them
        if (in_array($this->action, array('add', 'edit'))) {
        	$memberships = $this->getMembershipsList();
        	$customers = $this->getCustomersList();
			$this->set(compact('memberships', 'customers'));
        }
    }

    public $helpers = array('Html', 'Form');
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
                    'Membership' => array(

                    )
                ),
				'conditions' => array(
					'Member.customer_id' => array(
						$currentUser['Member']['customer_id']
					)
				)
			);
		endif;
		
		$this->set('members', $this->paginate());
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
		$member = $this->Member->read(null, $id);
		$this->check_customerID($member['Member']['customer_id']);
		$this->set('member', $member);
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
		$this->check_customerID($this->request->data['Member']['customer_id']);
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
	
/**
 * Returns a list formatted array of memberships for multi-select form
 *
 * @return array
 */
	
	private function getMembershipsList() {
		$currentUser = $this->get_currentUser();
		$memberships = $this->Member->Membership->find('list', array(
					'contain' => false,
					'conditions' => array('id >=' => $currentUser['Membership']['id'])
				));
		return $memberships;
	}

}
