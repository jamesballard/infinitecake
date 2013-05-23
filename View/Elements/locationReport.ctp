<?php

$this->Html->script('https://www.google.com/jsapi', false);
echo $this->GChart->start('chart_div');
echo $this->GChart->visualize('chart_div', $data);

echo '<div style="width:400px">';

echo $this->Form->create();

echo $this->Form->input('chart', array(
    'options' => array('bar' => 'bar', 'column' => 'column', 'pie' => 'pie', 'line' => 'line', 'table' => 'table'),
    'default' => 'column'
));

echo $this->element('dateWindowSelect');
echo $this->element('systemMultiSelect');
echo $this->element('periodSelect');
echo $this->element('sizeInput');

echo $this->Form->end('Change');

echo '</div>';

?>
<div id="chart_div"></div>