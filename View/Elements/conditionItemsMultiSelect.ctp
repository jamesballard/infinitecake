<?php
	echo $this->Form->label($formid, $label.'(s)');
	echo $this->Chosen->select(
    	$formid,
    	$conditionItems,
    	array(
    		'data-placeholder' => "Select $label(s)...",
    		'multiple' => true, 
    		'deselect' => true
    	)
	);
?>