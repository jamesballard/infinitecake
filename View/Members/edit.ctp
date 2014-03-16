<div class="members form">
<h2><?php echo __('Edit Member'); ?></h2>
<?php echo $this->Form->create('Member'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		echo $this->Form->input('email');
		echo $this->Form->input('membership_id');
		echo $this->element('FormItems/hiddenCustomer_id');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>
