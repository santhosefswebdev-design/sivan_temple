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
</style>
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
							<?php if($_SESSION['succ'] != '') { ?>
							<div class="row" style="padding: 0 30%;" id="content_alert">
								<div class="suc-alert">
									<span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
									<p><?php echo $_SESSION['succ']; ?></p> 
								</div>
							</div> 
							<?php } ?>
							<?php if($_SESSION['fail'] != '') { ?>
							<div class="row" style="padding: 0 30%;" id="content_alert">
								<div class="alert">
									<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
									<p><?php echo $_SESSION['fail']; ?></p>
								</div>
							</div>
							<?php } ?>
                        <form id="payment_store_validation" >
						<input type="hidden" id="entry_type_id" name="entry_type_id" value="<?= $en_id; ?>" >
						<input type="hidden" id="entry_id" name="entry_id" value="<?php if(!empty($entries['id'])){ echo $entries['id']; }?>" >
						<div class="row">
							<div class="col-md-6">
								<div class="row">
								    <div class="col-md-4">
										<div class="form-group">
											<label class="floating-label" for="Text">Date </label>
											<input type="date" class="form-control" name="payment_date" id="payment_date" value="<?php if(!empty($entries['date'])) echo date("Y-m-d",strtotime($entries['date'])); else echo date("Y-m-d");?>" autocomplete="off" <?php echo $disabled; ?>>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="floating-label" for="Text">Payment Mode</label>
											<select class="form-control" name="payment_paymode" id="payment_paymode" <?php echo $disabled; ?>>
												<option value="">Select payment mode</option>
												<option value="cash" <?php if(!empty($entries['payment'])){ if($entries['payment'] == "cash"){ echo "selected"; }} ?>>Cash</option>
												<option value="cheque" <?php if(!empty($entries['payment'])){ if($entries['payment'] == "cheque"){ echo "selected"; }} ?>>Cheque</option>
												<option value="online" <?php if(!empty($entries['payment'])){ if($entries['payment'] == "online"){ echo "selected"; }} ?>>Online Payment</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label class="floating-label" for="Text">Credit A/C</label>
											<select class="form-control search_box" data-live-search="true" name="payment_debit_ac" id="payment_debit_ac" <?php echo $disabled; ?>>
												<option value="0">Select credit a/c</option>
												<?php
												if(!empty($bank_ledgers))
												{
													foreach($bank_ledgers as $ledger)
													{
												?>
													<option value="<?php echo $ledger["id"]; ?>"  <?php if(!empty($credit_ledger['ledger_id'])){ if($credit_ledger['ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo '(' . $ledger['left_code'] . '/' . $ledger['right_code'] . ") - ".$ledger["name"]; ?> </option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="floating-label" for="Text">Entry Code</label>
											<input type="text" class="form-control" name="payment_entrycode" id="payment_entrycode" value="<?php echo $entry_code; ?>" readonly autocomplete="off">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="floating-label" for="Text">Paid To</label>
											<input type="text" class="form-control" name="payment_receivedfrom" id="payment_receivedfrom" autocomplete="off" <?php echo $readonly; ?>>
										</div>
									</div>
								</div>
								
								<div id="row_cheque" style="display:<?php if(!empty($entries['payment'])){ if($entries['payment'] == "cheque"){ echo "block!important"; } else { echo "none!important"; } }else { echo "none!important"; } ?>">
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading" style="color: #fff;background-color: #f44336;border-color: #f44336;padding: 5px 15px;">Cheque Detail</div>
												<div class="panel-body" style="border: 1px solid #f44336;padding: 10px;">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="floating-label" for="Text">Cheque No</label>
																<input type="text" class="form-control" name="payment_chequeno" id="payment_chequeno" autocomplete="off" value="<?php if(!empty($entries['cheque_no'])){ echo $entries['cheque_no']; }?>" <?php echo $readonly; ?>>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="floating-label" for="Text">Cheque Date</label>
																<input type="date" class="form-control" name="payment_chequedate" id="payment_chequedate" autocomplete="off" value="<?php if(!empty($entries['cheque_date'])){ echo $entries['cheque_date']; }?>" <?php echo $readonly; ?>>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">&nbsp;</div>
								</div>
								<div id="row_transaction_online" style="display:<?php if(!empty($entries['payment'])){ if($entries['payment'] == "online"){ echo "block!important"; } else { echo "none!important"; } }else { echo "none!important";} ?>">
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading" style="color: #fff;background-color: #f44336;border-color: #f44336;padding: 5px 15px;" id="transaction_online_title"></div>
												<div class="panel-body" style="border: 1px solid #f44336;padding: 10px;">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label class="floating-label" for="Text">Ref. No</label>
																<input type="text" class="form-control" name="payment_refno" id="payment_refno"  autocomplete="off" value="<?php if(!empty($entries['cheque_no'])){ echo $entries['cheque_no']; }?>" <?php echo $readonly; ?>>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="floating-label" for="Text">Transaction Date</label>
																<input type="date" class="form-control" name="payment_transactiondate" id="payment_transactiondate" autocomplete="off" value="<?php if(!empty($entries['cheque_date'])){ echo $entries['cheque_date']; }?>" <?php echo $readonly; ?>>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">&nbsp;</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-primary">
											<div class="panel-heading" style="color: #fff;background-color: #f44336;border-color: #f44336;padding: 5px 15px;">Payment Particulars</div>
											<div class="panel-body" style="border: 1px solid #f44336;padding: 10px;">
												<textarea class="form-control" name="payment_particulars" id="payment_particulars" <?php echo $readonly; ?>><?php if(!empty($credit_ledger['details'])){ echo $credit_ledger['details']; }?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="row">&nbsp;</div>
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-primary">
											<div class="panel-heading" style="color: #fff;background-color: #f44336;border-color: #f44336;padding: 5px 15px;">Amount in Words</div>
											<div class="panel-body" style="border: 1px solid #f44336;padding: 10px;">
												<p style="margin: 0px;font-size: 20px;font-weight: bold;"><span> RM </span> <span id="tot_amt_parag"><?php if(!empty($entries['dr_total'])){ echo $entries['dr_total']; }else { echo "0.00";}?></span>
												<input type="hidden" name="tot_amt_input" id="tot_amt_input" value="<?php if(!empty($entries['dr_total'])){ echo $entries['dr_total']; }else { echo "0.00";}?>">
											</p>
												<p style="margin: 0px;font-size: 20px;font-weight: bold;text-transform: uppercase;" id="tot_amt_txt"></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<?php
								if($view != true){
								?>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label class="floating-label" for="Text">Debit A/C</label>
											<select class="form-control search_box" data-live-search="true" name="payment_credit_ac" id="payment_credit_ac" <?php echo $disabled; ?>>
												<option value="0">Select debit a/c</option>
												<?php
												if(!empty($ledgers))
												{
													foreach($ledgers as $ledger)
													{
												?>
													<option value="<?php echo $ledger["id"]; ?>"><?php echo '(' . $ledger['left_code'] . '/' . $ledger['right_code'] . ") - ".$ledger["name"]; ?> </option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label class="floating-label" for="Text">Amount</label>
											<input type="number" min="0" step="any" value="0.00" class="form-control" name="payment_amount" id="payment_amount" autocomplete="off" <?php echo $readonly; ?>>
										</div>
									</div>
									<div class="col-md-4" style="margin-top:23px;">
										<a class="btn btn-primary" id="addcreditdetail" style="padding: 5px 15px;color:#fff;cursor: pointer;">Add</a>
										<a class="btn btn-secondary" id="clear_credit_ac" style="padding: 5px 15px;cursor: pointer;"> Clear</a>
									</div>
								</div>
								<div class="row">&nbsp;</div>
								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-primary">
											<div class="panel-heading" style="color: #fff;background-color: #f44336;border-color: #f44336;padding: 5px 15px;">Detail Particulars</div>
											<div class="panel-body" style="border: 1px solid #f44336;padding: 10px;">
												<textarea class="form-control" name="payment_detail_particulars" id="payment_detail_particulars" <?php echo $readonly; ?>></textarea>
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
											<div class="panel-heading" style="color: #fff;background-color: #f44336;border-color: #f44336;padding: 5px 15px;">Payment Details</div>
											<div class="panel-body scroll" style="border: 1px solid #f44336;padding: 10px;overflow-y: auto;height:250px;">
												<!--<div class="tableFixHead">-->
													<input type="hidden" class="tot" id="tot_amt" name="tot_amt" value="0.00">
													<table class="table table-bordered cart-table" style="overflow-y: scroll;height:150px;">
														<thead class="thead-light">
															<tr>
																<?php
																if($view != true){
																?>
																<th style="width: 10%;">#</th>
																<?php
																}
																?>	
																<th style="width: 50%;">Account</th>
																<th style="width: 10%;">Amount</th>
																<th style="width: 30%;">Details</th>
															</tr>
														</thead>
														<tbody >
														<?php
															if(!empty($entrie_items))
															{
																$j=1;
																foreach($entrie_items as $entrie_item)
																{
																	$ledger_name = $db->table('ledgers')->select('name')->where('id', $entrie_item['ledger_id'])->get()->getRowArray();
															?>
															<tr class="all_close" data-id="<?php echo $entrie_item['ledger_id']; ?>" >
																<?php
																if($view != true){
																?>
																<td><input type="hidden" name="entries[<?php echo $j; ?>][entryitemid]" value="<?php echo $entrie_item['id']; ?>"></td>
																<?php
																}
																?>	
																<td><input type="hidden" style="text-align: center;" class="row_amt" name="entries[<?php echo $j; ?>][ledgerid]" value="<?php echo $entrie_item['ledger_id']; ?>"><span id="ledgername_<?php echo $j; ?>"><?php echo $ledger_name['name']; ?></span></td>
																<td><input type="hidden" style="text-align: center;" class="row_tot" id="tot_<?php echo $j; ?>" value="<?php echo $entrie_item['amount']; ?>"><input type="hidden" style="text-align: center;" class="row_qty" name="entries[<?php echo $j; ?>][amount]" id="qty_<?php echo $j; ?>" value="<?php echo $entrie_item['amount']; ?>"><?php echo $entrie_item['amount']; ?></td>
																<td><input type="hidden" style="text-align: center;" class="" name="entries[<?php echo $j; ?>][particulars]" id="particulars_<?php echo $j; ?>" value="<?php echo $entrie_item['details']; ?>"><?php echo $entrie_item['details']; ?></td>
															</tr>
															<?php
																$j++;
																}
															}
															?>
														</tbody>
													</table>
												<!--</div>-->
											</div>
										</div>
									</div>
								</div>
								
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
										
                                    <!--<button id="submit" class="btn btn-success">Save</button>-->
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
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/entries/save_payment_entries",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{	
					if($("#print").prop('checked'))	
					{
						printData(obj.id);
					}
					else 
					{
						window.location.replace("<?php echo base_url();?>/entries/payment_add");
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
        window.location.replace("<?php echo base_url();?>/entries/payment_add");
        //return true;
    }

$(document).ready(function(){
	$('#payment_debit_ac').change(function(){
		var payment_debit_ac = $("#payment_debit_ac").val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>/entries/payment_debit_ac",
			data:{rtdebit_ac: payment_debit_ac},
			success:function(data){
				$("#payment_credit_ac").empty();
				$('#payment_credit_ac').html(data);
				$('#payment_credit_ac').prop('selectedIndex',0);
				$("#payment_credit_ac").selectpicker("refresh");
			}
		});
	});
});


$(function() {
    $('#row_cheque').hide(); 
    $('#row_transaction_online').hide(); 
    $('#transaction_online_title').html("");
	$("#payment_refno").val("");
	$("#payment_transactiondate").val("");
	$("#payment_transactionstatus").val("");
	$("#payment_chequeno").val("");
	$("#payment_chequedate").val("");
	$("#payment_chequestatus").val("");
    $('#payment_paymode').change(function(){
		
		var payment_paymode = $("#payment_paymode").val();
        if($('#payment_paymode').val() == 'cheque') {
            $('#row_cheque').show(); 
			$("#payment_chequeno").val("");
			$("#payment_chequedate").val("");
			$("#payment_chequestatus").val("");
			
        } else {
            $('#row_cheque').hide();
			$("#payment_chequeno").val("");
			$("#payment_chequedate").val("");
			$("#payment_chequestatus").val("");
        }
		
		if($('#payment_paymode').val() == 'online') {
            $('#row_transaction_online').show();
			if(payment_paymode == 'online')
			{
				$("#transaction_online_title").html("Online");
				$("#payment_refno").val("");
				$("#payment_transactiondate").val("");
				$("#payment_transactionstatus").val("");
			}
        } else {
            $('#row_transaction_online').hide(); 
			$('#transaction_online_title').html("");
			$("#payment_refno").val("");
			$("#payment_transactiondate").val("");
			$("#payment_transactionstatus").val("");
        }
		
    });
	
	$('#row_cheque_returned_status').hide();
	$('#row_cheque_completed_status').hide();
	$("#payment_returndate").val("");
	$("#payment_extracharge").val("");
	$("#payment_collectiondate").val("");
	$('#payment_chequestatus').change(function(){
		var payment_chequestatus = $("#payment_chequestatus").val();
		if(payment_chequestatus == "Returned")
		{
			$('#row_cheque_returned_status').show();
			$('#row_cheque_completed_status').hide();
			$("#payment_collectiondate").val("");
		}
		else if(payment_chequestatus == "Completed")
		{
			$('#row_cheque_completed_status').show();
			$('#row_cheque_returned_status').hide();
			$("#payment_returndate").val("");
			$("#payment_extracharge").val("");
		}
		else
		{
			$('#row_cheque_returned_status').hide();
			$('#row_cheque_completed_status').hide();
			$("#payment_returndate").val("");
			$("#payment_extracharge").val("");
			$("#payment_collectiondate").val("");
		}
	});
});

$(document).ready(function(){
	var i= 1;
	$('#addcreditdetail').click(function(){
		var payment_credit_ac = $("#payment_credit_ac").val();
        var payment_amount = $("#payment_amount").val();  
      //  var cnt = parseInt($("#pay_row_count").val());
        if(payment_credit_ac != '' && payment_amount != "0.00" && payment_amount != "0"){
			i++;
			var credit_ac = $("#payment_credit_ac").val();
			var ledgername = getladgerName(credit_ac,i);
			var payment_detail_particulars = $("#payment_detail_particulars").val();
			var amt = Number($("#payment_amount").val()).toFixed(2);
			
			var text1 = '<tr class="all_close" data-id="'+credit_ac+'" id="remov'+i+'"><td><input type="hidden" name="entries['+i+'][entryitemid]"><a class="btn btn-info" style="font-size: 15px;cursor: pointer;color: #fff;font-weight: bold;padding: 0px 5px;" onclick="remove('+i+')" id="remove">X</a></td>';
			text1 += '<td><input type="hidden" style="text-align: center;" class="row_amt" name="entries['+i+'][ledgerid]" value="'+credit_ac+'"><span id="ledgername_'+i+'"></span></td>';
			text1 += '<td><input type="hidden" style="text-align: center;" class="row_tot" id="tot_'+i+'" value="'+amt+'"><input type="hidden" style="text-align: center;" class="row_qty" name="entries['+i+'][amount]" id="qty_'+i+'" value="'+amt+'">'+amt+'</td>';
			text1 += '<td><input type="hidden" style="text-align: center;" class="" name="entries['+i+'][particulars]" id="particulars_'+i+'" value="'+payment_detail_particulars+'">'+payment_detail_particulars+'</td>';
			text1 += '</tr>';
			$(".cart-table").append(text1);
			sum_total();
			$('#payment_credit_ac').prop('selectedIndex',0);
			$("#payment_credit_ac").selectpicker("refresh");
			$("#payment_detail_particulars").val("");
			$("#payment_amount").val("0.00");
		}
	});
});
	  
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
$("#clear_credit_ac").click(function() {
	$('#payment_credit_ac').prop('selectedIndex',0);
	$("#payment_credit_ac").selectpicker("refresh");
	$("#payment_detail_particulars").val("");
	$("#payment_amount").val("0.00");
	//sum_total();
});

function sum_total(){
	var total_qty = 0;
	$( ".row_qty" ).each(function() {
		total_qty += parseFloat($( this ).val());
	});
	/* $("#tot_qty").text(total_qty); */

	var total_amt = 0;
	$( ".row_tot" ).each(function() {
		total_amt += parseFloat($( this ).val());
	});
	$("#tot_amt").val(Number(total_amt).toFixed(2));
	$("#tot_amt_parag").text(Number(total_amt).toFixed(2));
	$("#tot_amt_input").val(Number(total_amt).toFixed(2));
	numberToWords(total_amt);
}

function numberToWords(number) {  
	$.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>/entries/AmountInWords",
		data:{number: number},
		success:function(data){
			$('#tot_amt_txt').html(data);
			//console.log(data)
			//return str.trim() + "";  
		}
	});
}

$("#clear_all").click(function() {
	$(".cart-table .all_close").empty();
	$("#payment_paymode").val("");
	$('#payment_debit_ac').prop('selectedIndex',0);
	$("#payment_debit_ac").selectpicker("refresh");
	$("#payment_receivedfrom").val("");
	$("#payment_chequeno").val("");
	$("#payment_chequedate").val("");
	$("#payment_chequestatus").val("");
	$("#payment_returndate").val("");
	$("#payment_extracharge").val("");
	$("#payment_collectiondate").val("");
	$("#payment_refno").val("");
	$("#payment_transactiondate").val("");
	$("#payment_transactionstatus").val("");
	$("#payment_particulars").val("");
	sum_total();
});
</script>