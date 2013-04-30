<?php
	echo $this->Form->label('Group', 'Group(s)');
	echo $this->Chosen->select(
    	'Group',
    	$groups,
    	array(
    		'data-placeholder' => "Select Group(s)...",
    		'multiple' => true, 
    		'deselect' => true
    	)
	);
?>