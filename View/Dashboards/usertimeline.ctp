<?php if(empty($actions)) : ?>
    <h3><?php echo __('User Timeline'); ?></h3>
    <?php echo $this->element('Misc/waitingForData'); ?>
<?php else : ?>
<div class="row">
    <div class="col-md-2">
        <h3><?php echo __('User Timeline'); ?></h3>
    </div>
    <div class="col-md-8 userSelect" >
        <?php
        echo $this->dynamicForms->autocomplete('DashboardUser','/People/jsonfeed');
        ?>
        <div class="ui-widget">
            <?php
            echo $this->Form->create('Dashboard', array('class' => 'form-inline'));

            echo $this->Form->input('userid', array('default' => $userid, 'type' => 'hidden'));
            echo $this->Form->input('user', array(
                'default' => $userdefault,
                'label' => array('class' => 'sr-only'),
                'between' => '',
                'after' => '',
            ));

            echo $this->Form->end(array(
                'style' => 'primary',
                'label' => 'Change',
                'before' => '',
                'after' => '',
            ));
        ?>
        </div>
    </div>
</div>

<?php if (!empty($userid)) : ?>

    <div class="container">
        <div class="page-header">
            <h1 id="timeline">Timeline</h1>
        </div>
        <ul class="timeline">
            <?php
                foreach($actions as $action) {
                    echo $this->element('Timeline/event', array('action' => $action));
                }
            ?>
        </ul>
    </div>

    <?php echo $this->Paginator->next('Show more actions...'); ?>

    <script>
        $(function(){
            var $container = $('.timeline');

            $container.infinitescroll({
                    navSelector  : '.next',    // selector for the paged navigation
                    nextSelector : '.next a',  // selector for the NEXT link (to page 2)
                    itemSelector : '.timeline-event',     // selector for all items you'll retrieve
                    debug         : true,
                    dataType      : 'html',
                    loading: {
                        finishedMsg: 'No more actions to load.',
                        img: '<?php echo $this->webroot; ?>img/pac-loader.gif'
                    }
                }
            );
        });

    </script>

<?php
    endif;
    endif;
?>