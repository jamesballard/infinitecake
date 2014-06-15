<div class="form-group">
<?php
echo $this->Form->label('Group', 'Group(s)', array('class' => 'col-sm-2 control-label'));
echo '<div class="col-sm-5">';
echo $this->Chosen->select(
    'Group',
    $groups,
    array(
        'data-placeholder' => "Select Group(s)...",
        'multiple' => true,
        'class' => 'form-control',
        'deselect' => true
    )
);
?>
    </div>
</div>