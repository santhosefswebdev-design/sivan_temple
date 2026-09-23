

<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?><section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>USER SETTING<small>Finance / <b>Add User Role</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Add User  Settings</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/user/user_role"><button type="button" class="btn bg-deep-purple waves-effect">User Role</button></a></div></div>
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
                        <form action="<?php echo base_url(); ?>/userpermission/update_role" method="post">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="name" class="form-control" id="role_name" value="<?php echo $role['name'];?>" <?php echo $readonly; ?> >
                                                <input type="hidden" name="role_id" id="role_id" value="<?= $role['id']?>">
												<label class="form-label">Type of User <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text"  name="description" class="form-control" value="<?php echo $role['description'];?>" <?php echo $readonly; ?> >
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
                                        <?php 
										
										 $dkey = array_search('dashboard', array_column($permission, 'name')); 
										if ($permission[$dkey]['name']!='dashboard')
											$dkey=99999;
										?>
                                        <td>Dashboard</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[dashboard][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[dashboard][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[dashboard][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[dashboard][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<tr><td colspan=6 style="text-align : center;"><b><u>Master</u><b></td></tr>

                                    <tr>
                                        <?php 
                                            $dkey = array_search('temple_setting', array_column($permission, 'name')); 
                                            if ($permission[$dkey]['name']!='temple_setting')
                                                $dkey=99999;
										?>
                                        <td>Temple Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[temple_setting][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox" id="view"></td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[temple_setting][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
									
									<?php
									$dkey = array_search('user_setting', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='user_setting')
										$dkey=99999;
									?>
									
                                    <tr>
                                        <td>User Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[user_setting][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[user_setting][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[user_setting][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[user_setting][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<?php
									$dkey = array_search('staff_setting', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='staff_setting')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Staff Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[staff_setting][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[staff_setting][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[staff_setting][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[staff_setting][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<?php
									$dkey = array_search('archanai_setting', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='archanai_setting')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Archanai Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_setting][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_setting][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_setting][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_setting][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<?php
									$dkey = array_search('hall_setting', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='hall_setting')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Hall Package Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_setting][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_setting][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_setting][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_setting][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<?php
									$dkey = array_search('donation_setting', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='donation_setting')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Donation Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[donation_setting][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[donation_setting][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[donation_setting][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[donation_setting][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<?php
									$dkey = array_search('ubayam_setting', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='ubayam_setting')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Ubayam Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_setting][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_setting][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_setting][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_setting][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <?php $dkey = array_search('member', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='member')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Member Setting</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
                                    <tr>
									<?php
									
									$dkey = array_search('uom', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='uom')
										$dkey=99999;
									?>
                                        <td>UOM</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[uom][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[uom][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[uom][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[uom][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<?php
									$dkey = array_search('timing', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='timing')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Timing</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[timing][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[timing][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[timing][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[timing][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<?php
									$dkey = array_search('stock_group', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='stock_group')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Stock Group</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_group][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_group][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_group][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_group][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<?php
									$dkey = array_search('product', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='product')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Product</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
                                    <?php
									$dkey = array_search('cemetery', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='cemetery')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Cemetery</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                    </tr>
									<tr><td colspan=6 style="text-align : center;"><b><u>Transactions</u><b></td></tr>
									<?php
									$dkey = array_search('archanai_ticket', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='archanai_ticket')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Archanai Ticket</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_ticket][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_ticket][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('hall_booking', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='hall_booking')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Hall Booking</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_booking][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_booking][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_booking][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_booking][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('cash_donation', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='cash_donation')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Cash Donation</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cash_donation][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cash_donation][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cash_donation][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('ubayam', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='ubayam')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Ubayam</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('product_donation', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='product_donation')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Product Donation</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product_donation][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product_donation][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product_donation][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('stock_in', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='stock_in')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Stock In</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_in][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_in][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_in][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('stock_out', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='stock_out')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Stock Out</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_out][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_out][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_out][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('pay_slip', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='pay_slip')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Pay Slip</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[pay_slip][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[pay_slip][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[pay_slip][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
                                    <?php
									$dkey = array_search('advance_salary', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='advance_salary')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Advance Salary</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[advance_salary][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[advance_salary][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[advance_salary][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
                                    <?php
									$dkey = array_search('cemetery_reg', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='cemetery_reg')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Member Register</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_reg][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_reg][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_reg][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_reg][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('cemetery_reg', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='cemetery_reg')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Cemetery Register</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_reg][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_reg][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_reg][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_reg][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<tr><td colspan=6 style="text-align : center;"><b><u>Reports</u><b></td></tr>
									<?php
									$dkey = array_search('archanai_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='archanai_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Archanai Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[archanai_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('hall_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='hall_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Hall Booking Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[hall_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('cash_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='cash_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Cash Donation Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cash_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('ubayam_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='ubayam_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Ubayam Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ubayam_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('product_donation_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='product_donation_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Product Donation Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[product_donation_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('stock_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='stock_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Stock Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[stock_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('commission_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='commission_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Commission Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[commission_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
                                    <?php
									$dkey = array_search('payslip_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='payslip_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>PaySlip Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[payslip_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
                                    <?php
									$dkey = array_search('member_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='member_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Member Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[member_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<?php
									$dkey = array_search('cemetery_report', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='cemetery_report')
										$dkey=99999;
									?>
                                    <tr>
                                        <td>Cemetery Report</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[cemetery_report][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
                                    </tr>
									<tr><td colspan=6 style="text-align : center;"><b><u>Accounts</u><b></td></tr>
									
									<?php
									$dkey = array_search('ac_creation_accounts', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='ac_creation_accounts')
										$dkey=99999;
									?>
                                    <tr>
										<td>A/C Creation</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
										<!--<td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ac_creation_accounts][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>-->
									</tr>
                                    <?php
									$dkey = array_search('group', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='group')
										$dkey=99999;
									?>
                                    <tr>
										<td>Group</td>
										<!--<td><input style="opacity: 1;position: inherit;" name="permission[group][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>-->
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[group][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[group][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[group][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                        <!--<td><input style="opacity: 1;position: inherit;" name="permission[group][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>-->
									</tr>
                                    <?php
									$dkey = array_search('ledger', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='ledger')
										$dkey=99999;
									?>
                                    <tr>
										<td>Ledger</td>
										<!--<td><input style="opacity: 1;position: inherit;" name="permission[ledger][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>-->
                                        <td>-</td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ledger][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ledger][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[ledger][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td>-</td>
                                        <!--<td><input style="opacity: 1;position: inherit;" name="permission[ledger][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>-->
									</tr>
									<?php
									$dkey = array_search('entries_accounts', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='entries_accounts')
										$dkey=99999;
									?>
									<tr>
										<td>Entries</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][create_p]" <?php if($permission[$dkey]['create_p'] == 1) echo "checked"; ?> type="checkbox" id="create"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][edit]" <?php if($permission[$dkey]['edit'] == 1) echo "checked"; ?> type="checkbox" id="edit"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][delete_p]" <?php if($permission[$dkey]['delete_p'] == 1) echo "checked"; ?> type="checkbox" id="delete"></td>
                                        <td><input style="opacity: 1;position: inherit;" name="permission[entries_accounts][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
									</tr>
									<?php
									$dkey = array_search('ledger_report_accounts', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='ledger_report_accounts')
										$dkey=99999;
									?>
									<tr>
										<td>Ledger Reports</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[ledger_report_accounts][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td>-</td>
										<td>-</td>
										<td>-</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[ledger_report_accounts][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
									</tr>
									<?php
									$dkey = array_search('trial_balance_accounts', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='trial_balance_accounts')
										$dkey=99999;
									?>
									<tr>
										<td>Trial Balance</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[trial_balance_accounts][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td>-</td>
										<td>-</td>
										<td>-</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[trial_balance_accounts][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
									</tr>
									<?php
									$dkey = array_search('balance_sheet_accounts', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='balance_sheet_accounts')
										$dkey=99999;
									?>
									<tr>
										<td>Balance Sheet</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[balance_sheet_accounts][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td>-</td>
										<td>-</td>
										<td>-</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[balance_sheet_accounts][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
									</tr>
									<?php
									$dkey = array_search('profit_and_loss_accounts', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='profit_and_loss_accounts')
										$dkey=99999;
									?>
									<tr>
										<td>Profit & Loss Reports</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[profit_and_loss_accounts][view]" <?php if($permission[$dkey]['view'] == 1) echo "checked"; ?> type="checkbox"  id="view"></td>
                                        <td>-</td>
										<td>-</td>
										<td>-</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[profit_and_loss_accounts][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
									</tr>
									<?php
									$dkey = array_search('ledgers_name_list_accounts', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='ledgers_name_list_accounts')
									?>
									<tr>
										<td>Ledgers Name List</td>
										<td>-</td>
                                        <td>-</td>
										<td>-</td>
										<td>-</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[ledgers_name_list_accounts][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
									</tr>
									<?php
									$dkey = array_search('account_group_list_accounts', array_column($permission, 'name')); 										
									if ($permission[$dkey]['name']!='account_group_list_accounts')
									?>
									<tr>
										<td>Account Group List</td>
										<td>-</td>
                                        <td>-</td>
										<td>-</td>
										<td>-</td>
										<td><input style="opacity: 1;position: inherit;" name="permission[account_group_list_accounts][print]" <?php if($permission[$dkey]['print'] == 1) echo "checked"; ?> type="checkbox" id="print"></td>
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
                data: {name: name,role_id: $("#role_id").val()},
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