<?php $this->layout = 'configManage'; ?>
<div class="customers form">
<?php echo $this->Form->create('Customer'); ?>
	<fieldset>
		<legend><?php echo __('Edit Customer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('zip');
		echo $this->Form->input('lat');
		echo $this->Form->input('lon');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
