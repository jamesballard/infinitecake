<div class="groups index">
	<h2 class="pull-left"><?php echo __('Groups'); ?></h2>
	<?php 
		echo $this->element('Buttons/add',array(
					'current_user' => $current_user,
					'add' => false
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
		<th><?php echo $this->Paginator->sort('sysid'); ?></th>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('type'); ?></th>
		<th><?php echo $this->Paginator->sort('system'); ?></th>
	</tr>
	<?php
	foreach ($groups as $group): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
				'id' => $group['Group']['id'],
				'name' => h($group['Group']['idnumber']),
				'customer_id' => h($group['System']['customer_id']),
				'current_user' => $current_user,
				'delete' => false,
				'offset' => false
			));
			?>&nbsp;</td>
		<td><?php echo h($group['Group']['sysid']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
		<td><?php echo $group_types[h($group['Group']['type'])]; ?>&nbsp;</td>
		<td><?php echo $this->Html->link($group['System']['name'], array('controller' => 'systems', 'action' => 'view', $group['System']['id'])); ?>&nbsp;</td>
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
