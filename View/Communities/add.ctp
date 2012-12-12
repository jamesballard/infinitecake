<div class="communities form">
<?php echo $this->Form->create('Community'); ?>
	<fieldset>
		<legend><?php echo __('Add Community'); ?></legend>
	<?php
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('type');
		echo $this->Form->input('customer_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Communities'), array('action' => 'index')); ?></li>
	</ul>
</div>
