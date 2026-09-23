<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }

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
                        <div class="row"><div class="col-md-8"><h2>Consolidate Sheet</h2></div>
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
                        <!--<form action="<?php echo base_url();?>/balance_sheet" method="post">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                <div class="col-sm-3 date">
                                    <div class="form-group">
                                        <div class="form-line focused" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;">From Date</label>
                                            <input type="date" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 date">
                                    <div class="form-group">
                                        <div class="form-line focused" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;">To Date</label>
                                            <input type="date" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                                        </div>
                                    </div>
                                </div>
                                                                <div class="col-sm-2" align="right">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                                </div>
                                                                </div>
                                </div>
                            </form>-->
                            <form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url();?>/balance_sheet/print_multi_balance_sheet" method="post">
                                <input type="date" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="date" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                            </form>
                        <div class="table-responsive">
                        <table class="table table-striped" style="width:100%;">
                        <table style="width:100%;" border="1">
    <thead><tr>
    <th>Account Name</th>
    <th>Bala Thandayuthapani</th>
    <th>Ganesha</th>
    <th>Ayyappa</th>
    <th>Naganathar</th>
    <th>T5Mariamman</th>
    <th>Maha Mariamman</th>
    <th>Kunj Bihari</th>
    <th>Ramar</th>
    <th>Vinayagar</th>
    <th>Thropathi Amman</th>
    <th>Sakthi Vinayagar</th>
    <th>Kaliamman</th>
    <th>Veerakaliyamman</th>
    </tr></thead>
    <tbody>
    		<tr style="color: black;">
					<td><b>ASSETS</b></td>
					<td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
					</tr>    		
                    <tr style="color: black;">
                    <td><span style="margin-left: 2%;color: black;">Current Assets</span></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Cash-in-Hand</span></td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    <td style="text-align: right;">21,870.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">Cash Ledger</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">PETTY CASH</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">CASH DRAWER</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Deposits</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Loans and Advances</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Bank Accounts</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">CIMB Bank</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Stock-In-Hand</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Sundry Debtors</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Fixed Deposits</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Burial Ground (Ayyappa Swamy)</span></td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    <td style="text-align: right;">-2,364.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">Overtime Fee</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">சவக்கூட தொகை/Parlour Fee</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">குளிர்சாதனப்பெட்டி/Refridgeration Fee</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">தகனம்/Cremation/Burial Fee</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 4%;">Burial Ground (Naganathar)</span></td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    <td style="text-align: right;">-2,585.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">Overtime Fee</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">சவக்கூட தொகை/Parlour Fee</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">குளிர்சாதனப்பெட்டி/Refridgeration Fee</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 6%;">தகனம்/Cremation/Burial Fee</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 2%;color: black;">FIXED ASSETS</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 2%;color: black;">Misc. Expenses</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 2%;color: black;">Investments</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		<tr style="color: black;">
                    <td><span style="margin-left: 2%;color: black;">Long Term Current Assets</span></td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    <td style="text-align: right;">0.00</td>
                    </tr>    		</tbody><tfoot><tr style="color: black;">
                    <td><b>Total Assets</b></td>
                    <td style="text-align: right;"><b>16,921.00</b></td>
                    </tr></tfoot></table>
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
