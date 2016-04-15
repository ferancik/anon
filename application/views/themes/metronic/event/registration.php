<div class="row">
    <?php if (strtotime($event->registration_from) < time()) { ?>
        <div class="col-md-6 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet">

                <div class="portlet-body form" id="registration-form">
                    <?php $this->load->view(TEMPLATE . 'event/form', array('event' => $event, 'fields' => $fields)); ?>
                </div>
            </div>
        </div>
        <div id="submission-list">
            <?php $this->load->view(TEMPLATE . 'event/submissionList', array('submissions' => $submissions, 'sub_total' => $sub_total)); ?>
        </div>
    <?php } else { ?>
        <div class="col-md-12 text-center">
            <h2>Registrácia bude spustená <?php echo date("d.m.Y H:i", strtotime($event->registration_from)); ?></h2>
        </div>
    <?php } ?>
</div>




<script type="text/javascript">
    $(document).ready(function () {
//        jQuery.validator.setDefaults({
//            errorPlacement: function (error, element) {
//                error.appendTo('#error--' + element.attr('id'));
//            }
//        });

        $("#form_registration").validate({
            errorElement: 'span',
            errorPlacement: function (error, element) {
                var type = $(element).attr("type");
                if (type === "radio") {
                    // custom placement
                    error.appendTo('#error-' + element.attr('id'));
                } else if (type === "checkbox") {
                    // custom placement
                    error.insertAfter(element).wrap('<div/>');
                } else {
                    error.insertAfter(element).wrap('<div/>');
                }
            },
        });
    });
</script>

<script src="<?php echo base_url(); ?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/global/plugins/jquery-validation/js/localization/messages_sk.js"></script>

