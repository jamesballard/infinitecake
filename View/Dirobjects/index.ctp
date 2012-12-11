<div class="dirobjects index">
	<h2><?php echo __('Dirobjects'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('artefact_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($dirobjects as $dirobject): ?>
	<tr>
		<td><?php echo h($dirobject['Dirobject']['id']); ?>&nbsp;</td>
		<td><?php echo h($dirobject['Dirobject']['idnumber']); ?>&nbsp;</td>
		<td><?php echo h($dirobject['Dirobject']['name']); ?>&nbsp;</td>
		<td><?php echo h($dirobject['Dirobject']['artefact_id']); ?>&nbsp;</td>
		<td><?php echo h($dirobject['Dirobject']['created']); ?>&nbsp;</td>
		<td><?php echo h($dirobject['Dirobject']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $dirobject['Dirobject']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $dirobject['Dirobject']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $dirobject['Dirobject']['id']), null, __('Are you sure you want to delete # %s?', $dirobject['Dirobject']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Dirobject'), array('action' => 'add')); ?></li>
	</ul>
</div>
