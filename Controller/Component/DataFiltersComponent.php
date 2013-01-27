<?php
App::uses('Component', 'Controller');
App::uses('User', 'Model');

class DataFiltersComponent extends Component {
   
    /**
     * Creates report filter conditions based on systems for logged in user
     *
     * @param array $system 
     * @return array conditions
     */
    
    public function returnSystemFilter($system) {
    	//This should work as long as contain is used to avoid 
    	//ambiguous use of sysem_id in Models. Otherwise model
    	//must also be provided.
    	$conditions = array('System.id' => $system); 
    	
    	return $conditions;
    }
    
    /**
     * Creates report filter conditions based on selected user 
     * and systems for logged in user.
     * 
     * @param array $system
     * @return array conditions
     */
    
    public function returnPersonFilter($system, $userid) {
   		
    	$User = new User();
    	//Set the user filter conditions as all users for selected person
    	$user_ids = $User->find('list', array(
    			'conditions' => array('person_id' => $userid),
    			'contain' => false,
    			'fields' => array('User.id'),
    		)
    	);
    	$conditions = array('user_id'=>$user_ids);
    	
    	//Merge with system conditions
    	$conditions = array_merge($conditions,$this->returnSystemFilter($system));
    	 
    	return $conditions;
    }
    
    /**
     * Creates report filter conditions based on selected group
     * and systems for logged in user.
     *
     * @param array $system
     * @return array conditions
     */
    
    public function returnGroupFilter($system, $groupid) {
    
    	//Set the user filter conditions as all users for selected person
    	$conditions = array('group_id'=>$groupid);
    	 
    	//Merge with system conditions
    	$conditions = array_merge($conditions,$this->returnSystemFilter($system));
    
    	return $conditions;
    }
}
?>