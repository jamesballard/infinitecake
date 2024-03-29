<?php
App::uses('AppController', 'Controller');
/**
 * Courses Controller
 *
 * @property Course $Course
 */
class CoursesController extends AppController {

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'config';
        $this->set('menu', 'configure');
        // conditional ensures only actions that need the vars will receive them
        if (in_array($this->action, array('add', 'edit'))) {
            $customers = $this->getCustomersList();
            $departments = $this->getCustomerDepartments();
            $people = $this->getPeopleList();
            $this->set(compact('departments', 'people', 'customers'));
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
                    'Department' => array(
                        'fields' => array(
                            'Department.id',
                            'Department.name',
                            'Department.idnumber'
                        )
                    ),
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
                'contain' => array(
                    'Department' => array(
                        'fields' => array(
                            'Department.id',
                            'Department.name',
                            'Department.idnumber'
                        ),
                        'Customer' => array(
                            'fields' => array(
                                'Customer.id'
                            )
                        )
                    )
                ),
                'conditions' => array(
                    'Department.customer_id' => array(
                        $currentUser['Member']['customer_id']
                    )
                ),
            );
        endif;
		$this->set('courses', $this->paginate());
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
        $course = $this->Course->find('first',array(
            'contain' => array(
                'Person' => array (
                    'fields' => array(
                        'Person.id',
                        'Person.idnumber'
                    )
                ),
                'Department' => array(
                    'Customer' => array(
                        'fields' => array(
                            'Customer.id',
                            'Customer.name'
                        )
                    ),
                    'fields' => array(
                        'Department.id',
                        'Department.name',
                        'Department.customer_id'
                    )
                )
            ),
            'conditions' => array('Course.id' => $id)
        ));
        $this->check_customerID($course['Department']['customer_id']);
        $this->set('course', $course);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Course->create();
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please, try again.'));
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
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Course->find('first', array(
                    'contain' => array(
                        'PersonCourse' => array(),
                        'Person' => array (
                            'fields' => array(
                                'Person.id',
                                'Person.idnumber'
                            )
                        ),
                        'Department' => array(
                            'Customer' => array(
                                'fields' => array(
                                    'Customer.id',
                                    'Customer.name'
                                )
                            ),
                            'fields' => array(
                                'Department.id',
                                'Department.name',
                                'Department.customer_id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'Course.id' => $id
                    )
                )
            );
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
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->Course->delete()) {
			$this->Session->setFlash(__('Course deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course was not deleted'));
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
        $courses = $this->Course->find('all',array(
                'contain' => array(
                    'Department' => array(
                        'fields' => array(
                            'Department.customer_id'
                        )
                    )
                ),
                'conditions' => array('Course.idnumber LIKE'=>'%'.$_GET['term'].'%',
                    'Department.customer_id' => $currentUser['Member']['customer_id']
                ),
                'fields' => array('Course.idnumber AS label','Course.id AS value'), //array of field names
            )
        );
        $courses = Set::extract('/Course/.', $courses);

        return new CakeResponse(array('body' => json_encode($courses)));
    }

/**
 * Returns a list formatted array of groups for multi-select form
 *
 * @return array
 */

    private function getGroupsList() {
        $currentUser = $this->get_currentUser();
        $groupRecords = $this->Course->Group->find('all', array(
            'contain' => array(
                'System' => array(
                    'fields' => array(
                        'System.id',
                        'System.name',
                        'System.customer_id'
                    )
                )
            ),
            'fields' => array('id', 'CONCAT(Group.idnumber, " (",System.name,": ",Group.sysid,")") as name'),
            'conditions' => array(
                'System.customer_id' => array(
                    $this->get_allCustomersID(),
                    $currentUser['Member']['customer_id']
                )
            ),
        ));
        return Set::combine($groupRecords, '{n}.Group.id', '{n}.0.name');
    }

 /**
  * Returns a list formatted array of people for multi-select form
  *
  * @return array
  */

    private function getPeopleList() {
        $currentUser = $this->get_currentUser();
        return $this->Course->Person->find('list', array(
            'contain' => array(
                'Customer' => array(
                    'fields' => array('id')
                )
            ),
            'conditions' => array(
                'Customer.id' => array(
                    $this->get_allCustomersID(),
                    $currentUser['Member']['customer_id']
                )
            ),
        ));
    }
}
