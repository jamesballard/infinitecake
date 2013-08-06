<div class="modules form">
<h2><?php echo __('Add Module'); ?></h2>
<?php echo $this->BootstrapForm->create('Module'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('sysid');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('artefact_id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('system_id');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>