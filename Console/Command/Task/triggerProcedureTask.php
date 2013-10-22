<?php
class TriggerProcedureTask extends Shell {
    public $uses = array('Customer', 'Rule', 'Action', 'CustomerStatus');
    public function execute() {
        $customers = $this->Customer->find('all', array(
            'conditions' => array(
                'id >' => 1
            )
        ));
        foreach ($customers as $customer) {
            $customerid = $customer['Customer']['id'];
            $types = $this->Rule->rule_types;
            foreach ($types as $typekey=>$type) {
                $rules = $this->Rule->getCustomerRules($customerid);
                foreach ($rules as $rule) {
                    $ruleid = $rule['Rule']['id'];
                    $lastid = $this->CustomerStatus->find('first', array(
                            'conditions' => array(
                                'type' => $typekey,
                                'rule_id' => $ruleid,
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
                                'System.customer_id' => $customerid
                            ),
                            'fields' => array('MAX(Action.id) as maxid'),
                        )
                    );

                    //Define the latest action id for the customer
                    $maxid = (int)$maxid[0]['maxid'];

                    //Define the last id processed for the customer
                    $lastid = (empty($lastid) ? 0 : (int)$lastid['CustomerStatus']['endid']);

                    //Compare values and only process if new actions exist since last procedure update
                    if($maxid > $lastid) {
                        //Call process based on the type
                        switch($typekey) {
                            case 1:
                                $this->CustomerStatus->query("CALL map_users_to_person($customerid);");
                                break;
                            case 2:
                                $this->CustomerStatus->query("CALL map_groups_to_course($customerid);");
                                break;
                            case 3:
                                $this->CustomerStatus->query("CALL aggregate_summed_actions($customerid, $lastid, $maxid);");
                                break;
                            case 4:
                                $this->CustomerStatus->query("CALL aggregate_summed_rule_conditions($customerid, $lastid, $maxid, $ruleid);");
                                break;
                            case 5:
                                //$this->CustomerStatus->query("CALL aggregate_summed_ip_conditions($customerid, $lastid, $maxid, 2);");
                                break;
                        }
                    }
                }
            }
        }
    }
}
?>