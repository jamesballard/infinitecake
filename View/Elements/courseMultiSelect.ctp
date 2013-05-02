<?php
	echo $this->Form->label('Course', 'Course(s)');
	echo $this->Chosen->select(
    	'Course',
    	$courses,
    	array(
    		'data-placeholder' => "Select Course(s)...",
    		'multiple' => true, 
    		'deselect' => true
    	)
	);
?>