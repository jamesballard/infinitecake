<?php $this->layout = 'configManage'; ?>
<div class="members form">
<?php echo $this->Form->create('Member'); ?>
	<fieldset>
		<legend><?php echo __('Add Member'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('membership_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
