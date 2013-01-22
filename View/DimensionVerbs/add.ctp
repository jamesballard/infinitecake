<div class="dimensionVerbs form">
<?php echo $this->Form->create('DimensionVerb'); ?>
	<fieldset>
		<legend><?php echo __('Add Dimension Verb'); ?></legend>
	<?php
		echo $this->Form->input('sysname');
		echo $this->Form->input('name');
		echo $this->Form->input('type', array('type' => 'select', 'options' => $types));
		echo $this->Form->input('uri');
		echo $this->Form->input('artefact_id', array('type' => 'select', 'options' => $artefacts));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dimension Verbs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Artefacts'), array('controller' => 'artefacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Artefact'), array('controller' => 'artefacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fact User Actions Dates'), array('controller' => 'fact_user_actions_dates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fact User Actions Date'), array('controller' => 'fact_user_actions_dates', 'action' => 'add')); ?> </li>
	</ul>
</div>
