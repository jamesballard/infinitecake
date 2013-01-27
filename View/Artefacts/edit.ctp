<div class="artefacts form">
<h2><?php echo __('Edit Artefact'); ?></h2>
<?php echo $this->Form->create('Artefact'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('type', array('type' => 'select', 'options' => $types));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
