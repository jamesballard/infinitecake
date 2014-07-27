<div class="courses index">
    <h2 class="pull-left"><?php echo __('Courses'); ?></h2>
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
			<th><?php echo $this->Paginator->sort('shortname'); ?></th>
			<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('department_id'); ?></th>
            <?php echo $this->element('Misc/tableheaderCustomerAdmin'); ?>
	</tr>
	<?php
	foreach ($courses as $course): ?>
	<tr>
        <td><?php echo $this->element('Buttons/action', array(
                'id' => $course['Course']['id'],
                'name' => $course['Course']['name'],
                'customer_id' => h($course['Customer']['id']),
                'current_user' => $current_user,
                'delete' => false,
                'offset' => false
            ));
            ?></td>
		<td><?php echo h($course['Course']['shortname']); ?>&nbsp;</td>
		<td><?php echo h($course['Course']['idnumber']); ?>&nbsp;</td>
		<td><?php echo empty($course['Course']['active']) ? 'No' : 'Yes'; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($course['Department']['name'], array('controller' => 'departments', 'action' => 'view', $course['Department']['id'])); ?>
		</td>
        <?php
        if($this->Permissions->is_admin($current_user)):
            echo '<td>'.$this->Html->link(h($course['Customer']['name']), array('controller' => 'Customers', 'action' => 'view', $course['Customer']['id'])).'</td>';
        endif;
        ?>
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
