<div class="row">

    <div class="col-md-4">
        <img class="img-responsive pic-bordered" src="<?php echo base_url() . $event->img; ?>" />
        <?php if (strtotime($event->registration_from) < time()) { ?>
            <a href="<?php echo createEventForm($event->url); ?>" class="btn red btn-block"> Registrovať </a>
        <?php }else{ ?>
            <span class="btn red btn-block"> Spustenie registrácie <?php echo date("d.m.Y H:i", strtotime($event->registration_from)); ?> </span>
        <?php } ?>
        <?php if ($event->propozicie != null) { ?>
            <a target="_blank" href="<?php echo base_url() . $event->propozicie; ?>" class="btn btn-primary btn-block"> Propozície </a>
        <?php } ?>
        <a href="<?php echo site_url('event/table_competitors/' . $event->url); ?>" class="btn btn-success btn-block"> Pretekári </a>

    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8 profile-info">
                <ul class="list-inline">
                    <li>
                        <i class="fa fa-map-marker"></i> <?php echo $event->location; ?> </li>
                    <li>
                        <i class="fa fa-calendar"></i><?php echo date("d. m. Y H:i", strtotime($event->date_from)); ?> </li>
                    <li>
                        <i class="fa fa-briefcase"></i> Šport </li>
                    <li>
                        <i class="fa fa-heart"></i> Beh
                    </li>
                </ul>
                <p><?php echo $event->description; ?></p>
                <p>
                    <a href="<?php echo $event->website; ?>"><?php echo $event->website; ?></a>
                </p>

            </div>
            <!--end col-md-8-->
            <div class="col-md-4">

            </div>
            <!--end col-md-4-->
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="portlet-body">
                    <div id="gmap_basic" class="gmaps"> </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var MapsGoogle = function () {

        var mapBasic = function () {
            var map = new GMaps({
                div: '#gmap_basic',
                lat: <?php echo $event->lat; ?>,
                lng: <?php echo $event->lng; ?>
            });
            map.addMarker({
                lat: <?php echo $event->lat; ?>,
                lng: <?php echo $event->lng; ?>,
                title: 'Start',
                infoWindow: {
                    content: '<span style="color:#000">Start</span>'
                }
            });
            map.addMarker({
                lat: 49.141264,
                lng: 19.328325,
                title: 'Ciel',
                infoWindow: {
                    content: '<span style="color:#000">Ciel</span>'
                }
            });
            map.setZoom(11);
        }

        return {
            //main function to initiate map samples
            init: function () {
                mapBasic();
            }
        };

    }();

    jQuery(document).ready(function () {
        MapsGoogle.init();
    });

</script>

