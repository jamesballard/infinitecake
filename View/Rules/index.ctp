<?php $this->layout = 'configManage'; ?>
<div class="rules index">
	<h2><?php echo __('Rules'); ?></h2>
	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Rule'), array('action' => 'add')); ?></li>
		</ul>
	</div>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('value'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($rules as $rule): ?>
	<tr>
		<td><?php echo h($rule['Rule']['id']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['name']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['value']); ?>&nbsp;</td>
        <td><?php echo h($rule['Rule']['type']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['created']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $rule['Rule']['id'])); ?>
			<?php 
				if(h($rule['Rule']['customer_id']) == $current_user['Member']['customer_id']):
					echo $this->Html->link(__('Edit'), array('action' => 'edit', $rule['Rule']['id'])); 
					echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $rule['Rule']['id']), null, __('Are you sure you want to delete # %s?', $rule['Rule']['id'])); 
				endif;
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
