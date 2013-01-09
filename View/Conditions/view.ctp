<div class="conditions view">
<h2><?php  echo __('Condition'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['id']); ?>
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
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Condition'), array('action' => 'edit', $condition['Condition']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Condition'), array('action' => 'delete', $condition['Condition']['id']), null, __('Are you sure you want to delete # %s?', $condition['Condition']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Conditions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Condition'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Rules'), array('controller' => 'rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rule'), array('controller' => 'rules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Verbs'), array('controller' => 'dimension_verb', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Verbs'), array('controller' => 'dimension_verb', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Rules'); ?></h3>
	<?php if (!empty($condition['Rule'])): ?>
	<table class="table table-striped" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Customer'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($condition['Rule'] as $rule): ?>
		<tr>
			<td><?php echo $rule['id']; ?></td>
			<td><?php echo $rule['name']; ?></td>
			<td><?php echo $rule['value']; ?></td>
			<td><?php
                switch ($rule['type']) {
                    case Rule::RULE_TYPE_ACTION:
                        echo 'Action';
                        break;
                    case Rule::RULE_TYPE_ARTEFACT:
                        echo 'Artefact';
                        break;
                    case Rule::RULE_TYPE_DIMENSION_VERB:
                        echo 'Verb';
                        break;
                    case Rule::RULE_TYPE_MODULE:
                        echo 'Module';
                        break;
                }
                ?></td>
			<td><?php echo $rule['Customer']['name']; ?></td>
			<td><?php echo $rule['created']; ?></td>
			<td><?php echo $rule['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'rules', 'action' => 'view', $rule['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'rules', 'action' => 'edit', $rule['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'rules', 'action' => 'delete', $rule['id']), null, __('Are you sure you want to delete # %s?', $rule['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Rule'), array('controller' => 'rules', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Actions'); ?></h3>
	<?php if (!empty($condition['Action'])): ?>
	<table class="table table-striped" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Time'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Module Id'); ?></th>
		<th><?php echo __('Dimension Verb Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($condition['Action'] as $action): ?>
		<tr>
			<td><?php echo $action['id']; ?></td>
			<td><?php echo $action['name']; ?></td>
			<td><?php echo $action['time']; ?></td>
			<td><?php echo $action['user_id']; ?></td>
			<td><?php echo $action['group_id']; ?></td>
			<td><?php echo $action['module_id']; ?></td>
			<td><?php echo $action['dimension_verb_id']; ?></td>
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
	<h3><?php echo __('Related Verbs'); ?></h3>
	<?php if (!empty($condition['DimensionVerb'])): ?>
	<table class="table table-striped" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('System Name'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($condition['DimensionVerb'] as $dimensionVerb): ?>
		<tr>
			<td><?php echo $dimensionVerb['id']; ?></td>
			<td><?php echo $dimensionVerb['sysname']; ?></td>
			<td><?php echo $dimensionVerb['name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'dimension_verb', 'action' => 'view', $dimensionVerb['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'dimension_verb', 'action' => 'edit', $dimensionVerb['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'dimension_verb', 'action' => 'delete', $dimensionVerb['id']), null, __('Are you sure you want to delete # %s?', $dimensionVerb['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Dimension Verb Condition'), array('controller' => 'dimension_verb_conditions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
