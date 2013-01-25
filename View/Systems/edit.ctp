<?php $this->layout = 'configManage'; ?>
<div class="systems form">
<?php echo $this->Form->create('System'); ?>
	<fieldset>
		<legend><?php echo __('Edit System'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('type', array('options' => $types));
		echo $this->Form->input('name');
        echo $this->Form->input('customer_id', array('type' => 'select', 'options' => $customers));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>