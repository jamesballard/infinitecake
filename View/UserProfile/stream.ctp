<?php

$this->start('sidebar');
echo $this->element('reportSidebar');
echo $this->element('helpSidebar');
$this->end();

?>
<h2>Activity Stream for <?php echo $userid; ?></h2>
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
            <a class="screen-name" title="&lt;em&gt;Anon&lt;/em&gt;"><em><?php echo $action['Group']['name']; ?></em></a>
          </span>
        </div>
        <div class="activity-row">
          <div class="text">
            <?php echo $action['DimensionVerb']['Artefact']['name'].' '.$action['DimensionVerb']['name']; ?>
          </div>
        </div>
        <div class="activity-row">
          <a href="undefined" class="timestamp">
            <span title="<?php echo $action['Action']['time']; ?>"><?php echo $action['Action']['time']; ?></span>
          </a>
          <!--<span class="activity-actions">
            <span class="tweet-action action-favorite">
              <a href="#" class="like-action" data-activity="like" title="Like"><span><i></i><b>Like</b></span></a>
            </span>
          </span>-->
        </div>
      </div>
    </div>
  </li>
<?php } ?>
</ul>

