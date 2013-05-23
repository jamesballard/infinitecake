<div class="conditions view">
	<h2 class="pull-left"><?php  echo __('Condition'); ?></h2>
	
	<?php echo $this->element('actionButton', array(
								'id' => $condition['Condition']['id'],
								'customer_id' => h($condition['Condition']['customer_id']),
								'current_user' => $current_user,
								'delete' => true,
								'offset' => true
							)); 
	?>

	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($condition['Condition']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($condition['Condition']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd class="clearfix">
			<?php echo h($condition['Condition']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rule'); ?></dt>
		<dd class="clearfix">
			<?php 
				$rule_type = '&nbsp;';
				if (!empty($condition['Rule'])): 
					$i = 0;
					foreach ($condition['Rule'] as $rule):
						echo $this->Html->link($rule['name'].': '.$rule['value'], array('controller' => 'rules', 'action' => 'view', $rule['id'])); 
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
		<dd class="clearfix"><?php echo $rule_type; ?></dd>
	
		<?php if (!empty($condition['Action'])): ?>
		<dt><?php echo __('Associated Actions'); ?></dt>
		<dd class="clearfix">
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
		<dd class="clearfix">
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
		<dd class="clearfix">
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
		<dd class="clearfix">
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
		<dd class="clearfix">
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