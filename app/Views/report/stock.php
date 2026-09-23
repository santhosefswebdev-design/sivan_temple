<?php global $lang;?>
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
            <h2><?php echo $lang->stock; ?> <?php echo $lang->report; ?>  <small><?php echo $lang->inventory; ?> / <a href="#" target="_blank"><?php echo $lang->stock; ?> <?php echo $lang->report; ?></a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            <form action="<?php echo base_url(); ?>/report/print_stockreport" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" name="producttype" id="producttype">
                                                    <option value=""><?php echo $lang->select; ?> <?php echo $lang->type; ?></option>
                                                    <option value="1"><?php echo $lang->product; ?></option>
                                                    <option value="2"><?php echo $lang->raw; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">                                        
                                                <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>                                                		
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12" style="margin-bottom:0px;">                                    
											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
											<input name="pdf_stockreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_stockreport" value="PDF">
											<input name="excel_stockreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_stockreport" value="EXCEL">
										</div>
                                        </div>
                                    </div>
                            </form>
                                <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables">       
                                <thead>
                                        <tr> 
                                            <th style="width:10%;text-align:left;"><?php echo $lang->type; ?></th>
                                            <th style="width:30%;text-align:left;"><?php echo $lang->item; ?> <?php echo $lang->name; ?></th>
                                            <th style="width:10%;"><?php echo $lang->opening; ?></th>
                                            <th style="width:15%;"><?php echo $lang->donate; ?></th>
                                            <th style="width:15%;"><?php echo $lang->stock; ?> <?php echo $lang->in; ?></th>
                                            <th style="width:15%;"><?php echo $lang->stock; ?> <?php echo $lang->out; ?></th>
                                            <th style="width:15%;"><?php echo $lang->defective; ?></th>
                                            <th style="width:15%;"><?php echo $lang->available; ?></th>
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
                url: "<?php echo base_url(); ?>/report/stock_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.type = $('#producttype').val();
                    }
            },
        });

        $('#submit').click(function() {
        report.ajax.reload();
        });
    });

</script>
