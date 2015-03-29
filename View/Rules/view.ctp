<div class="rules view">
	<h2 class="pull-left"><?php echo __('Classification'); ?>:
	
	<?php echo $this->element('Buttons/action', array(
								'id' => $rule['Rule']['id'],
                                'name' => $rule['Rule']['name'],
								'customer_id' => h($rule['Rule']['customer_id']),
								'current_user' => $current_user,
								'delete' => true,
								'offset' => false
							)); 
	?>
    </h2>
    <div class="clearfix"></div>
        <dl class="dl-horizontal">
            <dt><?php echo __('Category'); ?></dt>
            <dd class="clearfix">
                <?php echo $rule_cats[$rule['Rule']['category']]; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Sub Category'); ?></dt>
            <dd class="clearfix">
                <?php echo $rule_subs[$rule['Rule']['subcategory']]; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Type'); ?></dt>
            <dd class="clearfix">
                <?php echo $rule_types[$rule['Rule']['type']]; ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Created'); ?></dt>
            <dd class="clearfix">
                <?php echo $this->Time->format('d/m/Y H:i', h($rule['Rule']['created'])); ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Modified'); ?></dt>
            <dd class="clearfix">
                <?php echo $this->Time->format('d/m/Y H:i', h($rule['Rule']['modified'])); ?>
                &nbsp;
            </dd>

            <?php if (!empty($rule['Condition'])): ?>
                <dt><?php echo __('Items'); ?></dt>
                <dd class="clearfix">
                    <div class="well">
                        <?php
                        $i = 1;
                        foreach ($rule['Condition'] as $condition): ?>
                            <a href="#" data-toggle="collapse" class="toggler active" data-target="#label<?php echo $i; ?>">
                                <i class="icon-minus"></i>
                                <i class="icon-plus"></i>
                                <?php echo $condition['name']; ?>
                            </a>

                            <div id="label<?php echo $i; ?>" class="collapse in">
                                <?php if (!empty($condition['Action'])): ?>
                                    <ul>
                                        <?php
                                        $i = 0;
                                        foreach ($condition['Action'] as $action): ?>
                                            <li><?php echo $action['name']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <?php if (!empty($condition['Artefact'])): ?>
                                    <ul>
                                        <?php
                                        foreach ($condition['Artefact'] as $artefact): ?>
                                            <li><?php echo $artefact['name']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <?php if (!empty($condition['Group'])): ?>
                                    <ul>
                                        <?php
                                        foreach ($condition['Group'] as $group): ?>
                                            <li><?php echo $group['name'].': '.$group['idnumber']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <?php if (!empty($condition['Module'])): ?>
                                    <ul>
                                        <?php
                                        foreach ($condition['Module'] as $module): ?>
                                            <li><?php echo $module['sysid']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <?php if (!empty($condition['DimensionVerb'])): ?>
                                    <ul>
                                        <?php
                                        foreach ($condition['DimensionVerb'] as $dimensionVerb): ?>
                                            <li><?php echo $dimensionVerb['Artefact']['name'].': '.$dimensionVerb['name']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>

                            <!--/.nav-collapse -->
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </div>
                </dd>
            <?php endif; ?>
        </dl>
</div>