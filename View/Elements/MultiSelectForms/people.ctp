<div class="form-group">
<?php
echo $this->Form->label('Person', 'People', array('class' => 'col-sm-2 control-label'));
echo '<div class="col-sm-5">';
echo $this->Chosen->select(
    'Person',
    $people,
    array(
        'data-placeholder' => "Select People...",
        'multiple' => true,
        'class' => 'form-control',
        'deselect' => true,
    )
);
?>
    </div>
</div>