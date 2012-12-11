<div class="labours index">
	<h2><?php echo __('Labours'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('person_id'); ?></th>
			<th><?php echo $this->Paginator->sort('community_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($labours as $labour): ?>
	<tr>
		<td><?php echo h($labour['Labour']['id']); ?>&nbsp;</td>
		<td><?php echo h($labour['Labour']['idnumber']); ?>&nbsp;</td>
		<td><?php echo h($labour['Labour']['name']); ?>&nbsp;</td>
		<td><?php echo h($labour['Labour']['person_id']); ?>&nbsp;</td>
		<td><?php echo h($labour['Labour']['community_id']); ?>&nbsp;</td>
		<td><?php echo h($labour['Labour']['created']); ?>&nbsp;</td>
		<td><?php echo h($labour['Labour']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $labour['Labour']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $labour['Labour']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $labour['Labour']['id']), null, __('Are you sure you want to delete # %s?', $labour['Labour']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Labour'), array('action' => 'add')); ?></li>
	</ul>
</div>
