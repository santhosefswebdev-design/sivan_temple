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
            <h2>Offering  <small>Offering / <?php echo $lang->report; ?></a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            <form action="<?php echo base_url(); ?>/offering/print_offeringreport" method="get" target="_blank">
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
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select id="offering_id" name="offering_id" class="form-control">
            										    <option value="">-- Select Offering Category --</option>
            										    <?php foreach($offer as $row) { ?>
            										    <option <?php if($data['off_cat_id']==$row['id']) { echo "selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            										    <?php } ?>
            										</select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select id="product_id" name="product_id" class="form-control">
            										    <option value="">-- Select Product Category --</option>
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
                                <!-- <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                    <table class="table table-striped dataTable" id="datatables">       
                                        <thead>
                                            <tr> 
                                                <th style="width:10%;">Sl.No</th>
                                                <th style="width:10%;">Name</th>
                                                <th style="width:10%;">Phone</th>
                                                <th style="width:15%;">Category</th>
                                                <th style="width:15%;">Product</th> 
                                                <th style="width:15%;">Grams</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userTable"></tbody>                               
                                    </table>
                                </div> -->
                                <div class="table-responsive col-md-12 det" align="center" style="background:#FFF; float:none;">
                                    <table style="width:100%;" align="center" class="table table-striped dataTable" id="datatables">       
                                        <thead>
                                            <tr> 
                                                <th style="width:10%;">Sl.No</th>
                                                <th style="width:10%;">Name</th>
                                                <th style="width:10%;">Phone</th>
                                                <th style="width:15%;">Category</th>
                                                <th style="width:15%;">Product</th> 
                                                <th style="width:15%;">Grams</th>
                                                <th style="width:15%;">Action</th>
                                            </tr>
                                        </thead>
                                            <tbody id="userTable" >                                    
                                            </tbody>
                                    </table>
                                </div>
                                <div id="totalsDisplay" style="text-align: right;font-weight: bold;"></div>
           
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$("#offering_id").change(function(){
var id = $("#offering_id").val();
if(id != "")
	{
        $.ajax({
			url: '<?php echo base_url();?>/offering/get_category',
			type: 'post',
			data: {id:id},
			dataType: 'json',
			success:function(data)
			{
				console.log(data.data);
                $('#product_id').empty();
                $('#product_id').append('<option value="">Select Product Category</option>');
                data.data.forEach(function(item) {
                    $('#product_id').append(
                        $('<option></option>').val(item.id).text(item.name)
                    );
                });
                $('#product_id').selectpicker('refresh');
				//$('#product_id').append('<option value="' + data.data.pid + '">' + data.data.pname + '</option>');
		    }
		});
	}
});

$(document).ready(function() {        
    var report = $('#datatables').DataTable({
        dom: 'Bfrtip',
        buttons: [],
        "ajax": {
            url: "<?php echo base_url(); ?>/offering/offering_rep_ref",
            dataType: "json",
            type: "POST",
            data: function (data) {
                data.fdt = $('#fdt').val();
                data.tdt = $('#tdt').val();
                data.offering_id = $('#offering_id').val();
                data.product_id = $('#product_id').val();
            },
            dataSrc: function (json) {
                // Assuming you have a place to display totals
                updateCategoryTotals(json.totals);
                return json.data;
            }
        }
    });

    $('#submit').click(function() {
        report.ajax.reload();
    });
});

function updateCategoryTotals(totals) {
    $('#totalsDisplay').empty();

    $.each(totals, function(category, grams) {
        $('#totalsDisplay').append('<div class="total-item">' + category + ': ' + grams + ' grams</div>');
    });
}

</script>
