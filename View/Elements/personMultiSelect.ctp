<?php
	echo $this->Form->label('Person', 'People');
	echo $this->Chosen->select(
    	'Person',
    	$people,
    	array(
    		'data-placeholder' => "Select People...",
    		'multiple' => true, 
    		'deselect' => true
    	)
	);
?>