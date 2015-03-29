<h2><?php echo __('Module Based Activity'); ?></h2>
<?php
echo $this->DrasticTreeMap->init('chart_div');
echo $this->DrasticTreeMap->visualize('chart_div', $data);

echo '<div id="chart_div"  style="width:'.$width.'px; height:'.$height.'px;"></div>';

echo $this->Form->create('Modules');
?>
<fieldset>
<?php
echo $this->element('FormItems/legendChangeSettings');
//echo $this->element('FormItems/selectDateWindow');
echo $this->element('MultiSelectForms/systems');
echo $this->element('FormItems/inputSize');
?>
</fieldset>
<?php
echo $this->Form->end();
?>
