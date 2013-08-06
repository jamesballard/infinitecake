<div class="conditions form">
<h2><?php echo __('Edit Condition'); ?></h2>
<?php echo $this->BootstrapForm->create('Condition'); ?>
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('value');
		echo $this->Form->input('type', array( 'value' => Condition::CONDITION_TYPE_USER , 'type' => 'hidden') );
        echo $this->Form->input('Rule');
        echo $this->element('FormItems/hiddenCustomer_id');
        if($formid != 'Action') {
        	echo $this->element('MultiSelectForms/conditionItems');
        }
    ?>
	</fieldset>
<?php echo $this->BootstrapForm->end(); ?>
</div>