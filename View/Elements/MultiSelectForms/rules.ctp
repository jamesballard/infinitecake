<div class="form-group">
<?php
echo $this->Form->label('Condition.0.Rule', 'Rule(s)', array('class' => 'col-sm-2 control-label'));
echo '<div class="col-sm-5">';
echo $this->Chosen->select(
    "Condition.$count.Rule",
    $rules,
    array(
        'data-placeholder' => "Select Rule(s)...",
        'multiple' => true,
        'deselect' => true,
        'class' => 'form-control',
        'default' => $rule_id
    )
);
?>
    </div>
</div>