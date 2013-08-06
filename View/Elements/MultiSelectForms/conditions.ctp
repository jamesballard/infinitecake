<div class="control-group">
<?php
echo $this->Form->label('Condition', 'Condition(s)', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'Condition',
    $conditions,
    array(
        'data-placeholder' => "Select Condition(s)...",
        'multiple' => true,
        'deselect' => true
    )
);
?>
    </div>
</div>