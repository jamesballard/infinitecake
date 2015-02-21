<div class="members index">
	<h2 class="pull-left"><?php echo __('Members'); ?></h2>
	<?php 
		echo $this->element('Buttons/add',array(
					'current_user' => $current_user,
					'add' => true
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('firstname'); ?></th>
			<th><?php echo $this->Paginator->sort('lastname'); ?></th>
			<th><?php echo $this->Paginator->sort('membership_id'); ?></th>
			<?php echo $this->element('Misc/tableheaderCustomerAdmin'); ?>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
	</tr>
	<?php
	foreach ($members as $member): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
				'id' => $member['Member']['id'],
				'name' => h($member['Member']['email']),
				'customer_id' => h($member['Member']['customer_id']),
				'current_user' => $current_user,
				'delete' => true,
				'offset' => false
			));
			?>&nbsp;</td>
		<td><?php echo h($member['Member']['firstname']); ?>&nbsp;</td>
		<td><?php echo h($member['Member']['lastname']); ?>&nbsp;</td>
		<td><?php echo h($member['Membership']['name']); ?></td>
		<?php
			if($this->Permissions->is_admin($current_user)):
				echo '<td>'.h($member['Customer']['name']).'</td>';
			endif;
		?>
		<td><?php echo h($member['Member']['created']); ?>&nbsp;</td>
		<td><?php echo h($member['Member']['modified']); ?>&nbsp;</td>
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
