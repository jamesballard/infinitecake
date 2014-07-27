<div class="departments form">
<h2><?php echo __('Add Department'); ?></h2>
<?php echo $this->Form->create('Department'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('name');
		echo $this->Form->input('idnumber');
        echo $this->element('SelectForms/yesno', array('name' => 'active', 'description' => 'Active'));
        echo $this->element('FormItems/hiddenCustomer_id');
        echo $this->element('SelectForms/departments');
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
