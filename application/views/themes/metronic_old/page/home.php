<div class="row">
    <?php foreach ($events as $key => $event) { ?>

        <div class="col-sm-12 col-md-3">
            <div class="thumbnail event">
                <a href="<?php echo createUrlEventDetail($event->url); ?>" >
                    <img src="<?php echo base_url() . $event->img; ?>" alt="<?php echo $event->name; ?>" >
                </a>
                <div class="caption">


                    <a  class="text-center" href="<?php echo createUrlEventDetail($event->url); ?>" ><h3><?php echo $event->name; ?></h3></a>
                </div>
                <div class="coming-soon-countdown">
                    <input type="hidden" class="myCountdownTime" value="<?php echo strtotime($event->date_from); ?>" />
                    <div id="countdown_<?php echo $event->event_id; ?>" class="countDownElement"> </div>
                </div>
            </div>
        </div>
    </a>
<?php } ?>
</div>

