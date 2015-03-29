<div class="form-group">
<?php
echo $this->Form->label('department_id',
    'Parent Department',
    array('class' => 'col-sm-2 control-label')
);

echo '<div class="col-sm-5">';

echo $this->Chosen->select(
    'department_id',
    $departments,
    array(
        'class' => 'form-control',
        'data-placeholder' => "Select Department...")
);
?>
    </div>
</div>