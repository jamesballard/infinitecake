<?php $this->layout = 'configManage'; ?>
<div class="members form">
<h2><?php echo __('Edit Member'); ?></h2>
<?php echo $this->Form->create('Member'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		echo $this->Form->input('email');
		echo $this->Form->input('membership_id');
		echo $this->element('customerIdHidden');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
