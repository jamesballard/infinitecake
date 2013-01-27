<?php $this->layout = 'configManage'; ?>
<div class="users index">
	<h2 class="pull-left"><?php echo __('Users'); ?></h2>
	<?php 
		echo $this->element('addButton',array(
					'current_user' => $current_user,
					'add' => false
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('sysid'); ?></th>
			<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('person_id'); ?></th>
			<th><?php echo $this->Paginator->sort('system_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['sysid']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['idnumber']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($user['Person']['idnumber'], array('controller' => 'people', 'action' => 'view', $user['Person']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($user['System']['name'], array('controller' => 'systems', 'action' => 'view', $user['System']['id'])); ?>
		</td>
		<td>
			<?php echo $this->element('actionButton', array(
								'id' => $user['User']['id'],
								'customer_id' => h($user['System']['customer_id']),
								'current_user' => $current_user,
								'delete' => false,
								'offset' => false
							)); 
			?>	
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
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?></li>
	</ul>
</div>
