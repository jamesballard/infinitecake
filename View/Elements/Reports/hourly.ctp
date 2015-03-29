<h2><?php echo __('Activity Time'); ?></h2>
<?php

echo $this->Html->image('pchart/clock.php?dayData='.$dayData.'&nightData='.$nightData.'&height='.$height.'&width='.$width);

echo $this->Form->create('Hourly');
?>
<fieldset>
<?php
echo $this->element('FormItems/legendChangeSettings');
echo $this->element('FormItems/selectDateWindow');
echo $this->element('MultiSelectForms/systems');
echo $this->element('FormItems/inputSize');
?>
</fieldset>
<?php
echo $this->Form->end();
?>