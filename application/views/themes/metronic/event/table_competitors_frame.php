<link href="<?php echo base_url(); ?>/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">

            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                        <tr>
                            <th> Štartovné číslo </th>
                            <th> Kat. </th>
                            <th> Meno </th>
                            <th> Nar. </th>
                            <th> Klub </th>
                            <th> Štát </th>
                            <th> Stav </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submissions as $key => $row) { ?>
                            <tr>
                                <td> <?php echo ($row->serial_number == 0) ? '' : $row->serial_number; ?> </td>
                                <td> <?php echo $row->kategoria; ?></td>
                                <td> <?php echo $row->meno . ' ' . $row->priezvisko; ?></td>
                                <td> 
                                    <?php if ($row->datum_narodenia != '') { ?>
                                        <?php echo date("Y", strtotime($row->datum_narodenia)); ?> 
                                    <?php } ?>
                                </td>
                                <td> <?php echo $row->klub; ?> </td>
                                <td>
                                    <?php if ($row->country) { ?>
                                        <img src="<?php echo base_url(); ?>/assets/img/flags/<?php echo strtolower($row->country->iso_code_2); ?>.png" height="18"/>
                                        <?php echo $row->country->name; ?> 
                                    <?php } ?>

                                </td>
                                <td> <?php echo $row->stav; ?> </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script src="<?php echo base_url(); ?>/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/pages/scripts/contact.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/global/plugins/countdown/jquery.countdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
    var TableDatatablesColreorder = function () {

        var initTable1 = function () {
            var table = $('#sample_1');

            var oTable = table.dataTable({
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
//                "language": {
//                    "aria": {
//                        "sortAscending": ": activate to sort column ascending",
//                        "sortDescending": ": activate to sort column descending"
//                    },
//                    "emptyTable": "No data available in table",
//                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
//                    "infoEmpty": "No entries found",
//                    "infoFiltered": "(filtered1 from _MAX_ total entries)",
//                    "lengthMenu": "_MENU_ entries",
//                    "search": "Search:",
//                    "zeroRecords": "No matching records found",
//                    search: "Hľadať"
//                },
                // Or you can use remote translation file
                "language": {
                    url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Slovak.json'
                },
                // setup buttons extentension: http://datatables.net/extensions/buttons/
                buttons: [
                    //{extend: 'print', className: 'btn dark btn-outline'},
                ],
                // setup responsive extension: http://datatables.net/extensions/responsive/
                responsive: true,
                // setup colreorder extension: http://datatables.net/extensions/colreorder/
                colReorder: {
                    reorderCallback: function () {
                        console.log('callback');
                    }
                },
                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 10,
                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            });
        }


        return {
            //main function to initiate the module
            init: function () {

                if (!jQuery().dataTable) {
                    return;
                }

                initTable1();
            }

        };

    }();

    jQuery(document).ready(function () {
        TableDatatablesColreorder.init();
    });

</script>