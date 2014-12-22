<div class="users index">
	<h2 class="pull-left"><?php echo __('Users'); ?></h2>
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
		<th><?php echo $this->Paginator->sort('person_id'); ?></th>
		<th><?php echo $this->Paginator->sort('system_id'); ?></th>
	</tr>
	<?php
	foreach ($users as $user): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
				'id' => $user['User']['id'],
				'name' => h($user['User']['idnumber']),
				'customer_id' => h($user['System']['customer_id']),
				'current_user' => $current_user,
				'delete' => false,
				'offset' => false
			));
			?>	&nbsp;</td>
		<td><?php echo h($user['User']['sysid']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($user['Person']['idnumber'], array('controller' => 'people', 'action' => 'view', $user['Person']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($user['System']['name'], array('controller' => 'systems', 'action' => 'view', $user['System']['id'])); ?>
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
