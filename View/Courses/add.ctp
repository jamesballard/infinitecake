<div class="courses form">
<h2><?php echo __("Add Course"); ?></h2>
<?php echo $this->Form->create('Course'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('shortname');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('active');
		echo $this->Form->input('department_id');
        echo $this->element('personMultiSelect');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
