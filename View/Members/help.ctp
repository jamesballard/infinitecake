<h1>Members<i class="icon-question-sign"></i></h1>
<p>Members are accounts for people who you want to be able to view reports in Infinite Rooms and are distinct from
    <?php echo $this->Html->link('users', array('controller' => 'Users', 'action' => 'help')); ?> and
    <?php echo $this->Html->link('people', array('controller' => 'People', 'action' => 'help')); ?> who belong to the systems
    being analysed. If you want to allow another member of your team to access your report pages then you need to create them as
    a member.</p>
<h2>Memberships</h2>
<p>This defines what a person can do in the system.</p>
<table class="table table-striped pull-left" style="width: 500px" cellpadding="0" cellspacing="0">
    <tbody>
    <tr><th>Type</th><th>Description</th></tr>
    <tr>
        <td>Adminsitrator</td>
        <td>Can do anything on the site - currently reserved for Infinite Rooms employees only.</td>
    </tr>
    <tr>
        <td>Manager</td>
        <td>Can configure new reports and view the lists of courses, users, modules etc.</td>
    </tr>
    <tr>
        <td>User</td>
        <td>Can view the different dashboard reports only.</td>
    </tr>
    </tbody>
</table>