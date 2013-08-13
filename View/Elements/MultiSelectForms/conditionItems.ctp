<div class="control-group">
<?php
	echo $this->Form->label(
        "Condition.0.".$rule_types[$rule_type],
        $label.'(s)',
        array('class' => 'control-label')
    );
    echo '<div class="controls">';
    echo $this->Chosen->select(
        "Condition.$count.".$rule_types[$rule_type],
    	$conditionItems,
    	array(
    		'data-placeholder' => "Select $label(s)...",
    		'multiple' => true, 
    		'deselect' => true,
            'value' => $selected
    	)
	);
?>
    </div>
</div>