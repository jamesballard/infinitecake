<?php $this->layout = 'configManage'; ?>
<div class="groups form">
<?php echo $this->Form->create('Group'); ?>
	<fieldset>
		<legend><?php echo __('Edit Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('sysid');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('type');
		echo $this->Form->input('system_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
