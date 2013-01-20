<?php

echo $this->Html->image('pchart/clock.php?dayData='.$dayData.'&nightData='.$nightData.'&height='.$height.'&width='.$width);

echo '<div style="width:400px">';

echo $this->Form->create();

/*echo $this->Form->input('report', array(
    'options' => array('sum' => 'Sum', 'min' => 'Minimum', 'max' => 'Maximum'),
    'default' => 'sum'
));*/

echo $this->element('dateWindowSelect');
echo $this->element('systemMultiSelect');
echo $this->element('sizeInput');

echo $this->Form->end('Change');

echo '</div>';

?>