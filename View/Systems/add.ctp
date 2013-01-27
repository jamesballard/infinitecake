<?php $this->layout = 'configManage'; ?>
<div class="systems form">
<h2><?php echo __('Add System'); ?></h2>
<?php echo $this->Form->create('System'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('type', array('options' => $system_types));
		echo $this->Form->input('name');
		echo $this->Form->input('customer_id', array('type' => 'select', 'options' => $customers));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>