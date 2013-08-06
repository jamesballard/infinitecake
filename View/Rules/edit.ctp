<div class="rules form">
<h2><?php echo __('Edit Rule'); ?></h2>
<?php echo $this->BootstrapForm->create('Rule'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('value');
        echo $this->Form->input('type', array('type' => 'select', 'options' => $rule_types));
        echo $this->element('FormItems/hiddenCustomer_id');
        echo $this->element('MultiSelectForms/conditions');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>