<div class="conditions index">
	<h2><?php echo __('Conditions'); ?></h2>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('value'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($conditions as $condition): ?>
	<tr>
		<td><?php echo h($condition['Condition']['id']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['name']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['value']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $condition['Condition']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $condition['Condition']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $condition['Condition']['id']), null, __('Are you sure you want to delete # %s?', $condition['Condition']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Condition'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Rules'), array('controller' => 'rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rule'), array('controller' => 'rules', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actions'), array('controller' => 'actions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Action'), array('controller' => 'actions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dimension Verb Conditions'), array('controller' => 'dimension_verb_conditions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dimension Verb Condition'), array('controller' => 'dimension_verb_conditions', 'action' => 'add')); ?> </li>
	</ul>
</div>
