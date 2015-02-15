<?php $url = $this->request->here;?>
<li class="nav-header"><h4>Administration</h4></li>
<li<?php echo (preg_match("/Customers/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Customers', array('admin' => false, 'plugin' => false, 'controller' => 'Customers', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/Memberships/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Memberships', array('admin' => false, 'plugin' => false, 'controller' => 'Memberships', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/DimensionVerbs/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Verbs', array('admin' => false, 'plugin' => false, 'controller' => 'DimensionVerbs', 'action' => 'index')); ?>
</li>
<li<?php echo (preg_match("/acl/", $url))? ' class="active"' : ''?>>
  <?php echo $this->Html->link('Access Control', array('admin' => true, 'controller' => 'acl', 'action' => 'index', 'full_base' => true,)); ?>
</li>