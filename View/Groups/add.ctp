<div class="groups form">
<h2><?php echo __('Add Group'); ?></h2>
<?php echo $this->BootstrapForm->create('Group'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('sysid');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('name');
		echo $this->Form->input('type', array('type' => 'select', 'options' => $group_types));
		echo $this->Form->input('system_id');
        echo $this->element('MultiSelectForms/courses');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>
