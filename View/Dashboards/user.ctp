<div class="row">
    <div class="col-md-2">
        <h3><?php echo __('User Dashboard'); ?></h3>
    </div>
    <div class="col-md-8 userSelect" >
        <?php
        echo $this->dynamicForms->autocomplete('DashboardUser','/People/jsonfeed');

        echo '<div class="ui-widget">';

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
        echo '</div>';
    echo '</div>';
echo '</div>';

echo '<div class="row">';
    echo '<div class="col-md-12">';

        if (!empty($userid)) {
            echo $this->Html->script('zingchart-html5-min');
            echo $this->Html->script('license');
            echo $this->zingCharts->addDashboardChart('userDashboard', $dashboards, '768px', '800px');
            echo $this->zingCharts->start('userDashboard');
        }
?>
    </div>
</div>