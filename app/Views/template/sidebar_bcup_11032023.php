<?php 
function permission_validate($name, $access){
    $permission = $_SESSION['permission'];
    $dkey = array_search($name, array_column($permission, 'name'));
    if ($permission[$dkey]['name']== $name)
    {
        $val = $permission[$dkey][$access];
        if($val == 1) $res = true;
        else $res = false;
    }else{
        $res = false;
    }
    return $res;
}
 function list_validate($name){
        $permission = $_SESSION['permission'];
        $dkey = array_search($name, array_column($permission, 'name'));
        if ($permission[$dkey]['name']== $name)
        {
			//echo $name;
            $view = $permission[$dkey]['view'];
            $create = $permission[$dkey]['create_p'];
            $edit = $permission[$dkey]['edit'];
            $delete = $permission[$dkey]['delete_p'];
            $print = $permission[$dkey]['print'];

            if($view == 1 || $create == 1 || $edit == 1 || $delete == 1 || $print == 1 ) $res = true;
            else $res = false;
		}else{
            $res = false;
        }
        return $res;
    }
//Profile
$temple_setting     = list_validate('temple_setting');
$view_per           = permission_validate('temple_setting', 'view');
$edit_per           = permission_validate('temple_setting', 'edit');
$member             = list_validate('member');


//Master
$user_setting       = list_validate('user_setting');
$member_setting       = list_validate('member');
$staff_setting      = list_validate('staff_setting');
$archanai_setting   = list_validate('archanai_setting');
$hall_setting       = list_validate('hall_setting');
$donation_setting   = list_validate('donation_setting');
$ubayam_setting     = list_validate('ubayam_setting');
$uom     			= list_validate('uom');
$timing     		= list_validate('timing');
$stock_group     	= list_validate('stock_group');
$product     		= list_validate('product');

// Transaction
$archanai_ticket    = list_validate('archanai_ticket');
$hall_booking       = list_validate('hall_booking');
$cash_donation      = list_validate('cash_donation');
$ubayam             = list_validate('ubayam');
$product_donation	= list_validate('product_donation');
$stock_in           = list_validate('stock_in');
$stock_out          = list_validate('stock_out');
$pay_slip           = list_validate('pay_slip');

//Report
$archanai_report    		= list_validate('archanai_report');
$hall_report        		= list_validate('hall_report');
$cash_report        		= list_validate('cash_report');
$ubayam_report   			= list_validate('ubayam_report');
$product_donation_report	= list_validate('product_donation_report');
$stock_report      			= list_validate('stock_report');
$commission_report      	= list_validate('commission_report');
$payslip_report      	            = list_validate('payslip_report');

//Accounts
$ac_creation_accounts    	= list_validate('ac_creation_accounts');
$entries_accounts    		= list_validate('entries_accounts');
$ledger_report_accounts    	= list_validate('ledger_report_accounts');
$trial_balance_accounts    	= list_validate('trial_balance_accounts');
$balance_sheet_accounts    	= list_validate('balance_sheet_accounts');
$profit_and_loss_accounts   = list_validate('profit_and_loss_accounts');
$ledgers_name_list_accounts   = list_validate('ledgers_name_list_accounts');
$account_group_list_accounts   = list_validate('account_group_list_accounts');


?>
<link href="<?php echo base_url(); ?>/assets/css/menustyle.css" rel="stylesheet">


