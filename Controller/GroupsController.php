<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();
        $this->layout = 'config';
        $this->set('menu', 'configure');
		$this->set('group_types', $this->Group->group_types);
        // conditional ensures only actions that need the vars will receive them
        if (in_array($this->action, array('add', 'edit'))) {
            $courses = $this->getCustomerCourses();
            $this->set(compact('courses'));
        }
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$currentUser = $this->get_currentUser();
		$this->paginate = array(
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
		);
		$this->set('groups', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$group = $this->Group->find('first', array(
					'contain' => array(
							'System' => array(
									'fields' => array(
											'System.id',
											'System.name',
											'System.customer_id'
									)
							),
                            'Course' => array(
                                'fields' => array(
                                    'Course.id',
                                    'Course.name',
                                    'Course.idnumber'
                                )
                            )
					),
					'conditions' => array(
							'Group.id' => $id
					),
				));
		$this->check_customerID($group['System']['customer_id']);
		$this->set('group', $group);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Group->find('first', array(
                'contain' => array(
                    'System' => array(
                        'fields' => array(
                            'System.id',
                            'System.name',
                            'System.customer_id'
                        )
                    ),
                    'Course' => array(
                        'fields' => array(
                            'Course.id',
                            'Course.name',
                            'Course.idnumber'
                        )
                    )
                ),
                'conditions' => array(
                    'Group.id' => $id
                ),
            ));
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('Group deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Group was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function help() {

    }

/**
 * Provides a JSON feed of groups for auto-complete entry
 *
 * @return json
 */
	
	public function jsonfeed() {
		$currentUser = $this->get_currentUser();
		$groups = $this->Group->find('all',array(
				'contain' => array(
						'System' => array(
								'fields' => array(
										'System.customer_id'
									)
							)
					),
				'conditions' => array('Group.idnumber LIKE'=>'%'.$_GET['term'].'%',
							'Group.type' => 1,
					    	'System.customer_id' => $currentUser['Member']['customer_id']
						),				
				'fields' => array('Group.idnumber AS label','Group.id AS value'), //array of field names
		)
		);
		$groups = Set::extract('/Group/.', $groups);
	
		return new CakeResponse(array('body' => json_encode($groups)));
	}
}
