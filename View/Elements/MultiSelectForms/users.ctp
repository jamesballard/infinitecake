<div class="form-group">
<?php
echo $this->Form->label('User', 'User(s)', array('class' => 'col-sm-2 control-label'));
echo '<div class="col-sm-5">';
echo $this->Chosen->select(
    'User',
    $users,
    array(
        'data-placeholder' => "Select User(s)...",
        'multiple' => true,
        'class' => 'form-control',
        'deselect' => true
    )
);
?>
    </div>
</div>