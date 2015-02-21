<?php $url = $this->request->here; ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $this->webroot ?>">
                <?php echo $this->Html->image('logo.png', array('alt' => '', 'border' => '0', 'width' => 60, 'height' => 60)); ?>
                <span class="brandname">infinite rooms</span>
            </a>
        </div>
        <?php if (!preg_match("/\/(members|Members)\/(login|forgotpwd|logout|reset)/", $url)) : ?>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dashboards <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link('Category', array('controller' => 'Dashboards', 'action' => 'category')); ?></li>
                        <li><?php echo $this->Html->link('Course', array('controller' => 'Dashboards', 'action' => 'course')); ?></li>
                        <li><?php echo $this->Html->link('User', array('controller' => 'Dashboards', 'action' => 'user')); ?></li>
                        <li><?php echo $this->Html->link('User Timeline', array('controller' => 'Dashboards', 'action' => 'usertimeline')); ?></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach($navreports as $id => $report) {
                            echo '<li>'.$this->Html->link($report, array(
                                    'controller' => 'Stats',
                                    'action' => 'report',
                                    $id)
                                ).'</li>';
                        }
                        ?>
                    </ul>
                </li>
                <?php if($current_user['Membership']['id'] < 3) : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customise <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link('Dashboards', array('controller' => 'Dashboards', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Reports', array('controller' => 'Reports', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Classifications', array('controller' => 'Rules', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Periods', array('controller' => 'Periods', 'action' => 'index')); ?></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configure <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link('Members', array('controller' => 'Members', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Departments', array('controller' => 'Departments', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Courses', array('controller' => 'Groups', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('People', array('controller' => 'People', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Systems', array('controller' => 'Systems', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Artefacts', array('controller' => 'Artefacts', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Modules', array('controller' => 'Modules', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Users', array('controller' => 'Users', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Groups', array('controller' => 'Groups', 'action' => 'index')); ?></li>

                    </ul>
                </li>
                <?php endif; ?>
                <?php if($current_user['Membership']['id'] == 1) : ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link('Customers', array('controller' => 'Customers', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Memberships', array('controller' => 'Memberships', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Verbs', array('controller' => 'DimensionVerbs', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Access', array('controller' => 'admin', 'action' => 'acl')); ?></li>
                    </ul>
                </li>
                <?php endif; ?>
                <li><a href="/support">Support</a></li>
                <!--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Guides <b class="caret"></b></a>
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
                -->
            </ul>
        </div><!-- /.navbar-collapse -->
        <?php endif; ?>
    </div><!-- /.container-fluid -->
</nav>