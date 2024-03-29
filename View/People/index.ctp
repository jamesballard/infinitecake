<div class="people index">
	<h2 class="pull-left"><?php echo __('People'); ?></h2>
	<?php 
		echo $this->element('Buttons/add',array(
					'current_user' => $current_user,
					'add' => true
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('firstname'); ?></th>
			<th><?php echo $this->Paginator->sort('lastname'); ?></th>
			<?php echo $this->element('Misc/tableheaderCustomerAdmin'); ?>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
	</tr>
	<?php
	foreach ($people as $person): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
				'id' => $person['Person']['id'],
				'name' => h($person['Person']['idnumber']),
				'customer_id' => h($person['Person']['customer_id']),
				'current_user' => $current_user,
				'delete' => false,
				'offset' => false
			));
			?>&nbsp;</td>
		<td><?php echo h($person['Person']['firstname']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['lastname']); ?>&nbsp;</td>
		<?php
			if($this->Permissions->is_admin($current_user)):
				echo '<td>'.h($person['Customer']['name']).'</td>';
			endif;
		?>
		<td><?php echo h($person['Person']['created']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['modified']); ?>&nbsp;</td>
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
