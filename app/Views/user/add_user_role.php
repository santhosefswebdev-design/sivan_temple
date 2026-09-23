</style>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?><section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> USER ROLE SETTING<small>Finance / <b>Add User Role</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Add User  Settings</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/user/user_role"><button type="button" class="btn bg-deep-purple waves-effect">User Role List</button></a></div></div>
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
                        <form action="<?php echo base_url(); ?>/userpermission/save_role" method="post">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="name" class="form-control" id="role_name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Type of User <span style="color: red;">*</sapn></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text"  name="description" class="form-control" value="<?php echo $data['username'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Description</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-12">
                                    <table class="table table-bordered table-striped">
                                    <tr><th style="width:50% !important;">Form Name</th>
                                    <th style="width:10%;"><input style="opacity: 1;position: inherit;" type="checkbox" id="allview"> View</th>
                                    <th style="width:10%;"><input style="opacity: 1;position: inherit;" type="checkbox" id="allcrea"> Create</th>
                                    <th style="width:10%;"><input style="opacity: 1;position: inherit;" type="checkbox" id="alledit"> Edit</th>
                                    <th style="width:10%;"><input style="opacity: 1;position: inherit;" type="checkbox" id="alldele"> Delete</th>
                                    <th style="width:10%;"><input style="opacity: 1;position: inherit;" type="checkbox" id="allprin"> Print</th></tr>
                                    <tr>
                                        <td>Dashboard</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[dashboard][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[dashboard][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[dashboard][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[dashboard][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<tr><td colspan=6 style="text-align : center;"><b><u>Master</u><b></td></tr>
                                    <tr>
                                        <td>Temple Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[temple_setting][view]" type="checkbox" id="view"></td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[temple_setting][edit]" type="checkbox" id="edit"></td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>User Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[user_setting][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[user_setting][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[user_setting][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[user_setting][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Member Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][delete_p]" type="checkbox" id="delete"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Staff Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[staff_setting][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[staff_setting][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[staff_setting][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[staff_setting][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Archanai Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_setting][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_setting][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_setting][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_setting][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Hall Package Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_setting][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_setting][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_setting][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_setting][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Donation Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[donation_setting][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[donation_setting][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[donation_setting][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[donation_setting][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Ubayam Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_setting][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_setting][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_setting][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_setting][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>UOM</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[uom][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[uom][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[uom][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[uom][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Timing</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[timing][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[timing][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[timing][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[timing][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Stock Group</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_group][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_group][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_group][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_group][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Product</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Cemetery</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery][edit]" type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery][delete_p]" type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<tr><td colspan=6 style="text-align : center;"><b><u>Transactions</u><b></td></tr>
                                    <tr>
                                        <td>Archanai Ticket</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_ticket][create_p]" type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_ticket][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Hall Booking</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_booking][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_booking][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_booking][edit]" type="checkbox" id="edit"></td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_booking][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Cash Donation</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cash_donation][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cash_donation][create_p]" type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cash_donation][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Ubayam</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam][create_p]" type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Product Donation</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product_donation][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product_donation][create_p]" type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product_donation][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Stock In</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_in][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_in][create_p]" type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_in][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Stock Out</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_out][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_out][create_p]" type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_out][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td>Pay Slip</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[pay_slip][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[pay_slip][create_p]" type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[pay_slip][print]" type="checkbox" id="print"></td>
                                    </tr>
                                        <td>Advance Salary</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[advance_salary][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[advance_salary][create_p]" type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[advance_salary][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Member Register</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_reg][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_reg][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_reg][edit]" type="checkbox" id="edit"></td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_reg][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Cemetery Register</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_reg][view]" type="checkbox" id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_reg][create_p]" type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_reg][edit]" type="checkbox" id="edit"></td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_reg][print]" type="checkbox" id="print"></td>
                                    </tr>
									<tr><td colspan=6 style="text-align : center;"><b><u>Reports</u><b></td></tr>
                                    <tr>
                                        <td>Archanai Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Hall Booking Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Cash Donation Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cash_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Ubayam Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Product Donation Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product_donation_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Stock Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Commission Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[commission_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>PaySlip Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[payslip_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Member Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_report][print]" type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
                                        <td>Cemetery Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_report][print]" type="checkbox" id="print"></td>
                                    </tr>
									<tr><td colspan=6 style="text-align : center;"><b><u>Accounts</u><b></td></tr>
										<tr>
											<td>A/C Creation</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][view]" type="checkbox" id="view"></td>
											<!--<td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][create_p]" type="checkbox" id="create"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][edit]" type="checkbox" id="edit"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][delete_p]" type="checkbox" id="delete"></td>-->
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<!--<td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][print]" type="checkbox" id="print"></td>-->
										</tr>
                                        <tr>
											<td>Group</td>
											<!--<td><input style="opacity: 1;position: inherit;" name="permission[group][view]" type="checkbox" id="view"></td>-->
											
											<td>-</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[group][create_p]" type="checkbox" id="create"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[group][edit]" type="checkbox" id="edit"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[group][delete_p]" type="checkbox" id="delete"></td>
											<td>-</td>
											<!--<td><input style="opacity: 1;position: inherit;" name="permission[group][print]" type="checkbox" id="print"></td>-->
										</tr>
                                        <tr>
											<td>Ledger</td>
											<!--<td><input style="opacity: 1;position: inherit;" name="permission[ledger][view]" type="checkbox" id="view"></td>-->
											<td>-</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ledger][create_p]" type="checkbox" id="create"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ledger][edit]" type="checkbox" id="edit"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ledger][delete_p]" type="checkbox" id="delete"></td>
											<td>-</td>
											<!--<td><input style="opacity: 1;position: inherit;" name="permission[ledger][print]" type="checkbox" id="print"></td>-->
										</tr>
										<tr>
											<td>Entries</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][view]" type="checkbox" id="view"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][create_p]" type="checkbox" id="create"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][edit]" type="checkbox" id="edit"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][delete_p]" type="checkbox" id="delete"></td>
											<td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][print]" type="checkbox" id="print"></td>
										</tr>
										<tr>
											<td>Ledger Reports</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ledger_report_accounts][view]" type="checkbox" id="view"></td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ledger_report_accounts][print]" type="checkbox" id="print"></td>
										</tr>
										<tr>
											<td>Trial Balance</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[trial_balance_accounts][view]" type="checkbox" id="view"></td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[trial_balance_accounts][print]" type="checkbox" id="print"></td>
										</tr>
										<tr>
											<td>Balance Sheet</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[balance_sheet_accounts][view]" type="checkbox" id="view"></td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[balance_sheet_accounts][print]" type="checkbox" id="print"></td>
										</tr>
										<tr>
											<td>Profit & Loss Reports</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[profit_and_loss_accounts][view]" type="checkbox" id="view"></td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[profit_and_loss_accounts][print]" type="checkbox" id="print"></td>
										</tr>
										<tr>
											<td>Ledgers Name List</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[ledgers_name_list_accounts][print]" type="checkbox" id="print"></td>
										</tr>
										<tr>
											<td>Account Group List</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td><input style="opacity: 1;position: inherit;" name="permission[account_group_list_accounts][print]" type="checkbox" id="print"></td>
										</tr>
                                    </table>
                                    </div>
                                    
                                    
                                   </div>
                                </div>
                            </div>
                        </form> 
                        <?php if($view != true) { ?>
                                    <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                                        <button type="submit" onclick="validations()" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                        <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                        <button type="button" onclick="history.back()" id="clear" class="btn btn-info btn-lg waves-effect">BACK</button>
                                        
                                    </div>
                        <?php } ?>
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
	
	$('#allview').change(function () {
		$('tbody tr td input[type="checkbox"]#view').prop('checked', $(this).prop('checked'));
	});
	$('#allcrea').change(function () {
		$('tbody tr td input[type="checkbox"]#create').prop('checked', $(this).prop('checked'));
	});
	$('#alledit').change(function () {
		$('tbody tr td input[type="checkbox"]#edit').prop('checked', $(this).prop('checked'));
	});
	$('#alldele').change(function () {
		$('tbody tr td input[type="checkbox"]#delete').prop('checked', $(this).prop('checked'));
	});
	$('#allprin').change(function () {
		$('tbody tr td input[type="checkbox"]#print').prop('checked', $(this).prop('checked'));
	});
</script>
<script>
    function validations(){
        var name = $("#role_name").val();
        
        if(name.trim() == ''){
            $('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text("Please Fill Out Required Fields");
        }else{
            $.ajax({
                type:"POST",
                url: "<?php echo base_url(); ?>/userpermission/validation",
                data: {name: name},
                success:function(data)
                {
                    obj = jQuery.parseJSON(data);
                    console.log(obj);
                    if(obj.err != ''){
                        $('#alert-modal').modal('show', {backdrop: 'static'});
                        $("#spndeddelid").text(obj.err);
                    }else{
                        $("form").submit();
                    }
                }
            });
        }    
    }
</script>