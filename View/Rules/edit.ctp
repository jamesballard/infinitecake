<div class="rules form">
<h2><?php echo __('Edit Rule'); ?></h2>
<?php echo $this->Form->create('Rule'); ?>
    <?php
    $html = "<legend>Label '+ (i + 1) +'";
    $html .= '<span class="help-inline"><small>';
    $html .= $this->html->link('Remove', '#', array('class' => 'remScnt'));
    $html .= '</small></span></legend>';
    $html .= $this->Form->input("Condition.' + i +'.name");
    $html .= $this->Form->input("Condition.' + i +'.type", array( 'value' => 1 , 'type' => 'hidden') );
    $html .= $this->formGeneration->generateConditionRulesForm($rules, $rule_id);
    $html .= $this->Form->input("Condition.' + i +'.customer_id", array( 'value' => $customer_id, 'type' => 'hidden'));
    if($formid != Rule::RULE_TYPE_ACTION) {
        $html .= $this->formGeneration->generateConditionItemsForm($rule_types, $formid, $label, $conditionItems);
    }
    ?>
    <div id="elementContainer">
	<fieldset>
	<?php
        echo $this->element('FormItems/legendSettings');
		echo $this->Form->input('id');
		echo $this->Form->input('name');
        echo $this->Form->input('category', array('type' => 'select', 'options' => $rule_cats));
        echo $this->Form->input('subcategory', array('type' => 'select', 'options' => $rule_subs));
        echo $this->Form->input('type', array('type' => 'select', 'options' => $rule_types));
        echo $this->element('FormItems/hiddenCustomer_id');
    ?>
    </fieldset>

    <?php
        $i = 0;
        //TODO: DimensionVerb creates an exception case - rename model to Verb?
        $rulekey = (($formid == Rule::RULE_TYPE_VERB) ? 'DimensionVerb' : $rule_types[$formid]);
        foreach($this->request->data['Condition'] as $condition):
            $selected = Set::extract($condition[$rulekey], '{n}.id');
    ?>
    <fieldset>
    <?php
            echo '<legend>Label '.($i + 1);
            echo '<span class="help-inline"><small>';
            echo $this->html->link('Remove', '#', array('class' => 'remScnt'));
            echo '</small></span></legend>';
            echo $this->Form->input("Condition.$i.id", array( 'value' => $condition['id']));
            echo $this->Form->input("Condition.$i.name", array( 'value' => $condition['name']));
            echo $this->Form->input("Condition.$i.type", array( 'value' => $condition['type'] , 'type' => 'hidden'));
            echo $this->element('MultiSelectForms/rules', array('count' => $i));
            echo $this->Form->input("Condition.$i.customer_id", array( 'value' => $customer_id, 'type' => 'hidden'));
            if($formid == Rule::RULE_TYPE_ACTION) {
                echo $this->Form->input("Condition.$i.value", array( 'value' => $condition['value']));
            } else {
                echo $this->element('MultiSelectForms/conditionItems', array(
                    'count' => $i,
                    'rule_key' => $rulekey,
                    'selected' => $selected
                ));
            }
    ?>
    </fieldset>
    <?php
            $i++;
        endforeach;
	?>
    </div>
    <fieldset>
    <?php echo $this->Form->button('Add element', array('id' => 'addElement', 'type' =>'button'), 'primary'); ?>
    <?php echo $this->Form->end(); ?>
    </fieldset>
</div>
<?php echo $this->dynamicForms->addremoveHtmlElement('addElement', 'elementContainer', 'fieldset', $html, $i);