<div class="materials form">
<?php echo $this->Form->create('Material'); ?>
	<fieldset>
		<legend><?php echo __('Add Material'); ?></legend>
	<?php
		echo $this->Form->input('sysid');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('module_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Materials'), array('action' => 'index')); ?></li>
	</ul>
</div>
