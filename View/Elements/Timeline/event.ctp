<li class="timeline-event">
    <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
    <div class="timeline-panel">
        <div class="timeline-heading">
            <h4 class="timeline-title"><?php echo $action['Action']['name']; ?></h4>
            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo $action['Action']['time']; ?></small></p>
        </div>
        <div class="timeline-body">
            <p><?php echo $action['Artefact']['name']; ?>: <?php echo $action['Module']['name']; ?></p>
            <p><?php echo $action['Group']['name']; ?> (<?php echo $action['Group']['idnumber']; ?>)</p>
        </div>
    </div>
</li>