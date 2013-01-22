<div class="artefacts form">
<?php echo $this->Form->create('Artefact'); ?>
	<fieldset>
		<legend><?php echo __('Edit Artefact'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Artefact.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Artefact.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Artefacts'), array('action' => 'index')); ?></li>
	</ul>
</div>
