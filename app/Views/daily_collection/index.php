<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
.table th {
    padding: 5px !important;
}
.table td{
    padding: 3px !important;
    line-height: unset;
    border: none;
}

table, td, th {
    font-size: 12px!important;
    white-space: nowrap!important;
    text-transform: uppercase;
}

.table-sticky>thead>tr>th,
.table-sticky>thead>tr>td {
	top: 0px;
	position: sticky;
}
.table-height {
	height: 100%;
	/*display: block;
	overflow-y: scroll!important;*/
	width: 100%;
}

table {
	border-collapse: collapse;
	border-spacing: 0;
}
.table tbody tr td, .table tbody tr th {
    padding: 10px;
    border-top: none!important;
    border-bottom: none!important;
}

.table1{ border:1px solid #CCCCCC; }
.table1 tr th { background-color:#EFEFEF; padding:5px; min-width:120px; font-size:16px; }
.table1 tr td:first-child { padding:5px; text-align:left; }
.table1 tr td { padding:5px !important; text-align:right;  }
/* .table tr{ border-bottom: 1px solid !important;} */
</style>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> Daily Collections <small>Accounts / Daily Collections</small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8">&nbsp;</div>
                        </div>
                    </div>
                    <div class="body">
                        <div calss="row">
                            <form id="dateform" method="post">
                                <div class="col-md-12">
                                    <div class="col-md-2 col-sm-2">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" >
                                                <input type="date" name="sdate" id="sdate" class="form-control" value="<?php echo date("Y-m-d", strtotime($sdate)); ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label">Date</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <select class="form-control" name="type_id" id="type_id">
                                                    <option value="" >Select Type</option>
                                                    <option value="1" <?php if($type_id == 1){ echo "selected"; } ?>>Receipts</option>
                                                    <option value="2" <?php if($type_id == 2){ echo "selected"; } ?>>Payments</option>
                                                </select>
                                                <label class="form-label">Type</label>                                                 
                                            </div>                                            
                                        </div>                                            
                                    </div>
                                    <div class="col-md-3" style="display:<?php if($type_id == 1){ echo "block"; }else{ echo "none"; } ?>;" id="type_receipt_hide_show">
										<div class="form-group form-float">
                                            <div class="form-line focused">
                                                <select class="form-control search_box" data-live-search="true" name="receipt_debit_ac" id="receipt_debit_ac">
                                                    <option value="">Select credit a/c</option>
                                                    <?php
                                                    if(!empty($receipt_ledgers))
                                                    {
                                                        foreach($receipt_ledgers as $ledger)
                                                        {
                                                    ?>
                                                        <option value="<?php echo $ledger["id"]; ?>" <?php if($receipt_debit_ac == $ledger["id"]){ echo "selected"; } ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label class="form-label">Credit A/C</label>
                                            </div>
										</div>
									</div>
                                    <div class="col-md-3" style="display:<?php if($type_id == 2){ echo "block"; }else{ echo "none"; } ?>;" id="type_payment_hide_show">
										<div class="form-group form-float">
                                            <div class="form-line focused">
                                                <select class="form-control search_box" data-live-search="true" name="payment_credit_ac" id="payment_credit_ac" >
                                                    <option value="">Select debit a/c</option>
                                                    <?php
                                                    if(!empty($payment_ledgers))
                                                    {
                                                        foreach($payment_ledgers as $ledger)
                                                        {
                                                    ?>
                                                        <option value="<?php echo $ledger["id"]; ?>" <?php if($payment_credit_ac == $ledger["id"]){ echo "selected"; } ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label class="form-label">Debit A/C</label>              
                                            </div>
										</div>
									</div>
                                    <div class="col-md-2">
										<div class="form-group form-float">
                                            <div class="form-line focused">
                                                <select class="form-control search_box" data-live-search="true" name="fund_id" id="fund_id">
                                                    <option value="">Select funds</option>
                                                    <?php
                                                    if(!empty($funds))
                                                    {
                                                        foreach($funds as $fund)
                                                        {
                                                    ?>
                                                        <option value="<?php echo $fund["id"]; ?>" <?php if($fund_id == $fund["id"]){ echo "selected"; } ?>><?php echo $fund['name'] . '(' . $fund['code'] . ")"; ?> </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label class="form-label">Funds</label>
                                            </div>
										</div>
									</div>
                                    <div class="col-md-1 col-sm-1">
                                        <div class="form-group form-float">
                                            <button type="submit" id="submit" class="btn btn-success">Submit</button>
                                        </div>                                            
                                    </div>
                                </div>
                            </form>
							<form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url(); ?>/dailycollection/print_daily_collection" method="post">
                               <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="ptype_id" id="ptype_id" class="form-control" value="<?= $type_id; ?>">
                                <input type="hidden" name="pfund_id" id="pfund_id" class="form-control" value="<?= $fund_id; ?>">
                                <input type="hidden" name="preceipt_ledger_id" id="preceipt_ledger_id" class="form-control" value="<?= $receipt_debit_ac; ?>">
                                <input type="hidden" name="ppayment_ledger_id" id="ppayment_ledger_id" class="form-control" value="<?= $payment_credit_ac; ?>">
                            </form>
                         </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table-height" style="">
                                <table class="table1" border="1" >
                                    <thead>
                                        <tr>
                                            <th align="left" class="thead" style="width:30%!important;font-size: 16px !important;">A/C</th>
                                            <th align="left" class="thead" style="width:50%!important;font-size: 16px !important;">Description</th>
                                            <th align="right" class="thead" style="width:20%!important;font-size: 16px !important;text-align:right;">Amount (RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($table as $row) { ?>
                                            <?php echo $row; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                            <div class="row">
                                <br>
                                <div class="col-md-12" align="center">
                                    <label id="print" class="btn btn-primary">Print</label>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#print").click(function(){
        $("#print_sheet").submit();
    });

    $('document').ready(function() {
        $('#type_id').change(function(){
            if($('#type_id').val() == '1') {
                $('#type_receipt_hide_show').show();
                $('#type_payment_hide_show').hide();
            }
            else if($('#type_id').val() == '2') {
                $('#type_payment_hide_show').show();
                $('#type_receipt_hide_show').hide();
            }
            else {
                $('#type_payment_hide_show').hide(); 
                $('#type_receipt_hide_show').hide();
            } 
        });
    });
</script>