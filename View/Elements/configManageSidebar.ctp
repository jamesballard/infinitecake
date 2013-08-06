<?php $url = $this->request->here; ?>
<li class="nav-header">Status</li>
<li<?php echo (preg_match("/CustomerStatuses/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Data Status', array('controller' => 'CustomerStatuses', 'action' => 'index')); ?>
</li>
<li class="nav-header">Report Configuration</li>
<li<?php echo (preg_match("/Rules/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Rules', array('controller' => 'Rules', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Conditions/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Conditions', array('controller' => 'Conditions', 'action' => 'index')); ?>
</li>
<li class="nav-header">Institution Data</li>
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
<li class="nav-header">System Data</li>
<li<?php echo (preg_match("/Systems/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Systems', array('controller' => 'Systems', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Users/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Users', array('controller' => 'Users', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Groups/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Groups', array('controller' => 'Groups', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Modules/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Modules', array('controller' => 'Modules', 'action' => 'index')); ?>
</li>
<li class="divider"></li> 