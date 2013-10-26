<div class="conditions form">
    <h2><?php echo __("Add Report Items"); ?></h2>
    <?php echo $this->BootstrapForm->create('Condition'); ?>
<?php
$html = '<fieldset>';
$html .= "<legend>Item '+ (i + 1) +'</legend>";
$html .=  $this->Form->input("Condition.' + i +'.name");
$html .= $this->Form->input("Condition.' + i +'.type", array( 'value' => 1 , 'type' => 'hidden') );
$html .= $this->formGeneration->generateConditionRulesForm($rules, $rule_id);
$html .= $this->Form->input("Condition.' + i +'.customer_id", array( 'value' => $customer_id, 'type' => 'hidden'));
if ($formid == Rule::RULE_TYPE_ACTION) {
    $html .=  $this->Form->input("Condition.' + i +'.value");
} else {
    $html .= $this->formGeneration->generateConditionItemsForm($rule_types, $formid, $label, $conditionItems);
}
$html .= '</fieldset>';
?>

<div id="elementContainer">
    <fieldset>
        <?php
            echo '<legend>'.__('Item').' 1</legend>';
            echo $this->Form->input("Condition.0.name");
            echo $this->Form->input("Condition.0.type", array( 'value' => 1 , 'type' => 'hidden'));
            echo $this->element('MultiSelectForms/rules', array('count' => 0));
            echo $this->Form->input("Condition.0.customer_id", array( 'value' => $customer_id, 'type' => 'hidden'));
            if($formid == Rule::RULE_TYPE_ACTION) {
                echo $this->Form->input("Condition.0.value");
            } else {
                echo $this->element('MultiSelectForms/conditionItems', array(
                    'count' => 0,
                    'rule_type' => $formid,
                    'selected' => array()
                ));
            }
        ?>
    </fieldset>
</div>
    <?php echo $this->BootstrapForm->button('Add item', array('id' => 'addElement', 'type' =>'button'), 'primary'); ?>
    <?php echo $this->BootstrapForm->end('',array(),'success'); ?>
</div>
<?php echo $this->dynamicForms->addremoveHtmlElement('addElement', 'elementContainer', $html, 1); ?>
