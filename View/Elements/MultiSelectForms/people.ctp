<div class="control-group">
<?php
echo $this->Form->label('Person', 'People', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'Person',
    $people,
    array(
        'data-placeholder' => "Select People...",
        'multiple' => true,
        'deselect' => true
    )
);
?>
    </div>
</div>