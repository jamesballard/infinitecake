<div class="memberships form">
    <h2><?php echo __('Edit Membership'); ?></h2>
<?php echo $this->Form->create('Membership'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>
