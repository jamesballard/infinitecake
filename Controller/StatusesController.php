<?php
App::uses('AppController', 'Controller');
/**
 * Statuses Controller
 *
 * @property Status $Status
 */
class StatusesController extends AppController {

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'configManage';
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
                'conditions' => array(
                    'Status.customer_id' => array(
                        $currentUser['Member']['customer_id']
                    )
                )
            );
        endif;

        $this->set('rules', $this->paginate());

    }


}
