<div class="control-group">
<?php
echo $this->Form->label('system', 'System(s)', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'system',
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