<?php        
$db = db_connect();
if($view == true)
{
    $readonly = "readonly";
    $disabled = "disabled";
}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/jquery-ui.css">
<script src="<?php echo base_url(); ?>/assets/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>/assets/monthpicker/MonthPicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>/assets/monthpicker/MonthPicker.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>RENTAL<small>rental / <b>Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/rental"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                    <form action="<?php echo base_url(); ?>/rental/store" method="POST" id="form_validation">
						<input type="hidden" value="<?php echo isset($rental['id']) ? $rental['id'] : ""; ?>" name="id" id="updateid">
                        <div class="container-fluid">
                        <div class="row clearfix">
							<div class="col-sm-8">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select name="property_id" id="property_id" class="form-control" required <?php echo $readonly; ?>> 
											<option value="">select property</option>
											<?php
											foreach($property_lists as $property_list)
											{
											?>
											<option value="<?php echo $property_list['id']; ?>" <?php if(isset($rental['property_id'])){ if($rental['property_id'] == $property_list['id']){ echo "selected"; } }?>><?php echo $property_list['name']; ?></option>
											<?php
											}
											?>
										</select>
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="property_amount" class="form-control" value="<?php if(!empty($rental_amt)){ echo $rental_amt; }else{ echo 0; } ?>" readonly>
                                        <label class="form-label">Amount</label>
                                    </div>
                                </div>
                            </div>
							<div style="clear:both"></div>
							 <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="rental_monthyear" id="rental_monthyear" class="form-control rental_monthyear" value="<?php echo isset($rental['month_year']) ? $rental['month_year'] : ""; ?>" autocomplete="off" required>
                                        <label class="form-label">Month<span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" name="rental_amount" id="rental_amount" class="form-control" value="<?php echo isset($rental['amount']) ? $rental['amount'] : 0; ?>" step=".01" readonly>
                                        <label class="form-label">Payee Amount <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" name="rental_paynee_name" id="rental_paynee_name" class="form-control" value="<?php echo isset($rental['payee_name']) ? $rental['payee_name'] : ""; ?>" required>
                                        <label class="form-label">Payee Name<span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
							<div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
										<textarea name="rental_description" id="rental_description" class="form-control"><?php echo isset($rental['payee_description']) ? $rental['payee_description'] : ""; ?></textarea>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-12"> 
							<div class="products row">
								<div class="col-sm-12">
									<h3 style="margin-bottom:5px; margin-top:5px;">Pay Details</h3>
								</div>
								<div class="col-sm-4">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="date" class="form-control" id="pay_date" value="<?php echo date('Y-m-d'); ?>">
											<label class="form-label">Pay Date</label>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="number" id="pay_amt" min="0" class="form-control" step=".01"  value="0">
											<label class="form-label">Amount</label>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-float">
										<div class="form-line">
											<select class="form-control" name="paymentmode" id="paymentmode">
												<option value="0">Select</option>
												<?php foreach($payment_modes as $payment_mode) { ?>
												<option value="<?php echo $payment_mode['id']; ?>"><?php echo $payment_mode['name'];?></option>
												<?php } ?>
											</select>
											<label class="form-label">Payment Mode</label>
										</div>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group form-float">
										<div class="form-line" style="border: none;">
											<label id="pay_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
								<div class="table-responsive"><table style="width:100%" class="table table-bordered" id="pay_table" style="height: 150px;">
									<thead>
										<tr>
											<th width="40%">Date</th>
											<th width="25%">Total RM</th>
											<th width="20%">Payment Mode</th>
											<th width="15%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if(!empty($payment))
										{
											foreach($payment as $row) { 
												$payment_mode_check = $db->table('payment_mode')
                                                                            ->select('payment_mode.name')
                                                                            ->where("payment_mode.ledger_id", $row['payment_mode'])
                                                                            ->get()->getResultArray();
												if(count($payment_mode_check) > 0)
												{
													$payment_mode_row = $payment_mode_check[0]['name'];
												}
												else
												{
													$payment_mode_row = "";
												}
										?>
											<tr>
												<td><?php echo date("d/m/Y", strtotime($row['date'])); ?></td>
												<td>
													<input type="hidden" style="border: none;" readonly class="pay_amt" value="<?php echo $row['amount']; ?>">
													<?php echo $row['amount']; ?></td>
												<td><?php echo $payment_mode_row; ?></td>
												<td>---</td>
											</tr>
										<?php 
											} 
										}
										?>
									</tbody>
								</table></div>
								<input type="hidden" id="pay_row_count" value="1">
							</div>
						</div>
									
                        <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                            <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                        </div>
                    </div>
                    </form>
                    
                    </div>
             
            </div>
        </div>
    </div>
    </div>

