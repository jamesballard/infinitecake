<div class="form-group">
<?php
echo $this->Form->label($name,
    $label,
    array('class' => 'col-sm-2 control-label')
);

echo '<div class="col-sm-5">';

$options = array(0 => 'No', 1 => 'Yes');

echo $this->Chosen->select(
    $name,
    $options,
    array(
        'class' => 'form-control',
        'data-placeholder' => "Select...")
);
?>
    </div>
</div>