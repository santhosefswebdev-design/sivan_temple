<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> ACCOUNT <small>Account Create / <a href="#" target="_blank">Edit Opening Balance</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <div class="row"><div class="col-md-8"><h2>Edit Opening Balance</h2></div>
                      <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/account"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        
                        <form action="<?php echo base_url(); ?>/account/save_add_ledger_opbal" method="post">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" id="id">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <select class="form-control show-tick" name="fyear" id="fyear">
                                                <option value="">--Select Financial Year--</option>
                                                <?php foreach($year as $row) { ?>
                                                    <option <?php if($data['ac_year_id'] == $row['id'] ) echo 'selected'; ?> value="<?= $row['id'];?>"><?= $row['from_year_month'];?> to <?= $row['to_year_month'];?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="op_dc" id="op_dc">
                                                    <option <?php if($data['dr_amount'] != '0.00') echo 'selected'; ?> value="D">Debit</option>
                                                    <option <?php if($data['cr_amount'] != '0.00') echo 'selected'; ?> value="C">Credit</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
												<?php 
												if($data['dr_amount'] == '0.00') { $amt = $data['cr_amount']; }
												else if($data['cr_amount'] == '0.00') { $amt = $data['dr_amount']; }
												else { $amt = "0.00"; }
                                                ?>
                                                <input type="text" name="op_bal" class="form-control" id="op_bal" value="<?php echo $amt; ?>">
                                                <label class="form-label">Opening Balance</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                    <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                </div>
                                <?php } ?>
                                </div>
                            </form>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
	
	$('#fyear').change(function(){
		var id = $('#id').val();
		var yr = $('#fyear').val();
		//alert(id);
		//alert(yr);
		if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/account/get_amt",
                type: "post",
                data: {id: id, yr: yr},
                dataType: "json",
                success: function(data){
                    console.log(data)
                    $("#op_dc").val(data['select']).change();;
					$("#op_bal").val(Number(data['amt']).toFixed(2));
                }
            });
        }else{
            $("#op_bal").val(0);
        }
	});
</script>