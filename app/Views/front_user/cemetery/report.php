<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-2 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:center; }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> CEMETERY REPORT <small>Cemetery / <a href="#" target="_blank">Cemetery Report</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            <form action="<?php echo base_url(); ?>/cemetery/print_cemetery" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                                    <label class="form-label">From</label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                                    <label class="form-label">To</label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">                                        
                                                <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit">Submit</label>                                                		
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6" style="margin-bottom:0px; text-align:right;">                                    
											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
											<input name="pdf_cemeteryreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_cemeteryreport" value="PDF">
											<input name="excel_cemeteryreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_cemeteryreport" value="EXCEL">
										</div>
                                        </div>
                                    </div>
                            	</form>
                                <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables">       
                                <thead>
                                        <tr> 
                                            <th style="width:5%;">S.No</th>
                                            <th style="width:25%;">Name of Dec</th>
                                            <th style="width:10%;">Age of Dec</th>
                                            <th style="width:15%;">Date of Cremation</th>
                                            <th style="width:20%;">Burial No</th>
                                            <th style="width:25%;">Place of Demise</th>
                                            <th style="width:25%;">Print</th>
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
                url: "<?php echo base_url(); ?>/cemetery/cemetery_report",
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
