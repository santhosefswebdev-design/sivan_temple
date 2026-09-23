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
            <h2> ACCOUNTS<small>Accounts / Statement Receipt And Payment</small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Statement of Receipt And Payment</h2></div>
                        </div>
                    </div>
                    <div class="body">
                        <div calss="row">
                            <form id="dateform" method="post">
                                <div class="col-md-12">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" id="bs_datepicker_container">
                                                <input type="date" name="sdate" id="sdate" class="form-control" value="<?php echo date("Y-m-d", strtotime($sdate)); ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label">From</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" id="bs_datepicker_container">
                                                <input type="date" name="edate" id="edate" class="form-control" value="<?php echo date("Y-m-d", strtotime($edate)); ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                                <label class="form-label">To</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-3 col-sm-2">
                                        <div class="form-group form-float">
                                            <select class="form-control" name="type_id" id="type_id">
                                                <option value="3" <?php if($type_id == 3){ echo "selected"; } ?>>Both</option>
												<option value="1" <?php if($type_id == 1){ echo "selected"; } ?>>Receipts</option>
												<option value="2" <?php if($type_id == 2){ echo "selected"; } ?>>Payments</option>
											</select>                                                   
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <button type="submit" id="submit" class="btn btn-success">Submit</button>
                                        </div>                                            
                                    </div>
                                </div>
                            </form>
							<form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url(); ?>/accountreport/print_receipt_payment" method="post">
                               <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $edate; ?>">
                                <input type="hidden" name="ptype_id" id="ptype_id" class="form-control" value="<?= $type_id; ?>">
                            </form>
                         </div>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table-height" style="">
                                <table class="table1" border="1" >
                                    <thead>
                                        <tr>
                                            <?php
                                            if($type_id == 1){
                                            ?>
                                            <th align="left" class="thead" colspan="2" style="width:50%!important;font-size: 16px !important;">Receipts (RM)</th>
                                            <?php
                                            }
                                            if($type_id == 2){
                                            ?>
                                            <th align="left" class="thead" colspan="2" style="width:50%!important;font-size: 16px !important;">Payments (RM)</th>
                                            <?php
                                            }
                                            if($type_id == 3){
                                            ?>
                                            <th align="left" class="thead" style="width:50%!important;font-size: 16px !important;">Receipts (RM)</th>
                                            <th align="left" class="thead" style="width:50%!important;font-size: 16px !important;">Payments (RM)</th>
                                            <?php    
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($table as $row) { ?>
                                            <?php echo $row; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot >
                                        <tr>
                                            <?php
                                            if($type_id == 1){
                                            ?>
                                            <th class="thead" style="width:50%!important;text-align: right;font-size: 18px !important;"><?php echo number_format($total_receipt, '2','.',''); ?></th>
                                            <?php
                                            }
                                            if($type_id == 2){
                                            ?>
                                            <th class="thead" style="width:50%!important;text-align: right;font-size: 18px !important;"><?php echo number_format($total_payment, '2','.',''); ?></th>
                                            <?php
                                            }
                                            if($type_id == 3){
                                            ?>
                                            <th class="thead" style="width:50%!important;text-align: right;padding: 0 15px !important;font-size: 18px !important;"><?php echo number_format($total_receipt, '2','.',''); ?></th>
                                            <th class="thead" style="width:50%!important;text-align: right;padding: 0 15px !important;font-size: 18px !important;"><?php echo number_format($total_payment, '2','.',''); ?></th>
                                            <?php    
                                            }
                                            ?>
                                        </tr>
                                    </tfoot>
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
</script>