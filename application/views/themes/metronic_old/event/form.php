<form class="form-horizontal" role="form" id="form_registration" method="post" action="<?php echo createEventForm($event->url); ?>">
    <input type="hidden" name="event_id" id="event_id" value="<?php echo $event->event_id; ?>" />
    <input type="hidden" name="count_submision" value="1" id="count_submission" />
    <input type="hidden" name="submission_hash" value="<?php echo $submissions['submission_hash']; ?>" />
    <div class="form-body" style="padding: 0;">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    1. <?php echo lang("Registrácia"); ?>
                </div>

                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php foreach ($fields as $key => $field) { ?>
                    <?php $this->load->view(TEMPLATE . 'form/' . $field->field_type, array('field' => $field,'value'=>$submissions[$field->field_name])); ?>
                <?php } ?>

            </div>
        </div>

        <div id="new-form"></div>

        <div class="form-actions no-border-top no-padding-left no-padding-right no-background-color">
            <div class="row">
                <div class="col-md-6">
                    <!-- Dalsi ucastnik -->
                    
                    

                </div>
                <div class="col-md-6">
                    <button id="more_submission" type="button" onclick="getNewSubmission('<?php echo site_url('event/addSubmission/'); ?>')" class="btn green pull-right">Pridať

                    </button>
                    <button id="save-update-submission"  type="button" onclick="getNewSubmission('<?php echo site_url('event/addSubmission/'); ?>')" class="btn green pull-right hide">Uložiť

                    </button>
                    <!--<button type="submit" class="btn green pull-right"><?php echo lang("Pokračovať"); ?></button>-->
                </div>
            </div>
        </div>
    </div>
</form>

