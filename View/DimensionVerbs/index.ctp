<div class="dimensionVerbs index">
	<h2 class="pull-left"><?php echo __('Dimension Verbs'); ?></h2>
	<?php 
		echo $this->element('Buttons/add',array(
					'current_user' => $current_user,
					'add' => false
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('sysname'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('uri'); ?></th>
			<th><?php echo $this->Paginator->sort('artefact_id'); ?></th>
	</tr>
	<?php
	foreach ($dimensionVerbs as $dimensionVerb): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
                'id' => $dimensionVerb['DimensionVerb']['id'],
                'name' => h($dimensionVerb['DimensionVerb']['sysname']),
                'customer_id' => 1,
                'current_user' => $current_user,
                'delete' => false,
                'offset' => false
            ));
            ?></td>
		<td><?php echo h($dimensionVerb['DimensionVerb']['name']); ?>&nbsp;</td>
		<td><?php echo $verb_types[h($dimensionVerb['DimensionVerb']['type'])]; ?>&nbsp;</td>
		<td><?php echo h($dimensionVerb['DimensionVerb']['uri']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($dimensionVerb['Artefact']['name'], array('controller' => 'artefacts', 'action' => 'view', $dimensionVerb['Artefact']['id'])); ?>
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
