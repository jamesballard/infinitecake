<div class="rules form">
<?php echo $this->Form->create('Rule'); ?>
	<fieldset>
		<legend><?php echo __('Edit Rule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('value');
		echo $this->Form->input('artefact_id');
		echo $this->Form->input('community_id');
		echo $this->Form->input('person_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Rule.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Rule.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Rules'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Artefacts'), array('controller' => 'artefacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Artefact'), array('controller' => 'artefacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Communities'), array('controller' => 'communities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Community'), array('controller' => 'communities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List People'), array('controller' => 'people', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('controller' => 'people', 'action' => 'add')); ?> </li>
	</ul>
</div>