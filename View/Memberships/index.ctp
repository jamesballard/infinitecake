<div class="memberships index">
	<h2 class="pull-left"><?php echo __('Memberships'); ?></h2>
	<?php 
		echo $this->element('Buttons/add',array(
					'current_user' => $current_user,
					'add' => true
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
	</tr>
	<?php
	foreach ($memberships as $membership): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
                'id' => $membership['Membership']['id'],
                'name' => $membership['Membership']['name'],
                'customer_id' => 1,
                'current_user' => $current_user,
                'delete' => false,
                'offset' => false
            ));
            ?></td>
		<td><?php echo h($membership['Membership']['created']); ?>&nbsp;</td>
		<td><?php echo h($membership['Membership']['modified']); ?>&nbsp;</td>
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
