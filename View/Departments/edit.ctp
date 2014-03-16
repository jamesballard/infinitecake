<div class="departments form">
<h2><?php echo __('Edit Department'); ?></h2>
<?php echo $this->Form->create('Department'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('idnumber');
		echo $this->Form->input('active');
        echo $this->element('FormItems/hiddenCustomer_id');
        echo $this->element('SelectForms/departments');
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
