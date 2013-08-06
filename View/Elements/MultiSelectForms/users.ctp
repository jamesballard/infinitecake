<div class="control-group">
<?php
echo $this->Form->label('User', 'User(s)', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'User',
    $users,
    array(
        'data-placeholder' => "Select User(s)...",
        'multiple' => true,
        'deselect' => true
    )
);
?>
    </div>
</div>