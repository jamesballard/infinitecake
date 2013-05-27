<h1>Rules<i class="icon-question-sign"></i></h1>
<p>A rule contains a set of <?php echo $this->Html->link('conditions', array('controller' => 'Conditions', 'action' => 'help')); ?>
that provide different insights into the activity taking place. There are different types of rules supported in the system to
allow for different perspectives and granularity of analysis. Once a rule is created the system will aggregate and update the reports
so that patterns of behaviour can be compared.</p>

<h2>Rule Types</h2>
<table class="table table-striped pull-left" style="width: 500px" cellpadding="0" cellspacing="0">
    <tbody>
    <tr><th>Type</th><th>Description</th></tr>
    <tr>
        <td>Action</td>
        <td>This is the smallest level of granularity and applies the conditions to each individual activity. This is usually
            indicative of system rules (such as IP address or time of activity)</td>
    </tr>
    <tr>
        <td>Artefact</td>
        <td>An artefact rule applies conditions to particular tools, such as a forum or blog, where one wishes to look at
            actions associated with different tool types or categories.</td>
    </tr>
    <tr>
        <td>Course</td>
        <td>A course rule applies conditions to a course as a specific group of learners. This is typically used to explore
            how different modes or levels of study might influence actions.</td>
    </tr>
    <tr>
        <td>Module</td>
        <td>The module is a particular instance of a tool, for example the forum tool may allow many instances of discussions
            to be created. This is typically beneficial to analyses looking at specific learning design techniques
            (this forum was different in design to this forum).</td>
    </tr>
    <tr>
        <td>Verb</td>
        <td>A verb rule applies conditions to particular tasks and allows some distinction between tasks such as reading and
            writing. For example reading a forum post may be a different learning task to posting a reply.</td>
    </tr>
    </tbody>
</table>