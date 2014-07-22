<?php
$axis_url = $this->Html->url(array('controller' => 'Reports', 'action' => 'axis_options_ajax', 'ext' => 'json'));
$label_url = $this->Html->url(array('controller' => 'Reports', 'action' => 'label_options_ajax', 'ext' => 'json'));
$empty = count($filter_options) > 0 ? __('pleaseSelect') : array('0' => __('noOptionAvailable'));

$filterlistelement = '<div class="form-group">';
$filterlistelement .= $this->Form->input("Filter.' + i +'.id");
$filterlistelement .= $this->Form->input("Filter.' + i +'.type", array('type' => 'hidden', 'value' => Filter::FILTER_TYPE_VALUE));
$filterlistelement .= $this->Form->input("Filter.' + i +'.operator", array(
    'label' => false,
    'div' => '',
    'between' => '<div class="col-sm-2">',
    'after' => '</div>',
    'class' => 'form-control',
    'options' => $filter_operators,
    'default' => 'and'
));
$filterlistelement .= $this->Form->input("Filter.' + i +'.model", array(
    'label' => false,
    'div' => '',
    'between' => '<div class="col-sm-2">',
    'after' => '</div>',
    'class' => 'form-control',
    'options' => array_combine(array_keys($filter_models), array_keys($filter_models)),
));
$filterlistelement .= $this->Form->input("Filter.' + i +'.comparison", array(
    'label' => false,
    'div' => '',
    'between' => '<div class="col-sm-2">',
    'after' => '</div>',
    'class' => 'form-control',
    'options' => $filter_comparisons,
    'default' => 'is'
));
$filterlistelement .= $this->Form->input("Filter.' + i +'.value", array(
    'label' => false,
    'div' => '',
    'between' => '<div class="col-sm-3">',
    'after' => '</div>',
    'class' => 'form-control',
    //'options' => $filter_options, // TODO: this needs to update based on model selected.
    'empty' => $empty,
));
$filterlistelement .= '</div>';

?>

<div class="reports form">
    <h2><?php echo __('Edit Report'); ?></h2>
