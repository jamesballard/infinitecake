<?php $url = $this->request->here; ?>
<li>
  <?php echo $this->Html->link('Select User', array('controller' => $this->name, 'action' => 'index')); ?>
</li>
<li class="nav-header">Reports</li>
<li<?php echo (preg_match("/overview/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Overview', array('controller' => $this->name, 'action' => 'overview')); ?>
</li>
<li<?php echo (preg_match("/stream/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Activity Stream', array('controller' => $this->name, 'action' => 'stream')); ?>
</li>
<li<?php echo (preg_match("/hourly/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Around the Clock', array('controller' => $this->name, 'action' => 'hourly')); ?>
</li>
<li<?php echo (preg_match("/location/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Location', array('controller' => $this->name, 'action' => 'location')); ?>
</li>
<li<?php echo (preg_match("/modules/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Tools', array('controller' => $this->name, 'action' => 'modules')); ?>
</li>
<li<?php echo (preg_match("/tasktype/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Task Type', array('controller' => $this->name, 'action' => 'tasktype')); ?>
</li>
<li class="divider"></li> 