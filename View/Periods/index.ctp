<div class="periods index">
	<h2 class="pull-left"><?php echo __('Periods'); ?></h2>
    <?php
    echo $this->element('Buttons/add',array(
            'current_user' => $current_user,
            'add' => false
        )
    );
    ?>	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('start'); ?></th>
			<th><?php echo $this->Paginator->sort('end'); ?></th>
			<th><?php echo $this->Paginator->sort('interval'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
	</tr>
	<?php foreach ($periods as $period): ?>
	<tr>
		<td><?php echo $this->element('Buttons/action', array(
                'id' => $period['Period']['id'],
                'name' => $period['Period']['name'],
                'customer_id' => h($period['Period']['customer_id']),
                'current_user' => $current_user,
                'delete' => true,
                'offset' => false
            ));
            ?>&nbsp;
        </td>
		<td><?php echo h($period['Period']['start']); ?>&nbsp;</td>
		<td><?php echo h($period['Period']['end']); ?>&nbsp;</td>
		<td><?php echo h($period['Period']['interval']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($period['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $period['Customer']['id'])); ?>
		</td>
		<td><?php echo h($period['Period']['created']); ?>&nbsp;</td>
		<td><?php echo h($period['Period']['modified']); ?>&nbsp;</td>
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
