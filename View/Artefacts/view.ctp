<div class="artefacts view">
<h2 class="pull-left"><?php  echo __('Artefact'); ?></h2>
	<?php echo $this->element('Buttons/action', array(
								'id' => $artefact['Artefact']['id'],
								'customer_id' => 1,
								'current_user' => $current_user,
								'delete' => false,
								'offset' => true
							)); 
	?>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($artefact['Artefact']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('System Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($artefact['Artefact']['sysname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($artefact['Artefact']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd class="clearfix">
			<?php echo $artefact_types[h($artefact['Artefact']['type'])]; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($artefact['Artefact']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($artefact['Artefact']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
