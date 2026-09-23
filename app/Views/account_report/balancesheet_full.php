<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; 

    .thead{
        color: #fff;
        background-color: red;
    }
    a:hover { text-decoration: none; }*/
	
	.table1{ border:1px solid #CCCCCC; }
	.table1 tr th { background-color:#EFEFEF; padding:5px; min-width:130px; font-size:16px; }
	.table1 tr td:first-child { padding:5px; text-align:left; width: 300px; min-width:300px !important;}
	.table1 tr td { padding:5px; text-align:right; width: 130px; min-width:130px !important;  }
</style>
<section class="content">
    <div class="container-fluid">
        <!-- <div class="block-header">
            <h2> ACCOUNTS</h2>
        </div>
        Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-4"><h2>Statement of Financial Position</h2></div>
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
                        </div>
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
                        <form action="<?php echo base_url();?>/balance_sheet/balancesheet_full" method="post" style="margin-top:15px;">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                <div class="col-sm-3 date">
                                    <div class="form-group">
                                        <div class="form-line focused" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;">Date</label>
                                            <input type="date" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                            <!--<label class="form-label">To Date</label>-->
                                        </div>
                                    </div>
                                </div>
								<?php /* <div class="col-sm-3">
									<div class="form-group form-float">
										<select class="form-control search_box" data-live-search="true" name="fund_id" id="fund_id">
											<option value="">Select Fund</option>
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
									</div>                                            
                                </div> */ ?>
                                <div class="col-sm-2" align="right">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                                    <!-- <label id="print" class="btn btn-primary btn-lg waves-effect">Print</label> -->
                                </div>
                                                                </div>
                                </div>
                            </form>
                            <form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url();?>/balance_sheet/print_balancesheet_full" method="post">
                                <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tpdate" id="tpdate" class="form-control" value="<?= $tdate; ?>">
								<input type="hidden" name="fund_id" id="fund_id" class="form-control" value="<?= $fund_id; ?>">
                            </form>
                            <form style="display: none;" target="_blank" id="excel_sheet" action="<?php echo base_url();?>/balance_sheet/excel_balancesheet_full" method="post">
                                <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tedate" id="tedate" class="form-control" value="<?= $tdate; ?>">
								<input type="hidden" name="fund_id" id="fund_id" class="form-control" value="<?= $fund_id; ?>">
                            </form>
                        <div class="table-responsive">
                        <table class="table1" border="1" style="width:100%;">
                        <tr>
                            <th style="width: 300px; min-width:300px !important;">Account Name</th>
                            <th style="text-align: right;" class="thead">Current Year</th>
                            <th style="text-align: right;" class="thead">Previous Year</th>
                        </tr>
                        <?php foreach($list as $row) { ?>
                            <?php print_r($row); ?>
                        <?php } ?>
                        </table>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12" align="center">
                                <label id="print" class="btn btn-primary">Print</label>
                                <a href="<?php echo base_url();?>/balance_sheet/pdf_balancesheet_full?tdate=<?= $tdate; ?>"><label class="btn btn-danger">PDF</label></a>
                                <label id="excel" class="btn btn-success">Excel</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="modal-title" id="modal_ledger_title"></h4>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size: 24px;">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
			<div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-12">
                        <div id="display_indivitual_ledgers"></div>
                    </div>
                </div>
			</div>
		</div><!-- /.modal-content -->
	</div>
</div>
<script>
    $("#print").click(function(){
        $("#print_sheet").submit();
    });
    $("#excel").click(function(){
        $("#excel_sheet").submit();
    });
</script>

<script>
	function open_group_ledger_triblezero_modal(led_id,fdate,tdate)
    {
        if(led_id != "")
        {
            $.ajax({
                url: '<?php echo base_url(); ?>/balance_sheet/open_group_ledger_triblezero',
                type: 'post',
                data: {led_id:led_id,fdate:fdate,tdate:tdate},
                success: function(response){
                    get_ledger_triblezero(led_id);
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#display_indivitual_ledgers").html(response);
                }
            }); 
        }
    }
    function get_ledger_triblezero(ledg_id)
    {
        if(ledg_id != "")
        {
            $.ajax({
                url: '<?php echo base_url(); ?>/balance_sheet/get_ledger_triblezero',
                type: 'post',
                data: {ledg_id:ledg_id},
                success: function(response){
                    $("#modal_ledger_title").text(response);
                }
            }); 
        }
    }
</script>
