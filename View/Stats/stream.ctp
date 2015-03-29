<?php

$this->start('sidebar');
echo $this->element('Sidebars/reports');
echo $this->element('Sidebars/help');
$this->end();

?>
<h2>Activity Stream</h2>
<?php 
	echo '<div style="width:400px">';
	echo $this->Form->create();
	echo $this->element('FormItems/selectDateWindowShort');
	echo $this->element('MultiSelectForms/systems');
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
          <span class="user-name">
            <a class="screen-name" title=""><em><?php echo $action['User']['idnumber']; ?></em></a>
          </span>
        </div>
        <div class="activity-row">
          <span class="user-name">
            <a class="screen-name" title="<?php echo $action['Group']['idnumber']; ?>"><em><?php echo $action['Group']['name']; ?></em></a>
          </span>
        </div>
        <div class="activity-row">
          <div class="text">
            <?php
             	//Construct the action sentence.
             	
             	//1. User idnumber
             	echo $action['User']['idnumber'].' ';
             	 
            	//2. Verb (past tense) from language strings.
            	echo __($action['DimensionVerb']['sysname'].'_past').' ';
            	
            	//3. Artefact Type 
            	echo 'a '.$action['DimensionVerb']['Artefact']['name'].' ';
            	
            	//4. Group ID number
            	echo 'in '.$action['Group']['name'].' '; 
            	
            	//5. Date and time
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

