<?php $url = $this->request->here; ?>
<li class="title"><h4>Customisation</h4></li>
<li<?php echo (preg_match("/Dashboards/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link(__('Dashboards'), array('controller' => 'Dashboards', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Reports/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link(__('Reports'), array('controller' => 'Reports', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Rules/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link(__('Classifications'), array('controller' => 'Rules', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Periods/", $url))? ' class="active"' : ''?>>
    <?php echo $this->Html->link(__('Periods'), array('controller' => 'Periods', 'action' => 'index')); ?>
</li>