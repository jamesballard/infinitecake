<div class="artefacts form">
<?php echo $this->Form->create('Artefact'); ?>
	<fieldset>
		<legend><?php echo __('Add Artefact'); ?></legend>
	<?php
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('type', array('type' => 'select', 'options' => $types));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
