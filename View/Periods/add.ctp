<div class="periods form">
    <h2><?php echo __('Add Period'); ?></h2>
<?php echo $this->BootstrapForm->create('Period'); ?>
	<fieldset>
        <?php echo $this->element('FormItems/legendSettings'); ?>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('start');
		echo $this->Form->input('end');
		echo $this->Form->input('interval');
		echo $this->Form->input('customer_id');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>