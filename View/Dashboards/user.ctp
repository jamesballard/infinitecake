<div class="row">
    <div class="col-md-2">
        <h3><?php echo __('User Dashboard'); ?></h3>
    </div>
    <div class="col-md-8 userSelect" >
        <?php
        echo $this->dynamicForms->autocomplete('DashboardUser','/People/jsonfeed');
        ?>
        <div class="ui-widget">
            <?php
            echo $this->Form->create('Dashboard', array('class' => 'form-inline'));

            echo $this->Form->input('userid', array('default' => $userid, 'type' => 'hidden'));
            echo $this->Form->input('user', array(
                'default' => $userdefault,
                'label' => array('class' => 'sr-only'),
                'between' => '',
                'after' => '',
            ));

            echo $this->Form->end(array(
                'style' => 'primary',
                'label' => 'Change',
                'before' => '',
                'after' => '',
            ));
        ?>
        </div>
    </div>
</div>

<?php if (!empty($userid)) :
    echo $this->Html->script('zingchart-html5-min');
    echo $this->Html->script('license');
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading orange">
                <i class="fa fa-cube fa-fw"></i> Weekly Activity
            </div>
            <div class="panel-body chart-height-2x">
                <?php
                echo $this->zingCharts->start('chart1');
                ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading orange">
                        <i class="fa fa-cube fa-fw"></i> User Dashboard: <?php echo $userdefault; ?>
                    </div>
                    <div class="panel-body">
                        <p>Data is summarised from the previous 3 months and represent a weekly count of activity to
                            explore regularity of access opportunities, a classification showing the variety of tasks,
                            and access time to identify when interactions or interventions might be scheduled.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading orange">
                        <i class="fa fa-cube fa-fw"></i> Task Types
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->zingCharts->start('chart2');
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading orange">
                        <i class="fa fa-cube fa-fw"></i> Time of Day
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->zingCharts->start('chart3');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
    $chart1 = new StdClass();
    $chart1->id = 'chart1';
    $chart1->url = '/Dashboards/userweekly/'.$userid;
    $chart1->width = '100%';
    $chart1->height = '600';

    $chart2 = new StdClass();
    $chart2->id = 'chart2';
    $chart2->url = '/Dashboards/usertypes/'.$userid;
    $chart2->width = '100%';
    $chart2->height = '300';

    $chart3 = new StdClass();
    $chart3->id = 'chart3';
    $chart3->url = '/Dashboards/usertime/'.$userid;
    $chart3->width = '100%';
    $chart3->height = '300';

    $charts = array(
        $chart1, $chart2, $chart3
    );
    echo $this->zingCharts->configureJsonGraph($charts);
endif;
?>