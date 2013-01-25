<div class="dimensionVerbs index">
	<h2><?php echo __('Dimension Verbs'); ?></h2>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('sysname'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('uri'); ?></th>
			<th><?php echo $this->Paginator->sort('artefact_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($dimensionVerbs as $dimensionVerb): ?>
	<tr>
		<td><?php echo h($dimensionVerb['DimensionVerb']['id']); ?>&nbsp;</td>
		<td><?php echo h($dimensionVerb['DimensionVerb']['sysname']); ?>&nbsp;</td>
		<td><?php echo h($dimensionVerb['DimensionVerb']['name']); ?>&nbsp;</td>
		<td><?php echo h($dimensionVerb['DimensionVerb']['type']); ?>&nbsp;</td>
		<td><?php echo h($dimensionVerb['DimensionVerb']['uri']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($dimensionVerb['Artefact']['name'], array('controller' => 'artefacts', 'action' => 'view', $dimensionVerb['Artefact']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $dimensionVerb['DimensionVerb']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $dimensionVerb['DimensionVerb']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $dimensionVerb['DimensionVerb']['id']), null, __('Are you sure you want to delete # %s?', $dimensionVerb['DimensionVerb']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Dimension Verb'), array('action' => 'add')); ?></li>
	</ul>
</div>
