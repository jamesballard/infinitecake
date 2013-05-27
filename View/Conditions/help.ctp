<h1>Conditions<i class="icon-question-sign"></i></h1>
<p>Conditions are used to create <?php echo $this->Html->link('rules', array('controller' => 'Rules', 'action' => 'help')); ?> and
    define the aggregation model for analysis. This is based on a categorisation process where one or more items are grouped
    together as a condition. Use the links below to display a list of possible items for each rule type.</p>
<ul>
    <li><?php echo $this->Html->link(__('Action'), array('action' => 'help', 1), array('escape' => FALSE)); ?></li>
    <li><?php echo $this->Html->link(__('Artefact'), array('action' => 'help', 4), array('escape' => FALSE)); ?></li>
    <li><?php echo $this->Html->link(__('Course'), array('action' => 'help', 5), array('escape' => FALSE)); ?></li>
    <li><?php echo $this->Html->link(__('Module'), array('action' => 'help', 3), array('escape' => FALSE)); ?></li>
    <li><?php echo $this->Html->link(__('Verb'), array('action' => 'help', 2), array('escape' => FALSE)); ?></li>
</ul>
<?php
if($label) {
    echo '<h2>'.$label.' list</h2>';
}
if($conditionItems) {
    foreach($conditionItems as $id=>$item) {
        echo $this->Html->link($item, array('action' => 'view', $id));
        echo '<br />';
    }
}