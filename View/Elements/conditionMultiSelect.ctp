<?php
	echo $this->Form->label('Condition', 'Condition(s)');
	echo $this->Chosen->select(
    	'Condition',
    	$conditions,
    	array(
    		'data-placeholder' => "Select Condition(s)...",
    		'multiple' => true, 
    		'deselect' => true
    	)
	);
?>