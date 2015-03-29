<div class="dashboards index">
    <h2><?php echo __('Dashboards'); ?></h2>
    <?php echo $this->element('Misc/underConstruction'); ?>
</div>
<!--
<div class="dashboards index">
	<h2 class="pull-left"><?php echo __('Dashboards'); ?></h2>
    <?php
    echo $this->element('Buttons/add',array(
            'current_user' => $current_user,
            'add' => false
        )
    );
    ?>	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('layout'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($dashboards as $dashboard): ?>
	<tr>
		<td><?php echo h($dashboard['Dashboard']['id']); ?>&nbsp;</td>
		<td><?php echo h($dashboard['Dashboard']['name']); ?>&nbsp;</td>
		<td><?php echo h($dashboard['Dashboard']['layout']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($dashboard['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $dashboard['Customer']['id'])); ?>
		</td>
		<td><?php echo h($dashboard['Dashboard']['created']); ?>&nbsp;</td>
		<td><?php echo h($dashboard['Dashboard']['modified']); ?>&nbsp;</td>
		<td>
<?php echo $this->element('Buttons/action', array(
                'id' => $dashboard['Dashboard']['id'],
                'customer_id' => 1,
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
-->