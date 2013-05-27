<h1>Users<i class="icon-question-sign"></i></h1>
<p>Users are created as part of the import routine and represent user accounts on the associated system. A user consists of a
    system identifier and an institutional idnumber. The system identifier maps the user to the original system (primary key) and
    ensures integrity when data is updated. The institutional idnumber is used to map a user across systems into a single
    <?php echo $this->Html->link('person', array('controller' => 'Person', 'action' => 'help')); ?>. If some some reason a person
    has two accounts on the same system then this is not a problem - just map them both to the same person in Infinite Rooms.</p>
<p>There should be no need to alter the user data unless the institutional identifier is missing from the original system.</p>