<?php
App::uses('AppHelper', 'View/Helper');
    /**
     * CakePHP helper that acts as a wrapper for Drastic Data Tree Maps.
     */
class RecursiveDepartmentsHelper  extends AppHelper {

    public $helpers = array('Html');

/**
 * Takes a threaded list department array and outputs a list with bootstrap classes.
 * Used to create hierarchy trees.
 *
 * @param array $array
 * @return html
 */

    public function RecursiveDepartments($array) {
        if (count($array)) {
            static $i = 1;
            echo "<a href=\"#collapse-$i\" class=\"pull-right\" data-toggle=\"collapse\" title=\"Collapse or Expand\"><i class=\"icon-fullscreen\">&nbsp;</i></a>";
            echo "<div id=\"collapse-$i\" class=\"in collapse\">";
            echo '<ul class="well well-small" style="list-style-type:none">';

            foreach ($array as $department) {
                $i++;
                $viewurl = $this->Html->link($department['Department']['name'], array('action'=>'view', $department['Department']['id'], 1),array('title'=>'View department details'));

                $upurl = $this->Html->link('<i class="icon-arrow-up"></i>', array('action'=>'moveup', $department['Department']['id'], 1),array('escape'=>false,'title'=>'Move Up the Tree'));
                $downurl = $this->Html->link('<i class="icon-arrow-down"></i>', array('action'=>'movedown', $department['Department']['id'], 1),array('escape'=>false,'title'=>'Move Down the Tree'));
                $editurl = $this->Html->link('<i class="icon-edit"></i>',array('action'=>'edit', $department['Department']['id']),array('escape'=>false,'title'=>'Edit department'));
                $removeurl = $this->Html->link('<i class="icon-minus-sign"></i>',array('action'=>'removeNode', $department['Department']['id']),array('escape'=>false,'title'=>'Remove the Node only from the Tree'));
                $deleteurl = $this->Html->link('<i class="icon-remove-sign"></i>',array('action'=>'delete', $department['Department']['id']),array('escape'=>false,'title'=>'Delete Node and children from the Tree'));


                echo '<li>'.$viewurl.'&nbsp;'.$upurl.$downurl.$editurl.$removeurl.$deleteurl;
                if ($n = count($department['children'])) {
                    $this->RecursiveDepartments($department['children'], $i);
                }
                echo "</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }
}