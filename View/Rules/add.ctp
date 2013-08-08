<div class="rules form">
<h2><?php echo __('Add Rule'); ?></h2>
<?php echo $this->BootstrapForm->create('Rule'); ?>
	<fieldset>
    <?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('name');
        echo $this->Form->input('category', array('type' => 'select', 'options' => $rule_cats));
        echo $this->Form->input('subcategory', array('type' => 'select', 'options' => $rule_subs));
		echo $this->Form->input('type', array('type' => 'select', 'options' => $rule_types));
		echo $this->element('FormItems/hiddenCustomer_id');
		echo $this->element('MultiSelectForms/conditions');
	?>
    </fieldset>

<?php echo $this->BootstrapForm->end(); ?>
</div>