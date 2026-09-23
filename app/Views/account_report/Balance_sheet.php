<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; 

    .thead{
        color: #fff;
        background-color: red;
    }
    a:hover { text-decoration: none; }*/
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
                        <div class="row"><div class="col-md-2"><h2>Balance Sheet</h2></div>
                        <div class="col-md-10">
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
                        <form action="<?php echo base_url();?>/balance_sheet" method="post" style="margin-top:15px;">
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
                                <div class="col-sm-2" align="right">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                                    <!-- <label id="print" class="btn btn-primary btn-lg waves-effect">Print</label> -->
                                </div>
                                                                </div>
                                </div>
                            </form>
                            <form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url();?>/balance_sheet/print_balance_sheet" method="post">
                                <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                            </form>
                        <div class="table-responsive">
                        <table class="table table-striped" style="width:100%;">
                        <tr>
                            <th style="width: 40%;" class="thead">Account Name</th>
                            <th style="text-align: right;" class="thead">Amount</th>
                        </tr>
                        <?php foreach($list as $row) { ?>
                            <?php print_r($row); ?>
                        <?php } ?>
                        </table>
                        </div>
                        <div class="row"><div class="col-md-12" align="center"><label id="print" class="btn btn-primary">Print</label></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#print").click(function(){
        $("#print_sheet").submit();
    })
</script>
