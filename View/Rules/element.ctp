<div class="conditions form">
    <h2><?php echo __("Add Rule"); ?></h2>
    <?php echo $this->BootstrapForm->create('Condition'); ?>
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
        echo '<legend>'.__('Add new '.$label.' conditions').'</legend>';
            echo $this->Form->input("Condition.0.name");
            echo $this->Form->input("Condition.0.type", array( 'value' => 1 , 'type' => 'hidden'));
            echo $this->element('MultiSelectForms/rules');
            echo $this->Form->input("Condition.0.customer_id", array( 'value' => $customer_id, 'type' => 'hidden'));
            if($formid != Rule::RULE_TYPE_ACTION) {
                echo $this->element('MultiSelectForms/conditionItems');
            }
            echo '<hr />';
        ?>
    </fieldset>
</div>
    <?php echo $this->BootstrapForm->button('Add Element', array('id' => 'addElement', 'type' =>'button'), 'primary'); ?>
    <?php echo $this->BootstrapForm->end('',array(),'success'); ?>
</div>
<?php echo $this->dynamicForms->addremoveHtmlElement('addElement', 'elementContainer', $html); ?>
