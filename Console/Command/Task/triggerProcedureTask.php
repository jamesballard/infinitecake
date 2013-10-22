<?php
class TriggerProcedureTask extends Shell {
    public $uses = array('Customer', 'Rule', 'Action', 'Group', 'User', 'CustomerStatus');
    public function execute() {
        $customers = $this->Customer->find('all', array(
            'conditions' => array(
                'id >' => 1
            )
        ));
        foreach ($customers as $customer) {
            $customerid = $customer['Customer']['id'];
            // Find the latest group for the customer.
            $maxid = $this->User->find('first', array(
                    'contain' => array(
                        'System'
                    ),
                    'conditions' => array(
                        'System.customer_id' => $customerid
                    ),
                    'fields' => array('MAX(User.id) as maxid'),
                )
            );
            //Define the latest group mapping id for the customer
            $maxid = (int)$maxid[0]['maxid'];

            $lastid = $this->CustomerStatus->find('first', array(
                    'conditions' => array(
                        'type' => CustomerStatus::PROC_USER_TO_PEOPLE,
                        'customer_id' => $customerid
                    ),
                    'fields' => array('endid')
                )
            );

            //Define the last id processed for the customer
            $lastid = (empty($lastid) ? 0 : (int)$lastid['CustomerStatus']['endid']);

            if($maxid > $lastid) {
                $this->CustomerStatus->query("CALL map_users_to_person($customerid, $lastid, $maxid);");
            }

            // Find the latest group for the customer.
            $maxid = $this->Group->find('first', array(
                    'contain' => array(
                        'System'
                    ),
                    'conditions' => array(
                        'System.customer_id' => $customerid
                    ),
                    'fields' => array('MAX(Group.id) as maxid'),
                )
            );
            //Define the latest group mapping id for the customer
            $maxid = (int)$maxid[0]['maxid'];

            $lastid = $this->CustomerStatus->find('first', array(
                    'conditions' => array(
                        'type' => CustomerStatus::PROC_GROUP_TO_COURSE,
                        'customer_id' => $customerid
                    ),
                    'fields' => array('endid')
                )
            );

            //Define the last id processed for the customer
            $lastid = (empty($lastid) ? 0 : (int)$lastid['CustomerStatus']['endid']);

            if($maxid > $lastid) {
                $this->CustomerStatus->query("CALL map_groups_to_course($customerid, $lastid, $maxid);");
            }

            // Find the latest action for the customer.
            $maxid = $this->Action->find('first', array(
                    'contain' => array(
                        'System'
                    ),
                    'conditions' => array(
                        'System.customer_id' => $customerid
                    ),
                    'fields' => array('MAX(Action.id) as maxid'),
                )
            );
            //Define the latest sum action id for the customer
            $maxid = (int)$maxid[0]['maxid'];

            $lastid = $this->CustomerStatus->find('first', array(
                    'conditions' => array(
                        'type' => CustomerStatus::PROC_SUM_ACTION,
                        'customer_id' => $customerid
                    ),
                    'fields' => array('endid')
                )
            );

            //Define the last id processed for the customer
            $lastid = (empty($lastid) ? 0 : (int)$lastid['CustomerStatus']['endid']);

            if($maxid > $lastid) {
                $this->CustomerStatus->query("CALL aggregate_summed_actions($customerid, $lastid, $maxid);");
            }

            $rules = $this->Rule->getCustomerRules($customerid);
            foreach ($rules as $rule) {
                if ($rule['Rule']['name'] == 'IP Address') {
                    // Don't process this.
                    continue;
                }
                $ruleid = $rule['Rule']['id'];
                $lastid = $this->CustomerStatus->find('first', array(
                        'conditions' => array(
                            'type' => CustomerStatus::PROC_SUM_RULE,
                            'rule_id' => $ruleid,
                            'customer_id' => $customerid
                        ),
                        'fields' => array('endid')
                    )
                );

                //Define the last id processed for the customer
                $lastid = (empty($lastid) ? 0 : (int)$lastid['CustomerStatus']['endid']);

                //Compare values and only process if new actions exist since last procedure update
                if($maxid > $lastid) {
                    $this->CustomerStatus->query("CALL aggregate_summed_rule_conditions($customerid, $lastid, $maxid, $ruleid);");
                }
            }
            //$this->CustomerStatus->query("CALL aggregate_summed_ip_conditions($customerid, $lastid, $maxid, 2);");
        }
    }
}
?>