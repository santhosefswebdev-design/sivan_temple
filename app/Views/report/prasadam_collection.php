<style>
    .btn-default,
    .btn-default:hover,
    .btn-default:active,
    .btn-default:focus {
        background: transparent !important;
    }

    .form-group {
        margin-bottom: 0 !important;
    }

    .col-sm-3 {
        margin-bottom: 10px !important;
    }

    .table tr th,
    .table tr td {
        text-align: center;
    }

    .paid_text {
        color: green;
        font-weight: 600;
    }

    .unpaid_text {
        color: red;
        font-weight: 600;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> PRASADAM REPORT <small><b>Prasadam Report</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form action="<?php echo base_url(); ?>/report/print_collection_prasadamreport" method="get"
                            target="_blank">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <!-- <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="collection_date" id="collection_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                                    <label class="form-label">Collection Date</label>
                                                </div>                                                        
                                            </div>                                            
                                        </div> -->
                                    <div class="col-md-2 col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container">
                                                <input type="date" name="fdt" id="fdt" class="form-control" value="">
                                                <label class="form-label">From Date (Collection)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container">
                                                <input type="date" name="tdt" id="tdt" class="form-control" value="">
                                                <label class="form-label">To Date (Collection)</label>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" name="fltername" id="fltername">
                                                        <option value="0">Select Name</option>
                                                        <?php
                                                        foreach ($fltr_name as $row) {
                                                            ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label class="form-label"></label>
                                                </div>
                                            </div>                                            
                                        </div> -->
                                    <div class="cocol-md-2 col-sm-4">
                                        <div class="form-group form-float">
                                            <label type="submit" class="btn btn-success btn-lg waves-effect"
                                                id="submit">Submit</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12" style="margin:0px;">
                                        <button type="submit" class="btn btn-primary btn-lg waves-effect"
                                            id="submit">Print</button>
                                        <input name="pdf_prasadamreport" type="submit"
                                            class="btn btn-danger btn-lg waves-effect" id="pdf_prasadamreport"
                                            value="PDF">
                                        <input name="excel_prasadamreport" type="submit"
                                            class="btn btn-success btn-lg waves-effect" id="excel_prasadamreport"
                                            value="EXCEL">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-striped dataTable" id="datatables">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">S.No</th>
                                        <th style="width:8%;">Date</th>
                                        <th style="width:9%;">Customer Name</th>
                                        <th style="width:12%;">Collection Date</th>
                                        <th style="width:12%;">Estimated Time</th>
                                        <!-- <th style="width:12%;">Distribution Type</th> -->
                                        <th style="width:15%;text-align:left;">Pay for</th>
                                        <th style="width:10%;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    //$(document).ready
    // (
    //     function()
    //     {        
    //         report = $('#datatables').DataTable({
    //             dom: 'Bfrtip',
    //             buttons: [],
    //             "ajax":{
    //                 url: "<?php echo base_url(); ?>/report/prasadam_collection_rep_ref",
    //                 dataType: "json",
    //                 type: "POST",
    //                 data: function ( data ) {
    //                     data.collection_date = $('#collection_date').val();
    //                      data.fltername = $('#fltername').val();
    //                     }
    //             },
    //         });

    //         $('#submit').click(function() {
    // 			report.ajax.reload();
    //         });

    //     });
    $(document).ready(function () {
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax": {
                url: "<?php echo base_url(); ?>/report/prasadam_collection_rep_ref",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    data.fdt = $('#fdt').val();  // From date (collection date)
                    data.tdt = $('#tdt').val();  // To date (collection date)
                    data.fltername = $('#fltername').val();  // Optional filter by customer name
                }
            }
        });

        $('#submit').click(function () {
            report.ajax.reload();  // Reload the DataTable with new filters
        });
    });

</script>