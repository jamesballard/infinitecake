<h1>Course Dashboard<i class="icon-question-sign"></i></h1>
<p>For the course dashboard, one must first select a
    <?php echo $this->Html->link('course', array('controller' => 'Courses', 'action' => 'help')); ?>
    which will then display a list of
    <?php echo $this->Html->link('people', array('controller' => 'People', 'action' => 'help')); ?> enrolled to this course
    and each one's total actions over the previous 4 weeks. Each visualisation represents the sum total of all actions
    for the people listed only.</p>
<?php echo $this->element('standardReportHelps'); ?>