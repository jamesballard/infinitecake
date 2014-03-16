<div class="courses form">
<h2><?php echo __("Add Course"); ?></h2>
<?php echo $this->Form->create('Course'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('name');
		echo $this->Form->input('shortname');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('active');
        echo $this->element('SelectForms/departments');
        echo $this->element('MultiSelectForms/people');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>
