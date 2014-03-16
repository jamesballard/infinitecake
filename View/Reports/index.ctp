<div class="reports index">
	<h2 class="pull-left"><?php echo __('Reports'); ?></h2>
    <?php
    echo $this->element('Buttons/add', array(
            'current_user' => $current_user,
            'add' => true
        )
    );
    ?>	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('visualisation'); ?></th>
            <?php echo $this->element('Misc/tableheaderCustomerAdmin'); ?>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($reports as $report): ?>
	<tr>
		<td><?php echo h($report['Report']['id']); ?>&nbsp;</td>
		<td><?php echo h($report['Report']['name']); ?>&nbsp;</td>
		<td><?php echo $visualisation_types[h($report['Report']['visualisation'])]; ?>&nbsp;</td>
        <?php
        if($this->Permissions->is_admin($current_user)):
            echo '<td>'.$this->Html->link(h($rule['Customer']['name']), array('controller' => 'Customers', 'action' => 'view', $rule['Customer']['id'])).'</td>';
        endif;
        ?>
		<td><?php echo h($report['Report']['created']); ?>&nbsp;</td>
		<td><?php echo h($report['Report']['modified']); ?>&nbsp;</td>
		<td>
<?php echo $this->element('Buttons/action', array(
                'id' => $report['Report']['id'],
                'customer_id' => h($report['Report']['customer_id']),
                'current_user' => $current_user,
                'delete' => false,
                'offset' => false
            ));
            ?>		</td>
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
