<div class="form-group">
<?php
	echo $this->Form->label(
        "Condition.0.".$rule_key,
        $label.'(s)',
        array('class' => 'col-sm-2 control-label')
    );
    echo '<div class="col-sm-5">';
    echo $this->Chosen->select(
        "Condition.$count.".$rule_key,
    	$conditionItems,
    	array(
    		'data-placeholder' => "Select $label(s)...",
    		'multiple' => true,
            'class' => 'form-control',
    		'deselect' => true,
            'value' => $selected
    	)
	);
?>
    </div>
</div>