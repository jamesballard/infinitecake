<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Debugger', 'Utility');
?>
<div class="row">
    <div class="col-xs-12 col-sm-9 col-sm-push-3 col-md-9 col-lg-9">
        <div class="panel panel-default">
            <div class="panel-heading dblue">
                <i class="fa fa-line-chart fa-fw"></i> Overall Activity
            </div>
            <div class="panel-body overall-stats">
                <?php
                echo $this->Html->script('zingchart-html5-min');
                echo $this->Html->script('license');
                echo $this->zingCharts->start('chart1');
                echo $this->zingCharts->addDashboardChart($summary, '100%', '350');
                ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-3 col-sm-pull-9 col-md-3 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading orange">
                <i class="fa fa-cubes fa-fw"></i> Status
            </div>
            <div class="panel-body">
                <h3>Hi, <?php echo $current_user['Member']['firstname']; ?>!</h3>
                <p>Last update: <?php echo $latest->format('d-M-Y H:i'); ?></p>
                <div class="status-block panel-lightblue">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-paw fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo number_format($actions); ?></div>
                            <div>Actions</div>
                        </div>
                    </div>
                </div>
                <div class="status-block panel-orange">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo number_format($persons); ?></div>
                            <div>Users</div>
                        </div>
                    </div>
                </div>
                <div class="status-block panel-darkblue">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-graduation-cap fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo number_format($courses); ?></div>
                            <div>Courses</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading orange">
                <i class="fa fa-cubes fa-fw"></i> Using this site
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <i class="fa fa-cube fa-4x pull-left site-panel orange"></i>
                        <p><strong>Dashboards</strong><br />
                            Use dashboards to explore how student activity can help identify and promote effective teaching practices.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <i class="fa fa-cube fa-4x pull-left site-panel orange"></i>
                        <p><strong>Reports</strong><br />
                            Develop your own visualisations to see how student contributions can provide dynamic indications of success.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <i class="fa fa-cube fa-4x pull-left site-panel orange"></i>
                        <p><strong>Configuration</strong><br />
                            Create classifications of your data to understand the role that analytics can play in learning design, feedback and assessment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading lblue">
                <i class="fa fa-rocket fa-fw"></i> Get started
            </div>
            <div class="panel-body">
                <p>Coming soon...</p>
            </div>
        </div>
    </div>
</div>