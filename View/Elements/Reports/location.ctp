<h2><?php echo __('Location Based Activity'); ?></h2>
<?php

$this->Html->script('https://www.google.com/jsapi', false);
echo $this->GChart->start('chart_div');
echo $this->GChart->visualize('chart_div', $data);

echo $this->Form->create('Location');
?>
<fieldset>
<?php
echo $this->element('FormItems/legendChangeSettings');
echo $this->Form->input('chart', array(
    'options' => array('bar' => 'bar', 'column' => 'column', 'pie' => 'pie', 'line' => 'line', 'table' => 'table'),
    'default' => 'column'
));
echo $this->element('FormItems/selectDateWindow');
echo $this->element('MultiSelectForms/systems');
echo $this->element('FormItems/selectPeriod');
echo $this->element('FormItems/inputSize');
?>
</fieldset>
<?php
echo $this->Form->end();
?>
<div id="chart_div"></div>