<div class="communities index">
	<h2><?php echo __('Communities'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($communities as $community): ?>
	<tr>
		<td><?php echo h($community['Community']['id']); ?>&nbsp;</td>
		<td><?php echo h($community['Community']['idnumber']); ?>&nbsp;</td>
		<td><?php echo h($community['Community']['name']); ?>&nbsp;</td>
		<td><?php echo h($community['Community']['type']); ?>&nbsp;</td>
		<td><?php echo h($community['Community']['customer_id']); ?>&nbsp;</td>
		<td><?php echo h($community['Community']['created']); ?>&nbsp;</td>
		<td><?php echo h($community['Community']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $community['Community']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $community['Community']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $community['Community']['id']), null, __('Are you sure you want to delete # %s?', $community['Community']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Community'), array('action' => 'add')); ?></li>
	</ul>
</div>
