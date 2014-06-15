<div class="form-group">
<?php
echo $this->Form->label('System', 'System(s)', array('class' => 'col-sm-2 control-label'));
echo '<div class="col-sm-5">';
echo $this->Chosen->select(
    'System',
    $systems,
    array(
    	'data-placeholder' => 'Select system(s)...',
    	'default' => array_keys($systems),
    	'multiple' => true,
        'class' => 'form-control',
        'deselect' => true,
        )
);
?>
    </div>
</div>