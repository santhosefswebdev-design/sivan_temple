<style>
/*body { background:#fff; }
.content { max-width: 100%; padding: 0 .2rem; }*/
.table-responsive {
    overflow-x: inherit !important;
    overflow-y: inherit !important;
}
</style>
<section class="content">
    <div class="container-fluid">
        <!--<div class="block-header">-->
<?php 
$db = db_connect();

if($results['entrytype_id'] == 1) {
	$type = 'Receipt';
} else if($results['entrytype_id'] == 2) {
	$type = 'Payment';
} else if($results['entrytype_id'] == 3) {
	$type = 'Contra';
} else if($results['entrytype_id'] == 4) {
	$type = 'Journal';
}
function AmountInWords(float $amount)
{
	
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    //echo $amount_after_decimal;
   // $amount="50.50";
   // echo $amount;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
   
   // if ($amount_after_decimal<10)
   // {
   // $get_paise = ($amount_after_decimal > 0) ? "and ".($change_words[$amount_after_decimal /(($amount_after_decimal < 10) ? "10" : "1")]." 
   // ". $change_words[$amount_after_decimal % 10]) .' Cents ' : '';
	$get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal /10]).' '. trim($change_words[$amount_after_decimal % 10]))  : '';

   // }
   // else {
   // $get_paise = ($amount_after_decimal > 0) ? "and ".($change_words[$amount_after_decimal ]." 
   // ". $change_words[$amount_after_decimal % 10]) .' Cents ' : '';
   // }
   //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
   return ($implode_to_Rupees ? 'Ringgit '.$implode_to_Rupees : ''). $get_paise. ' Only' ;
}
?>
            <!-- <h2> ENTRIES <small style="font-size: 14px;">Account / <b>View <?= $type ?> Entry</b></small></h2>
        </div>


        Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-12" align="right">
                                <a class="btn bg-deep-purple waves-effect" href="<?php echo base_url();?>/account/entries">List</a>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                            <!--<input type="hidden" name="id" id="id" value="<?php //echo $data['id'];?>">-->
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div >
                                                <label class="form-label">Date </label> : <b><?= date('d-M-Y',strtotime($results['date']))?></b>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div >
                                                <label class="form-label">Entry Code </label> : <b><?= $results['entry_code']; ?></b>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    <label style="padding-left: 20px;" class="control-label">Paid To</label> : <b> <?= $results['paid_to'] ?></b>
								    </div>
                                
                                </div>
								
								<table border="1" >
									<thead> 
										<tr>
											<th style="width:10%;text-align:center;">Dr/Cr</th>
											<th style="width:30%;text-align:center;">Ledger</th>
											<th style="width:30%;text-align:center;">Details</th>
											<th style="width:10%;text-align:center;">Dr Amount</th>
											<th style="width:10%;text-align:center;">Cr Amount</th>
											
										</tr>   
									</thead>
									<tbody>
									<?php										
											
									foreach($results2 as $key) {
										
											if($key['dc']=='D') {
												$debit_amt = number_format($key['amount'],2);
												$credit_amt = '';
											} else {
												$credit_amt = $key['amount'];
												$debit_amt = '';
											}
											if($key['dc'] == 'D') {
												$dc = 'Dr';
											} else {
												$dc = 'Cr';
											}
											$ledgername = get_ledger_name($key['ledger_id']);
										?>
										<tr>
										<td style="text-align:center;"><?= $dc?></td>
										<td><?= $ledgername?></td>
										<td><?= $key['details']?></td>
										<td style="text-align:right;"><?= $debit_amt?></td>
										<td style="text-align:right;"><?= $credit_amt?></td>  
										</tr>
										<?php } ?>
										<tr>
											
											<td colspan="3" style="text-align:right;"><b>Total</b></td>
											<td style="text-align:right;"><b>Dr <?= number_format($results['dr_total'],2)?></b></td>
											<td style="text-align:right;"><b>Cr <?= number_format($results['cr_total'],2)?></b></td>
										</tr>
										</tbody>
								</table >
								<hr>
								<br>
								<div class="col-md-12" >
                                    <label style="padding-left: 20px;" class="control-label">Payment Mode</label> : <b> <?= $results['payment'] ?></b>
								</div>
                                
                                
                                <div id="hiden_item" <?php if($results['payment'] == 'cash' || $results['payment'] == '') echo 'style="display: none;"' ?>>
                                                <div class="col-md-12 box"><h4 id="name"><?php if($results['payment'] == 'cheque') echo 'Cheque '; else if($results['payment'] == 'online') echo 'Transaction '; else echo 'TC ' ?> Detail</h4>    
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                                <label style="display: contents;" class="form-label  cheque_no"><?php if($results['payment'] == 'cheque') echo 'Cheque '; else if($results['payment'] == 'online') echo 'Transaction '; else echo 'TC ' ?> No</label>
                                                                <br><label><?php echo $results['cheque_no']; ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                                <label style="display: contents;" class="form-label  cheque_date"><?php if($results['payment'] == 'cheque') echo 'Cheque '; else if($results['payment'] == 'online') echo 'Transaction '; else echo 'TC ' ?> Date</label>
                                                                <br><label><?php echo date('d-M-Y',strtotime($results['cheque_date'])); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                                <label style="display: contents;" class="form-label status">Status</label>
                                                                <br><label><?php echo $results['status']; ?></label>
                                                        </div>
                                                    </div>
                                                    <div id="hiden_item1"  <?php if($results['payment'] == 'cheque' && $results['status'] == 'returned') {} else echo 'style="display:none;"'; ?>>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                    <label style="display: contents;" class="form-label">Return Date</label>
                                                                    <br><label><?php echo date('d-M-Y',strtotime($results['return_date'])); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <label style="display: contents;" class="form-label">Extra Charge</label>
                                                                    <br><label><?php echo $results['extra_charge']; ?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="hiden_item2"  <?php if($results['payment'] == 'cheque' && $results['status'] == 'complete') {} else echo 'style="display:none;"'; ?>>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                    <label style="display: contents;" class="form-label">Collection Date</label>
                                                                    <br><label><?php echo date('d-M-Y',strtotime($results['collection_date'])); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



								<div class="col-md-12">
								    <label style="padding-left: 20px;" class="control-label">Amount In Words</label> : <b> <?= AmountInWords($results['cr_total']) ?></b>
								</div>
                                <div class="col-md-12">
								    <label style="padding-left: 20px;" class="control-label">Narration</label> : <b> <?= $results['narration'] ?></b>
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
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
</script>

<script>
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/ubayam/save",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    printData(obj.id);
                }
            }
        });
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/ubayam/print_page/"+id,
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
        window.location.replace("<?php echo base_url();?>/ubayam");
        //return true;
    }

</script>