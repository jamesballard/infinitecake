<?php
    /**
     * CakePHP helper that acts as a wrapper for Drastic Data Tree Maps.
     */
class permissionsHelper extends AppHelper {

/**
 * Checks that the record belongs to the customer.
 * Used to determine action options.
 *
 * @param array $current_user
 * @param integer $customer_id 
 * @return boolean
 */
    
    public function check_customerID($currentUser, $customer_id) {
    	if($customer_id == $currentUser['Member']['customer_id']) {
    		return true;
    	}else{
    		return false;
    	}	
    }

 /**
  * Checks that the current user has Administrator privileges.
  * Used to determine action options.
  *
  * @param array $current_user
  * @return boolean
  */
    
    public function is_admin($currentUser) {
    	if($currentUser['Membership']['id'] == 1) {
    		return true;
    	}else{
    		return false;
    	}
    }
}