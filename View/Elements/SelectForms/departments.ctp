<div class="control-group">
<?php
echo $this->Form->label('department_id', 'Parent Department', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'department_id',
    $departments,
    array(
        'data-placeholder' => "Select Department...")
);
?>
    </div>
</div>