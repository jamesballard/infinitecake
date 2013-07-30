<?php $this->layout = 'configManage'; ?>
<div class="actionslist index">
	<h2><?php echo __('Actions'); ?></h2>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('time'); ?></th>
			<th><?php echo $this->Paginator->sort('system_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('module_id'); ?></th>
			<th><?php echo $this->Paginator->sort('dimension_verb_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($actions as $action): ?>
	<tr>
		<td><?php echo h($action['Action']['id']); ?>&nbsp;</td>
		<td><?php echo h($action['Action']['name']); ?>&nbsp;</td>
		<td><?php echo h($action['Action']['time']); ?>&nbsp;</td>
		<td><?php echo h($action['System']['name']); ?>&nbsp;</td>
		<td><?php echo h($action['User']['idnumber']); ?>&nbsp;</td>
		<td><?php echo h($action['Group']['idnumber']); ?>&nbsp;</td>
		<td><?php echo h($action['Module']['name']); ?>&nbsp;</td>
		<td><?php echo h($action['DimensionVerb']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $action['Action']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $action['Action']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $action['Action']['id']), null, __('Are you sure you want to delete # %s?', $action['Action']['id'])); ?>
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
