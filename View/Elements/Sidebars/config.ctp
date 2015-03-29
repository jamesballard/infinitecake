<?php $url = $this->request->here; ?>
<li class="title"><h4>Configuration</h4></li>
<li<?php echo (preg_match("/Members/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Members', array('controller' => 'Members', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Departments/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Departments', array('controller' => 'Departments', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Courses/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Courses', array('controller' => 'Courses', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/People/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('People', array('controller' => 'People', 'action' => 'index')); ?>
</li>
<li class="title"><h4>System Data</h4></li>
<li<?php echo (preg_match("/Systems/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Systems', array('controller' => 'Systems', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Artefacts/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Artefacts', array('admin' => false, 'plugin' => false, 'controller' => 'Artefacts', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Modules/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Modules', array('controller' => 'Modules', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Users/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Users', array('controller' => 'Users', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Groups/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Groups', array('controller' => 'Groups', 'action' => 'index')); ?>
</li>
