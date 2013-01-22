<div class="conditions form">
<?php echo $this->Form->create('Condition'); ?>
	<fieldset>
		<legend><?php echo __('Add Condition'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('value');
		echo $this->Form->input('type', array( 'value' => CONDITION_TYPE_USER , 'type' => 'hidden') );
		echo $this->Form->input('Rule');
        echo $this->Chosen->select(
            'DimensionVerb',
            $dimensionVerbs,
            array('data-placeholder' => 'Select verbs...', 'multiple' => true, 'deselect' => true)
        );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Conditions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Rules'), array('controller' => 'rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rule'), array('controller' => 'rules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dimension Verb Conditions'), array('controller' => 'dimension_verb_conditions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dimension Verb Condition'), array('controller' => 'dimension_verb_conditions', 'action' => 'add')); ?> </li>
	</ul>
</div>