</section>
<script>
$('#rental_monthyear').MonthPicker({ Button: false });


$('#form_validation').validate({
	rules: {
		"property_id": {
			required: true,
			remote: {
				url: "<?php echo base_url(); ?>/rental/findpropertyNameExists",
				data: {
					update_id: function() {
						return $("#updateid").val();
					},
					rental_monthyear: function() {
						return $("#rental_monthyear").val();
					},
					property_id: $(this).data('property_id')
				},
				type: "post",
			},
		}
	},
	messages: {
		"property_id": {
			required: "property name is required",
			remote: "Already property name exist"
		}
	},
	highlight: function (input) {
		$(input).parents('.form-line').addClass('error');
	},
	unhighlight: function (input) {
		$(input).parents('.form-line').removeClass('error');
	},
	errorPlacement: function (error, element) {
		$(element).parents('.form-group').append(error);
	}
});

$('#property_id').change(function(){
	var id = $("#property_id").val();
	$.ajax({
		url: "<?php echo base_url(); ?>/rental/get_properties_amount",
		data: { prop_id : id },
		dataType:"JSON",
		type: "POST",
		success: function(data){
			$("#property_amount").val(data.amount);
			$("#rental_paynee_name").val(data.payee_name);
			$("#rental_description").val(data.address);
		}
	});
    
});
function get_payment_mode(id,cntno){
	//alert(id);
	if(id != ''){
		$.ajax({
			url: "<?php echo base_url();?>/rental/get_payment_mode",
			type: "post",
			data: {id: id},
			dataType: "json",
			success: function(data){
				$("#payment_mode_"+cntno).val(data['ledger_id']);
				$("#payment_mode_label_"+cntno).text(data['name']);
			}
		});
	}
}
$("#pay_add").click(function(){
	var date = $("#pay_date").val();
	var amt = $("#pay_amt").val();
	var paymentmode = $("#paymentmode").val(); 
	var cnt = parseInt($("#pay_row_count").val());
	if(date != '' && amt != 0 && paymentmode != 0){
		var property_amount = parseFloat($('#property_amount').val());
		var rental_amount = parseFloat($('#rental_amount').val());
		amt = parseFloat(amt);
		if(amt <= (property_amount - rental_amount)){
			get_payment_mode(paymentmode,cnt);
    		var html = '<tr id="rmv_payrow'+cnt+'">';
    			html += '<td style="width: 40%;"><input type="hidden" readonly name="pay['+cnt+'][id]" value=""><input type="date" style="border: none;" readonly name="pay['+cnt+'][date]" value="'+date+'"></td>';
    			html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" id="pay_amts_'+cnt+'" name="pay['+cnt+'][pay_amt]" value="'+Number(amt).toFixed(2)+'"></td>';
    			html += '<td style="width: 20%;"><input type="hidden" style="border: none;" readonly id="payment_mode_'+cnt+'" name="pay['+cnt+'][payment_mode]"><span id="payment_mode_label_'+cnt+'"></span></td>';
    			html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay('+ cnt +')" style="width:auto;"><i class="material-icons"></i></a></td>';
    			html += '</tr>';
    		$("#pay_table").append(html);
    		var ct = parseInt(cnt + 1);
    		$("#pay_row_count").val(ct);
    		sum_amount();
    		$("#pay_amt").val(0);
    		$('#paymentmode').prop('selectedIndex',0);
            $("#paymentmode").selectpicker("refresh");
		} else {
		    alert('Can\'t exceed the amount more than Property amount');
		}
	}
});

function rmv_pay(id){
	var total = $("#rental_amount").val();
	var pay_tot = $("#pay_amts_"+id).val();
	var balance1 = total - pay_tot;
	$("#rental_amount").val(Number(balance1).toFixed(2));
	$("#rmv_payrow"+id).remove();
}
function sum_amount(){
	var pay_tot = 0;
	$(".pay_amt").each(function(){
		pay_tot += parseFloat($(this).val());
	});
	$("#rental_amount").val(pay_tot);
}
$("form").on("submit", function(){
        $('input[type=submit]').prop('disabled', true);
        $("#loader").show();
    });
</script>