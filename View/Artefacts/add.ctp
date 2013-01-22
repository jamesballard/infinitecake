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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Artefacts'), array('action' => 'index')); ?></li>
	</ul>
</div>