<?php echo $this->Form->create('Report'); ?>
    <div id="elementContainer">
        <fieldset>
            <?php
            echo $this->element('FormItems/legendChangeSettings');
            echo $this->Form->input('id');
            echo $this->Form->input('name');
            echo $this->element('MultiSelectForms/systems');
            echo $this->element('FormItems/hiddenCustomer_id');
            // TODO: hard-coded to count actions - may be other approaches.
            echo $this->Form->input('ReportValue.0.id', array('type' => 'hidden'));
            echo $this->Form->input('ReportValue.0.value_id', array('value' => 1, 'type' => 'hidden'));
            echo $this->Form->input('ReportValue.0.parameter', array('value' => 1, 'type' => 'hidden'));
            echo $this->Form->input('visualisation', array(
                'options' => $visualisation_types,
                'default' => Report::VISUALISATION_LINE
            ));
            echo $this->Form->input('startdate', array(
                'type' => 'text',
                'label' => 'Start date',
                'class' => 'form-control datepicker',
                'placeholder' => 'dd/mm/yyyy (empty = earliest)'
            ));
            echo $this->Form->input('enddate', array(
                'type' => 'text',
                'label' => __('End date'),
                'class' => 'form-control datepicker',
                'placeholder' => 'dd/mm/yyyy (empty = latest)'
            ));
            echo $this->Form->input('datewindow', array(
                'options' => array(
                    NULL => 'All',
                    '-1 day' => '1 day',
                    '-3 days' => '3 days',
                    '-5 days' => '5 days',
                    '-1 week' => '1 week',
                    '-2 weeks' => '2 weeks',
                    '-3 weeks' => '3 weeks',
                    '-1 month' => '1 month',
                    '-3 months' => '3 months',
                    '-6 months' => '6 months',
                    '-1 year' => '1 year'
                ),
                'default' => NULL
            ));
            /*
             * Only count is supported for logs.
             echo $this->Form->input('yaxis', array(
                'options' => $visualisation_types,
                'label' => 'y-Axis',
                'default' => Report::VISUALISATION_LINE
            ));*/
        ?>
            <div class="form-group">
                <?php
                echo $this->Form->input('rankorder', array(
                    'div' => '',
                    'between' => '<div class="col-sm-2">',
                    'after' => '</div>',
                    'class' => 'form-control',
                    'options' => array('' => 'All', 'DESC' => 'Top', 'ASC' => 'Bottom'),
                    'default' => 'All'
                ));
                echo $this->Form->input('ranklimit', array(
                    'type' => 'number',
                    'div' => 'col-sm-3',
                    'between' => false,
                    'after' => '',
                    'class' => 'form-control',
                    'label' => false,
                    'placeholder' => 'Number of results'
                ));
                ?>
            </div>
        </fieldset>
        <fieldset>
            <div class="form-group">
                <?php
                echo $this->Form->input('ReportDimension.0.id');
                echo $this->Form->input('ReportDimension.0.type', array('type' => 'hidden',
                    'value' => Dimension::DIMENSION_TYPE_AXIS));
                echo $this->Form->input('ReportDimension.0.model', array(
                    'div' => '',
                    'rel' => $axis_url,
                    'id' => 'axis',
                    'between' => '<div class="col-sm-2">',
                    'after' => '</div>',
                    'class' => 'form-control',
                    'options' => $dimension_models,
                    'label' => 'x-Axis',
                    'default' => Dimension::DIMENSION_DATE
                ));
                echo $this->Form->input('ReportDimension.0.parameter', array(
                    'div' => '',
                    'id' => 'axisParams',
                    'between' => '<div class="col-sm-3">',
                    'after' => '</div>',
                    'class' => 'form-control',
                    'options' => $axis_parameters,
                    'label' => false,
                ));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('ReportDimension.1.id');
                echo $this->Form->input('ReportDimension.1.type', array('type' => 'hidden',
                    'value' => Dimension::DIMENSION_TYPE_LABEL));
                echo $this->Form->input('ReportDimension.1.model', array(
                    'div' => '',
                    'id' => 'labels',
                    'rel' => $label_url,
                    'between' => '<div class="col-sm-2">',
                    'after' => '</div>',
                    'class' => 'form-control',
                    'options' => $dimension_models,
                    'label' => 'Labels',
                    'default' => Dimension::DIMENSION_PERIOD
                ));
                echo $this->Form->input('ReportDimension.1.parameter', array(
                    'div' => '',
                    'id' => 'labelParams',
                    'between' => '<div class="col-sm-3">',
                    'after' => '</div>',
                    'class' => 'form-control',
                    'options' => $label_parameters,
                    'label' => false,
                ));
                ?>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo __('Filters'); ?></legend>
        </fieldset>
        <?php
        $i = 0;
        foreach($this->request->data['Filter'] as $filter):
        ?>
        <fieldset>
            <div class="form-group">
                <?php
                echo $this->Form->input("Filter.$i.id");
                echo $this->Form->input("Filter.$i.type", array('type' => 'hidden', 'value' => Filter::FILTER_TYPE_VALUE));
                if ($i > 0) {
                    echo $this->Form->input("Filter.$i.operator", array(
                        'label' => false,
                        'div' => '',
                        'between' => '<div class="col-sm-2">',
                        'after' => '</div>',
                        'class' => 'form-control',
                        'options' => $filter_operators,
                        'default' => 'and'
                    ));
                    echo $this->Form->input("Filter.$i.model", array(
                        'label' => false,
                        'between' => false,
                        'div' => '<div class="col-sm-2">',
                        'after' => '</div>',
                        'class' => 'form-control',
                        'options' => array_combine(array_keys($filter_models), array_keys($filter_models)),
                    ));
                } else {
                    echo $this->Form->input("Filter.$i.model", array(
                        'label' => false,
                        'div' => '',
                        'between' => '<div class="col-sm-2">',
                        'after' => '</div>',
                        'class' => 'form-control',
                        'options' => array_combine(array_keys($filter_models), array_keys($filter_models)),
                    ));
                }
                echo $this->Form->input("Filter.$i.comparison", array(
                    'label' => false,
                    'div' => '',
                    'between' => '<div class="col-sm-2">',
                    'after' => '</div>',
                    'class' => 'form-control',
                    'options' => $filter_comparisons,
                    'default' => 'is'
                ));
                echo $this->Form->input("Filter.$i.value", array(
                    'label' => false,
                    'div' => '',
                    'between' => '<div class="col-sm-3">',
                    'after' => '</div>',
                    'class' => 'form-control',
                    //'options' => $filter_options, TODO: dynamic drop-down of filters from model.
                    'empty' => $empty,
                ));
                echo '<span class="col-sm-2"><small>';
                echo $this->html->link('Remove', '#', array('class' => 'remScnt'));
                echo '</small></span></div>';
                ?>
            </div>
        </fieldset>
        <?php
            $i++;
        endforeach;
        ?>
    </div>
    <fieldset>
        <?php echo $this->Form->button('Add filter', array('id' => 'addElement', 'type' =>'button'), 'primary'); ?>
        <?php echo $this->Form->end(); ?>
    </fieldset>
</div>
<?php
echo $this->dynamicForms->addremoveHtmlElement('addElement', 'elementContainer', 'fieldset', $filterlistelement, $i);
echo $this->dynamicForms->addSelectionDependency('axis', 'axisParams');
echo $this->dynamicForms->addSelectionDependency('labels', 'labelParams');
?>
