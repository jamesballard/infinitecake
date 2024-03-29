<div class="rules index">
	<h2 class="pull-left"><?php echo __('Classifications'); ?></h2>
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
			<th><?php echo $this->Paginator->sort('category'); ?></th>
            <th><?php echo $this->Paginator->sort('subcategory'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<?php echo $this->element('Misc/tableheaderCustomerAdmin'); ?>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
	</tr>
	<?php
	foreach ($rules as $rule): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
				'id' => $rule['Rule']['id'],
				'name' => $rule['Rule']['name'],
				'customer_id' => h($rule['Rule']['customer_id']),
				'current_user' => $current_user,
				'delete' => true,
				'offset' => false
			));
			?>&nbsp;</td>
        <td><?php echo $rule_cats[h($rule['Rule']['category'])]; ?>&nbsp;</td>
        <td><?php echo $rule_subs[h($rule['Rule']['subcategory'])]; ?>&nbsp;</td>
        <td><?php echo $rule_types[h($rule['Rule']['type'])]; ?>&nbsp;</td>
        <?php
			if($this->Permissions->is_admin($current_user)):
                echo '<td>'.$this->Html->link(h($rule['Customer']['name']), array('controller' => 'Customers', 'action' => 'view', $rule['Customer']['id'])).'</td>';
			endif;
		?>
		<td><?php echo h($rule['Rule']['created']); ?>&nbsp;</td>
		<td><?php echo h($rule['Rule']['modified']); ?>&nbsp;</td>
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
