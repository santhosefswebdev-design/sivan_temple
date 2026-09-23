<style>
    <?php if($view == true) { ?>
    label.form-label span { display:none !important; color:transporant; }
    <?php } ?>
    input:read-only{
        background-color: #dbdbdb !important;
    }
	table tr td .btn {
		padding: 8px 12px !important; 
		margin: 0 3px !important;
	}
	.box { border:1px solid #a1a09f; padding:0 0 10px; }
	.box h4 { color:#FFFFFF; background:#a1a09f; padding:8px; margin:0; margin-bottom:10px; }
	/*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }*/
    .table-responsive {
        overflow-x: inherit !important;
        overflow-y: inherit !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
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
                        <!-- <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/ubayam"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div> -->
                    </div>
                    <div class="body">
                        <form action="" id="en_form" method="post">
                            <input type="hidden" id="entry_type_id" value="<?= $en_id; ?>" >  
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12" align="right">
                                        <a class="btn bg-deep-purple waves-effect" href="<?php echo base_url();?>/account/entries">List</a>
                                    </div>
                                <div>
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                           <div class="form-line">
                                                <label class="form-label">Entry Code</label>
                                                <input id="entry_code" type="text" readonly style="background-color: #fff !important;" class="form-control" name="entry_code" value="<?php echo $results['entry_code']; ?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container" >
                                                <label class="form-label">Date <span style="color: red;">*</span></label>
                                                <input type="date" name=""  readonly style="background-color: #fff !important;" id="dt" class="form-control"  value="<?php echo $results['date']; ?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="paid_to" value="<?php echo $results['paid_to']; ?>">
                                                <label class="form-label">Paid To</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                        <table class="table" id="en_table">
                                            <thead>
                                                <th style="width: 5%;">Dr/Cr</th>
                                                <th style="width: 30%;">Ledger</th>
                                                <th style="width: 30%;">Details</th>
                                                <th style="width: 10%;">Dr Amount</th>
                                                <th style="width: 10%;">Cr Amount</th>
                                                <th style="width: 3%;">&nbsp;</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach($results2 as $key => $row) { ?>
                                                <tr>
                                                    <td><?php if($row['dc'] == 'D') echo "Dr"; else echo 'Cr'; ?></td>
                                                    <td><?php echo $led_name[$key]; ?></td>
                                                    <td><?php echo $row['details']; ?></td>
                                                    <td><input type="text" readonly style="background-color: #fff !important; border: none;"  class="d_amt" value="<?php if($row['dc'] == 'D') echo $row['amount'];?>"></td>
                                                    <td><input type="text" readonly style="background-color: #fff !important; border: none;"  class="c_amt" value="<?php if($row['dc'] == 'C') echo $row['amount'];?>"></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="col-md-12" align="right">
                                            <label id="add_row" class="btn btn-success"><i class="fa fa-plus"></i></label>
                                            <input type="hidden" id="row_cnt" value="0">
                                        </div>
                                            <div class="col-md-8">
                                                <label>Total</label>
                                            </div>
                                            <div class="col-md-2" align="right">
                                                <label>
                                                    <input id="total_debit" name="total_debit" style="background-color: #fff !important;border:none;" type="text" value="<?php echo number_format($results['dr_total'],2); ?>" readonly>
                                                    <input type="hidden" value="<?php echo $results['dr_total']; ?>" name="sdr_total">
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <label>
                                                    <input id="total_credit" name="total_credit" style="background-color: #fff !important;border:none;" type="text" value="<?php echo number_format($results['cr_total'],2); ?>" readonly>
                                                    <input type="hidden" value="<?php echo $results['cr_total']; ?>" name="scr_total">
                                                </label>
                                            </div>

                                            <div class="col-md-8">
                                                <label>Difference</label>
                                            </div>
                                            <div class="col-md-2" align="right">
                                                <label><input  id="diff_debit" style="background-color: #fff !important; border: none;" type="text" readonly></label>
                                            </div>
                                            <div class="col-md-2">
                                                <label><input  id="diff_credit" style="background-color: #fff !important; border: none;" type="text" readonly></label>
                                            </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="form-label"  style="display: contents;">Payment Method <span style="color: red;">*</span></label>
                                                    <select class="form-control" name="payment" id="payment">
                                                        <option <?php if($results['payment'] == 'cash') echo 'selected'; ?> value="cash">Cash</option>
                                                        <option <?php if($results['payment'] == 'cheque') echo 'selected'; ?> value="cheque">Cheque</option>
                                                        <option <?php if($results['payment'] == 'online') echo 'selected'; ?> value="online">Online</option>
                                                        <option <?php if($results['payment'] == 'tc') echo 'selected'; ?> value="tc">TC</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                            <div id="hiden_item" <?php if($results['payment'] == 'cash' || $results['payment'] == '') echo 'style="display: none;"' ?>>
                                                <div class="col-md-12 box"><h4 id="name"><?php if($results['payment'] == 'cheque') echo 'Cheque '; else if($results['payment'] == 'online') echo 'Transaction '; else echo 'TC ' ?> Detail</h4>    
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label style="display: contents;" class="form-label  cheque_no"><?php if($results['payment'] == 'cheque') echo 'Cheque '; else if($results['payment'] == 'online') echo 'Transaction '; else echo 'TC ' ?> No</label>
                                                                <input type="text" name="cheque_no" class="form-control cheque_details" value="<?php echo $results['cheque_no']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label style="display: contents;" class="form-label  cheque_date"><?php if($results['payment'] == 'cheque') echo 'Cheque '; else if($results['payment'] == 'online') echo 'Transaction '; else echo 'TC ' ?> Date</label>
                                                                <input type="date" name="cheque_date" class="form-control cheque_details" value="<?php echo $results['cheque_date']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label style="display: contents;" class="form-label status">Status</label>
                                                                <select class="form-control" name="status" id="status">
                                                                <option <?php if($results['status'] == 'process') echo 'selected'; ?> value="process">Process</option>
                                                                <option <?php if($results['status'] == 'returned') echo 'selected'; ?> value="returned">Returned</option>
                                                                <option <?php if($results['status'] == 'complete') echo 'selected'; ?> value="complete">Complete</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="hiden_item1"  <?php if($results['payment'] == 'cheque' && $results['status'] == 'returned') {} else echo 'style="display:none;"'; ?>>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <label style="display: contents;" class="form-label">Return Date</label>
                                                                    <input type="date" name="return_date" class="form-control hid1" value="<?php echo $results['return_date']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <label style="display: contents;" class="form-label">Extra Charge</label>
                                                                    <input type="text" name="extra_charge" class="form-control hid1" value="<?php echo $results['extra_charge']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="hiden_item2"  <?php if($results['payment'] == 'cheque' && $results['status'] == 'complete') {} else echo 'style="display:none;"'; ?>>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <label style="display: contents;" class="form-label">Collection Date</label>
                                                                    <input type="date" name="collection_date" class="form-control hid2" value="<?php echo $results['collection_date']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <div id="hiden_item3">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label style="display: contents;" class="form-label">Amount in Words</label>
                                                    <input type="text" style="background-color: #fff !important;" class="form-control" readonly id="amount_in_words">
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--<div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label style="display: contents;" class="form-label">Paid To</label>
                                                    <input type="text" class="form-control" name="paid_to"">
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label style="display: contents;" class="form-label">Narration</label>
                                                    <textarea class="form-control" row="10" name="narration"><?php echo $results['narration']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">      
                            <div class="col-sm-12" align="center">
                                <div class="form-group">
									<input  type="checkbox"  id="print" name="print" value="Print">
									<label for ='print'> Print &nbsp;&nbsp; </label>
									<label id="submit" class="btn btn-success btn-lg waves-effect">Save</label>
									
                                    <!--<button id="submit" class="btn btn-success">Save</button>-->                                </div>
                            </div>
                        </div>                  
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

<script type="text/javascript">

$("#submit").click(function(){
	
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/entries/update_entries/<?= $en_id ?>",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
				console.log (obj.err);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{					
					if ($("#print").prop('checked')==true)	
						{
							
							printData(obj.id);
						}
						else 
							window.location.replace("<?php echo base_url();?>/account/entries");
                }
            }
        });
    });  

    function printData(id) {
		//alert(id)
		
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
        window.location.replace("<?php echo base_url();?>/account/entries");
        //return true;
    }
	
$(document).ready(function () {
	//$('#hiden_item').hide();
	//$('#hiden_item1').hide();
	//$('#hiden_item2').hide();
	$('#payment').change(function () {
        $('.hid1').val('');
        $('.hid2').val('');
		var a = $(this).val();
		//alert(a);
        $('.cheque_details').val('');
		if (a == 'cheque') {
			$('#hiden_item').show();
			$('#hiden_item1').hide();
			$('#hiden_item2').hide();
			$('#name').text('Cheque Detail');
			$('.cheque_no').text('Cheque No');
			$('.cheque_date').text('Cheque date');
			//$('#hiden_item3').show();
			$('#status').change(function () {
                $('.hid1').val('');
                $('.hid2').val('');
				var b = $(this).val();
				if (a == 'cheque' && b == 'returned') {
					$('#hiden_item1').show();
					$('#hiden_item2').hide();
				} else if (a == 'cheque' && b == 'complete') {
					$('#hiden_item1').hide();
					$('#hiden_item2').show();
				} else {
					$('#hiden_item1').hide();
					$('#hiden_item2').hide();
				}
			});
		} else if(a == 'online') {
			$('#hiden_item').show();
            $('#hiden_item1').hide();
            $('#hiden_item2').hide();
			$('#name').text('Transaction Detail');
			$('.cheque_no').text('Transaction No');
			$('.cheque_date').text('Transaction date');
				$('#status').change(function () {
				var b = $(this).val();
				if (a == 'online' && b == 'returned') {
					$('#hiden_item1').hide();
					$('#hiden_item2').hide();
				} else if (a == 'online' && b == 'complete') {
					$('#hiden_item1').hide();
					$('#hiden_item2').hide();
				} else {
					$('#hiden_item1').hide();
					$('#hiden_item2').hide();
				}
			});
		} else  if(a == 'tc'){
			$('#hiden_item').show();
            $('#hiden_item1').hide();
            $('#hiden_item2').hide();
			$('#name').text('TC Detail');
			$('.cheque_no').text('TC No');
			$('.cheque_date').text('TC date');
				$('#status').change(function () {
				var b = $(this).val();
				if (a == 'tc' && b == 'returned') {
					$('#hiden_item1').hide();
					$('#hiden_item2').hide();
				} else if (a == 'tc' && b == 'complete') {
					$('#hiden_item1').hide();
					$('#hiden_item2').hide();
				} else {
					$('#hiden_item1').hide();
					$('#hiden_item2').hide();
				}
			});
		} else {
			$('#hiden_item').hide();
            $('#hiden_item1').hide();
            $('#hiden_item2').hide();
            //$('#hiden_item3').hide();
		}
	});
}); 
$(document).ready(function () {
    var en_type = $('#entry_type_id').val();
    if(en_type == 1) {  numberToWords(<?php echo $results['cr_total']; ?>);  }
    else {  numberToWords(<?php echo $results['dr_total']; ?>);  }

	$('#status').change(function () {
        $('.hid1').val('');
        $('.hid2').val('');
	});

});
    $("#status, #payment").change(function(){
        var b = $("#status").val();
        var a = $("#payment").val();
        if(a == 'cheque'){
            if (b === 'returned') {
                $('#hiden_item1').show();
                $('#hiden_item2').hide();
            } else if (b === 'complete') {
                $('#hiden_item1').hide();
                $('#hiden_item2').show();
            } else {
                $('#hiden_item1').hide();
                $('#hiden_item2').hide();
            }
        }
    });
	
    
    function drs_func(ids){
        var id = "drs"+ids;
        var data_id = ids;
        var drs_val = $("#"+id).val(); 
        if(drs_val == 'D'){
            $("#d_amt"+data_id).removeAttr("readonly"); 
            $("#c_amt"+data_id).attr("readonly","");
            $("#c_amt"+data_id).val('');
        }else{
            $("#c_amt"+data_id).removeAttr("readonly");
            $("#d_amt"+data_id).attr("readonly","");
            $("#d_amt"+data_id).val('');
        }
        sum_total();
    }

    $(".d_amt, .c_amt").keyup(function(){
        sum_total();
    });
    
    function sum_total(){
        var en_type = $('#entry_type_id').val();
        var total_damt = 0.00;
        $(".d_amt").each(function() {
            total_damt += parseFloat($(this).val()) || 0;
        });
        $('#total_debit').val(total_damt.toFixed(2));
        var total_camt = 0.00;
        $(".c_amt").each(function() {
            total_camt += parseFloat($(this).val()) || 0;
        });
        $('#total_credit').val(total_camt.toFixed(2));
        if(en_type == 1) {numberToWords(total_camt); }
        else { numberToWords(total_damt); }
        if(total_damt > total_camt){
            var diff = total_damt - total_camt;
            $("#diff_credit").val(diff.toFixed(2));
            $("#diff_debit").val('');
        }else{
            var diff = total_camt - total_damt;
            $("#diff_debit").val(diff.toFixed(2));
            $("#diff_credit").val('');
        }
    }

    $(".drs").change(function(){
        var id = $(this).attr("id");
        var data_id = $(this).attr("data-id");
        var drs_val = $("#"+id).val();
        if(drs_val == 'D'){
            $("#d_amt"+data_id).removeAttr("readonly");
            $("#c_amt"+data_id).attr("readonly","");
            $("#c_amt"+data_id).val('');
        }else{
            $("#c_amt"+data_id).removeAttr("readonly");
            $("#d_amt"+data_id).attr("readonly","");
            $("#d_amt"+data_id).val('');
        }
        sum_total();
    });

    $("#add_row").click(function(){
        var cnt = $("#row_cnt").val();
        var html = '<tr id="rem_row'+cnt+'">';
            html += '<td>';
            html += '<select class="form-control drs selectpicker" onchange="drs_func('+cnt+')" id="drs'+cnt+'" data-id="'+cnt+'" name="entries['+cnt+'][dc]">';
            html += '<option value="D">Dr</option>';
            html += '<option value="C">Cr</option>';
            html += '</select>';
            html += '</td>';
            html += '<td>';
            html += '<select class="form-control selectpicker" style="border: none !important;" name="entries['+cnt+'][ledger]">';
            html += '<option value="">--Select Option--</option>';
            html += '<?php foreach($ledger as $row) { echo addslashes($row);  }  ?>';
            html += '</select>';
            html += '</td>';
            html += '<td><input type="text" name="entries['+cnt+'][details]" class="form-control"></td>';
            html += '<td><input name="entries['+cnt+'][d_amt]" id="d_amt'+cnt+'" type="text" onkeyup="sum_total()" class="form-control d_amt"></td>';
            html += '<td><input readonly type="text" name="entries['+cnt+'][c_amt]" id="c_amt'+cnt+'" onkeyup="sum_total()" class="form-control c_amt"></td>';
            html += '<td><label class="btn btn-danger" onclick="remove_row('+cnt+')"><i class="fa fa-remove"></i></label></td>';
            html +=  '</tr>';
            $("#en_table").append(html);
            cnt++;
        $("#row_cnt").val(cnt++);
        sum_total();
        $('.selectpicker').selectpicker('refresh');
    });

    function remove_row(id){
        $("#rem_row"+id).remove();
        sum_total();
    }

	$("#clear").click(function(){
	   $("input").val("");
	});
    
	
    function numberToWords(number) {  
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>/dashboard/AmountInWords",
            data:{number: number},
            success:function(data){
                $('#amount_in_words').val(data);
                console.log(data)
                //return str.trim() + "";  
            }
        });
    }
</script>