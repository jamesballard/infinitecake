<div class="control-group">
<?php
echo $this->Form->label('System', 'System(s)', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'System',
    $systems,
    array(
    	'data-placeholder' => 'Select system(s)...',
    	'default' => array_keys($systems),
    	'multiple' => true
        )
);
?>
    </div>
</div>