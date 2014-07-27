<div class="reports view">
<h2 class="pull-left"><?php  echo __('Report'); ?>:
<?php echo $this->element('Buttons/action', array(
        'id' => $report['Report']['id'],
        'name' => $report['Report']['name'],
        'customer_id' => 1,
        'current_user' => $current_user,
        'delete' => true,
        'offset' => false
    ));
    ?>
    </h2>
    <div class="clearfix">
        <dl class="dl-horizontal">
            <dt><?php echo __('Id'); ?></dt>
            <dd class="clearfix">
                <?php echo h($report['Report']['id']); ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Name'); ?></dt>
            <dd class="clearfix">
                <?php echo h($report['Report']['name']); ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Visualisation'); ?></dt>
            <dd class="clearfix">
                <?php echo h($report['Report']['visualisation']); ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Initial'); ?></dt>
            <dd class="clearfix">
                <?php echo h($report['Report']['initial']); ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Customer'); ?></dt>
            <dd class="clearfix">
                <?php echo $this->Html->link($report['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $report['Customer']['id'])); ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Created'); ?></dt>
            <dd class="clearfix">
                <?php echo h($report['Report']['created']); ?>
                &nbsp;
            </dd>
            <dt><?php echo __('Modified'); ?></dt>
            <dd class="clearfix">
                <?php echo h($report['Report']['modified']); ?>
                &nbsp;
            </dd>
            <?php if (!empty($report['Filter'])): ?>
                <dt><?php echo __('Related Filters'); ?></dt>
                <dd class="clearfix">
                    <ul>
                        <?php
                        foreach ($report['Filter'] as $filter): ?>
                            <li>
                                <?php echo $this->Html->link($filter['name'], array('controller' => 'filters', 'action' => 'view', $filter['id'])); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </dd>
            <?php endif; ?>

            <?php if (!empty($report['ReportDimension'])): ?>
                <dt><?php echo __('Related Report Dimensions'); ?></dt>
                <dd class="clearfix">
                    <ul>
                        <?php
                        foreach ($report['ReportDimension'] as $reportDimension): ?>
                            <li>
                                <?php echo $this->Html->link($reportDimension['id'], array('controller' => 'report_dimensions', 'action' => 'view', $reportDimension['id'])); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </dd>
            <?php endif; ?>

            <?php if (!empty($report['ReportValue'])): ?>
                <dt><?php echo __('Related Report Values'); ?></dt>
                <dd class="clearfix">
                    <ul>
                        <?php
                        foreach ($report['ReportValue'] as $reportValue): ?>
                            <li>
                                <?php echo $this->Html->link($reportValue['id'], array('controller' => 'report_values', 'action' => 'view', $reportValue['id'])); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </dd>
            <?php endif; ?>

        </dl>
    </div>
</div>
