<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }*/
	.table1{ border:1px solid #CCCCCC; }
	.table1 tr th { background-color:#EFEFEF; padding:5px; min-width:130px; font-size:16px; }
	.table1 tr td:first-child { padding:5px; text-align:left; }
	.table1 tr td { padding:5px; text-align:right;  }
</style>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" />-->

<script>
/*$(function() {
  $('.search_box').selectpicker();
});*/
</script>
<style>
/*.bootstrap-select .bs-searchbox:after {
    top: 7px;
    left: 10px;
    font-size: 14px;
}*/
.bootstrap-select.btn-group .dropdown-menu.inner {
    padding-bottom:50px;
}
</style>

<section class="content">
    <div class="container-fluid">
        <!-- <div class="block-header">
            <h2> ACCOUNT <small>Accounts / General Ledger</small></h2>
        </div>
        Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-4"><h2>General Ledger</h2></div>
                        <div class="col-md-8">
							<?php
                            if(count($check_financial_year) > 0)
                            {
                                $from_date = $check_financial_year[0]['from_year_month']."-01";
                                $from_date_re = date("d-m-Y", strtotime($from_date));
                                $to_date = $check_financial_year[0]['to_year_month']."-31";
                                $to_date_re = date("d-m-Y", strtotime($to_date));
                            ?>
                            <p style="font-weight: bold;font-size: 16px;text-transform: uppercase;">( Current Financial Year From <?php echo $from_date_re; ?> To <?php echo $to_date_re; ?> )</p>
                            <?php
                            }
                            ?>
					    </div>
                      <!-- <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/account"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div> -->
                        </div>
                    </div>
                    <div class="body" style="padding-top: 30px;"> 
                        <form action="<?php echo base_url(); ?>/accountreport/new_ledger_report" method="post">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="ledger[]" id="ledger" multiple="multiple">
                                                <?php foreach($ledger as $row){ ?>
                                                   <?php echo $row; ?>
                                              <?php  } // print_r($ledger); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control date_show" readonly>
                                            <label class="form-label date_show" id="date_show">Option</label>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="col-sm-2 date">
                                    <div class="form-group">
                                        <div class="form-line" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;">From Date</label>
                                            <input type="date"  name="fdate" id="fdate" class="form-control" value="<?php echo $fdate; ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                            <!--<label class="form-label">From Date</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 date">
                                    <div class="form-group">
                                        <div class="form-line" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;">To Date</label>
                                            <input type="date" name="tdate" id="tdate" class="form-control" value="<?php echo $tdate; ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                            <!--<label class="form-label">To Date</label>-->
                                        </div>
                                    </div>
                                </div>
                                <?php if($view != true) { ?>
                                <div class="col-sm-2" align="right">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                                    <label id="print" class="btn btn-primary btn-lg waves-effect">Print</label>
                                </div>
                                <?php } ?>
								
								
								<div class="col-md-12 col-sm-12" style="margin:0px;">                                    
    											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
    											<input name="pdf_archanaireport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_archanaireport" value="PDF">
    											<input name="excel_archanaireport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_archanaireport" value="EXCEL">
    										</div>
								
                                </div>
                                </div>
                     </form>
                           
                    <form style="display: none;" target="_blank" action="<?php echo base_url(); ?>/accountreport/print_multiple_ledger_statement" method="POST" id="print_ledger">
                        <input type="hidden"  name="print" id="print" class="form-control" value="1" >
                        <?php
                        foreach($ledger_id as $ledgerid_new){
                        ?>
                        <input type="hidden"  name="ledger[]" id="ledger" class="form-control" value="<?php echo $ledgerid_new; ?>" >
                        <?php
                        }
                        ?>
                        <input type="hidden"  name="fdate" id="fdate" class="form-control" value="<?php echo $fdate; ?>" >
                        <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?php echo $tdate; ?>">
                        <button type="submit" id="print_sub" class="btn btn-success">Submit</button>
                    </form>
	<?php
    foreach($ledger_id as $ledgerid){
        $ledgername_code = get_ledger_name($ledgerid);
        $res_ledger = loop_general_ledger_statement($ledgerid,$fdate, $tdate);
    ?>
    <h3 style="text-transform: uppercase;font-size: 18px;margin:15px 0px;"><?php echo $ledgername_code; ?></h3>
    <div class="table-responsive">
        <table class="table1" border="1" width="1000" align="center" style="border-collapse:collapse; font-family: Arial, Helvetica, sans-serif; font-size: 15px;">
            <thead>
                <tr style="padding: 15px 0;">
                    
                    <td width="10%" align="left" style="padding: 15px 5px;"><strong>Date</strong></td>
                    <td width="10%" align="left" style=""><strong>Ref No</strong></td>
                    <td width="25%" align="left" style="padding: 15px 5px;"><strong>Ledger</strong></td>
                    <td width="10%" align="right" style="padding: 15px 5px;"><strong>Debit Amount</strong></td>
                    <td width="10%" align="right" style="padding: 15px 5px;"><strong>Credit Amount</strong></td>
                    <td width="10%" align="right" style="padding: 15px 5px;"><strong>Net Activity</strong></td>
                    <td width="18%" align="right" style="padding: 15px 5px;"><strong>Balance Amount</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color:#F2F2F2;">
                    <td></td><td colspan="2">Opening Balance</td><td></td><td></td><td></td>
                    <td align="right" style="padding: 15px 5px;"><?php
                        if($res_ledger['op_bal'] < 0){
                            echo "( ".number_format(abs($res_ledger['op_bal']),'2','.',',')." )";
                        }
                        else{
                            echo number_format($res_ledger['op_bal'],'2','.',',');
                        }
                        ?></td>
                </tr> 
                <?php 
                $cu_credit = 0;
                $cu_debit = 0;
                foreach($res_ledger['data'] as $row) { 
                    if(!empty($row['credit_amount'])) $cu_credit += (float) $row['credit_amount'];
                    if(!empty($row['debit_amount'])) $cu_debit += (float) $row['debit_amount'];
                ?>
                    <tr>
                        <td style="padding: 6px 0;" ><?= date('d-m-Y',strtotime($row['date'])); ?></td>
                        <td align="left" style="padding: 6px 0;" ><?= $row['entry_code']; ?></td>
                        <td style="padding: 6px 0;" ><?= $row['ledger']; ?></td>
                        <td align="right" style="padding: 6px 0;" ><?= $row['debit']; ?></td>
                        <td align="right" style="padding: 6px 0;" ><?= $row['credit']; ?></td>
                        <td align="right" style="padding: 6px 0;" ></td>
                        <td align="right" style="padding: 6px 2px;" >
                            <?php
                            if($row['balance'] < 0){
                                echo "( ".number_format(abs($row['balance']),2)." )";
                            }
                            else{
                                echo number_format($row['balance'],2);
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr style="background-color: #F2F2F2;">
                    <td></td>
                    <td colspan="2">Closing Balance</td>
                    <td align="right"><?= number_format($cu_debit,'2','.',','); ?></td>
                    <td align="right"><?= number_format($cu_credit,'2','.',','); ?></td>
                    <td align="right">
                    <?php
                    $diffrence_amt = $cu_debit - $cu_credit;
                    echo number_format(abs($diffrence_amt),'2','.',',');
                    ?>
                    </td>
                    <td align="right" style="padding: 15px 5px;">
                        <?php
                        if($res_ledger['cl_bal'] < 0){
                            echo "( ".number_format(abs($res_ledger['cl_bal']),'2','.',',')." )";
                        }
                        else{
                            echo number_format($res_ledger['cl_bal'],'2','.',',');
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
    }
    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $(".date_show").click(function(){ 
            $(".date").slideToggle();
        });
    });

	$("#clear").click(function(){
	   $("input").val("");
	});

    // $(document).ready(function(){
    //                         $('.js-example-basic-single').select2();
    //                         $('.decimal').keyup(function(){
    //                             var val = $(this).val();
    //                             if(isNaN(val)){
    //                                 val = val.replace(/[^0-9\.]/g,'');
    //                                 if(val.split('.').length>2)
    //                                     val =val.replace(/\.+$/,"");
    //                             }
    //                             $(this).val(val);
    //                         });

    //                         //$('.datepicker-autoclose').datepicker({ autoclose: true, todayHighlight: true });
                           
    //                     });
</script>
<script type="text/javascript">
$(document).ready(function () {
                //Select2
                /*$("#ledger").select2({
                    maximumSelectionLength: 2,
                });*/
            });
$("#print").click(function(){
    $("#print_sub").trigger('click');
});
</script>