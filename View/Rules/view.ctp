<div class="rules view">
	<h2 class="pull-left"><?php  echo __('Rule'); ?></h2>
	
	<?php echo $this->element('Buttons/action', array(
								'id' => $rule['Rule']['id'],
								'customer_id' => h($rule['Rule']['customer_id']),
								'current_user' => $current_user,
								'delete' => true,
								'offset' => true
							)); 
	?>

	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd class="clearfix">
			<?php echo h($rule['Rule']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd class="clearfix">
			<?php echo h($rule['Rule']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd class="clearfix">
			<?php echo h($rule['Rule']['value']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Type'); ?></dt>
        <dd class="clearfix">
            <?php
                switch (h($rule['Rule']['type'])) {
                    case Rule::RULE_TYPE_ACTION:
                        echo $rule_types[Rule::RULE_TYPE_ACTION];
                        break;
                    case Rule::RULE_TYPE_ARTEFACT:
                        echo $rule_types[Rule::RULE_TYPE_ARTEFACT];
                        break;
                    case Rule::RULE_TYPE_VERB:
                        echo $rule_types[Rule::RULE_TYPE_VERB];
                        break;
                    case Rule::RULE_TYPE_MODULE:
                        echo $rule_types[Rule::RULE_TYPE_MODULE];
                        break;
                }
            ?>
            &nbsp;
        </dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd class="clearfix">
			<?php echo h($rule['Rule']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd class="clearfix">
			<?php echo h($rule['Rule']['modified']); ?>
			&nbsp;
		</dd>
		
		<?php if (!empty($rule['Condition'])): ?>
		<dt><?php echo __('Conditions'); ?></dt>
		<dd class="clearfix">
			<ul>
			<?php
				foreach ($rule['Condition'] as $condition): ?>
					<li><?php echo $this->Html->link($condition['name'], array('controller' => 'conditions', 'action' => 'view', $condition['id'])); ?></li>
			<?php endforeach; ?>
			</ul>
		</dd>
		<?php endif; ?>
	</dl>
</div>