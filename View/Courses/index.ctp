<div class="courses index">
    <h2 class="pull-left"><?php echo __('Courses'); ?></h2>
    <?php
    echo $this->element('addButton',array(
            'current_user' => $current_user,
            'add' => true
        )
    );
    ?>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('shortname'); ?></th>
			<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('department_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($courses as $course): ?>
	<tr>
		<td><?php echo h($course['Course']['id']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['name']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['shortname']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['idnumber']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['active']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($course['Department']['name'], array('controller' => 'departments', 'action' => 'view', $course['Department']['id'])); ?>
		</td>
        <td>
            <?php echo $this->element('actionButton', array(
                    'id' => $course['Course']['id'],
                    'customer_id' => h($course['Department']['customer_id']),
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
