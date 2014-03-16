<div class="control-group">
<?php
echo $this->Form->label('Dashboard', 'Dashboard(s)', array('class' => 'control-label'));
echo '<div class="controls">';
echo $this->Chosen->select(
    'Dashboard',
    $dashboards,
    array(
        'data-placeholder' => "Select dashboard...",
        'multiple' => true,
        'deselect' => true
    )
);
?>
    </div>
</div>