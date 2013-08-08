<div class="conditions index">
	<h2 class="pull-left"><?php echo __('Conditions'); ?></h2>
	<div class="btn-group btn-offset">
	  <a class="btn" href="#"><i class="icon-plus-sign"></i> Add new</a>
	  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
	  <ul class="dropdown-menu">
	  	<li><?php echo $this->Html->link(__('Action'), array('action' => 'add', 1), array('escape' => FALSE)); ?></li>
	  	<li><?php echo $this->Html->link(__('Artefact'), array('action' => 'add', 4), array('escape' => FALSE)); ?></li>
	  	<li><?php echo $this->Html->link(__('Course'), array('action' => 'add', 5), array('escape' => FALSE)); ?></li>
	  	<li><?php echo $this->Html->link(__('Module'), array('action' => 'add', 3), array('escape' => FALSE)); ?></li>
	    <li><?php echo $this->Html->link(__('Verb'), array('action' => 'add', 2), array('escape' => FALSE)); ?></li>
	  </ul>
	</div>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<?php echo $this->element('Misc/tableheaderCustomerAdmin'); ?>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($conditions as $condition): ?>
	<tr>
		<td><?php echo h($condition['Condition']['id']); ?>&nbsp;</td>
		<td><?php echo h($condition['Condition']['name']); ?>&nbsp;</td>
		<?php
			if($this->Permissions->is_admin($current_user)):
				echo '<td>'.h($condition['Customer']['name']).'</td>';
			endif;
		?>
		<td>
			<?php echo $this->element('Buttons/action', array(
								'id' => $condition['Condition']['id'],
								'customer_id' => h($condition['Condition']['customer_id']),
								'current_user' => $current_user,
								'delete' => true,
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