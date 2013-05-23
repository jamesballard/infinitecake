<div class="navbar">
    <div class="navbar-inner">
        <?php echo $this->Html->link('Infinite Rooms', array('controller' => 'pages', 'action' => 'display', 'home'), array('class' => 'brand')); ?>
        <ul class="nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Dashboards
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><?php echo $this->Html->link('Overall Statistics', '/Stats'); ?></li>
                    <li><?php echo $this->Html->link('Course Profile', '/CourseProfile'); ?></li>
                    <li><?php echo $this->Html->link('User Profile', '/UserProfile'); ?></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Configuration
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><?php echo $this->Html->link('Rules', array('controller' => 'Rules', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link('Conditions', array('controller' => 'Conditions', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link('Members', array('controller' => 'Members', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link('Departments', array('controller' => 'Departments', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link('Courses', array('controller' => 'Courses', 'action' => 'index')); ?></li>
                    <li><?php echo $this->Html->link('People', array('controller' => 'People', 'action' => 'index')); ?></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Guides
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><?php echo $this->Html->link('Get Started', array('controller' => 'Guides', 'action' => 'getstarted')); ?></li>
                    <li><?php echo $this->Html->link('Analyse', array('controller' => 'Guides', 'action' => 'analyse')); ?></li>
                    <li><?php echo $this->Html->link('Develop', array('controller' => 'Guides', 'action' => 'develop')); ?></li>
                    <li><?php echo $this->Html->link('Glossary', array('controller' => 'Guides', 'action' => 'glossary')); ?></li>
                    <li><?php echo $this->Html->link('Learning Analytics', array('controller' => 'Guides', 'action' => 'analytics')); ?></li>
                    <li><?php echo $this->Html->link('Activity Theory', array('controller' => 'Guides', 'action' => 'theory')); ?></li>
                    <li><?php echo $this->Html->link('Engagement', array('controller' => 'Guides', 'action' => 'engagement')); ?></li>
                    <li><?php echo $this->Html->link('Key Questions', array('controller' => 'Guides', 'action' => 'questions')); ?></li>
                </ul>
            </li>
        </ul>
    </div>
</div>