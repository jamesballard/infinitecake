<div class="control-group">
<?php
	echo $this->Form->label($formid, $label.'(s)', array('class' => 'control-label'));
    echo '<div class="controls">';
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
    </div>
</div>