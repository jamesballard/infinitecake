<div class="dimensionVerbs form">
<?php echo $this->BootstrapForm->create('DimensionVerb'); ?>
	<fieldset>
		<legend><?php echo __('Edit Dimension Verb'); ?></legend>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('sysname');
		echo $this->Form->input('name');
        echo $this->Form->input('type', array('type' => 'select', 'options' => $verb_types));
        echo $this->Form->input('uri');
        echo $this->Form->input('artefact_id', array('type' => 'select', 'options' => $artefacts));
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>