<div class="artefacts form">
<h2><?php echo __('Add Artefact'); ?></h2>
<?php echo $this->Form->create('Artefact'); ?>
    <fieldset>
    <?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('sysname');
		echo $this->Form->input('name');
		echo $this->Form->input('type', array('type' => 'select', 'options' => $artefact_types));
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
