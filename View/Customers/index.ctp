<div class="customers index">
	<h2 class="pull-left"><?php echo __('Customers'); ?></h2>
	<?php 
		echo $this->element('Buttons/add',array(
					'current_user' => $current_user,
					'add' => true
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<!--<th><?php echo $this->Paginator->sort('zip'); ?></th>
			<th><?php echo $this->Paginator->sort('lat'); ?></th>
			<th><?php echo $this->Paginator->sort('lon'); ?></th>-->
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
	</tr>
	<?php
	foreach ($customers as $customer): ?>
	<tr>
		<td><?php echo h($customer['Customer']['id']); ?>&nbsp;</td>
		<td><?php echo $this->element('Buttons/action', array(
                'id' => $customer['Customer']['id'],
                'name' => $customer['Customer']['name'],
                'customer_id' => h($customer['Customer']['id']),
                'current_user' => $current_user,
                'delete' => false,
                'offset' => false
            ));
            ?>
		<!--<td><?php echo h($customer['Customer']['zip']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['lat']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['lon']); ?>&nbsp;</td>-->
		<td><?php echo h($customer['Customer']['created']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['modified']); ?>&nbsp;</td>
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
