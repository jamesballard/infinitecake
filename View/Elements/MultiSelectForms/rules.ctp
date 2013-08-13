<div class="control-group">
<?php
echo $this->Form->label('Condition.0.Rule', 'Rule(s)', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    "Condition.$count.Rule",
    $rules,
    array(
        'data-placeholder' => "Select Rule(s)...",
        'multiple' => true,
        'deselect' => true,
        'default' => $rule_id
    )
);
?>
    </div>
</div>