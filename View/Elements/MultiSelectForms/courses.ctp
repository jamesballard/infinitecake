<div class="control-group">
<?php
echo $this->Form->label('Course', 'Course(s)', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'Course',
    $courses,
    array(
        'data-placeholder' => "Select Course(s)...",
        'multiple' => true,
        'deselect' => true
    )
);
?>
    </div>
</div>