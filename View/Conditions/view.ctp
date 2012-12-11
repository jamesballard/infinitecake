<div class="conditions view">
<h2><?php  echo __('Condition'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sysid'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['sysid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Module Id'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['module_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Id'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['group_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['user_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Condition'), array('action' => 'edit', $condition['Condition']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Condition'), array('action' => 'delete', $condition['Condition']['id']), null, __('Are you sure you want to delete # %s?', $condition['Condition']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Conditions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Condition'), array('action' => 'add')); ?> </li>
	</ul>
</div>
