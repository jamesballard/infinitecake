<?php
echo $this->Form->input('customer_id', array( 
		'value' => $current_user['Member']['customer_id'], 
		'type' => 'hidden'
	));
?>