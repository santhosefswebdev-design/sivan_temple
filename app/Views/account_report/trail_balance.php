<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }
    .thead{
        color: #fff;
        background-color: red;
    }
    a:hover { text-decoration: none; }*/
	.card .body .col-xs-3, .card .body .col-sm-3, .card .body .col-md-3, .card .body .col-lg-3 {
		 margin-bottom: 0px; 
	}
	.form-group { margin-bottom: 0; }
</style>
<section class="content">
    <div class="container-fluid">
        <!-- <div class="block-header">
            <h2> ACCOUNTS <small>Accounts / Trial Balance</small></h2>
        </div>
        Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-4"><h2>Trial Balance</h2></div>
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
                        <!-- <div class="col-md-2" align="right"><a href="<?php echo base_url(); ?>/account/add_group"><button type="button" class="btn bg-deep-purple waves-effect">Add Group</button></a></div>
                        <div class="col-md-2" align="right"><a href="<?php echo base_url(); ?>/account/add_ledger"><button type="button" class="btn bg-deep-purple waves-effect">Add Ledger</button></a></div>-->
                        </div>
                    </div>
                    <div class="body" style="margin-top: 15px;">
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
                        <form action="<?php echo base_url();?>/accountreport/trail_balance" method="post">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                <div class="col-sm-3 date">
                                    <div class="form-group">
                                        <div class="form-line focused" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;">From Date</label>
                                            <input type="date" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                            <!--<label class="form-label">From Date</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 date">
                                    <div class="form-group">
                                        <div class="form-line focused" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;">To Date</label>
                                            <input type="date" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                                            <!--<label class="form-label">To Date</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                                </div>
                                <div class="col-sm-2" align="right">
                                    <label id="print" class="btn btn-primary">Print</label>
                                    <label id="excel" class="btn btn-success">Excel</label>
                                </div>
                                </div>
                                </div>
                            </form>
                            <form style="display: none;" target="_blank" action="<?php echo base_url();?>/accountreport/print_trial_balance" method="POST" id="print_balance">
                                <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                                <button type="submit" id="print_sub" class="btn btn-success">Submit</button>
                            </form>
                            <form style="display: none;" target="_blank" action="<?php echo base_url();?>/accountreport/excel_trial_balance" method="POST" id="excel_balance">
                                <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                                <button type="submit" id="excel_sub" class="btn btn-success">Submit</button>
                            </form>
                        <div class="table-responsive">
                        <table class="table table-striped" style="width:100%;margin-top: 15px;">
                        <tr>
                            <th style="width: 20%;" class="thead">A/C No</th>
                            <th style="width: 60%;" class="thead">Description</th>
                            <th style="width: 10%;text-align:right;" class="thead">Debit</th>
                            <th style="width: 10%;text-align:right;" class="thead">Credit</th>
                        </tr>
                        <?php foreach($list as $row) { ?>
                            <?php print_r($row); ?>
                        <?php } ?>
                        </table>
                        </div>
                        <!--<div class="row"><div class="col-md-12" align="center"><a target="_blank" class="btn btn-primary" href="<?php echo base_url(); ?>/accountreport/print_trial_balance">Print</a></div></div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form style="display: none;" target="_blank" action="<?php echo base_url();?>/accountreport/print_ledger_statement" method="POST" id="ledgers">
        <input type="text" name="ledger" id="ledger" class="form-control" value="">
        <input type="date" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
        <input type="date" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
        <button type="submit" id="ledger_print" class="btn btn-success">Submit</button>
    </form>
</section>
<script>
    $("#print").click(function(){
        $("#print_sub").trigger('click');
    });
    $("#excel").click(function(){
        $("#excel_sub").trigger('click');
    });
    function ledger_report(id){
        $("#ledger").val(id);
        $("#ledger_print").trigger("click");
    }
</script>