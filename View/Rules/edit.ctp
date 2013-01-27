<?php $this->layout = 'configManage'; ?>
<div class="rules form">
<h2><?php echo __('Edit Rule'); ?></h2>
<?php echo $this->Form->create('Rule'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('value');
        echo $this->Form->input('type', array('type' => 'select', 'options' => $rule_types));
        echo $this->element('customerIdHidden');
        echo $this->element('conditionMultiSelect');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>