<section class="top_content hidden-xs  hidden-sm">
    
      <div class="navbar1">
        <div class="nav-links">
          
          <ul class="links">
            <li><a href="<?php echo base_url(); ?>/dashboard"><img src="<?php echo base_url(); ?>/assets/images/dash.png" style="width:50px; display:block;"><span>Dashboard</span></a></li>
            <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/archanai.png" style="width:50px; display:block;"><span>Archanai  <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i></span></a>
              <ul class="js-sub-menu sub-menu">
                <li><a href="<?php echo base_url(); ?>/archanai">Archanai Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/archanaibooking">Entry</a></li>
                <li><a href="<?php echo base_url(); ?>/report/arch_book_rep_view">Report</a></li>
              </ul>
            </li>
            <li>
              <a href="#"><img src="<?php echo base_url(); ?>/assets/images/booking.png" style="width:50px; display:block;"><span>Booking <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i></span></a>
              <ul class="htmlCss-sub-menu sub-menu">
                <li><a href="<?php echo base_url(); ?>/master/hall">Hall Package Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/hallbooking">Hall Booking</a></li>
                <li><a href="<?php echo base_url(); ?>/report/hall_booking_rep_view">Report</a></li>
              </ul>
            </li>
            <li>
              <a href="#"><img src="<?php echo base_url(); ?>/assets/images/donation.png" style="width:50px; display:block;"><span>Donation <i class='bx bxs-chevron-down js-arrow arrow '></i></span></a>
              <ul class="js-sub-menu sub-menu">
                <li><a href="<?php echo base_url(); ?>/master/donation_setting">Donation Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/master/uom">UOM Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/master/product">Product Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/donation">Cash Donation</a></li>
                <li><a href="<?php echo base_url(); ?>/productdonation">Product Donation</a></li>
                <li><a href="<?php echo base_url(); ?>/report/cash_don_rep_view">Cash Donation Report</a></li>
                <li><a href="<?php echo base_url(); ?>/report/prod_don_rep_view">Product Donation Report</a></li>
              </ul>
            </li>
            <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/ubayam.png" style="width:50px; display:block;"><span>Ubayam <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i></span></a>
              <ul class="js-sub-menu sub-menu">
                <li><a href="<?php echo base_url(); ?>/master/ubayam_setting">Ubayam Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/ubayam">Entry</a></li>
                <li><a href="<?php echo base_url(); ?>/ubayam/ubayam_calendar">Ubayam Calendar</a></li>
                <li><a href="<?php echo base_url(); ?>/report/ubayam_rep_view">Report</a></li>
              </ul>
            </li>
            <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/inventory.png" style="width:50px; display:block;"><span>Inventory <i class='bx bxs-chevron-down js-arrow arrow '></i></span></a>
              <ul class="js-sub-menu sub-menu">
              <li><a href="<?php echo base_url(); ?>/master/stock_category">Stock Category Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/master/stock_group">Stock Group Setting</a></li>
                <li><a href="<?php echo base_url(); ?>/stock/stock_in">Stock In Entry</a></li>
                <li><a href="<?php echo base_url(); ?>/stock/stock_out">Stock Out Entry</a></li>
                <li><a href="<?php echo base_url(); ?>/report/stock_rep_view">Stock Report</a></li>
              </ul>
            </li>
            <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/account.png" style="width:50px; display:block;"><span>Account  <i class='bx bxs-chevron-down js-arrow arrow '></i></span></a>
            	<ul class="js-sub-menu sub-menu">
                    <li><a href="<?php echo base_url(); ?>/account">A/C Creation</a></li>
                    <li><a href="<?php echo base_url(); ?>/account/entries">Entries</a></li>
                    <li><a href="<?php echo base_url(); ?>/accountreport/ledger_report">General Ledger</a></li>
                    <li><a href="<?php echo base_url(); ?>/accountreport/trail_balance">Trial Balance</a></li>
                    <li><a href="<?php echo base_url(); ?>/balance_sheet">Balance Sheet</a></li>
                    <li><a href="<?php echo base_url(); ?>/accountreport/profile_loss">Profit & Loss Reports</a></li>
                    <li><a href="<?php echo base_url(); ?>/report/ledger_rep_view">Ledger Report</a></li>
                    <li><a href="<?php echo base_url(); ?>/report/groups_rep_view">Account Group Report</a></li>
                </ul>
            </li>
            <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/finance.png" style="width:50px; display:block;"><span>Finance  <i class='bx bxs-chevron-down js-arrow arrow '></i></span></a>
            	<ul class="js-sub-menu sub-menu">
                    <li><a href="<?php echo base_url(); ?>/user">User Setting </a></li>
                    <li><a href="<?php echo base_url(); ?>/master/staff">Staff Setting</a></li>
                    <li><a href="<?php echo base_url(); ?>/payslip">Pay Slip</a></li>
                    <li><a href="<?php echo base_url(); ?>/payslip/advance_salary">Advance Salary</a></li>
                    <li><a href="<?php echo base_url(); ?>/report/commission_rep_view">Commission Report</a></li>
                    <li><a href="<?php echo base_url(); ?>/report/">Pay Slip Report</a></li>
                </ul>
            </li>
            <li><a href="#"><img src="<?php echo base_url(); ?>/assets/images/profile.png" style="width:50px; display:block;"><span>Member  <i class='bx bxs-chevron-down js-arrow arrow '></i></span></a>
            	<ul class="js-sub-menu sub-menu">
                    <li><a href="<?php echo base_url(); ?>/member">Member Registration</a></li>
                    <li><a href="<?php echo base_url(); ?>/member_type">Member Type</a></li>
                    <li><a href="<?php echo base_url(); ?>/report/member_report">Report</a></li>
                </ul>
            </li>
            <li><a href="#"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:50px; display:block;"><span>Profile  <i class='bx bxs-chevron-down js-arrow arrow '></i></span></a>
            	<ul class="js-sub-menu sub-menu">
                    <li><a href="<?php echo base_url(); ?>/profile/profile_edit">Temple Setting</a></li>
                    <li><a href="<?php echo base_url(); ?>/login/logout">Sign Out</a></li>
                </ul>
            </li>
          </ul>
        </div>
        
      </div>
                    
    
