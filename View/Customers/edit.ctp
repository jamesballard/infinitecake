<div class="customers form">
<?php echo $this->Form->create('Customer'); ?>
	<fieldset>
		<legend><?php echo __('Edit Customer'); ?></legend>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('name');
        echo $this->Form->input('service', array(
            'options' => $service_levels,
            'default' => Customer::SERVICE_RESEARCH
        ));
		//echo $this->Form->input('zip');
		//echo $this->Form->input('lat');
		//echo $this->Form->input('lon');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>
