<?php $url = $this->request->here; ?>
<li class="nav-header">Administration</li>
<li<?php echo (preg_match("/Customers/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Customers', array('controller' => 'Customers', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Memberships/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Memberships', array('controller' => 'Memberships', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Artefacts/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Artefacts', array('controller' => 'Artefacts', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/DimensionVerbs/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Verbs', array('controller' => 'DimensionVerbs', 'action' => 'index')); ?>
</li>
<li class="divider"></li> 