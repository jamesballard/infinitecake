<?php

$this->start('sidebar');
echo $this->element('reportSidebar');
echo $this->element('helpSidebar');
$this->end();

?>
<table class="table table-striped" style="width:200px">
    <tr><th>ID</th><td><?php echo $user[0]['MdlUser']['idnumber'] ?></td></tr>
</table>
<p>In Development</p>