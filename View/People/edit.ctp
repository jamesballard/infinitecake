<div class="people form">
<h2><?php echo __('Edit Person'); ?></h2>
<?php echo $this->Form->create('Person'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		echo $this->Form->input('gender');
		echo $this->Form->input('dob');
		echo $this->Form->input('nationality');
		echo $this->Form->input('ethnicity');
		echo $this->Form->input('disability');
		echo $this->element('FormItems/hiddenCustomer_id');
        echo $this->Form->label('department_id', 'Department');
        echo $this->Chosen->select('department_id',$departments,array('data-placeholder' => "Select Department..."));
        echo $this->element('MultiSelectForms/courses');
		echo $this->element('MultiSelectForms/users');
	?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>