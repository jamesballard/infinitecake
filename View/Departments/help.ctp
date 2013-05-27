<h1>Departments<i class="icon-question-sign"></i></h1>
<p>Departments are a hierarchical structure that can be used to categorise
    <?php echo $this->Html->link('courses', array('controller' => 'Courses', 'action' => 'help')); ?> or
    <?php echo $this->Html->link('people', array('controller' => 'People', 'action' => 'help')); ?>. These then belong to
    parents of these as well. This is used to provide high level aggregation.</p>
<p>Departments can be configured manually or via an automated import script from a CSV file.</p>