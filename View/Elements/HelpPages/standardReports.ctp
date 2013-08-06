<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tbody>
    <tr><th>Report</th><th>Description</th></tr>
    <tr>
        <td>Overview</td>
        <td>The total sum of actions for the select parameters. Each action has a value of 1.</td>
    </tr>
    <tr>
        <td>Activity Stream</td>
        <td>A sequential list of actions in reverse chronological order. No value is placed on this.</td>
    </tr>
    <tr>
        <td>Around the Clock</td>
        <td>Analogue clock based visualisation to show the total sum of actions per hour of the day. Time is rounded down so
        the value for 11am will be the sum of actions between 11.00am and 11.59am.</td>
    </tr>
    <tr>
        <td>Location</td>
        <td>The total sum of actions based on the specific 'Access' rule for IP addresses. This currently only works for
            Moodle data.</td>
    </tr>
    <tr>
        <td>Modules</td>
        <td>The total sum of actions grouped per
            <?php echo $this->Html->link('artefact', array('controller' => 'Conditions', 'action' => 'help', 4)); ?> type.</td>
    </tr>
    <tr>
        <td>Rule Types</td>
        <td>Total actions summed based on custom rules/conditions configured within the system. Here you can switch to see
            different rules.</td>
    </tr>
    </tbody>
</table>