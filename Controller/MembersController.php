<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Members Controller
 *
 * @property Member $Member
 */
class MembersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'config';
        $this->set('menu', 'configure');
        $this->Auth->allow(array('login', 'logout', 'forgotpwd', 'reset'));
        // conditional ensures only actions that need the vars will receive them
        if (in_array($this->action, array('add', 'edit'))) {
        	$memberships = $this->getMembershipsList();
        	$customers = $this->getCustomersList();
			$this->set(compact('memberships', 'customers'));
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
					),
                    'Membership' => array(
                        'fields' => array(
                            'Membership.id',
                            'Membership.name'
                        )
                    )
				)
			);
		else:
			$this->paginate = array(
				'contain' => array(
                    'Membership' => array(
                        'fields' => array(
                            'Membership.id',
                            'Membership.name'
                        )
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
            $membership = $this->Member->getMembership($this->data['Member']['email']);
            $this->request->data['Member']['membership_id'] = $membership['Member']['membership_id'];

            // If the email/password match
            if($this->Auth->login($this->request->data)){
                $this->redirect('/');
            } else {
                $this->Member->invalidate('email', 'Email and password combination is incorrect!');
            }
        }
    }

    public function logout() {
        //Leave empty for now.
        $this->Session->setFlash('Good-Bye');
        $this->redirect($this->Auth->logout());
    }

    /**
     * Forgot password page
     */
    function forgotpwd(){
        if(!empty($this->data)) {
            if(empty($this->data['Member']['email'])) {
                $this->Session->setFlash('Please provide your Email Address that you used to register with us');
            } else {
                $email = $this->data['Member']['email'];
                $member = $this->Member->find('first',array('conditions'=>array('Member.email' => $email)));
                if($member) {
                    if($member['Member']['active']) {
                        $key = Security::hash(String::uuid(),'sha512',true);
                        $hash=sha1($member['Member']['email'].rand(0,100));
                        $url = Router::url( array('controller'=>'members','action'=>'reset'), true ).'/'.$key.'#'.$hash;
                        $ms = $url;
                        $ms = wordwrap($ms,1000);
                        $member['Member']['tokenhash'] = $key;
                        $this->Member->id = $member['Member']['id'];
                        if($this->Member->saveField('tokenhash', $member['Member']['tokenhash'])) {
                            $email = new CakeEmail('mandrill');
                            $email->to($member['Member']['email'], $member['Member']['firstname']);
                            $email->subject('Infinite Rooms reset password');
                            $email->viewVars(array(
                                'ms' => $ms,
                                'name' => $member['Member']['firstname']
                            ));
                            $email->template('pwd_reset');
                            $email->send();
                        } else {
                            $this->Session->setFlash("Error Generating Reset link");
                        }
                    } else {
                        $this->Session->setFlash('This account is not active.');
                    }
                } else {
                    $this->Session->setFlash('Email does not exist');
                }
            }
        }
    }

    /**
     * Reset password.
     * @param null $token
     */
    function reset($token=null){
        if(!empty($token)){
            $member = $this->Member->findBytokenhash($token);
            if($member){
                $this->Member->id = $member['Member']['id'];
                if(!empty($this->data)){
                    $this->Member->data = $this->data;
                    $this->Member->data['Member']['email'] = $member['Member']['email'];
                    $new_hash = sha1($member['Member']['email'].rand(0,100));//created token
                    $this->Member->data['User']['tokenhash'] = $new_hash;
                    if($this->Member->validates(array('fieldList' => array('password','password_confirm')))){
                        if($this->Member->save($this->Member->data)) {
                            $this->Session->setFlash('Password has been updated');
                            $this->redirect(array('controller'=>'members', 'action'=>'login'));
                        }
                    } else {
                        //$this->set('errors', $this->Member->invalidFields());
                    }
                }
            } else {
                $this->Session->setFlash('Token corrupted, please retry to generate a new reset link.');
            }
        } else {
            $this->redirect('/');
        }
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
        $member = $this->Member->find('first',array(
            'contain' => array(
                'Membership' => array(
                    'fields' => array(
                        'Membership.id',
                        'Membership.name'
                    )
                )
            ),
            'conditions' => array('Member.id' => $id)
        ));
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

            $toemail = $this->request->data['Member']['email'];
            $key = Security::hash(String::uuid(),'sha512',true);
            $hash=sha1($toemail.rand(0,100));
            $url = Router::url( array('controller'=>'members', 'action' => 'reset'), true ).'/'.$key.'#'.$hash;
            $ms = $url;
            $ms = wordwrap($ms, 1000);

            $this->request->data['Member']['tokenhash'] = $key;
            $this->request->data['Member']['active'] = 1;

			if ($this->Member->save($this->request->data)) {
                $email = new CakeEmail('mandrill');
                $email->to($toemail, $this->request->data['Member']['firstname']);
                $email->subject('Welcome to Infinite Rooms');
                $email->viewVars(array(
                    'ms' => $ms,
                    'name' => $this->request->data['Member']['firstname']
                ));
                $email->template('welcome');
                $email->send();
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

    public function help() {

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
