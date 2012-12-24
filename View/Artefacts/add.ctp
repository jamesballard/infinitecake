<div class="artefacts form">
<?php echo $this->Form->create('Artefact'); ?>
	<fieldset>
		<legend><?php echo __('Add Artefact'); ?></legend>
	<?php
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('type', array('type' => 'select',
            'options' => array(Artefact::ARTEFACT_TYPE_ASSESSMENT => 'Assessment',
                Artefact::ARTEFACT_TYPE_COMMUNICATION => 'Communication',
                Artefact::ARTEFACT_TYPE_COLLABORATION => 'Collaboration',
                Artefact::ARTEFACT_TYPE_RESOURCE => 'Resource',
                Artefact::ARTEFACT_TYPE_OPERATION => 'Operation')
        ));
		echo $this->Form->input('community_id', array('type' => 'select', 'options' => $communities));
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
