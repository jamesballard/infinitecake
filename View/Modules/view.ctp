<?php $this->layout = 'configManage'; ?>
<div class="modules view">
<h2><?php  echo __('Module'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($module['Module']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sysid'); ?></dt>
		<dd>
			<?php echo h($module['Module']['sysid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idnumber'); ?></dt>
		<dd>
			<?php echo h($module['Module']['idnumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($module['Module']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Artefact'); ?></dt>
		<dd>
			<?php echo $this->Html->link($module['Artefact']['name'], array('controller' => 'artefacts', 'action' => 'view', $module['Artefact']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($module['Group']['name'], array('controller' => 'groups', 'action' => 'view', $module['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System'); ?></dt>
		<dd>
			<?php echo $this->Html->link($module['System']['name'], array('controller' => 'systems', 'action' => 'view', $module['System']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Module'), array('action' => 'edit', $module['Module']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Module'), array('action' => 'delete', $module['Module']['id']), null, __('Are you sure you want to delete # %s?', $module['Module']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Modules'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Module'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Artefacts'), array('controller' => 'artefacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Artefact'), array('controller' => 'artefacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Systems'), array('controller' => 'systems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New System'), array('controller' => 'systems', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Conditions'), array('controller' => 'conditions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Condition'), array('controller' => 'conditions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Materials'), array('controller' => 'materials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Material'), array('controller' => 'materials', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Actions'); ?></h3>
	<?php if (!empty($module['Action'])): ?>
	<table class="table table-striped" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Time'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Module Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($module['Action'] as $action): ?>
		<tr>
			<td><?php echo $action['id']; ?></td>
			<td><?php echo $action['name']; ?></td>
			<td><?php echo $action['type']; ?></td>
			<td><?php echo $action['time']; ?></td>
			<td><?php echo $action['user_id']; ?></td>
			<td><?php echo $action['group_id']; ?></td>
			<td><?php echo $action['module_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'actions', 'action' => 'view', $action['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'actions', 'action' => 'edit', $action['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'actions', 'action' => 'delete', $action['id']), null, __('Are you sure you want to delete # %s?', $action['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Conditions'); ?></h3>
	<?php if (!empty($module['Condition'])): ?>
	<table class="table table-striped" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Sysid'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('Module Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($module['Condition'] as $condition): ?>
		<tr>
			<td><?php echo $condition['id']; ?></td>
			<td><?php echo $condition['sysid']; ?></td>
			<td><?php echo $condition['name']; ?></td>
			<td><?php echo $condition['value']; ?></td>
			<td><?php echo $condition['module_id']; ?></td>
			<td><?php echo $condition['group_id']; ?></td>
			<td><?php echo $condition['user_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'conditions', 'action' => 'view', $condition['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'conditions', 'action' => 'edit', $condition['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'conditions', 'action' => 'delete', $condition['id']), null, __('Are you sure you want to delete # %s?', $condition['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Condition'), array('controller' => 'conditions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Materials'); ?></h3>
	<?php if (!empty($module['Material'])): ?>
	<table class="table table-striped" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Sysid'); ?></th>
		<th><?php echo __('Idnumber'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Module Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($module['Material'] as $material): ?>
		<tr>
			<td><?php echo $material['id']; ?></td>
			<td><?php echo $material['sysid']; ?></td>
			<td><?php echo $material['idnumber']; ?></td>
			<td><?php echo $material['name']; ?></td>
			<td><?php echo $material['module_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'materials', 'action' => 'view', $material['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'materials', 'action' => 'edit', $material['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'materials', 'action' => 'delete', $material['id']), null, __('Are you sure you want to delete # %s?', $material['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Material'), array('controller' => 'materials', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
