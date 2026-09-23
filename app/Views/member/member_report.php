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
            <h2><?php echo $lang->member; ?> <?php echo $lang->report; ?>  <small><?php echo $lang->member; ?> / <b><?php echo $lang->member; ?> <?php echo $lang->report; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            
                        <form action="<?php echo base_url(); ?>/report/member_report_print" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>" max="<?php echo $booking_calendar_range_year; ?>" >
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo $booking_calendar_range_year; ?>" >
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
										<div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="type" id="type">
                                                    <option value="0"><?php echo $lang->all; ?></option>
                                                        <option value="1">ORDINARY MEMBER</option>
                                                        <option value="3">LIFETIME MEMBER</option>
                                                    </select>
													<label class="form-label"><?php echo $lang->member; ?> <?php echo $lang->type; ?></label>
												</div>
											</div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="status" id="status">
                                                        <option value="0"><?php echo $lang->all; ?></option>
                                                        <option value="1"><?php echo $lang->active; ?></option>
                                                        <option value="2"><?php echo $lang->deactive; ?></option>
                                                    </select>
													<label class="form-label"><?php echo $lang->status; ?></label>
												</div>
											</div>                                            
                                        </div>

                                            <div class="col-md-2 col-sm-3">
                                                <div class="form-group form-float">                                        
                                                        <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>                                          		</div>
                                            </div>
                                            <div class="col-md-12 col-sm-12" style="margin:0px;">                                    
    											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
    											<input name="pdf_member" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_archanaireport" value="PDF">
    											<input name="excel_member" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_archanaireport" value="EXCEL">
    										</div>
                                        </div>
                                    </div>
                        </form>

                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables">
                                    
                                <thead>
                                        <tr>
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:25%;"><?php echo $lang->member; ?> <?php echo $lang->name; ?></th>
                                            <th style="width:15%;"><?php echo $lang->membership; ?> <?php echo $lang->no; ?></th>
                                            <th style="width:20%;"><?php echo $lang->member; ?> <?php echo $lang->type; ?></th>
                                            <th style="width:20%;"><?php echo $lang->icno; ?></th>
                                            <th style="width:15%;"><?php echo $lang->status; ?></th>
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
    
    $(document).ready(function(){
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/member_report_ajax",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt    = $('#fdt').val();
                    data.tdt    = $('#tdt').val();
                    data.type   = $('#type').val();
                    data.status = $('#status').val();
                }
            },
        });



        $('#submit').click(function() {
        report.ajax.reload();
        });



    });

</script>
