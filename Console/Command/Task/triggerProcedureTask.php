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
        }
    }
}
?>