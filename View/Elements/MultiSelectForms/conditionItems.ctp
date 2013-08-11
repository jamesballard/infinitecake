<div class="control-group">
<?php
	echo $this->Form->label(
        "Condition.0.".$rule_types[Rule::RULE_TYPE_ACTION],
        $label.'(s)',
        array('class' => 'control-label')
    );
    echo '<div class="controls">';
    echo $this->Chosen->select(
        "Condition.0.".$rule_types[Rule::RULE_TYPE_ACTION],
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