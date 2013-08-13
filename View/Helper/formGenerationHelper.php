<?php
/**
 * Created by JetBrains PhpStorm.
 * User: James
 * Date: 09/08/13
 * Time: 18:16
 * To change this template use File | Settings | File Templates.
 */

class formGenerationHelper extends AppHelper {

    public $helpers = array('Html', 'Form', 'Chosen.Chosen');

    /**
     * Returns a html string for the condition items form for use with javascript updates
     *
     * @param array $rule_types the passed list of rule types
     * @param string $label the label for the form
     * @param array $conditionItems the passed list of condition items for the form
     * @return string html formatted form
     */

    public function generateConditionItemsForm($rule_types, $rule_type, $label, $conditionItems) {
        $o = '<div class="control-group">';
        $o .= $this->Form->label(
            "Condition.'+ i +'.".$rule_types[$rule_type],
            $label.'(s)',
            array('class' => 'control-label')
        );
        $o .= '<div class="controls">';
        $o .= $this->Chosen->select(
            "Condition.'+ i +'.".$rule_types[$rule_type],
            array_map("addslashes",$conditionItems),
            array(
                'data-placeholder' => "Select $label(s)...",
                'multiple' => true,
                'deselect' => true
            )
        );
        $o .= '</div>';
        $o .= '</div>';
        return $o;
    }

    /**
     * Returns a html string for the rule items form for use with javascript updates
     *
     * @param array $rules the passed list of rules for the form
     * @param integer $rule_id the current rule being created to add as default
     * @return string html formatted form
     */

    public function generateConditionRulesForm($rules, $rule_id) {
        $o = '<div class="control-group">';
        $o .= $this->Form->label("Condition.'+ i +'.Rule", 'Rule(s)', array('class' => 'control-label'));
        $o .= '<div class="controls">';
        $o .= $this->Chosen->select(
            "Condition.'+ i +'.Rule",
            array_map("addslashes",$rules),
            array(
                'data-placeholder' => "Select Rule(s)...",
                'multiple' => true,
                'deselect' => true,
                'default' => $rule_id
            )
        );
        $o .= '</div>';
        $o .= '</div>';
        return $o;
    }

}