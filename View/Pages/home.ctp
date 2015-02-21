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
echo $this->Html->script('zingchart-html5-min');
echo $this->Html->script('license');
?>
<div class="row">
    <div class="col-xs-12 col-sm-9 col-sm-push-3 col-md-9 col-lg-9">
        <div class="panel panel-default">
            <div class="panel-heading dblue">
                <?php if(!empty($actions)) : ?>
                <i class="fa fa-line-chart fa-fw"></i> Overall Activity
                <?php else : ?>
                <i class="fa fa-rocket fa-fw"></i> Get started
                <?php endif; ?>
            </div>
            <div class="panel-body overall-stats">
                <?php if(!empty($actions)) :
                    echo $this->zingCharts->start('chart1'); ?>
                <?php else : ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-bare">
                                <div class="panel-heading">
                                    <h4><i class="fa fa-fw fa-download"></i> Install</h4>
                                </div>
                                <div class="panel-body">
                                    <p>Install the report plugin for your system(s)</p>
                                    <p>Follow the instructions for each plugin on Github.</p>
                                    <a href="https://github.com/Tantalon/infinitemoodle" target="_blank" class="btn btn-default">Moodle</a> |
                                    <a href="https://github.com/Tantalon/infinitemahara" target="_blank" class="btn btn-default">Mahara</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-bare">
                                <div class="panel-heading">
                                    <h4><i class="fa fa-fw fa-pencil-square-o"></i> Configure</h4>
                                </div>
                                <div class="panel-body">
                                    <p>You'll need to add the following customer key to your module configuration so we know where to map your data.</p>
                                    <p class="alert alert-info"><?php echo $current_user['Customer']['CustomerKey']['accesskey']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-bare">
                                <div class="panel-heading">
                                    <h4><i class="fa fa-fw fa-thumbs-o-up"></i> Relax</h4>
                                </div>
                                <div class="panel-body">
                                    <p>The data export runs in the cron automagically. Once data arrives you'll get dashboards that keep themselves up-to-date.</p>
                                    <p>If you have a lot of data it may take a while to catch up - the count on the left will track your progress.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
                <p>Last update: <?php echo !empty($actions) ? $latest->format('d-M-Y H:i') : 'No data yet!'; ?></p>
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

<?php
if(!empty($actions)) :
$chart1 = new StdClass();
$chart1->id = 'chart1';
$chart1->url = '/Dashboards/overall_activity';
$chart1->width = '100%';
$chart1->height = '450';

$charts = array($chart1);
echo $this->zingCharts->configureJsonGraph($charts);
endif;
?>
