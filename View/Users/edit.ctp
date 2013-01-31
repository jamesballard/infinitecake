<div class="users form">
<h2><?php echo __('Edit User'); ?></h2>
<?php echo $this->Form->create('User'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('idnumber');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>