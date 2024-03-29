<div class="modules index">
	<h2 class="pull-left"><?php echo __('Modules'); ?></h2>
	<?php 
		echo $this->element('Buttons/add',array(
					'current_user' => $current_user,
					'add' => false
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('name'); ?></th>
		<th><?php echo $this->Paginator->sort('sysid'); ?></th>
		<th><?php echo $this->Paginator->sort('artefact_id'); ?></th>
		<th><?php echo $this->Paginator->sort('group_id'); ?></th>
		<th><?php echo $this->Paginator->sort('system_id'); ?></th>
	</tr>
	<?php
	foreach ($modules as $module): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
				'id' => $module['Module']['id'],
				'name' => h($module['Module']['name']),
				'customer_id' => h($module['System']['customer_id']),
				'current_user' => $current_user,
				'delete' => false,
				'offset' => false
			));
			?>&nbsp;</td>
		<td><?php echo h($module['Module']['sysid']); ?>&nbsp;</td>
		<td><?php echo h($module['Artefact']['name']); ?></td>
		<td><?php echo $this->Html->link($module['Group']['idnumber'],
				array('controller' => 'groups', 'action' => 'view', $module['Group']['id'])); ?></td>
		<td><?php echo $this->Html->link($module['System']['name'],
				array('controller' => 'systems', 'action' => 'view', $module['System']['id'])); ?></td>
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