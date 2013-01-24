<?php $this->layout = 'configManage'; ?>
<div class="actions form">
<?php echo $this->Form->create('Action'); ?>
	<fieldset>
		<legend><?php echo __('Add Action'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('type');
		echo $this->Form->input('time');
		echo $this->Form->input('user_id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('module_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Actions'), array('action' => 'index')); ?></li>
	</ul>
</div>
