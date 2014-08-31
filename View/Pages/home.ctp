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
    <div class="col-lg-12">
        <h3>Hi, <?php echo $current_user['Member']['firstname']; ?>!</h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-paw fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo number_format($actions); ?></div>
                        <div>Actions</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo number_format($persons); ?></div>
                        <div>Users</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-graduation-cap fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo number_format($courses); ?></div>
                        <div>Courses</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">13</div>
                        <div>Support Tickets!</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading dblue">
                <i class="fa fa-line-chart fa-fw"></i> Overall Activity
            </div>
            <div class="panel-body">
                <p>Insert chart here</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading orange">
                <i class="fa fa-cubes fa-2x"></i> Using this site
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <i class="fa fa-cube fa-4x pull-left orange"></i>
                        <p><strong>Dashboards</strong><br />
                            Use dashboards to explore how student activity can help identify and promote effective teaching practices.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <i class="fa fa-cube fa-4x pull-left orange"></i>
                        <p><strong>Reports</strong><br />
                            Develop your own visualisations to see how student contributions can provide dynamic indications of success.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <i class="fa fa-cube fa-4x pull-left orange"></i>
                        <p><strong>Configuration</strong><br />
                            Create classifications of your data to understand the role that analytics can play in learning design, feedback and assessment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading lblue">
                <i class="fa fa-rocket fa-2x"></i> Get started
            </div>
            <div class="panel-body">
                <p>Coming soon...</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <h3>Hi, <?php echo $current_user['Member']['firstname']; ?>!</h3>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h3 class="dblue"><i class="fa fa-slack fa-2x"></i> Summary</h3>
            <dl class="dl-horizontal">
                <dt>Actions</dt>
                <dd><?php echo number_format($actions); ?></dd>
                <dt>Users</dt>
                <dd><?php echo number_format($persons); ?></dd>
                <dt>Courses</dt>
                <dd><?php echo number_format($courses); ?></dd>
            </dl>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <h3 class="lblue"><i class="fa fa-rocket fa-2x"></i> Get started</h3>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <h3 class="orange"><i class="fa fa-cubes fa-2x"></i> Using this site</h3>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <i class="fa fa-cube fa-4x pull-left orange"></i>
                    <p><strong>Dashboards</strong><br />
                    Use dashboards to explore how student activity can help identify and promote effective teaching practices.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <i class="fa fa-cube fa-4x pull-left orange"></i>
                    <p><strong>Reports</strong><br />
                    Develop your own visualisations to see how student contributions can provide dynamic indications of success.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <i class="fa fa-cube fa-4x pull-left orange"></i>
                    <p><strong>Configuration</strong><br />
                    Create classifications of your data to understand the role that analytics can play in learning design, feedback and assessment.</p>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>