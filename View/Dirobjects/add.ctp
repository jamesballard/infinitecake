<div class="dirobjects form">
<?php echo $this->Form->create('Dirobject'); ?>
	<fieldset>
		<legend><?php echo __('Add Dirobject'); ?></legend>
	<?php
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('artefact_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dirobjects'), array('action' => 'index')); ?></li>
	</ul>
</div>
