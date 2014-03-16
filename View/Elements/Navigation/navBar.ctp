<div class="navbar">
    <div class="navbar-inner">
        <a href="/" class="brand">
            <svg width="40" height="40">
                <image xlink:href="/img/logo.svg" src="/img/logo.png" width="40" height="40" />
            </svg>
            <div class="logo-svg-alternate"></div>
            &nbsp;infinte rooms
        </a>
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
                    <li><?php echo $this->Html->link('Reports', array('controller' => 'Reports', 'action' => 'index')); ?></li>
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
                    <li><?php echo $this->Html->link('Key Questions', array('controller' => 'Guides', 'action' => 'questions')); ?></li>
                    <li><?php echo $this->Html->link('Learning Analytics', array('controller' => 'Guides', 'action' => 'analytics')); ?></li>
                    <li><?php echo $this->Html->link('Activity Theory', array('controller' => 'Guides', 'action' => 'theory')); ?></li>
                    <li><?php echo $this->Html->link('Engagement', array('controller' => 'Guides', 'action' => 'engagement')); ?></li>
                </ul>
            </li>
        </ul>
    </div>
</div>