<h1>User Dashboard<i class="icon-question-sign"></i></h1>
<p>For the user dashboard, one must first select a
    <?php echo $this->Html->link('person', array('controller' => 'People', 'action' => 'help')); ?> after which
    each visualisation represents the sum total of all actions for this person only.</p>
<?php echo $this->element('standardReportHelps'); ?>