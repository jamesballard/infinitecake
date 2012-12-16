<div class="conditions form">
<?php echo $this->Form->create('Condition'); ?>
	<fieldset>
		<legend><?php echo __('Edit Condition'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Condition.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Condition.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Conditions'), array('action' => 'index')); ?></li>
	</ul>
</div>