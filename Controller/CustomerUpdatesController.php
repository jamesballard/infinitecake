<?php
App::uses('AppController', 'Controller');
/**
 * CustomerUpdates Controller
 *
 * @property CustomerUpdate $CustomerUpdate
 */
class CustomerUpdatesController extends AppController {

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'config';
        $this->set('menu', 'configure');
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
                'contain' => array(
                    'Rule' => array(
                        'fields' => array(
                            'Rule.name'
                        )
                    )
                ),
                'conditions' => array(
                    'CustomerStatus.customer_id' => array(
                        $currentUser['Member']['customer_id']
                    )
                )
            );
        endif;

        $this->set('statuses', $this->paginate());

    }

}
