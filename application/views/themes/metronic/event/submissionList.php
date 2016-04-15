


<?php if (count($submissions) > 0) { ?>
    <div class="col-md-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-globe font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Zoznam vyplnených registrácií</span>
                </div>
            </div>
            <div class="portlet-body">
                <!--BEGIN TABS-->
                <div class="">
                    <ul class="feeds">
                        <?php foreach ($submissions as $key => $submission) { ?>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="desc"> 
                                                <?php echo $submission['meno'] . ' ' . $submission['priezvisko']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">

                                    <div class="actions">
                                        <a href="javascript:;" onclick="updateSubmission('<?php echo site_url('event/editSubmission'); ?>', '<?php echo $key; ?>')" class="btn btn-circle btn-icon-only btn-default">
                                            <i class="icon-pencil"></i>
                                        </a>
                                        <a href="javascript:;" class="btn btn-circle btn-icon-only btn-default" onclick="deleteSubmission('<?php echo site_url('event/deletSubmission'); ?>', '<?php echo $key; ?>')">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <!--END TABS-->
            </div>
        </div>

        <div class="well">
            <div class="row static-info align-reverse">
                <div class="col-md-8 name"> Spolu: </div>
                <div class="col-md-3 value"> <?php echo $sub_total['price'] . ' ' . $sub_total['currency']; ?> </div>
            </div>
        </div>
       
        <a href="<?php echo site_url('event/sumary'); ?>" class="btn green pull-right" style="width: 100%">Pokračovať</a>
        <!-- END PORTLET-->
    </div>
<?php } ?>