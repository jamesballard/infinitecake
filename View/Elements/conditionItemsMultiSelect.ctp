<?php
	echo $this->Form->label('Item', $label.'(s)');
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