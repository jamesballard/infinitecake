<div class="users form">
<h2><?php echo __('Add User'); ?></h2>
<?php echo $this->Form->create('User'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('sysid');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('person_id');
		echo $this->Form->input('system_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>