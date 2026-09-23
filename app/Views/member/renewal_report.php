<?php global $lang;?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
    .table-responsive {
        overflow-x: hidden;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->member; ?> Renewal Report <small><?php echo $lang->member; ?> / <b><?php echo $lang->member; ?> Renewal Report</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="header" style="border:none;">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>&nbsp;</p>
                                <form action="<?php echo base_url(); ?>/member/print_renewalreport" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float" style="margin-bottom:0px;">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float" style="margin-bottom:0px;">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                            <div class="col-md-2 col-sm-3">
                                                <div class="form-group form-float" style="margin-bottom:0px;">                                        
                                                        <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>                                          		</div>
                                            </div>
                                            <div class="col-md-6 col-sm-6" style="text-align:right;">                                    
    											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
    											<input name="pdf_renewalreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_renewalreport" value="PDF">
    											<input name="excel_renewalreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_renewalreport" value="EXCEL">
    										</div>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    <div class="body">
                        
                        <div class="table-responsive">
                            <table class="table table-striped dataTable" id="datatables">
                                <thead>
                                    <tr>
                                        <th><?php echo $lang->sno; ?></th>
                                        <th><?php echo $lang->member; ?> <?php echo $lang->name; ?></th>
                                        <th><?php echo $lang->member; ?> <?php echo $lang->no; ?></th>
                                        <th><?php echo $lang->member; ?> <?php echo $lang->type; ?></th>
                                        <th>Renewal Start Date</th>
                                        <th>Renewal End Date</th>
                                        <th>Amount</th>
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
$(document).ready(function(){
    report = $('#datatables').DataTable({
        dom: 'Bfrtip',
        buttons: [],
        "ajax":{
            url: "<?php echo base_url(); ?>/member/get_renewal_report",
            dataType: "json",
            type: "POST",
            data: function ( data ) {
                data.fdt = $('#fdt').val();
                data.tdt = $('#tdt').val();
                data.fltername = $('#fltername').val();
            }
        },
    });

    $('#submit').click(function() {
        report.ajax.reload();
    });
});
</script>