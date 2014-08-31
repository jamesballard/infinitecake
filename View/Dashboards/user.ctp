<div class="row">
    <div class="col-md-2">
        <h3><?php echo __('User Dashboard'); ?></h3>
    </div>
    <div class="col-md-8 userSelect" >
        <?php
        echo $this->dynamicForms->autocomplete('DashboardUser','/People/jsonfeed');
        ?>
        <div class="ui-widget">';
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
    <div class="col-md-7">
        <?php echo $this->zingCharts->start('graph1'); ?>
    </div>
    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->zingCharts->start('graph2'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->zingCharts->start('graph3'); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>