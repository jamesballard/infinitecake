<?php $url = $this->request->here; ?>

<li class="nav-header">User Guides</li>
<li<?php echo (preg_match("/getstarted/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Get Started', array('controller' => 'Guides', 'action' => 'getstarted')); ?>
</li>
<li<?php echo (preg_match("/analyse/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Analyse', array('controller' => 'Guides', 'action' => 'analyse')); ?>
</li>
<li<?php echo (preg_match("/develop/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Develop', array('controller' => 'Guides', 'action' => 'develop')); ?>
</li>
<li<?php echo (preg_match("/glossary/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Glossary', array('controller' => 'Guides', 'action' => 'glossary')); ?>
</li>
<li class="nav-header">Design Principles</li>
<li<?php echo (preg_match("/analytics/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Learning Analytics', array('controller' => 'Guides', 'action' => 'analytics')); ?>
</li>
<li<?php echo (preg_match("/theory/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Activity Theory', array('controller' => 'Guides', 'action' => 'theory')); ?>
</li>
<li<?php echo (preg_match("/engagement/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Engagement', array('controller' => 'Guides', 'action' => 'engagement')); ?>
</li>
<li<?php echo (preg_match("/questions/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Key Questions', array('controller' => 'Guides', 'action' => 'questions')); ?>
</li>
<li class="divider"></li> 