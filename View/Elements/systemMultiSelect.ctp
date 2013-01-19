<?php
echo $this->Form->label('system', 'System(s)');
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