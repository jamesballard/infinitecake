<div class="rules form">
<h2><?php echo __('Edit Rule'); ?></h2>
<?php echo $this->BootstrapForm->create('Rule'); ?>
    <?php
    $html = '<fieldset>';
    $html .= "<legend>Label '+ (i + 1) +'</legend>";
    $html .= $this->Form->input("Condition.' + i +'.name");
    $html .= $this->Form->input("Condition.' + i +'.type", array( 'value' => 1 , 'type' => 'hidden') );
    $html .= $this->formGeneration->generateConditionRulesForm($rules, $rule_id);
    $html .= $this->Form->input("Condition.' + i +'.customer_id", array( 'value' => $customer_id, 'type' => 'hidden'));
    if($formid != Rule::RULE_TYPE_ACTION) {
        $html .= $this->formGeneration->generateConditionItemsForm($rule_types, $formid, $label, $conditionItems);
    }
    $html .= '</fieldset>';
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
        foreach($this->request->data['Condition'] as $condition):
            $selected = Set::extract($condition[$rule_types[$formid]], '{n}.id');
    ?>
    <fieldset>
    <?php
            echo '<legend>Label '.($i + 1).'</legend>';
            echo $this->Form->input("Condition.$i.id", array( 'value' => $condition['id']));
            echo $this->Form->input("Condition.$i.name", array( 'value' => $condition['name']));
            echo $this->Form->input("Condition.$i.type", array( 'value' => $condition['type'] , 'type' => 'hidden'));
            echo $this->element('MultiSelectForms/rules', array('count' => $i));
            echo $this->Form->input("Condition.$i.customer_id", array( 'value' => $customer_id, 'type' => 'hidden'));
            if($formid != Rule::RULE_TYPE_ACTION) {
                echo $this->element('MultiSelectForms/conditionItems', array(
                    'count' => $i,
                    'rule_type' => $formid,
                    'selected' => $selected
                ));
            }
            $i++;
    ?>
    </fieldset>
    <?php
        endforeach;
	?>
    </div>
    <?php echo $this->BootstrapForm->button('Add Element', array('id' => 'addElement', 'type' =>'button'), 'primary'); ?>
    <?php echo $this->BootstrapForm->end('',array(),'success'); ?>
</div>
<?php echo $this->dynamicForms->addremoveHtmlElement('addElement', 'elementContainer', $html, $i);