</section>


<header class=" hidden-md  hidden-lg">
  <div class="menu-button__wrapper">
    <div class="menu-button">
      <span class="menu-button__bar"></span>
      <span class="menu-button__bar"></span>
      <span class="menu-button__bar"></span>
    </div>
  </div>

  <div class="menu-overlay">
    <section>
    <aside id="leftsidebar" class="sidebar">
        <div class="user-info">
            <!--<div class="image">
                <img src="<?php echo base_url(); ?>assets/images/user.png" width="48" height="48" alt="User" />
            </div>-->
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:12px;"><i class="material-icons">person</i> <?php echo $_SESSION['log_name']; ?></div>
                <!--<div class="email">john.doe@example.com</div>-->
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo base_url(); ?>/profile/myprofile"><i class="material-icons">person</i>Profile</a></li>
                        <!--<li role="separator" class="divider"></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>-->
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>/login/logout"><i class="material-icons">input</i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active">
                    <a href="<?php echo base_url(); ?>/dashboard"><i class="material-icons">home</i><span>Dashboard</span></a>
                </li>
				<?php if($user_setting || $member_setting || $staff_setting || $archanai_setting || $hall_setting || $donation_setting || $ubayam_setting || $uom || $timing || $stock_group || $product) { ?>
					
					<li>
						<a href="javascript:void(0);" class="menu-toggle"><i class="material-icons">widgets</i><span>Master</span></a>
						<ul class="ml-menu">
							<?php 
							if($temple_setting) {
								if($view_per == 1) {?>
									<li><a href="<?php echo base_url(); ?>/profile"><span>Temple Setting</span></a></li>
								<?php } else { ?>
									<li><a href="<?php echo base_url(); ?>/profile/profile_edit"><span>Temple Setting</span></a></li>
								<?php } 
							} 
							if($user_setting) { ?>
                                <li><a href="<?php echo base_url(); ?>/user"><span>User Setting</span></a></li>
                            <?php } 
                            if($member_setting){
                                ?>
                                <li><a href="<?php echo base_url(); ?>/member"><span>Member Card</span></a></li>
                            <?php
                                }
							if($staff_setting) { ?>
                                <li><a href="<?php echo base_url(); ?>/master/staff"><span>Staff Setting</span></a></li>
							<?php } 
							if($archanai_setting) { ?>
                                <li><a href="<?php echo base_url(); ?>/archanai"><span>Archanai Setting</span></a></li>
                            <?php } 
							if($hall_setting) { ?>
                                <li><a href="<?php echo base_url(); ?>/master/hall"><span>Hall Package Setting</span></a></li>
                            <?php }
							if($donation_setting) { ?>
                                <li><a href="<?php echo base_url(); ?>/master/donation_setting"><span>Donation Setting</span></a></li>
                            <?php }
							if($ubayam_setting) { ?>
                                <li><a href="<?php echo base_url(); ?>/master/ubayam_setting"><span>Ubayam Setting</span></a></li>                           						
							<?php }
							if($uom) { ?>
                                <li><a href="<?php echo base_url(); ?>/master/uom"><span>UOM</span></a></li>
							<?php }
							//if($timing) { ?>
                                <!--<li><a href="<?php echo base_url(); ?>/master/timing"><span>Timing</span></a></li>-->
							<?php //}
							if($stock_group) { ?>
                                <li><a href="<?php echo base_url(); ?>/master/stock_category">Stock Category Setting</a></li>
                                <li><a href="<?php echo base_url(); ?>/master/stock_group"><span>Stock group</span></a></li>
							<?php }
							if($product) { ?>
                                <li><a href="<?php echo base_url(); ?>/master/product"><span>Product</span></a></li>
							<?php } ?>
						</ul>
					</li>
                <?php } 
				
				if($archanai_ticket || $hall_booking || $cash_donation || $ubayam || $product_donation || $stock_in || $stock_out || $pay_slip) { ?>				
				
					<li>
						<a href="javascript:void(0);" class="menu-toggle"><i class="material-icons">widgets</i><span>Transactions</span></a>
						<ul class="ml-menu">
							<?php if($archanai_ticket) { ?>
                                <li><a href="<?php echo base_url(); ?>/archanaibooking"><span>Archanai Ticket</span></a></li>
                            <?php }
							if($hall_booking) { ?>
                                <li><a href="<?php echo base_url(); ?>/hallbooking"><span>Hall Booking</span></a></li>
                            <?php }
							if($cash_donation) { ?>
                                <li><a href="<?php echo base_url(); ?>/donation"><span>Cash Donation</span></a></li>
                            <?php }
							if($ubayam) { ?>
                                <li><a href="<?php echo base_url(); ?>/ubayam"><span>Ubayam</span></a></li>
							<?php }
							if($product_donation) { ?>
                                <li><a href="<?php echo base_url(); ?>/productdonation"><span>Product Donation</span></a></li>
							<?php }
							if($stock_in) { ?>
                                <li><a href="<?php echo base_url(); ?>/stock/stock_in"><span>Stock In</span></a></li> 
							<?php }
							if($stock_out) { ?>
                                <li><a href="<?php echo base_url(); ?>/stock/stock_out"><span>Stock Out</span></a></li> 
							<?php }
							if($pay_slip) { ?>
                                <li><a href="<?php echo base_url(); ?>/payslip"><span>Pay Slip</span></a></li> 
							<?php }  
                            if($pay_slip) { ?>
                                <li><a href="<?php echo base_url(); ?>/payslip/advance_salary"><span>Advance Salary</span></a></li> 
							<?php } ?>
						</ul>
					</li>					
                <?php }				
				
				if($archanai_report || $member_setting || $hall_report || $cash_report || $ubayam_report || $product_donation_report || $stock_report || $commission_report || $payslip_report) { ?>
					<li>
						<a href="javascript:void(0);" class="menu-toggle"><i class="material-icons">history</i><span>Report</span></a>
						<ul class="ml-menu">
							<?php if($archanai_report) { ?>
								<li><a href="<?php echo base_url(); ?>/report/arch_book_rep_view"><span>Archanai Report</span></a></li>
                            <?php }
                            if($member_setting){ ?>
                                <li><a href="<?php echo base_url(); ?>/report/member_report"><span>Member Report</span></a></li>
                            <?php }
							if($hall_report) { ?>
                                <li><a href="<?php echo base_url(); ?>/report/hall_booking_rep_view"><span>Hall Booking Report</span></a></li>
                            <?php }
							if($cash_report) { ?>    
                                <li><a href="<?php echo base_url(); ?>/report/cash_don_rep_view"><span>Cash Donation Report</span></a></li>
                            <?php }
							if($ubayam_report) { ?>
                                <li><a href="<?php echo base_url(); ?>/report/ubayam_rep_view"><span>Ubayam Report</span></a></li>
                            <?php }
							if($product_donation_report) { ?>
                                <li><a href="<?php echo base_url(); ?>/report/prod_don_rep_view"><span>Product Donation Report</span></a></li>
								<?php }
							if($stock_report) { ?>   
                                <li><a href="<?php echo base_url(); ?>/report/stock_rep_view"><span>Stock Report</span></a></li> 
								<?php }
							if($commission_report) { ?>
                                <li><a href="<?php echo base_url(); ?>/report/commission_rep_view"><span>Commission Report</span></a></li> 
							<?php } 
                            if($payslip_report) { ?>
                                <li><a href="<?php echo base_url(); ?>/report/"><span>Pay Slip Report</span></a></li> 
							<?php } ?>
							<li><a href="<?php echo base_url(); ?>/report/ledger_rep_view"><span>Ledger Report</span></a></li>
                            <li><a href="<?php echo base_url(); ?>/report/groups_rep_view"><span>Account Group Report</span></a></li>
						</ul>
					</li>
				<?php }				
				
				if($ac_creation_accounts || $entries_accounts || $ledger_report_accounts || $trial_balance_accounts || $balance_sheet_accounts || $profit_and_loss_accounts || $ledgers_name_list_accounts || $account_group_list_accounts) { ?>
                
					<li>
						<a href="javascript:void(0);" class="menu-toggle"><i class="material-icons">playlist_add_check</i><span>Accounts</span></a>
						<ul class="ml-menu">
							<?php if($ac_creation_accounts) { ?>
								<li><a href="<?php echo base_url(); ?>/account"><span>A/C Creation</span></a></li>
							<?php }
							if($entries_accounts) { ?>							
								<li><a href="<?php echo base_url(); ?>/account/entries"><span>Entries</span></a></li>
							<?php }
							if($ledger_report_accounts) { ?>
								<li><a href="<?php echo base_url(); ?>/accountreport/ledger_report"><span>General Ledger</span></a></li>
							<?php }
							if($trial_balance_accounts) { ?>
								<li><a href="<?php echo base_url(); ?>/accountreport/trail_balance"><span>Trial Balance</span></a></li>
							<?php }
							if($balance_sheet_accounts) { ?>
								<li><a href="<?php echo base_url(); ?>/balance_sheet"><span>Balance Sheet</span></a></li>
							<?php }
							if($profit_and_loss_accounts) { ?>
								<li><a href="<?php echo base_url(); ?>/accountreport/profile_loss"><span>Profit & Loss Reports</span></a></li>
							<?php }	
							?>
						</ul>
					</li> 
                <?php }	?>

                <!-- <li>
                    <a href="javascript:void(0);" class="menu-toggle"><i class="material-icons">widgets</i><span>Reports</span></a>
                    <ul class="ml-menu"> -->
                    
                    
<!-- 
                    </ul>
                </li> -->
                
            </ul>

        </div>
        <!--<div class="legal">
            <div class="copyright">
                &copy; 2022 <a href="#">ADMIN</a>. All Rights Reserved.
            </div>
        </div>-->
    </aside>
</section>
  </div>
  <div class="background-overlay"></div>

</header> 

<script src="<?php echo base_url(); ?>/assets/js/menustyle.js"></script>  



