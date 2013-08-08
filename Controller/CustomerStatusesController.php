<?php
App::uses('AppController', 'Controller');
/**
 * CustomerStatuses Controller
 *
 * @property CustomerStatus $CustomerStatus
 */
class CustomerStatusesController extends AppController {

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'configManage';
        $this->set('process_types', $this->CustomerStatus->process_types);
    }

    var $uses = array('CustomerStatus', 'Action', 'CustomerUpdates');

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

    /**
     * trigger method runs a one-time manually started stored procedure
     *
     * @return void
     */
    public function trigger($type=0, $rule_id=null) {
        $currentUser = $this->get_currentUser();
        $customerid = $currentUser['Member']['customer_id'];

        $lastid = $this->CustomerStatus->find('first', array(
                'conditions' => array(
                    'type' => $type,
                    'rule_id' => $rule_id,
                    'customer_id' => $customerid
                ),
                'fields' => array('endid')
            )
        );

        $maxid = $this->Action->find('first', array(
                'contain' => array(
                    'System'
                ),
                'conditions' => array(
                    'System.id' => array_keys($this->get_customerSystems()),
                ),
                'fields' => array('MAX(Action.id) as maxid'),
            )
        );

        //Define the latest action id for the customer
        $maxid = (int)$maxid[0]['maxid'];

        //Define the last id processed for the customer
        $lastid = (int)$lastid['CustomerStatus']['endid'];

        //Compare values and only process if new actions exist since last procedure update
        if($maxid > $lastid) {
            //Call process based on the type
            switch($type) {
                case 1:
                    $proc_results = $this->CustomerStatus->query("CALL map_users_to_person($customerid);");
                    break;
                case 2:
                    $proc_results = $this->CustomerStatus->query("CALL map_groups_to_course($customerid);");
                    break;
                case 3:
                    $proc_results = $this->CustomerStatus->query("CALL aggregate_summed_actions($customerid, $lastid, $maxid);");
                    break;
                case 4:
                    $proc_results = $this->CustomerStatus->query("CALL aggregate_summed_rule_conditions($customerid, $lastid, $maxid, $rule_id);");
                    break;
                case 5:
                    $proc_results = $this->CustomerStatus->query("CALL aggregate_summed_ip_conditions($customerid, $lastid, $maxid, 2);");
                    break;
            }
            $this->Session->setFlash(__('Data processed: '.$proc_results[0]['loop_cntr'].' / '.$proc_results[0]['num_rows']));
            $this->redirect(array('controller' => 'CustomerStatuses', 'action' => 'index'));
        }elseif($maxid == $lastid) {
            $this->Session->setFlash(__('There are no new actions since the last data sync - nothing to do.'));
            $this->redirect(array('controller' => 'CustomerStatuses', 'action' => 'index'));
        }elseif($maxid < $lastid) {
            $this->Session->setFlash(__('The latest action is less than last sync - contact support.'));
            $this->redirect(array('controller' => 'CustomerStatuses', 'action' => 'index'));
        }else{
            $this->Session->setFlash(__('Something has gone wrong - contact support.'));
            $this->redirect(array('controller' => 'CustomerStatuses', 'action' => 'index'));
        }

    }

    /**
     * index method
     *
     * @return void
     */
    public function reset($type=0, $rule_id=null) {
        $currentUser = $this->get_currentUser();
        $customerid = $currentUser['Member']['customer_id'];

        if ($this->request->is('post')) {
            if($this->request->data['submit'] == 'Yes') {
                $type = $this->request->data['Reset']['type'];
                $rule_id = $this->request->data['Reset']['rule_id'];
                switch($type) {
                    //Mappings do not need to be reset otherwise searches will fail.
                    case 1:
                    case 2:
                        $this->Session->setFlash(__('User and Course mappings do not have counts to reset - nothing to do.'));
                        $this->redirect(array('controller' => 'CustomerStatuses', 'action' => 'index'));
                        break;
                    //Summed actions table should not be reset by customer as this is core data model.
                    case 3:
                        $this->Session->setFlash(__('User and Course mappings do not have counts to reset - nothing to do.'));
                        $this->redirect(array('controller' => 'CustomerStatuses', 'action' => 'index'));
                        break;
                    //Valid requests should relate to a rule defined by a customer.
                    default:
                        //1. Delete the aggregation records.
                        $this->FactSummedVerbRuleDatetime->deleteAll(array(
                            'rule_id' => $rule_id,
                            'System.id' => array_keys($this->get_customerSystems())
                        ), false);

                        //2. Update the CustomerStaus to set start and end id = 0 to show reset.
                        $status_rec = $this->CustomerStatus->find('first', array(
                                'conditions' => array(
                                    'type' => $type,
                                    'rule_id' => $rule_id,
                                    'customer_id' => $customerid
                                )
                            )
                        );

                        $status_rec['CustomerStatus']['time'] = date("Y-m-d H:i:s", time());
                        $status_rec['CustomerStatus']['startid'] = 0;
                        $status_rec['CustomerStatus']['endid'] = 0;
                        $this->CustomerStatus->save($status_rec);

                        //3. Insert a CustomerUpdates log record for the reset
                        $this->CustomerUpdates->create();
                        $this->CustomerUpdates->set(array(
                            'type' => $type,
                            'time' => date("Y-m-d H:i:s", time()),
                            'startid' => 0,
                            'endid' => 0,
                            'numrows' => 0,
                            'processedrows' => 0,
                            'customer_id' => $customerid,
                            'rule_id' => $rule_id
                            )
                        );
                        $this->CustomerUpdates->save();

                        //4. Return to main status page.
                        $this->Session->setFlash(__('Reset complete.'));
                        $this->redirect(array('controller' => 'CustomerStatuses', 'action' => 'index'));
                        break;
                }
            }else{
                $this->Session->setFlash(__('Reset was cancelled - nothing to do.'));
                $this->redirect(array('controller' => 'CustomerStatuses', 'action' => 'index'));
            }
        }else{
            $this->set('type', $type);
            $this->set('rule_id', $rule_id);
        }
    }
}
