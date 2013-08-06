<div class="memberships form">
    <h2><?php echo __('Add Membership'); ?></h2>
<?php echo $this->BootstrapForm->create('Membership'); ?>
	<fieldset>
    <?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>
