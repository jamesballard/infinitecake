<?php
$axis_url = $this->Html->url(array('controller' => 'Reports', 'action' => 'axis_options_ajax', 'ext' => 'json'));
$label_url = $this->Html->url(array('controller' => 'Reports', 'action' => 'label_options_ajax', 'ext' => 'json'));
$empty = count($filter_options) > 0 ? __('pleaseSelect') : array('0' => __('noOptionAvailable'));

$filterlistelement = '<div class="control-group controls-row">';
$filterlistelement .= $this->Form->input("Filter.' + i +'.type", array('type' => 'hidden', 'value' => Filter::FILTER_TYPE_VALUE));
$filterlistelement .= $this->Form->input("Filter.' + i +'.operator", array(
    'div' => false,
    'between' => '<div class="controls">',
    'after' => false,
    'class' => 'span2',
    'options' => $filter_operators,
    'label' => false,
    'default' => 'and'
));
$filterlistelement .= $this->Form->input("Filter.' + i +'.model", array(
    'label' => false,
    'between' => false,
    'div' => false,
    'after' => false,
    'class' => 'span2',
    'options' => array_combine(array_keys($filter_models), array_keys($filter_models)),
));
$filterlistelement .= $this->Form->input("Filter.' + i +'.comparison", array(
    'div' => false,
    'between' => false,
    'after' => false,
    'class' => 'span2',
    'options' => $filter_comparisons,
    'label' => false,
    'default' => 'is'
));
$filterlistelement .= $this->Form->input("Filter.' + i +'.value", array(
    'id' => 'filterOptions',
    'div' => false,
    'between' => false,
    'after' => '</div>',
    'class' => 'span3',
    //'options' => $filter_options, TODO: this needs to update based on model selected.
    'empty' => $empty,
    'label' => false,
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
            echo $this->Form->input('name');
            echo $this->element('MultiSelectForms/dashboards');
            echo $this->element('FormItems/hiddenCustomer_id');
            echo $this->Form->input('visualisation', array(
                'options' => $visualisation_types,
                'default' => Report::VISUALISATION_LINE
            ));
            echo $this->Form->input('startdate', array(
                'type' => 'text',
                'label' => 'Start date',
                'class' => 'datepicker',
                'placeholder' => 'dd/mm/yyyy (empty = earliest)'
            ));
            echo $this->Form->input('enddate', array(
                'type' => 'text',
                'label' => __('End date'),
                'class' => 'datepicker',
                'placeholder' => 'dd/mm/yyyy (empty = latest)'
            ));

            /*
             * Only count is supported for logs.
             echo $this->Form->input('yaxis', array(
                'options' => $visualisation_types,
                'label' => 'y-Axis',
                'default' => Report::VISUALISATION_LINE
            ));*/
            ?>
            <div class="control-group controls-row">
                <?php
                echo $this->Form->input('rankorder', array(
                    'div' => false,
                    'between' => '<div class="controls">',
                    'after' => false,
                    'class' => 'span2',
                    'options' => array('' => 'All', 'DESC' => 'Top', 'ASC' => 'Bottom'),
                    'default' => 'All'
                ));
                echo $this->Form->input('ranklimit', array(
                    'type' => 'number',
                    'div' => false,
                    'between' => false,
                    'after' => '</div>',
                    'class' => 'span3',
                    'label' => false,
                    'placeholder' => 'Number of results'
                ));
                ?>
            </div>
        </fieldset>
        <fieldset>
            <div class="control-group controls-row">
                <?php
                echo $this->Form->input('ReportDimension.0.type', array('type' => 'hidden',
                    'value' => Dimension::DIMENSION_TYPE_AXIS));
                echo $this->Form->input('ReportDimension.0.model', array(
                    'div' => false,
                    'rel' => $axis_url,
                    'id' => 'axis',
                    'between' => '<div class="controls">',
                    'after' => false,
                    'class' => 'span2',
                    'options' => $dimension_models,
                    'label' => 'x-Axis',
                    'default' => Dimension::DIMENSION_DATE
                ));
                echo $this->Form->input('ReportDimension.0.parameter', array(
                    'div' => false,
                    'id' => 'axisParams',
                    'between' => false,
                    'after' => '</div>',
                    'class' => 'span3',
                    'options' => $axis_parameters,
                    'label' => false,
                ));
                ?>
            </div>
            <div class="control-group controls-row">
                <?php
                echo $this->Form->input('ReportDimension.1.type', array('type' => 'hidden',
                    'value' => Dimension::DIMENSION_TYPE_LABEL));
                echo $this->Form->input('ReportDimension.1.model', array(
                    'div' => false,
                    'id' => 'labels',
                    'rel' => $label_url,
                    'between' => '<div class="controls">',
                    'after' => false,
                    'class' => 'span2',
                    'options' => $dimension_models,
                    'label' => 'Labels',
                    'default' => Dimension::DIMENSION_PERIOD
                ));
                echo $this->Form->input('ReportDimension.1.parameter', array(
                    'div' => false,
                    'id' => 'labelParams',
                    'between' => false,
                    'after' => '</div>',
                    'class' => 'span3',
                    'options' => $label_parameters,
                    'label' => false,
                ));
                ?>
            </div>
        </fieldset>
        <fieldset>
            <div class="control-group controls-row">
                <?php
                echo $this->Form->input('Filter.0.type', array('type' => 'hidden', 'value' => Filter::FILTER_TYPE_VALUE));
                echo $this->Form->input('Filter.0.model', array(
                    'label' => 'Filter',
                    'div' => false,
                    'between' => '<div class="controls">',
                    'after' => false,
                    'class' => 'span2',
                    'options' => array_combine(array_keys($filter_models), array_keys($filter_models)),
                ));
                echo $this->Form->input('Filter.0.comparison', array(
                    'div' => false,
                    'between' => false,
                    'after' => false,
                    'class' => 'span2',
                    'options' => $filter_comparisons,
                    'label' => false,
                    'default' => 'is'
                ));
                echo $this->Form->input('Filter.0.value', array(
                    'div' => false,
                    'between' => false,
                    'after' => '</div>',
                    'class' => 'span3',
                    //'options' => $filter_options, TODO: dynamic drop-down of filters from model.
                    'empty' => $empty,
                    'label' => false,
                ));
                ?>
            </div>
        </fieldset>
    </div>
    <fieldset>
        <?php echo $this->Form->button('Add filter', array('id' => 'addElement', 'type' =>'button'), 'primary'); ?>
        <?php echo $this->Form->end(); ?>
    </fieldset>
</div>
<?php
echo $this->dynamicForms->addremoveHtmlElement('addElement', 'elementContainer', 'fieldset', $filterlistelement, 1);
echo $this->dynamicForms->addSelectionDependency('axis', 'axisParams');
echo $this->dynamicForms->addSelectionDependency('labels', 'labelParams');
?>
