<?php $this->layout = 'configManage'; ?>
<div class="rules form">
<?php echo $this->Form->create('Rule'); ?>
	<fieldset>
		<legend><?php echo __('Edit Rule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('value');
        echo $this->Form->input('type', array('type' => 'select', 'options' => $types));
        echo $this->Form->input('customer_id');
		echo $this->Form->input('Condition');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>