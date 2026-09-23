<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disabled = 'disabled';
}
?>
<?php $db = db_connect();?>
<style>
.form-group { margin-bottom: 0px; }
.form-group .form-control { border: 1px solid #CCC;padding-left: 5px; }
.btn { padding: 6px 12px !important; }

.dropdown-toggle {  border-bottom: 0px solid #ddd !important; }
.panel-primary { border-color: #f44336; }
.bootstrap-select.btn-group .dropdown-menu.inner { padding-bottom:50px; }
.row_totdr{
	border: 1px solid rgb(138, 136, 136);
    padding: 4px;
}
.row_totcr{
	border: 1px solid rgb(138, 136, 136);
    padding: 4px;
}
</style>
<?php
$min_date = '';
$max_date = '';
if(!empty($financial_year['start_date'])) $min_date = ' min="' . $financial_year['start_date'] .'"';
if(!empty($financial_year['end_date'])) $max_date = ' max="' . $financial_year['end_date'] .'"';
?>
<section class="content">
    <div class="container-fluid">
        <!--<div class="block-header">
            <h2> ENTRIES <small style="font-size: 14px;">Account / <?php echo $sub_title; ?></small></h2>
        </div>-->
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Ubayam</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/entries/list"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        <form id="credit_note_store_validation" >
							<input type="hidden" id="entry_type_id" name="entry_type_id" value="<?= $en_id; ?>" >
							<input type="hidden" id="entry_id" name="entry_id" value="<?php if(!empty($entries['id'])){ echo $entries['id']; }?>" >
							<div class="row">
								<div class="col-md-12">
									<div class="row">
									    <div class="col-md-3">
											<div class="form-group">
												<label class="floating-label" for="Text">Date<span style="color:red;">*</span></label>
												<input type="date" class="form-control" name="credit_note_date" id="credit_note_date" value="<?php if(!empty($entries['date'])) echo date("Y-m-d",strtotime($entries['date'])); else echo date("Y-m-d");?>" autocomplete="off" <?php echo $disabled; ?>>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="floating-label" for="Text">Entry Code<span style="color:red;">*</span></label>
												<input type="text" class="form-control" name="credit_note_entrycode" id="credit_note_entrycode" readonly autocomplete="off" value="<?php echo $entry_code; ?>">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="floating-label" for="fund_id">Funds</label>
												<select class="form-control search_box" required data-live-search="true" name="fund_id" id="fund_id">
													<?php
													if(!empty($funds))
													{
														foreach($funds as $fund)
														{
													?>
														<option value="<?php echo $fund["id"]; ?>" <?php if($entries['fund_id'] == $fund["id"]){ echo "selected"; } ?>><?php echo $fund['name'] . '(' . $fund['code'] . ")"; ?> </option>
													<?php
														}
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<?php
									if($view != true){
									?>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label class="floating-label" for="Text">Ledger Name</label>
												<select class="form-control search_box" data-live-search="true" name="credit_note_accountname" id="credit_note_accountname" <?php echo $disabled; ?>>
													<option value="">Select ledger</option>
													<?php
													if(!empty($ledgers))
													{
														foreach($ledgers as $ledger)
														{
													?>
														<option value="<?php echo $ledger["id"]; ?>"><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
													<?php
														}
													}
													?>
											    </select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="floating-label" for="Text">Amount Dr</label>
												<input type="number" class="form-control" step="any" min="0" value="0.00" name="credit_note_amountdr" id="credit_note_amountdr" <?php echo $readonly; ?>>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="floating-label" for="Text">Amount Cr</label>
												<input type="number" class="form-control" step="any" min="0" value="0.00" name="credit_note_amountcr" id="credit_note_amountcr" <?php echo $readonly; ?>>
											</div>
										</div>
										<div class="col-md-3" style="margin-top:30px;">
											<a class="btn btn-primary" id="addCreditDebitdetail" style="padding: 5px 15px;color:#fff;cursor: pointer;">Add</a>
											<a class="btn btn-secondary" id="clear_credit_debit_ac" style="padding: 5px 15px;cursor: pointer;"> Clear</a>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading" style="color: #fff;background-color: #f44336;border-color: #f44336;padding: 5px 15px;">Details Particulars</div>
												<div class="panel-body" style="border: 1px solid #f44336;padding: 10px;">
													<textarea class="form-control" name="credit_note_particulars" id="credit_note_particulars" <?php echo $readonly; ?>><?= $entries['narration']; ?></textarea>
												</div>
											</div>
										</div>
									</div>
									<div class="row">&nbsp;</div>
									<?php
									}
									?>
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading" style="color: #fff;background-color: #f44336;border-color: #f44336;padding: 5px 15px;">credit_note Details<span style="color:#fff;">*</span></div>
												<div class="panel-body" style="border: 1px solid #f44336;padding: 10px;">
													<input type="hidden" class="tot" id="tot_amt" name="tot_amt" value="0.00">
													<div class="tbl-header">
														<table style="width:100%;">
															<thead>
																<tr>
																	<?php
																	if($view != true){
																	?>
																	<th style="width:10%;">Options</th>
																	<?php
																	}
																	?>
																	<th style="width:30%">Account</th>
																	<th style="width:20%">Amount Dr</th>
																	<th style="width:20%">Amount Cr</th>
																	<?php // <th style="width:20%">Particulars</th> ?>
																</tr>
															</thead>
														</table>
													</div>
													<div style="width:100%;max-height:auto;">
														<table class="table table-bordered cart-table" style="width:100%;">
															<?php
															$debit_total = $credit_total = 0;
															if(!empty($entrie_items))
															{
																$j=1;
																foreach($entrie_items as $entrie_item)
																{
																	$ledger_name = $db->table('ledgers')->select('name')->where('id', $entrie_item['ledger_id'])->get()->getRowArray();
																	if($entrie_item['dc'] == "C")
																	{
																		$credit_total += $entrie_item['amount'];
																?>
															<tr class="all_close" data-id="<?php echo $entrie_item['ledger_id']; ?>" id="remov<?php echo $j; ?>">
																<td style="width:10%;"><input type="hidden" name="entries[<?php echo $j; ?>][entryitemid]" value="<?php echo $entrie_item['id']; ?>"><a class="btn btn-info" style="font-size: 15px;cursor: pointer;color: #fff;font-weight: bold;padding: 0px 5px;" onclick="remove(<?php echo $j; ?>)" id="remove">X</a></td>
																<td style="width: 30%;"><input type="hidden" name="entries[<?php echo $j; ?>][ledgerid]" id="edit_ledgerid_<?php echo $j; ?>" value="<?php echo $entrie_item['ledger_id']; ?>">
																<select class="form-control search_box" data-live-search="true" id="credit_note_accountname_new_<?php echo $j; ?>" onchange="edit_reselectledger(<?php echo $j; ?>,this.value)">
																	<option value="">Select ledger</option>
																	<?php
																	if(!empty($ledgers)) { foreach($ledgers as $ledger) {?><option value="<?php echo $ledger["id"]; ?>" <?php if(!empty($entrie_item['ledger_id'])){ if($entrie_item['ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option><?php } } ?>
																</select>
																</td>
																<td style="width: 20%;"><input type="text" style="text-align: center; background-color:#f6f6f6;" class="row_totdr" name="entries[<?php echo $j; ?>][dramt]" id="totdr_<?php echo $j; ?>" readonly value="0.00"></td>
																<td style="width: 20%;"><input type="text" style="text-align: center; background-color:field;" class="row_totcr" name="entries[<?php echo $j; ?>][cramt]" id="totcr_<?php echo $j; ?>" value="<?php echo $entrie_item['amount']; ?>" readonly></td>
																<?php /* <td style="width: 20%;"><input type="hidden" style="text-align: center;" class="" name="entries[<?php echo $j; ?>][particulars]" id="particulars_<?php echo $j; ?>" value="<?php echo $entrie_item['details']; ?>"><?php echo $entrie_item['details']; ?></td> */ ?>
															</tr>
																<?php
																	}
																	if($entrie_item['dc'] == "D")
																	{
																		$debit_total += $entrie_item['amount'];
																?>
															<tr class="all_close" data-id="<?php echo $entrie_item['ledger_id']; ?>" id="remov<?php echo $j; ?>">
																<td style="width:10%;"><input type="hidden" name="entries[<?php echo $j; ?>][entryitemid]" value="<?php echo $entrie_item['id']; ?>"><a class="btn btn-info" style="font-size: 15px;cursor: pointer;color: #fff;font-weight: bold;padding: 0px 5px;" onclick="remove(<?php echo $j; ?>)" id="remove">X</a></td>
																<td style="width: 30%;"><input type="hidden" name="entries[<?php echo $j; ?>][ledgerid]" id="edit_ledgerid_<?php echo $j; ?>" value="<?php echo $entrie_item['ledger_id']; ?>">
																<select class="form-control search_box" data-live-search="true" id="credit_note_accountname_new_<?php echo $j; ?>" onchange="edit_reselectledger(<?php echo $j; ?>,this.value)">
																	<option value="">Select ledger</option>
																	<?php
																	if(!empty($ledgers)) { foreach($ledgers as $ledger) {?><option value="<?php echo $ledger["id"]; ?>" <?php if(!empty($entrie_item['ledger_id'])){ if($entrie_item['ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option><?php } } ?>
																</select>
																</td>
																<td style="width: 20%;"><input type="text" style="text-align: center; background-color:field;" class="row_totdr" name="entries[<?php echo $j; ?>][dramt]" id="totdr_<?php echo $j; ?>" value="<?php echo $entrie_item['amount']; ?>" readonly></td>
																<td style="width: 20%;"><input type="text" style="text-align: center; background-color:#f6f6f6;" class="row_totcr" name="entries[<?php echo $j; ?>][cramt]" id="totcr_<?php echo $j; ?>" readonly value="0.00"></td>
																<?php /* <td style="width: 20%;"><input type="hidden" style="text-align: center;" class="" name="entries[<?php echo $j; ?>][particulars]" id="particulars_<?php echo $j; ?>" value="<?php echo $entrie_item['details']; ?>"><?php echo $entrie_item['details']; ?></td> */ ?>
															</tr>	
																<?php
																	}
															?>
															
															<?php
																$j++;
																}
															}
															echo '<input type="hidden" name="tot_row_cnt"  id="tot_row_cnt" value="' . $j. '">';
															?>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
									if($view != true){
									?>
									<div class="row">
										<div class="col-md-12" align="center">
											<?php 
											if($debit_total > 0 || $credit_total > 0){
												if($debit_total == $credit_total) $color = 'green';
												else $color = 'red';
											}else $color = 'red';
											?>
											<p style="font-size: 19px;font-weight: bold;color:<?= $color; ?>; text-align:center;" id="totl_debt_crdit_diff_color">
												<input type="hidden" value="<?= $debit_total; ?>" name="input_total_debit_balance" id="input_total_debit_balance" />
												<input type="hidden" value="<?= $credit_total; ?>" name="input_total_credit_balance" id="input_total_credit_balance" />
												<span>Total Debit Balance : </span><span id="total_debit_balance"><?= $debit_total; ?></span>,
												<span>Total Credit Balance : </span><span id="total_credit_balance"><?= $credit_total; ?></span>,
												<span>Difference : </span><span id="total_difference"><?= $credit_total; ?></span>
											</p>
										</div>
									</div>
									<?php
									}
									?>
								</div>
							</div>
						</form>
						<?php
						if($view != true){
						?>
                        <div class="row">      
                            <div class="col-sm-12" align="center">
                                <div class="form-group">
										<input  type="checkbox" checked="checked" id="print" name="print" value="Print">
										<label for ='print'> Print &nbsp;&nbsp; </label>
										<label id="submit" class="btn btn-success btn-lg waves-effect">Save</label>
                                </div>
                            </div>
                        </div>
						<?php
						}
						?>                
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
</section>

<script>
$(document).on('click', '#credit_note_amountdr, #credit_note_amountcr, .row_totcr, .row_totdr', function() {
	if($(this).val()=='0.00') {
		$(this).val('');
	}
});

$("#submit").click(function(){
	var entry_id= $('#entry_id'). val();
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/entries/update_credit_note_entries",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{					
					if ($("#print").prop('checked'))	
					{
						printData(obj.id);
					}
					else 
					{
						window.location.replace("<?php echo base_url();?>/entries/credit_note_edit/" + entry_id);
					}
                }
            }
        });
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/entries/print_page/"+id,
            type: 'POST',
            success: function (result) {
                //console.log(result)
                popup(result);
            }
        });
    }

    function popup(data)
    {
		var entry_id= $('#entry_id'). val();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body >');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            window.location.reload(true);
        }, 500);

        frame1.remove();
        window.location.replace("<?php echo base_url();?>/entries/credit_note_edit/" + entry_id);
        //return true;
    }

$(document).ready(function(){
	$("#credit_note_amountdr").keyup(function(){
		var dramt = $("#credit_note_amountdr").val();
		if(parseInt(dramt) == "0" || dramt == "" || dramt == "NaN"){
			$("#credit_note_amountcr").prop("readonly",false);
			$("#credit_note_amountcr").css("background","#ffffff");
			var dramt_ret = "0.00";
		}
		else
		{
			$("#credit_note_amountcr").prop("readonly",true);
			$("#credit_note_amountcr").css("background","#f6f6f6");
			var dramt_ret = dramt;
		}
		//console.log(dramt);
	});
	
	$("#credit_note_amountcr").keyup(function(){
		var cramt = $("#credit_note_amountcr").val();
		if(parseInt(cramt) == "0" || cramt == "" || cramt == "NaN"){
			$("#credit_note_amountdr").prop("readonly",false);
			$("#credit_note_amountdr").css("background","#ffffff");
			var cramt_ret = "0.00";
		}
		else
		{
			$("#credit_note_amountdr").prop("readonly",true);
			$("#credit_note_amountdr").css("background","#f6f6f6");
			var cramt_ret = cramt;
		}
		//console.log(cramt);
	});
	
});



$(document).ready(function(){
	console.log( $('#tot_row_cnt').val());
	var i = (($('#tot_row_cnt').val() != '') ? $('#tot_row_cnt').val() - 1 : 1);
	$('#addCreditDebitdetail').click(function(){
		var account_name = $("#credit_note_accountname").val();
		var dramt = Number($("#credit_note_amountdr").val()).toFixed(2);
		var cramt = Number($("#credit_note_amountcr").val()).toFixed(2);
		// var credit_note_particulars = $("#credit_note_particulars").val();
		if(account_name != '' && (dramt != "0.00" && dramt != "0" || cramt != "0.00" && cramt != "0")){
			i++;
			var ledgername = getladgerName(account_name,i);
			var text1 = '<tr class="all_close" data-id="'+account_name+'" id="remov'+i+'"><td style="width:10%;"><a class="btn btn-info" style="font-size: 15px;cursor: pointer;color: #fff;font-weight: bold;padding: 0px 5px;" onclick="remove('+i+')" id="remove">X</a></td>';
			text1 += '<td style="width: 30%;"><input type="hidden" style="text-align: center;" id="ledgerid_'+i+'" class="row_amt" name="entries['+i+'][ledgerid]" value="'+account_name+'"><select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" id="credit_note_accountname_new_'+i+'" onchange="reselectledger('+i+',this.value)"><option value="">Select ledger</option><?php
			if(!empty($ledgers)) { foreach($ledgers as $ledger) {?><option value="<?php echo $ledger["id"]; ?>"><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option><?php } } ?></select></td>';
			text1 += '<td style="width: 20%;"><input type="hidden" style="text-align: center;" class="row_totdr" name="entries['+i+'][dramt]" id="totdr_'+i+'" value="'+dramt+'" readonly>'+dramt+'</td>';
			text1 += '<td style="width: 20%;"><input type="hidden" style="text-align: center;" class="row_totcr" name="entries['+i+'][cramt]" id="totcr_'+i+'" value="'+cramt+'" readonly>'+cramt+'</td>';
			// text1 += '<td style="width: 20%;"><input type="hidden" style="text-align: center;" class="" name="entries['+i+'][particulars]" id="particulars_'+i+'" value="'+credit_note_particulars+'">'+credit_note_particulars+'</td>';
			text1 += '</tr>';
			$(".cart-table").append(text1);
			sum_total();
			$("#credit_note_accountname_new_"+i).prop('selected',true).val(account_name);
			$("#credit_note_accountname_new_"+i).selectpicker("refresh");
			$('#credit_note_accountname').prop('selectedIndex',0);
			$("#credit_note_accountname").selectpicker("refresh");
			// $("#credit_note_particulars").val("");
			$("#credit_note_amountdr").val("0.00");
			$("#credit_note_amountcr").val("0.00");
			$("#credit_note_amountdr").css("background","#ffffff");
			$("#credit_note_amountcr").css("background","#ffffff");
			$("#credit_note_amountdr").prop("readonly",false);
			$("#credit_note_amountcr").prop("readonly",false);
		}
	});
	$(document).on('keyup', '.row_totdr', function(){
		var dramt = this.value;
		if(parseInt(dramt) == "0" || dramt == "" || dramt == "NaN"){
			$(this).parent().parent().find(".row_totcr").prop("readonly",false);
			$(this).parent().parent().find(".row_totcr").css("background-color","field");
			// $("#credit_note_amountcr").css("background","#ffffff");
		}
		else
		{
			$(this).parent().parent().find(".row_totcr").prop("readonly",true);
			$(this).parent().parent().find(".row_totcr").css("background-color","#f6f6f6");
			// $("#credit_note_amountcr").css("background","#f6f6f6");
		}
		sum_total();
		//console.log(cramt);
	});
	
	$(document).on('keyup', '.row_totcr', function(){
		var cramt = this.value;
		if(parseInt(cramt) == "0" || cramt == "" || cramt == "NaN"){
			$(this).parent().parent().find(".row_totdr").prop("readonly",false);
			$(this).parent().parent().find(".row_totdr").css("background-color","field");
			// $("#credit_note_amountdr").css("background","#ffffff");
		}
		else
		{
			$(this).parent().parent().find(".row_totdr").prop("readonly",true);
			$(this).parent().parent().find(".row_totdr").css("background-color","#f6f6f6");
			// $("#credit_note_amountdr").css("background","#f6f6f6");
		}
		sum_total();
		//console.log(cramt);
	});
});
function reselectledger(incid,id){
	$("#ledgerid_"+incid).val(id);
	$("#remov"+incid).attr("data-id", id);
}
function edit_reselectledger(incid,id){
	$("#edit_ledgerid_"+incid).val(id);
	$("#remov"+incid).attr("data-id", id);
}
function getladgerName(ledgerid, incid) {  
	$.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>/entries/getladgerName",
		data:{ledger_id: ledgerid},
		success:function(data){
			$('#ledgername_'+incid).text(data);
		}
	});
}
function remove(id){
	$(".cart-table #remov"+id).remove();
	sum_total();
}
$("#clear_credit_debit_ac").click(function() {
	$('#credit_note_accountname').prop('selectedIndex',0);
	$("#credit_note_accountname").selectpicker("refresh");
	$("#credit_note_particulars").val("");
	$("#credit_note_amountdr").val("0.00");
	$("#credit_note_amountcr").val("0.00");
	$("#credit_note_amountdr").css("background","#ffffff");
	$("#credit_note_amountcr").css("background","#ffffff");
	$("#credit_note_amountdr").prop("readonly",false);
	$("#credit_note_amountcr").prop("readonly",false);
	sum_total();
});

function sum_total(){
	var total_amtdr = 0;
	$( ".row_totdr" ).each(function() {
		total_amtdr += parseFloat($( this ).val());
	});
	
	var total_amtcr = 0;
	$( ".row_totcr" ).each(function() {
		total_amtcr += parseFloat($( this ).val());
	});
	
	$("#tot_amt").val(Number(total_amtdr).toFixed(2));
	$("#input_total_debit_balance").val(Number(total_amtdr).toFixed(2));
	$("#input_total_credit_balance").val(Number(total_amtcr).toFixed(2));
	$("#total_debit_balance").text(Number(total_amtdr).toFixed(2));
	$("#total_credit_balance").text(Number(total_amtcr).toFixed(2));
	
	if(total_amtcr == total_amtdr)
	{
		$("#totl_debt_crdit_diff_color").css("color","#000000");
	}
	else
	{
		$("#totl_debt_crdit_diff_color").css("color","red");
	}
	
	var tot_dbt_diff = Number(total_amtdr).toFixed(2);
	var tot_crt_diff = Number(total_amtcr).toFixed(2);
	var tot_diff = tot_dbt_diff - tot_crt_diff;
	var posNum = (tot_diff < 0) ? tot_diff * -1 : tot_diff;
	$("#total_difference").text(Number(posNum).toFixed(2));
}

$("#clear_all").click(function() {
	$(".cart-table .all_close").empty();
	$('#credit_note_accountname').prop('selectedIndex',0);
	$("#credit_note_accountname").selectpicker("refresh");
	$("#credit_note_particulars").val("");
	$("#credit_note_amountdr").val("");
	$("#credit_note_amountcr").val("");
	sum_total();
});
</script>