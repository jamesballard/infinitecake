<?php

$this->start('sidebar');
echo $this->element('reportSidebar');
echo $this->element('helpSidebar');
$this->end();

echo $this->Html->image('pchart/clock.php?dayData='.$dayData.'&nightData='.$nightData.'&height='.$height.'&width='.$width);

echo '<div style="width:400px">';

echo $this->Form->create();

echo $this->Form->input('report', array(
    'options' => array('sum' => 'Sum', 'min' => 'Minimum', 'max' => 'Maximum'),
    'default' => 'sum'
));

echo $this->Form->input('width', array(
        'type' => 'text',
        'default' => '750'
    )
); // has a label element

echo $this->Form->input('height', array(
        'type' => 'text',
        'default' => '500'
    )
); // has a label element

echo $this->Form->end('Change');

echo '</div>';

?>