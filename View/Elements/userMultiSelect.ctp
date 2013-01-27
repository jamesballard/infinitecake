<?php
	echo $this->Form->label('User', 'User(s)');
	echo $this->Chosen->select(
    	'User',
    	$users,
    	array(
    		'data-placeholder' => "Select User(s)...",
    		'multiple' => true, 
    		'deselect' => true
    	)
	);
?>