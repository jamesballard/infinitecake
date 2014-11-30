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
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
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
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
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
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
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
<?php
    $chart1 = new StdClass();
    $chart1->id = 'chart1';
    $chart1->url = '/Dashboards/groups/'.$courseid;
    $chart1->width = '100%';
    $chart1->height = '600';
    $charts = array(
        $chart1
    );
echo $this->zingCharts->configureJsonGraph($charts);
endif;
?>