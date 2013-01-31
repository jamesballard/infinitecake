<?php $this->layout = 'configManage'; ?>
<div class="memberships form">
<?php echo $this->Form->create('Membership'); ?>
	<fieldset>
		<legend><?php echo __('Add Membership'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
