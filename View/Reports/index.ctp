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
        <th><?php echo $this->Paginator->sort('name'); ?></th>
        <th><?php echo $this->Paginator->sort('visualisation'); ?></th>
        <?php echo $this->element('Misc/tableheaderCustomerAdmin'); ?>
	</tr>
	<?php foreach ($reports as $report): ?>
	<tr>
        <td><?php echo $this->element('Buttons/action', array(
                'id' => $report['Report']['id'],
                'name' => $report['Report']['name'],
                'customer_id' => h($report['Report']['customer_id']),
                'current_user' => $current_user,
                'delete' => true,
                'offset' => false
            ));
            ?></td>
		<td><?php echo $visualisation_types[h($report['Report']['visualisation'])]; ?>&nbsp;</td>
        <?php
        if($this->Permissions->is_admin($current_user)):
            echo '<td>'.$this->Html->link(h($rule['Customer']['name']), array('controller' => 'Customers', 'action' => 'view', $rule['Customer']['id'])).'</td>';
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
	?></p>
	<div class="pagination">
        <ul class="pager">
            <li><?php echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'btn btn-default prev disabled')); ?></li>
            <li><?php echo $this->Paginator->numbers(array('separator' => '')); ?></li>
            <li><?php echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'btn btn-default next disabled'));	?></li>
        </ul>
	</div>
</div>
