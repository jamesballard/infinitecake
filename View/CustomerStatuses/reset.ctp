<div class="data-reset form">
<h2><?php echo __('Reset Data'); ?></h2>
<?php echo $this->Form->create('Reset'); ?>
    <fieldset>
        <?php
        echo $this->Form->input( 'type', array( 'value' => $type, 'type' => 'hidden' ) );
        echo $this->Form->input( 'rule_id', array( 'value' => $rule_id, 'type' => 'hidden' ) );
        ?>
    </fieldset>
    <p>Resetting data will delete all aggregated data counts for the selected process. This should be used when, for
        example, the elements in a report have been changed and you want to re-run the data. Resetting data will not delete
        the original actions on which reports are based and so be recovered if run accidentally.</p>
    <p>Are you sure you wish to continue?</p>
<?php
//  Extra test input field
    echo $this->Form->submit('Yes', array('class'=> 'btn btn-success', 'div'=>false, 'name'=>'submit'));
    echo $this->Form->submit('No', array('class'=>'btn btn-warning', 'div'=>false, 'name'=>'submit'));
    ?>
<?php echo $this->Form->end()?>
</div>