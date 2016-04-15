<div class="row">

    <div class="col-md-6 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <span class="caption-subject bold uppercase"><?php echo $event->name; ?></span>
                </div>
            </div>
            <div class="portlet-body form" id="registration-form">
                <?php $this->load->view(TEMPLATE . 'event/form', array('event' => $event, 'fields' => $fields)); ?>
            </div>
        </div>
    </div>
    <div id="submission-list">
        <?php $this->load->view(TEMPLATE . 'event/submissionList', array('submissions' => $submissions, 'sub_total'=> $sub_total)); ?>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
        $("#form_registration").validate({
            errorElement: "div",
            
        });
    });
</script>

<script src="<?php echo base_url(); ?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/global/plugins/jquery-validation/js/localization/messages_sk.js"></script>

