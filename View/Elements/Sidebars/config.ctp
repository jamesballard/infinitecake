<?php $url = $this->request->here; ?>
<li class="title">Status</li>
<li<?php echo (preg_match("/CustomerStatuses/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link('Data Status', array('controller' => 'CustomerStatuses', 'action' => 'index')); ?>
</li>
<li class="title">Report Configuration</li>
<li<?php echo (preg_match("/Reports/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link(__('Reports'), array('controller' => 'Reports', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Rules/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link(__('Classification'), array('controller' => 'Rules', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Periods/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link(__('Period'), array('controller' => 'Periods', 'action' => 'index')); ?>
</li>
<li class="title">Institution Data</li>
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
<li class="title">System Data</li>
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