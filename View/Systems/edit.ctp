<div class="systems form">
<?php echo $this->Form->create('System'); ?>
	<fieldset>
		<legend><?php echo __('Edit System'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('type', array(
        'options' => array(System::SYSTEM_TYPE_MOODLE => 'Moodle',
                System::SYSTEM_TYPE_ULCCILP => 'ULCC ILP',
                System::SYSTEM_TYPE_MAHARA => 'Mahara')
        ));
		echo $this->Form->input('name');
        echo $this->Form->input('customer_id', array('type' => 'select', 'options' => $customers));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('System.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('System.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Systems'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Modules'), array('controller' => 'modules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Module'), array('controller' => 'modules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
