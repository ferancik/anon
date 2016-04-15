
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="portlet grey-cascade box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Vyplnené registrácie</div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> Meno </th>
                                <th> Priezvisko </th>
                                <th> Kategória </th>
                                <th> Cena </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submissions as $key => $sub) { ?>
                                <tr>
                                    <td>
                                        <?php echo $sub['meno']; ?>
                                    </td>
                                    <td>
                                        <?php echo $sub['priezvisko']; ?>
                                    </td>

                                    <td> <?php echo $sub['kategoria_name']; ?> </td>
                                    <td> <?php echo $sub['kategoria_price'] ?></td>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="well">
            <div class="row static-info align-reverse">
                <div class="col-md-8 name"> Spolu: </div>
                <div class="col-md-3 value"> <?php echo $sub_total['price'] . ' ' . $sub_total['currency']; ?> </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions no-border-top no-padding-left no-padding-right no-background-color">
    <div class="row">
        <div class="col-md-6">
            <a href="<?php echo site_url("event/registration/".$event->url); ?>" class="btn red">Späť</a>
        </div>
        <div class="col-md-6">
            <a href="<?php echo site_url("order/createOrder"); ?>"class="btn green pull-right">Odoslať</a>
        </div>
    </div>
</div>