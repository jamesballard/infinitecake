<?php $this->layout = 'configManage'; ?>
<div class="people form">
<?php echo $this->Form->create('Person'); ?>
	<fieldset>
		<legend><?php echo __('Edit Person'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		echo $this->Form->input('gender');
		echo $this->Form->input('dob');
		echo $this->Form->input('nationality');
		echo $this->Form->input('ethnicity');
		echo $this->Form->input('disability');
		echo $this->Form->input('customer_id');
		echo $this->Form->input('Community');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>