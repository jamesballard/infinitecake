<div class="dimensionVerbs view">
<h2><?php  echo __('Dimension Verb'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sysname'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['sysname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uri'); ?></dt>
		<dd>
			<?php echo h($dimensionVerb['DimensionVerb']['uri']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Artefact'); ?></dt>
		<dd>
			<?php echo $this->Html->link($dimensionVerb['Artefact']['name'], array('controller' => 'artefacts', 'action' => 'view', $dimensionVerb['Artefact']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dimension Verb'), array('action' => 'edit', $dimensionVerb['DimensionVerb']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dimension Verb'), array('action' => 'delete', $dimensionVerb['DimensionVerb']['id']), null, __('Are you sure you want to delete # %s?', $dimensionVerb['DimensionVerb']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dimension Verbs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dimension Verb'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Artefacts'), array('controller' => 'artefacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Artefact'), array('controller' => 'artefacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fact User Actions Dates'), array('controller' => 'fact_user_actions_dates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fact User Actions Date'), array('controller' => 'fact_user_actions_dates', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Actions'); ?></h3>
	<?php if (!empty($dimensionVerb['Action'])): ?>
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
		foreach ($dimensionVerb['Action'] as $action): ?>
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
	<h3><?php echo __('Related Fact User Actions Dates'); ?></h3>
	<?php if (!empty($dimensionVerb['FactUserActionsDate'])): ?>
	<table class="table table-striped" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Artefact Id'); ?></th>
		<th><?php echo __('Dimension Verb Id'); ?></th>
		<th><?php echo __('Dimension Date Id'); ?></th>
		<th><?php echo __('Total'); ?></th>
		<th><?php echo __('Production'); ?></th>
		<th><?php echo __('Consumption'); ?></th>
		<th><?php echo __('Exchange'); ?></th>
		<th><?php echo __('Distribution'); ?></th>
		<th><?php echo __('Operation'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($dimensionVerb['FactUserActionsDate'] as $factUserActionsDate): ?>
		<tr>
			<td><?php echo $factUserActionsDate['user_id']; ?></td>
			<td><?php echo $factUserActionsDate['artefact_id']; ?></td>
			<td><?php echo $factUserActionsDate['dimension_verb_id']; ?></td>
			<td><?php echo $factUserActionsDate['dimension_date_id']; ?></td>
			<td><?php echo $factUserActionsDate['total']; ?></td>
			<td><?php echo $factUserActionsDate['production']; ?></td>
			<td><?php echo $factUserActionsDate['consumption']; ?></td>
			<td><?php echo $factUserActionsDate['exchange']; ?></td>
			<td><?php echo $factUserActionsDate['distribution']; ?></td>
			<td><?php echo $factUserActionsDate['operation']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'fact_user_actions_dates', 'action' => 'view', $factUserActionsDate['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'fact_user_actions_dates', 'action' => 'edit', $factUserActionsDate['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'fact_user_actions_dates', 'action' => 'delete', $factUserActionsDate['id']), null, __('Are you sure you want to delete # %s?', $factUserActionsDate['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Fact User Actions Date'), array('controller' => 'fact_user_actions_dates', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
