<div class="form-group">
<?php
echo $this->Form->label('Course', 'Course(s)', array('class' => 'col-sm-2 control-label'));
echo '<div class="col-sm-5">';
echo $this->Chosen->select(
    'Course',
    $courses,
    array(
        'data-placeholder' => "Select Course(s)...",
        'multiple' => true,
        'class' => 'form-control',
        'deselect' => true
    )
);
?>
    </div>
</div>