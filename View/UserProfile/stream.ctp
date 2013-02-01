<?php

$this->start('sidebar');
echo $this->element('reportSidebar');
echo $this->element('helpSidebar');
$this->end();

?>
<h2>Activity Stream for <?php echo $userid; ?></h2>
<?php 
	echo '<div style="width:400px">';
	echo $this->Form->create();
	echo $this->element('streamDateWindowSelect'); 
	echo $this->element('systemMultiSelect');
	echo $this->Form->end('Change');
	echo '</div>';
?>
<ul id="activity_stream_example" class="activity-stream">
<?php foreach($actions as $action) { ?> 
  <li class="activity scroll" data-activity-id="50f22dbf7421a" style="">
    <div class="stream-item-content">
      <div class="image">
        <?php echo $this->html->image('stream.png'); ?>
      </div>
      <div class="content">
        <div class="activity-row">
          <div class="text">
            <?php
             	//Construct the action sentence.
             	 
            	//1. Verb (past tense) from language strings.
            	echo __($action['DimensionVerb']['sysname'].'_past').' ';
            	
            	//2. Artefact Type 
            	echo 'a '.$action['DimensionVerb']['Artefact']['name'].' ';
            	
            	//3. Group ID number
            	echo 'in '.$action['Group']['name'].' '; 
            	
            	//4. Date and time
            	echo 'on '.$action['Action']['time'].'.';
            	
            	?>
            	<!--<span class="activity-actions">
            		<span class="tweet-action action-favorite">
              			<a href="#" class="like-action" data-activity="like" title="Like"><span><i></i><b>Like</b></span></a>
            		</span>
          		</span>-->
          </div>
        </div>
      </div>
    </div>
  </li>
<?php } ?>
</ul>

