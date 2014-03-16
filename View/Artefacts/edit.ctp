<div class="artefacts form">
<h2><?php echo __('Edit Artefact'); ?></h2>
<?php echo $this->Form->create('Artefact'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
        echo $this->Form->input('id');
		echo $this->Form->input('sysname');
		echo $this->Form->input('name');
		echo $this->Form->input('type', array('type' => 'select', 'options' => $artefact_types));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
