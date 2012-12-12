<div class="conditions form">
<?php echo $this->Form->create('Condition'); ?>
	<fieldset>
		<legend><?php echo __('Add Condition'); ?></legend>
	<?php
		echo $this->Form->input('sysid');
		echo $this->Form->input('name');
		echo $this->Form->input('value');
		echo $this->Form->input('module_id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Conditions'), array('action' => 'index')); ?></li>
	</ul>
</div>
