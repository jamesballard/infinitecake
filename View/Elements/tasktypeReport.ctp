<?php

$this->Html->script('https://www.google.com/jsapi', false);
echo $this->GChart->start('chart_div');
echo $this->GChart->visualize('chart_div', $data);

echo '<div style="width:400px">';

echo $this->Form->create();

echo $this->Form->input('chart', array(
    'options' => array('bar' => 'bar', 'column' => 'column', 'line' => 'line', 'table' => 'table'),
    'default' => 'column'
));

echo $this->element('systemMultiSelect');

echo $this->Form->input('period', array(
    'options' => array('day' => 'day', 'week' => 'week', 'month' => 'month'),
    'default' => 'month'
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
<div id="chart_div"></div>