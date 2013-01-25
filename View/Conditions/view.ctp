<?php $this->layout = 'configManage'; ?>
<h2><?php  echo __('Condition'); ?></h2>
<?php
	if($condition['Condition']['customer_id'] == $current_user['Member']['customer_id']):
?>					
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Condition'), array('action' => 'edit', $condition['Condition']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Condition'), array('action' => 'delete', $condition['Condition']['id']), null, __('Are you sure you want to delete # %s?', $condition['Condition']['id'])); ?> </li>
	</ul>
</div>
<?php endif; ?>
<div class="conditions view">
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($condition['Condition']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rule'); ?></dt>
		<dd>
			<?php 
				$rule_type = '&nbsp;';
				if (!empty($condition['Rule'])): 
					$i = 0;
					foreach ($condition['Rule'] as $rule):
						echo $rule['name'].': '.$rule['value']; 
						switch ($rule['type']) {
		                    case Rule::RULE_TYPE_ACTION:
		                        $rule_type = $rule_types[Rule::RULE_TYPE_ACTION];
		                        break;
		                    case Rule::RULE_TYPE_ARTEFACT:
		                        $rule_type = $rule_types[Rule::RULE_TYPE_ARTEFACT];
		                        break;
		                    case Rule::RULE_TYPE_GROUP:
		                        $rule_type = $rule_types[Rule::RULE_TYPE_GROUP];
		                        break;
		                    case Rule::RULE_TYPE_VERB:
		                        $rule_type = $rule_types[Rule::RULE_TYPE_VERB];
		                        break;
		                    case Rule::RULE_TYPE_MODULE:
		                        $rule_type = $rule_types[Rule::RULE_TYPE_MODULE];
		                        break;
		                }
		        	endforeach;
				endif;	
			?>	
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd><?php echo $rule_type; ?></dd>
	
		<?php if (!empty($condition['Action'])): ?>
		<dt><?php echo __('Associated Actions'); ?></dt>
		<dd>
			<ul>
			<?php
				$i = 0;
				foreach ($condition['Action'] as $action): ?>
					<li><?php echo $action['name']; ?></li>
			<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>
		
		<?php if (!empty($condition['Artefact'])): ?>
		<dt><?php echo __('Associated Artefacts'); ?></dt>
		<dd>
			<ul>
			<?php
				$i = 0;
				foreach ($condition['Artefact'] as $artefact): ?>
					<li><?php echo $artefact['name']; ?></li>
			<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>
		
		<?php if (!empty($condition['Group'])): ?>
		<dt><?php echo __('Associated Groups'); ?></dt>
		<dd>
			<ul>
			<?php
				$i = 0;
				foreach ($condition['Group'] as $group): ?>
					<li><?php echo $group['name'].': '.$group['idnumber']; ?></li>
			<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>
		
		<?php if (!empty($condition['Module'])): ?>
		<dt><?php echo __('Associated Modules'); ?></dt>
		<dd>
			<ul>
			<?php
				$i = 0;
				foreach ($condition['Module'] as $module): ?>
					<li><?php echo $module['sysid']; ?></li>
			<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>
		
		<?php if (!empty($condition['DimensionVerb'])): ?>
		<dt><?php echo __('Associated Verbs'); ?></dt>
		<dd>
			<ul>
			<?php
				$i = 0;
				foreach ($condition['DimensionVerb'] as $dimensionVerb): ?>
					<li><?php echo $dimensionVerb['Artefact']['name'].': '.$dimensionVerb['name']; ?></li>
			<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>

	</dl>
</div>