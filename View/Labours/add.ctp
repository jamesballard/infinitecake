<div class="labours form">
<?php echo $this->Form->create('Labour'); ?>
	<fieldset>
		<legend><?php echo __('Add Labour'); ?></legend>
	<?php
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('person_id');
		echo $this->Form->input('community_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Labours'), array('action' => 'index')); ?></li>
	</ul>
</div>
