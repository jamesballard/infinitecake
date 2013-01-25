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
        echo $this->Form->input('customer_id', array( 'value' => $current_user['Member']['customer_id'], 'type' => 'hidden'));
		echo $this->element('conditionMultiSelect');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>