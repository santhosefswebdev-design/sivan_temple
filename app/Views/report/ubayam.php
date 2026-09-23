<?php global $lang;?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-3 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:center; }
.paid_text { color:green; font-weight:600; }
.unpaid_text { color:red; font-weight:600; }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->ubayam; ?> <?php echo $lang->report; ?> <small><?php echo $lang->ubayam; ?> / <b><?php echo $lang->ubayam; ?> <?php echo $lang->report; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                        <form action="<?php echo base_url(); ?>/report/print_ubayamreport" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                    <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="payfor" id="payfor">
                                                        <option value="0"><?php echo $lang->select; ?> <?php echo $lang->pay_for; ?></option>
                                                        <?php
                                                        foreach($ubyam_set as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
													<label class="form-label"></label>
												</div>
											</div>                                            
                                        </div>
										<div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="fltername" id="fltername">
                                                        <option value="0"><?php echo $lang->select; ?> <?php echo $lang->name; ?></option>
                                                        <?php
                                                        foreach($fltr_name as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
													<label class="form-label"></label>
												</div>
											</div>                                            
                                        </div>
                                            <div class="cocol-md-2 col-sm-4">
                                                <div class="form-group form-float">                                        
                                                    <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12" style="margin:0px;">                                    
												<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
												<input name="pdf_ubayamreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_ubayamreport" value="PDF">
												<input name="excel_ubayamreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_ubayamreport" value="EXCEL">
											</div>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                    <table class="table table-striped dataTable" id="datatables">       
                                        <thead>
                                            <tr>
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:8%;"><?php echo $lang->date; ?></th>
                                            <th style="width:27%;"><?php echo $lang->pay_for; ?></th>
                                            <th style="width:24%;"><?php echo $lang->name; ?></th>
                                            <th style="width:9%;"><?php echo $lang->amount; ?></th>
                                            <th style="width:9%;"><?php echo $lang->paid; ?></th>
                                            <th style="width:9%;"><?php echo $lang->balance; ?></th>
                                            <th style="width:9%;"><?php echo $lang->status; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody >                                    

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
                url: "<?php echo base_url(); ?>/report/ubayam_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                     data.payfor = $('#payfor').val();
                     data.fltername = $('#fltername').val();
                    }
            },
        });

        $('#submit').click(function() {
        report.ajax.reload();

        $("#prt").attr("href", '<?php base_url()?>/report/print/ubayam/'+$('#fdt').val()+'/'+$('#tdt').val());
        });

    });

</script>
