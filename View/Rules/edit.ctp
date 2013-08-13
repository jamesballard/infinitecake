<div class="rules form">
<h2><?php echo __('Edit Rule'); ?></h2>
<?php echo $this->BootstrapForm->create('Rule'); ?>
    <?php
    $html = $this->Form->input("Condition.' + i +'.name");
    $html .= $this->Form->input("Condition.' + i +'.type", array( 'value' => 1 , 'type' => 'hidden') );
    $html .= $this->formGeneration->generateConditionRulesForm($rules, $rule_id);
    $html .= $this->Form->input("Condition.' + i +'.customer_id", array( 'value' => $customer_id, 'type' => 'hidden'));
    if($formid != Rule::RULE_TYPE_ACTION) {
        $html .= $this->formGeneration->generateConditionItemsForm($rule_types, $label, $conditionItems);
    }
    ?>
    <div id="elementContainer">
	<fieldset>
	<?php
        echo $this->element('FormItems/legendChangeSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('name');
        echo $this->Form->input('category', array('type' => 'select', 'options' => $rule_cats));
        echo $this->Form->input('subcategory', array('type' => 'select', 'options' => $rule_subs));
        echo $this->Form->input('type', array('type' => 'select', 'options' => $rule_types));
        echo $this->element('FormItems/hiddenCustomer_id');
        echo $this->element('MultiSelectForms/conditions');
	?>
	</fieldset>
    </div>
    <?php echo $this->BootstrapForm->button('Add Element', array('id' => 'addElement', 'type' =>'button'), 'primary'); ?>
    <?php echo $this->BootstrapForm->end('',array(),'success'); ?>
</div>
<?php echo $this->dynamicForms->addremoveHtmlElement('addElement', 'elementContainer', $html);