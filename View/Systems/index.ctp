<div class="systems index">
	<h2 class="pull-left"><?php echo __('Systems'); ?></h2>
	<?php 
		echo $this->element('Buttons/add',array(
					'current_user' => $current_user,
					'add' => false
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<?php echo $this->element('Misc/tableheaderCustomerAdmin'); ?>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($systems as $system): ?>
	<tr>
		<td><?php echo h($system['System']['id']); ?>&nbsp;</td>
		<td><?php echo $system_types[h($system['System']['type'])]; ?>&nbsp;</td>
		<td><?php echo h($system['System']['name']); ?>&nbsp;</td>
		<?php
			if($this->Permissions->is_admin($current_user)):
				echo '<td>'.h($system['Customer']['name']).'</td>';
			endif;
		?>
		<td><?php echo h($system['System']['created']); ?>&nbsp;</td>
		<td><?php echo h($system['System']['modified']); ?>&nbsp;</td>
		<td>
			<?php echo $this->element('Buttons/action', array(
								'id' => $system['System']['id'],
								'customer_id' => h($system['System']['customer_id']),
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
