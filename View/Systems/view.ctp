<?php $this->layout = 'configManage'; ?>
<div class="systems view">
<h2><?php  echo __('System'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($system['System']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($system['System']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($system['System']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($system['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $system['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($system['System']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($system['System']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit System'), array('action' => 'edit', $system['System']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete System'), array('action' => 'delete', $system['System']['id']), null, __('Are you sure you want to delete # %s?', $system['System']['id'])); ?> </li>
	</ul>
</div>
