<?php $this->layout = 'configManage'; ?>
<div class="groups form">
<?php echo $this->Form->create('Group'); ?>
	<fieldset>
		<legend><?php echo __('Add Group'); ?></legend>
	<?php
		echo $this->Form->input('sysid');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('type');
		echo $this->Form->input('system_id');
		echo $this->Form->input('community_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Groups'), array('action' => 'index')); ?></li>
	</ul>
</div>
