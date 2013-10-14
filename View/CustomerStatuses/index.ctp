<div class="customer-status index">
    <h2><?php echo __('Data Updates'); ?></h2>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('type'); ?></th>
            <th><?php echo $this->Paginator->sort('time'); ?></th>
            <th><?php echo $this->Paginator->sort('rule_id'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php
        foreach ($statuses as $status): ?>
            <tr>
                <td><?php echo $process_types[h($status['CustomerStatus']['type'])]; ?>&nbsp;</td>
                <td><?php echo h($status['CustomerStatus']['time']); ?>&nbsp;</td>
                <td><?php echo h($status['Rule']['name']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->element('Buttons/process', array(
                        'type' => $status['CustomerStatus']['type'],
                        'rule_id' => $status['CustomerStatus']['rule_id'],
                        'customer_id' => h($status['CustomerStatus']['customer_id']),
                        'current_user' => $current_user,
                        'delete' => false,
                        'offset' => false
                    ));
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>