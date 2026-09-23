<?php global $lang;?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-3 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:center; }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->vendor; ?> <?php echo $lang->report; ?> <small><?php echo $lang->booking; ?> / <b><?php echo $lang->vendor; ?> <?php echo $lang->report; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            
                            <form action="<?php echo base_url(); ?>/report/print_vendor_report" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                    <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        
										
                                            <div class="col-md-2 col-sm-3">
                                                <div class="form-group form-float">                                        
                                                    <label class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>
                                                    
                                                </div>
                                            </div>
                                        <div class="col-md-6 col-sm-12" style="margin:0px;" align="right">                                    
											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
											<input name="pdf_hallreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_hallreport" value="PDF">
											<input name="excel_hallreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_hallreport" value="EXCEL">
										</div>
                                        </div>
                                    </div>
                            </form>
                                <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables"> 
                                    
                                <thead>
                                        <tr>
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:11%;"><?php echo $lang->booking; ?> <?php echo $lang->date; ?></th>
                                            <th style="width:10%;"><?php echo $lang->entry; ?> <?php echo $lang->date; ?></th>
                                            <th style="width:10%;"><?php echo $lang->name; ?></th>
                                            <th style="width:28%;"><?php echo $lang->service; ?> <?php echo $lang->name; ?></th>
                                            <th style="width:25%;"><?php echo $lang->service; ?> <?php echo $lang->description; ?></th>
                                            <th style="width:12%;"><?php echo $lang->amount; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTable" >                                    

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
$(document).ready
(
    function()
    {        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/vendor_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    }
            },
        });

        $('#submit').click(function() {
        report.ajax.reload();
        });
    });
</script>
