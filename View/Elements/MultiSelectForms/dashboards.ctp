<div class="form-group">
<?php
echo $this->Form->label('Dashboard', 'Dashboard(s)', array('class' => 'col-sm-2 control-label'));
echo '<div class="col-sm-5">';
echo $this->Chosen->select(
    'Dashboard',
    $dashboards,
    array(
        'data-placeholder' => "Select dashboard...",
        'multiple' => true,
        'class' => 'form-control',
        'deselect' => true
    )
);
?>
    </div>
</div>