<div class="rules form">
<?php echo $this->Form->create('Rule'); ?>
	<fieldset>
		<legend><?php echo __('Add Rule'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('value');
		echo $this->Form->input('type', array('type' => 'select', 'options' => array(
                                                    Rule::RULE_TYPE_ACTION => 'Action',
                                                    Rule::RULE_TYPE_DIMENSION_VERB => 'Verb',
                                                    Rule::RULE_TYPE_MODULE => 'Module',
                                                    Rule::RULE_TYPE_ARTEFACT => 'Artefact',
                                                    Rule::RULE_TYPE_ARTEFACT => 'Group'
                                                )));
		echo $this->Form->input('customer_id');
		echo $this->Form->input('Condition');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Rules'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Artefacts'), array('controller' => 'artefacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Artefact'), array('controller' => 'artefacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Communities'), array('controller' => 'communities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Community'), array('controller' => 'communities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Conditions'), array('controller' => 'conditions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Condition'), array('controller' => 'conditions', 'action' => 'add')); ?> </li>
	</ul>
</div>
