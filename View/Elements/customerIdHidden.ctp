<?php

$is_admin = $this->Permissions->is_admin($current_user);

if($is_admin):
	echo $this->Form->input('customer_id');
else:
	echo $this->Form->input('customer_id', array( 
			'value' => $current_user['Member']['customer_id'], 
			'type' => 'hidden'
		));
endif;

?>