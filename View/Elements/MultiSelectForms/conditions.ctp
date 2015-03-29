<div class="form-group">
<?php
echo $this->Form->label('Condition', 'Condition(s)', array('class' => 'col-sm-2 control-label'));
echo '<div class="col-sm-5">';
echo $this->Chosen->select(
    'Condition',
    $conditions,
    array(
        'data-placeholder' => "Select Condition(s)...",
        'multiple' => true,
        'class' => 'form-control',
        'deselect' => true
    )
);
?>
    </div>
</div>