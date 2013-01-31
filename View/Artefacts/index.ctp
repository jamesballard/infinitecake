<?php $this->layout = 'configManage'; ?>
<div class="artefacts index">
	<h2 class="pull-left"><?php echo __('Artefacts'); ?></h2>
	<?php 
		echo $this->element('addButton',array(
					'current_user' => $current_user,
					'add' => false
				)
			); 
	?>
	<table class="table table-striped" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('idnumber'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($artefacts as $artefact): ?>
	<tr>
		<td><?php echo h($artefact['Artefact']['id']); ?>&nbsp;</td>
		<td><?php echo h($artefact['Artefact']['idnumber']); ?>&nbsp;</td>
		<td><?php echo h($artefact['Artefact']['name']); ?>&nbsp;</td>
		<td><?php echo $artefact_types[h($artefact['Artefact']['type'])]; ?>&nbsp;</td>
		<td><?php echo h($artefact['Artefact']['created']); ?>&nbsp;</td>
		<td><?php echo h($artefact['Artefact']['modified']); ?>&nbsp;</td>
		<td>
			<?php echo $this->element('actionButton', array(
								'id' => $artefact['Artefact']['id'],
								'customer_id' => 1,
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
