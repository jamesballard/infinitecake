<div class="control-group">
<?php
echo $this->Form->label('Group', 'Group(s)', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'Group',
    $groups,
    array(
        'data-placeholder' => "Select Group(s)...",
        'multiple' => true,
        'deselect' => true
    )
);
?>
    </div>
</div>