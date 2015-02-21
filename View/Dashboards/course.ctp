<?php if(empty($courses)) : ?>
    <h3><?php echo __('Course Dashboard'); ?></h3>
    <?php echo $this->element('Misc/waitingForData'); ?>
<?php else : ?>
<div class="row">
    <div class="col-md-3">
        <h3><?php echo __('Course Dashboard'); ?></h3>
    </div>
    <div class="col-md-8 userSelect" >
        <?php
        echo $this->dynamicForms->autocomplete('DashboardCourse','/Groups/jsonfeed');
        ?>
        <div class="ui-widget">
            <?php
            echo $this->Form->create('Dashboard', array('class' => 'form-inline'));

            echo $this->Form->input('courseid', array('default' => $courseid, 'type' => 'hidden'));
            echo $this->Form->input('course', array(
                'default' => $coursedefault,
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

<?php if (!empty($courseid)) :
    echo $this->Html->script('zingchart-html5-min');
    echo $this->Html->script('license');
?>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-5 col-lg-5">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading orange">
                        <i class="fa fa-cube fa-fw"></i> Course: <?php echo $coursedefault; ?>
                    </div>
                    <div class="panel-body">
                        <p>Data is summarised from the previous 3 months comparing total activity per learner
                            with a weekly summary drill-down, and showing classifications of task variety and
                            module usage to inform course design strategies.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading orange">
                        <i class="fa fa-cube fa-fw"></i> Activity Types
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->zingCharts->start('chart2');
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading orange">
                        <i class="fa fa-cube fa-fw"></i> Module Use
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
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading orange">
                <i class="fa fa-cube fa-fw"></i> User Activity
            </div>
            <div class="panel-body">
                <?php
                echo $this->zingCharts->start('chart1');
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    $chart1 = new StdClass();
    $chart1->id = 'chart1';
    $chart1->url = '/Dashboards/groups/'.$courseid;
    $chart1->width = '100%';
    $chart1->height = '800';

    $chart2 = new StdClass();
    $chart2->id = 'chart2';
    $chart2->url = '/Dashboards/coursetypes/'.$courseid;
    $chart2->width = '100%';
    $chart2->height = '400';

    $chart3 = new StdClass();
    $chart3->id = 'chart3';
    $chart3->url = '/Dashboards/coursemodules/'.$courseid;
    $chart3->width = '100%';
    $chart3->height = '400';

    $charts = array(
        $chart1, $chart2, $chart3
    );
echo $this->zingCharts->configureJsonGraph($charts);
endif;
endif;
?>