<?php if(empty($courses)) : ?>
    <h3><?php echo __('Category Dashboard'); ?></h3>
    <?php echo $this->element('Misc/waitingForData'); ?>
<?php else : ?>
<div class="row">
    <div class="col-md-3">
        <h3><?php echo __('Category Dashboard'); ?></h3>
    </div>
    <div class="col-md-8 userSelect" >
        <?php
        echo $this->dynamicForms->autocomplete('DashboardCategory','/GroupCategories/jsonfeed');
        ?>
        <div class="ui-widget">
            <?php
            echo $this->Form->create('Dashboard', array('class' => 'form-inline'));

            echo $this->Form->input('categoryid', array('default' => $categoryid, 'type' => 'hidden'));
            echo $this->Form->input('category', array(
                'default' => $categorydefault,
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

<?php if (!empty($categoryid)) :
    echo $this->Html->script('zingchart-html5-min');
    echo $this->Html->script('license');
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading orange">
                <i class="fa fa-cube fa-fw"></i> Course: <?php echo $categorydefault; ?>
            </div>
            <div class="panel-body">
                <p>Data is summarised from the previous 3 months showing classifications of task variety and module
                    usage to inform curriculum design strategies and a heat map to explore how different courses are
                    using learning design.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
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
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
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
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading orange">
                <i class="fa fa-cube fa-fw"></i> Task Type Heatmap
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
    $chart1->url = '/Dashboards/categories/'.$categoryid;
    $chart1->width = '100%';
    $chart1->height = '600';

    $chart2 = new StdClass();
    $chart2->id = 'chart2';
    $chart2->url = '/Dashboards/categorytypes/'.$categoryid;
    $chart2->width = '100%';
    $chart2->height = '400';

    $chart3 = new StdClass();
    $chart3->id = 'chart3';
    $chart3->url = '/Dashboards/categorymodules/'.$categoryid;
    $chart3->width = '100%';
    $chart3->height = '400';

    $charts = array(
        $chart1, $chart2, $chart3
    );
echo $this->zingCharts->configureJsonGraph($charts);
endif;

endif;
?>