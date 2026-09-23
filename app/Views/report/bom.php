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
            <h2> BILL OF MATERIAL REPORT <small>Inventory / <a href="#" target="_blank">Bom Report</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            <form action="<?php echo base_url(); ?>/report/print_bomreport" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                                    <label class="form-label">Date</label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" name="product_id" id="product_id">
                                                    <option value="">-- Select product --</option>
                                                    <?php
                                                    if(count($products) > 0)
                                                    {
                                                        foreach($products as $product)
                                                        {
                                                    ?>
                                                    <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>    
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">                                        
                                                <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit">Submit</label>                                                		
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12" style="margin-bottom:0px;">                                    
											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
											<input name="pdf_bomreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_bomreport" value="PDF">
											<input name="excel_bomreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_bomreport" value="EXCEL">
										</div>
                                        </div>
                                    </div>
                            </form>
                                <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables">       
                                <thead>
                                        <tr> 
                                            <th style="width:30%;text-align:left;">Item Name</th>
                                            <th style="width:20%;text-align:center;">Quantity</th>
                                            <th style="width:50%;text-align:left;">Description</th>
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
                url: "<?php echo base_url(); ?>/report/bom_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.product_id = $('#product_id').val();
                    }
            },
        });

        $('#submit').click(function() {
        report.ajax.reload();
        });
    });

</script>
