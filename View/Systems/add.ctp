<div class="systems form">
<h2><?php echo __('Add System'); ?></h2>
<?php echo $this->BootstrapForm->create('System'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('type', array('options' => $system_types));
		echo $this->Form->input('name');
		echo $this->Form->input('customer_id', array('type' => 'select', 'options' => $customers));
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>