<h1>Courses<i class="icon-question-sign"></i></h1>
<p>Courses are simply a list of users, which in turn represents the more complex enrolment and assessment functions of the
    institution. Each course should contain one or more
    <?php echo $this->Html->link('people', array('controller' => 'People', 'action' => 'help')); ?> where the data totals will
    represent the sum of all individual totals. A course may also contain multiple
    <?php echo $this->Html->link('groups', array('controller' => 'Groups', 'action' => 'help')); ?> which represent system
    entities. For example a course may have several spaces on the corresponding VLE, e-portfolio and other systems
    being used.</p>
<p>Courses are therefore configured independently of any specific system via manual configuration or a CSV import. Each course
will automatically have a dashboard once at least one person is added to it.</p>