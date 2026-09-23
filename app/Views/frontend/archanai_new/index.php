<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<style>
body { height:100vh; width:100%; }
.navbar-light .navbar-nav .nav-link {
    font-weight: 500;
}
/*.row { width:100%; }*/
.btn { padding: 0.25rem 0.5rem; height: 2rem; }
.product { /*height:500px;*/ max-height:67vh; overflow:auto; }
.cart { /*height:330px;*/ height:32vh; max-height:32vh; overflow:auto; width:100%; margin-bottom:10px; margin-top:10px; }
select.form-control:not([size]):not([multiple]) {
    height: calc(1.625rem + 2px);
}
.prod::-webkit-scrollbar {
  width: 3px;
}
.prod::-webkit-scrollbar-track, .prod1::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
.prod::-webkit-scrollbar-thumb, .prod1::-webkit-scrollbar-thumb {
  background: #d4aa00; 
}
.prod::-webkit-scrollbar-thumb:hover, .prod1::-webkit-scrollbar-thumb:hover {
  background: #e91e63; 
}

.prod1::-webkit-scrollbar {
  height: 3px;
}
a { text-decoration:none !important; }
.text-muted.arch { 
	color:#000000 !important; 
	font-size:12px !important;
	text-align:center; padding:10px;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	text-overflow: ellipsis; 
	max-height:50px;
	min-height:50px;
	text-transform:uppercase;
}
.show-cart { max-height:350px; overflow:auto; }
.show-cart tr { border-radius:10px; }
.show-cart td { font-size:11px; padding:5px; }
.total { margin-top:15px; padding-bottom:10px; } 
.total p { font-size: 24px; font-weight: bold; }
.submit_btn { width:100%; font-size:24px; padding:7px; height:50px; background: #d4aa00; border:#d4aa00; margin-top:1px; }
.amt { padding:3px 5px; font-weight:bold; color:#333333 !important; }
.prod_img { width:90px; margin:0 auto; border-radius: 50%; min-height:90px; max-height:90px;
    background: #e1e1d68a;
    padding: 5px; }
.clear-cart i, .total_cart i { font-size:28px; color:#000000bd;  }
.item-count {
    background: #dfdbdb;
    padding: 5px 1px;
    margin: 0 3px;
    border-radius: 5px;
    max-width: 27px;
    min-width: 27px;
    text-align: center;
    font-size: 14px;
}

.count {
    position: absolute;
    left: 28px;
    top: 7px;
    background: #051898;
    border-radius: 50%;
    padding: 2px 7px;
    font-size: 12px;
    color: #FFF;
}
.fade.show {
    opacity: 1;
    background: #abaaaad4;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.popup_table { height:50vh; overflow:auto; margin-top:15px; }
.show-cart_popup_table tr th { text-align:left; font-size:12px; font-weight:600; padding:5px; border-bottom:1px solid #E4E4E4; }
.show-cart_popup_table tr td, .show-cart_popup_table tr td p { text-align:left; font-size:11px; padding:5px; line-height:17px; border:0; }

.sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title { display:block !important; font-size:11px; color:#FFFFFF; }
.sidebar .nav .nav-item.active > .nav-link i.menu-icon {
    background: #edc10f;
    padding: 1px; list-style:outside;
    border-radius: 5px;
    box-shadow: 2px 5px 15px #00000017;
}
.sidebar-icon-only .sidebar .nav .nav-item .nav-link {
    display: block;
    padding-left: 0.25rem;
    padding-right: 0.25rem;
    text-align: center;
    position: static;
}
.sidebar-icon-only .sidebar .nav .nav-item .nav-link[aria-expanded] .menu-title {
    padding-top: 7px;
}
.form-group {
    margin-bottom: 0.5rem;
}
.caticon { font-size:22px; text-align:center; line-height:2em; }
@media (min-width: 1200px) {
.col-xl-3 { flex: 0 0 20%; max-width: 20%; }
}
.sidebar-icon-only .main-panel {
    width: calc(100% - 0px);
}
.ar_btn {
    background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
    border-radius: 15px;
    font-weight: bold;
    height: 1.75em;
}
.cl_btn {
    background: linear-gradient(179deg, rgb(212 0 0) 0%, rgb(242 105 105) 35%, rgb(209 59 59) 100%);
    border-radius: 15px;
    font-weight: bold;
    height: 1.75em;
}
@media (max-width: 960px) {
span.archa_name {
    text-transform: uppercase;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100px;
    display: inline-block;
}
.btn { padding: 0.25rem 0.35rem !important; }
}
</style>

<body class="sidebar-icon-only">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    
    
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <!--<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="typcn typcn-spanner-outline menu-icon"></i>
              <span class="menu-title">Setting</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link">
              <i class="typcn typcn-document-text menu-icon"></i>
              <span class="menu-title">Entry</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link">
              <i class="typcn typcn-film menu-icon"></i>
              <span class="menu-title">Report</span>
            </a>
          </li>
        </ul>
      </nav>-->
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <?php if($_SESSION['succ'] != '') { ?>
              <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
                  <div class="suc-alert" style="width: 100%;">
                      <span class="suc-closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
                      <p><?php echo $_SESSION['succ']; ?></p> 
                  </div>
              </div>
          <?php } ?>
            <?php if($_SESSION['fail'] != '') { ?>
              <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
                  <div class="alert" style="width: 100%;">
                      <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
                      <p><?php echo $_SESSION['fail']; ?></p>
                  </div>
              </div>
          <?php } ?>
        <div class="row">
        	<div class="row">
            <div class="col-xl-8 col-sm-6 col-lg-7 col-md-7 stretch-card flex-column">
              
              
                <ul id="filters" class="clearfix prod1">
                  <!--<li><span class="filter " data-filter=".app, .logo, .icon">All</span></li>-->
                  <?php 
                  foreach($archanai as $key => $value){ 
                  if(!empty($value)) {
                  ?>
                    <li><span class="filter" data-filter=".<?php if(!empty($key)) { echo str_replace(' ', '_', strtolower($key)); } ?>"><br><?php if(!empty($key)) { echo strtoupper($key); } ?></span></li>
                  <?php } }?>
                  
                </ul>
              
              <div class="row prod product" id="portfoliolist">
                  <?php 
                  foreach($archanai as $key => $value){ 
                  if(!empty($value)) {
                  ?>
                  <?php foreach($value as $row) { ?>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio <?php if(!empty($key)) { echo str_replace(' ', '_', strtolower($key)); } ?>" data-cat="<?php if(!empty($key)) { echo str_replace(' ', '_', strtolower($key)); } ?>" >
                  <div class="card">
                     <a href="#" data-product_id="<?php echo $row['id']; ?>" data-name="<?php echo str_replace(' ', '_', strtolower($row['name_eng'])); ?>" data-price="<?php echo number_format((float)($row['amount']), 2);?>" class="add-to-cart" data-src="<?php echo base_url(); ?>/uploads/archanai/<?php echo $row['image']; ?>" data-category="<?php echo $row['archanai_category']; ?>" data-group="<?php echo $row['groupname']; ?>">
                     <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/uploads/archanai/<?php echo $row['image']; ?>">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                    <?php
                    $englishName = $row['name_eng'];
                    $tamilName = $row['name_tamil'];
                    
                    if (strlen($englishName) > 20) {
                       
                        echo '<p class="mb-0 text-muted arch">' . $englishName . '</p>';
                    } else {
                        
                        echo '<p class="mb-0 text-muted arch">' . $englishName . '<br>' . $tamilName . '</p>';
                    }
                    ?>
                </div>
                    </div>
                    </a>
                  </div>
                </div>
                <?php } ?>
                <?php } }?>

               
                
              </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-lg-5 col-md-5 stretch-card flex-column">
              <div class="h-100">
                <div class="stretch-card" style="height:100%;">
                  <div class="card">
                    <div class="card-body">
                    <form action="" method="post">
                      <input type="hidden"  name="billno"  id="billno" class="form-control" value="<?php echo $bill_no; ?>" readonly>
                      <div class="d-flex align-items-start flex-wrap"> 

                         <div class="d-flex justify-content-between" style="width:100%;">
                         <!--<a class="count-indicator total_cart d-flex align-items-center justify-content-center" id="notificationDropdown" href="#">
                         <i class="typcn typcn-shopping-cart mx-0"></i>
                         <span class="count total-count"></span></a>
                         <a class="clear-cart" style="margin-top: -10px;"><i class="typcn typcn-trash"></i></a>-->
                         <div class="" id="ar_addrasi_cont"  style="display:none;">
                         <button type="button" class="btn btn-info btn-lg ar_btn" onClick="userModalRasi();">Add Rasi</button>
                         </div>
                         <button type="button" class="btn btn-warning btn-lg ar_btn" onClick="rePrint();" style="background: #FFC107;border: 1px solid #FFC107;color: #fff;">Reprint</button>
                         <button type="button" class="btn btn-danger btn-lg cl_btn clear-cart">Clear All</button>
                         </div>
                         
                         <div class="prod cart  col-md-12">
                            <table class="show-cart" style="width:100%;"></table>
                          </div>
                         <!--div class="col-md-6">
                             <div class="form-group">
                                <input type="text" placeholder="Enter Name.." name="ar_name"  id="ar_name" class="form-control" value="" />
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                <select class="form-control" name="rasi_id" id="rasi_id">
                                    <option>Select Rasi</option>
                                    <?php foreach($rasi as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng'];?></option>
                                    <?php } ?>
                                </select>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                <select class="form-control" name="natchathra_id" id="natchathra_id">
                                    <option>Select Natchathiram</option>
                                </select>
                             </div>
                         </div-->
                         <div class="col-md-6"></div>
                         <div class="col-md-6">
                         </div>
                            <div class="" id="ar_name_cont" style="display:none;" >
                                <!--button type="button"  name="ar_add_btn"  id="ar_add_btn" class="btn btn-info" style="width:100%;">Add</button-->
                            
                         <input type="hidden" value="0" name="cnt1" id="count1">
                          <div class="cart_tab_outer col-md-12" >
                            <table class="rasi-table1" style="width:100%">
                              <thead>
                                <th style="width: 38%;">Name</th>
                                <th style="width: 32%;">Rasi</th>
                                <th style="width: 35%;">Natchathiram</th>
                                <th style="width: 5%;"></th>
                              </thead>
                              <tbody class="rasi-body prod">
                              </tbody>
                            </table>
                          </div>
                          </div>
                         

                        <div id="vehicle_input_box" class="col-md-12" style="display:none;">
                          <div class="row">
                            <div class="col-md-4" >
                              <div class="form-group">
                                <input type="text"  name="vle_name"  id="vle_name" placeholder="Vehicle Name" class="form-control"/>
                              </div>
                            </div>
                            <div class="col-md-4" >
                              <div class="form-group">
                                  <input type="text" name="vle_no_name"  id="vle_no_name" placeholder="Vehicle No" class="form-control"/>
                              </div>
                            </div>
                            <div class="col-md-4" >
                                <div class="" id="vle_name_cont" >
                                  <button type="button"  name="vle_add_btn"  id="vle_add_btn" class="btn btn-info form-control">Add</button>
                              </div>
                            </div>        
                          </div>
                        </div> 
                        <div id="vehicle_table_box" class="" style="display:none;">
                            <input type="hidden" value="0" name="cnt_vehicle" id="count_vehicle">
                            <div class="cart_tab_outer12 col-md-12">
                                <table class="vehicle-table">
                                    <thead>
                                        <th style="width: 50%;">Vehicle Name</th>
                                        <th style="width: 50%;">Vehicle No</th>
                                    </thead>
                                    <tbody class="vehicle-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12" <?php if(!empty($setting['archanai_discount'])){ echo ' style="display: block;"'; }else echo ' style="display: none;"'; ?>>
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <div class="col-md-6 ">
                                    <h5 style="text-align: center; margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Archanai Amount</h5>
                                    <input style="text-align: center" type="number" min="0" step="any" id="sub_total" class="form-control" name="sub_total" value="0" readonly>
                                </div>

                                <div class="col-md-6 ">
                                    <h5 style="text-align: center; margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Discount</h5>
                                    <input style="text-align: center" type="number" min="0" step="any" id="discount_amount" class="form-control" name="discount_amount" value="0">
                                </div>
                            </div>
						            </div>
                                        
                         <div class="total d-flex justify-content-between align-items-center" style="width:100%; border-bottom:1px dashed #CCC;">
                        	<p class="mb-0">Total </p>
                            <p class="mb-0">RM : <span class="total-cart"></span></p>
                            <input type="hidden" id="tot_amt" name="tot_amt">
                         </div>
                         
                         <?php /* <div class="col-md-12">
							<div class="form-group form-float" style="margin: 10px;">
								<div class="form-line" >
									<!--<label>Comission To</label>-->
									<select class="form-control" name="comission_to">
										<option value="0">Select Staff for Commission</option>
										<?php foreach($staff as $row) { ?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['name'];?></option>
										
										<?php } ?>
									</select>
								</div>
							</div>
						</div> */ ?>
                        <!--h5 class="pay_mode">Payment Mode</h5-->
                         <ul class="payment">
                          <li><input type="radio" name="pay_method" id="cb1" value="cash" />
                            <label for="cb1"><i class="mdi mdi-square-inc-cash"></i> Cash</label>
                          </li>
                          <li><input type="radio" name="pay_method" id="cb3" value="qr" />
                            <label for="cb3"><i class="mdi mdi-qrcode"><br></i> QR</label>
                          </li>
                          <li><input type="radio" name="pay_method" id="cb4" value="card" />
                            <label for="cb4"><i class="mdi mdi-credit-card-multiple"></i> Card</label>
                          </li>
                          <li><input type="radio" name="pay_method" id="cb5" value="online" />
                            <label for="cb5"><i class="mdi mdi-web"></i> Online</label>
                          </li>
                        </ul>
                         <!-- <div class="col-md-6 paid_ro" style="padding: 0px;">
                          <div class="col-md-12"><p ><b>PAID AMT RM</b></p></div>
                          <div class="col-md-12"><input type="number" style="font-size:14px;height: 35px;border: 1px solid #cccccc;text-align: center;font-size: 24px;font-weight: bold;" name="paid_amount" id="paid_amount" placeholder="0.00" class="form-control paid_amount"></div>
                        </div>
                        <div class="col-md-6 paid_ro" style="padding: 0px;">
                          <div class="col-md-12"><p ><b>BALANCE AMT RM</b></p></div>
                          <div class="col-md-12"><input type="number" style="font-size:14px;height: 35px;border: 1px solid #cccccc;text-align: center;font-size: 24px;font-weight: bold;" name="balance_amount" id="balance_amount" placeholder="0.00" class="form-control" readonly></div>
                        </div> -->
                         <p style="width:100%; border-bottom:1px dashed #CCC;margin-top: 10px;"></p>
                         <!--<div class="pay_amt d-flex justify-content-between align-items-center" style="width:100%; margin-top:5px;">
                        	<p class="mb-0">Amount : </p>
                            <input type="number" style="width:100px; font-size:14px;" name="amount">
                            <p class="mb-0">Balance RM : </p>
                            <p class="mb-0"><span class="bal-amt total-cart"></span></p>
                         </div>-->
                         
                             <div class="col-xl-6 col-sm-6 col-lg-6 col-md-6 ">
                                 <input type="submit" disabled value="PRINT" class="btn btn-info submit_btn" id="submit">
                             </div>
                             <div class="col-xl-6 col-sm-6 col-lg-6 col-md-6">
                                 <!--button disabled class="btn btn-info submit_btn" id="submit"><span style="font-size:12px;position: absolute;top:1px;">Separate</span> PRINT</button-->
                                 <input type="submit" disabled value="Sep.PRINT" class="btn btn-info submit_btn" id="submit_sep">
                             </div>
                         
                         </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    <!-- Image loader -->
    <div id='loader' style='display: none;'>
            <img src='reload.gif' width='32px' height='32px'>
    </div>
    <!-- Image loader -->  
        <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body p-4" style="padding-bottom:10px;">
                        <div class="text-center">
                            <img src="images/logo.png" alt="logo" style="width:50px; margin:0 auto;"/>
                            <h5 class="mt-2">ARULMIGU SREE GANESHAR TEMPLE</h5>
                            <div class="popup_table prod">
                                <table class="table show-cart_popup_table" style="width:100%;">
                                    <tr><th style="width:10%">S.No</th>
                                    <th style="width:55%">Archanai</th>
                                    <th style="width:15%">Qty</th>
                                    <th style="width:20%; text-align:right;">Price</th>
                                    </tr>
                                    <tbody class="show-cart_popup">
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" onClick="print_page()" class="btn btn-info my-3" style="width:100%; font-size:24px; height:auto;margin-bottom: 0 !important;" data-dismiss="modal">PRINT</button>
                        </div>
                    </div>
                </div>
          </div>
        </div>
        
        
                
            </div>
        </div>
        
        
        
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <div id="prin_page"></div>
  <!-- container-scroller -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-4" style="padding-bottom:10px;">
                <div class="text-center">
                    <div class="row"><div class="col-md-5">
                     <div class="form-group">
                        <input type="text" placeholder="Enter Name.." name="ar_name"  id="ar_name" class="form-control" value="" />
                     </div>
                    </div>
                    <div class="col-md-3">
                     <div class="form-group">
                        <select class="form-control" name="rasi_id" id="rasi_id">
                            <option value="">Select Rasi</option>
                            <?php foreach($rasi as $row) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng'];?></option>
                            <?php } ?>
                        </select>
                     </div>
                    </div>
                    <div class="col-md-3">
                     <div class="form-group">
                        <select class="form-control" name="natchathra_id" id="natchathra_id">
                            <option>Select Natchathiram</option>
                        </select>
                     </div>
                     </div>
                     <div class="col-md-1">
                         <button type="button"  name="ar_add_btn"  id="ar_add_btn" class="btn btn-success" style="width:100%;">+</button>
                     </div>
                    </div>
                    <!--input type="hidden" value="0" name="cnt1" id="count1"-->
                      <div class="cart_tab_outer col-md-12" style="padding: 4px;">
                        <table class="" style="width:100%">
                          <thead>
                            <tr style="font-size: 13px;text-align: left;background: #ffc10726;">
                            <th style="width: 38%;">Name</th>
                            <th style="width: 27%;">Rasi</th>
                            <th style="width: 30%;">Natchathiram</th>
                            </tr>
                          </thead>
                          <tbody class="prod rasi-table" style="height:auto; margin-bottom:30px;">
                          </tbody>
                        </table>
                      </div>
                         <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <textarea class="form-control" placeholder="Remarks" name="description" id="description" ></textarea>
                  </div>
              </div>
            </div>
                    <button type="button"  name="ar_add_btn"  id="ar_add_btn" class="btn btn-info my-3"  style="width:100%; font-size:24px; height:auto;margin-bottom: 0 !important;" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
  </div>
</div>

<!--REPRINT SECTION START-->
<div id="myModal_reprint" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-4" style="padding-bottom:10px;">
                <div class="text-center">
                    <div class="row">
                      <div class="col-md-12">
                          <table class="table table-bordered" style="width:100%">
                            <thead>
                              <tr style="font-size: 13px;text-align: left;background: #3F51B5;color: #fff;">
                                <th style="width: 10%;padding: 5px 10px;text-align:center;">S.No</th>
                                <th style="width: 40%;padding: 5px 10px;text-align:center;">Invoice No</th>
                                <th style="width: 40%;padding: 5px 10px;text-align:center;">Amount</th>
                                <th style="width: 10%;padding: 5px 10px;text-align:center;">Action</th>
                              </tr>
                            </thead>
                            <tbody style="height:auto; margin-bottom:30px;">
                                <?php
                                if(count($reprintlists) > 0)
                                {
                                  $ire = 1;
                                  foreach($reprintlists as $reprintlist)
                                  {
                                ?>
                                <tr>
                                  <td style="width: 10%;padding: 5px 0px!important;text-align:center;"><?php echo $ire; ?></td>
                                  <td style="width: 40%;padding: 5px 0px!important;text-align:center;"><?php echo $reprintlist['ref_no']; ?></td>
                                  <td style="width: 40%;padding: 5px 0px!important;text-align:center;"><?php echo $reprintlist['amount']; ?></td>
                                  <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                                    <a class='btn btn-primary' style='font-size: 13px;font-weight: bold;padding: 8px 10px;background: #2196F3;border: 1px solid #2196F3;' title='Print' href='<?php echo base_url(); ?>/archanai_booking/print_booking/<?php echo $reprintlist['id']; ?>' target='_blank'>Print</a>
                                  </td>
                                </tr>
                                <?php
                                  $ire++;
                                  }
                                }
                                ?>
                            </tbody>
                          </table>  
                      </div>
                </div>
            </div>
        </div>
  </div>
</div>
</div>
<!-- REPRINT SECTION END -->
<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
  <!-- base:js -->
  <script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>/assets/archanai/js/off-canvas.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/template.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/settings.js"></script>
  <script src="<?php echo base_url(); ?>/assets/archanai/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>
  
  
  
  <!--script src='https://code.jquery.com/jquery-2.2.4.min.js'></script-->
  <script  src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>
  <!-- <script>
    $(document).ready(function() {
        // Hide paid amount and balance amount fields by default
        $(".paid_ro").hide();

        // When a payment method is selected
        $("input[name='pay_method']").change(function() {
            var selectedPayment = $("input[name='pay_method']:checked").val();

            if (selectedPayment == "cash") {
                // Show paid amount and balance amount for Cash
                $(".paid_ro").show();
            } else {
                // Hide paid amount and balance amount for QR, Card, and Online payment methods
                $(".paid_ro").hide();
            }
        });
    });
</script> -->
<style>
.rasi-table thead, tbody.rasi-body tr, .rasi-table1 thead {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.rasi-table th, .rasi-table1 th { font-size:12px; text-align:left; background: #fcf8eb; }
.rasi-table td, .rasi-table1 td { font-size:12px; text-align:left; }
.rasi-body{
    overflow:auto;
	height:12vh;
	display: block;
}

.vehicle-table thead, tbody.vehicle-body tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.vehicle-table th { font-size:12px; text-align:left; background: #fcf8eb; }
.vehicle-table td { font-size:12px; }
.vehicle-body{
    overflow:auto;
	height:90px;
	display: block;
}

.bal-amt { background:#1def3b; padding:3px 5px; }
.pay_amt p { font-size: 17px; font-weight:bold; }
.navbar + .page-body-wrapper {
    padding-top: calc(3.625rem + 1.875rem);
}
.pay_mode{
    display: block;
    margin-bottom: 0;
    margin-top: 10px;
    width: 100%;
    background: #00d454;
    color: white;
    padding: 5px;
    text-align: center;
    font-size: 16px;
    text-transform: uppercase;
}
#filters {
    margin: 0 0 10px;
    padding: 0;
    list-style: none;
    width: 100%;
    overflow: auto;
    display: inherit;
}

#filters li:first-child {
  margin-left: 0;
}

#filters li {
  float: left;
  background: white;
  margin: 0 7px;
  width:100px;
  max-height:95px;
  min-width:95px;
}

#filters li span {
  display: block;
  padding: 5px 2px;
  text-decoration: none;
  color: #000;
  cursor: pointer;
  transition: color 300ms ease-in-out;
  text-align:center;
  line-height: 1.5em;
  font-size:13px;
  height:95px;
}
.item-count_new {
    background: #dfdbdb;
    padding: 2px 1px;
    margin: 0 3px;
    border-radius: 5px;
    max-width: 50px;
    min-width: 27px;
    text-align: center;
    font-size: 14px;
}

#filters li span:hover {
  color: #d4aa00;
}

#filters li span.active {
  /*background: #d4aa00;*/
  background: linear-gradient(179deg, rgb(212 170 0) 0%, rgb(197 191 16) 35%, rgb(252 245 6) 100%);
  color: #000;
}

#portfoliolist .portfolio {
  display: none;
  float: left;
  overflow: hidden;
}

.portfolio-wrapper {
  overflow: hidden;
  position: relative !important;
  cursor: pointer;
}

.portfolio img {
  max-width: 100%;
  position: relative;
  top: 0;
}

.portfolio .label {
  position: absolute;
  width: 100%;
  height: 40px;
  bottom: -40px;
}

.portfolio .label-bg {
  background: #222;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
}

.portfolio .label-text {
  color: #fff;
  position: relative;
  z-index: 500;
  padding: 5px 8px;
}

.portfolio .text-category {
  display: block;
  font-size: 9px;
}

.container:after {
  content: "\0020";
  display: block;
  height: 0;
  clear: both;
  visibility: hidden;
}

.clearfix:before,
.clearfix:after{
  content: '\0020';
  display: block;
  overflow: hidden;
  visibility: hidden;
  width: 0;
  height: 0;
}

.clearfix {
  zoom: 1;
}

.clear {
  clear: both;
}

.clearfix:after {
  clear: both;
  display: block;
  overflow: hidden;
  visibility: hidden;
  width: 0;
  height: 0;
}

ul.payment {
    list-style-type: none;
    width: 100%;
    display: flex;
    justify-content: space-between;
	margin-bottom:0;
	padding-left:0;
}

.payment li {
    display: inline-block;
    text-align:center;
    width:50%;
}

input[type="radio"][id^="cb"] {
  display: none;
}

label {
  border: 1px solid #CCC;
  border-radius: 5px;
  line-height: 1;
  padding: 5px 15px;
  display: block;
  position: relative;
  margin: 10px 15px;
  cursor: pointer;
  font-weight:bold;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 18px;
  height: 18px;
  text-align: center;
  line-height: 18px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label i.mdi {
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
  font-size:18px;
  color:#0d2f95;
}

:checked + label {
background:#f6ef08;
}

:checked + label:before {
  content: "✓";
  background-color: green;
  transform: scale(1);
}

:checked + i.mdi{
  transform: scale(0.9);
}
  
.archname { }
</style>
<div id="alert_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body p-4" style="padding-bottom:10px;">
          <div class="text-center">
            <div class="row">
              <div class="col-md-12">
                <p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline"
                    style="font-size:42px; color:red;"></i></p>
                <h5 style="text-align:center;" id="spndeddelid"></h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
 </div>  
  
  
  <!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>-->
<script>
function rePrint()
{
    $("#myModal_reprint").modal("show");
}
function openVehicleEntryWithCategory2()
{
    var status_check = 0;
    $( ".archanai_category").each(function() {
        arcat = parseInt($(this).val());
        if(arcat == 2){
            status_check++;
        }
    });
    if(status_check > 0)
    { 
      
        $("#vehicle_input_box").css({"display":"block"});
        $("#vehicle_table_box").css({"display":"block"});
       
    }
    else
    {   
        
        $("#vehicle_input_box").css({"display":"none"});
        $("#vehicle_table_box").css({"display":"none"});
        
       
    }
}
function openVehicleEntryWithCategory1()
{
    $( ".archanai_group").each(function() {
        argrp = $(this).val();
        //alert(argrp);
        $.ajax({
            type:"POST",
            url: "<?php echo base_url(); ?>/archanai_booking/get_group_val",
            data: {argrp:argrp},
			dataType: 'json',
            success:function(data){
                console.log(data.rasi);
                var str = data.rasi;
                if(str==1)
                {
                    $("#ar_addrasi_cont").css({"display":"block"});
                    $("#ar_name_cont").css({"display":"block"}); 
                }
			},
			error:function(err){
				console.log('err');
				console.log(err);
			}
        });
        
        /*if(argrp == 'archanai' ||argrp == 'ARCHANAI' ||argrp == 'POOJA'){
            $("#ar_addrasi_cont").css({"display":"block"});
            $("#ar_name_cont").css({"display":"block"});
        }*/
    });
    
}
$(function() {
var filterList = {
  init: function() {
    // MixItUp plugin
    // http://mixitup.io
    $('#portfoliolist').mixItUp({
      selectors: {
        target: '.portfolio',
        filter: '.filter'
      },
      load: {
        filter: '.<?php echo strtolower($default); ?>'
      }
    });

  }

};
// Run the show!
filterList.init();
});

var shoppingCart = (function() {
  cart = [];
  // Constructor
  function Item(name, price, count, src,product_id,category,group) {
    this.name = name;
    this.price = price;
    this.count = count;
	  this.src = src;
	  this.product_id = product_id;
	  this.category = category;
    this.group=group;
  }
  
  // Save cart
  function saveCart() {
    sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
  }
  
    // Load cart
  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
  }
  if (sessionStorage.getItem("shoppingCart") != null) {
    loadCart();
  }
  
  var obj = {};
  
  // Add to cart
  obj.addItemToCart = function(name, price, count, src,product_id,category,group) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart[item].count ++;
        saveCart();
        return;
      }
    }
    var item = new Item(name, price, count, src,product_id,category,group);
    cart.push(item);
    saveCart();
  }
  // Set count from item
  obj.setCountForItem = function(name, count) {
    for(var i in cart) {
      if (cart[i].name === name) {
        cart[i].count = count;
		saveCart();
        break;
      }
    }
  };
  // Remove item from cart
  obj.removeItemFromCart = function(name) {
      for(var item in cart) {
        if(cart[item].name === name) {
          cart[item].count --;
          if(cart[item].count === 0) {
            cart.splice(item, 1);
          }
          break;
        }
    }
    saveCart();
  }

  // Remove all items from cart
  obj.removeItemFromCartAll = function(name) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart.splice(item, 1);
        break;
      }
    }
    saveCart();
  }

  // Clear cart
  obj.clearCart = function() {
    cart = [];
    saveCart();
  }

  // Count cart 
  obj.totalCount = function() {
    var totalCount = 0;
    for(var item in cart) {
      totalCount += cart[item].count;
    }
    return totalCount;
  }

  // Total cart
  obj.totalCart = function() {
    var totalCart = 0;
    for(var item in cart) {
      totalCart += cart[item].price * cart[item].count;
    }
    return Number(totalCart.toFixed(2));
  }

  // List cart
  obj.listCart = function() {
    var cartCopy = [];
    for(i in cart) {
      item = cart[i];
      itemCopy = {};
      for(p in item) {
        itemCopy[p] = item[p];

      }
      itemCopy.total = Number(item.price * item.count).toFixed(2);
      cartCopy.push(itemCopy)
    }
    return cartCopy;
  }
  return obj;
})();


// Add item
$('.add-to-cart').click(function(event) {
  event.preventDefault();
  var src = $(this).data('src');
  var name = $(this).data('name');
  var price = Number($(this).data('price'));
  var product_id = Number($(this).data('product_id'));
  var category = Number($(this).data('category'));
  //var group = Number($(this).data('group'));
  var group = $(this).data('group');
  shoppingCart.addItemToCart(name, price, 1, src,product_id,category,group);
  displayCart();
});

// Clear items
$('.clear-cart').click(function() {
  shoppingCart.clearCart();
  displayCart();
  $("#ar_addrasi_cont").css({"display":"none"});
  $("#ar_name_cont").css({"display":"none"});
});
$(document).ready(function() {
    
    $(".clear-cart").click(function() {
        
        $("#discount_amount").val(0); // Reset Discount to 0
         $('.total-cart').html("0.00"); // Reset total cart amount display to 0.00
        $('.total-cart').val(0); 
       
       
    });
});


function displayCart() {
  var cartArray = shoppingCart.listCart();
  console.log(cartArray);
  var output = "";
  var popup = "";
  //var output = '<tr><td colspan="4" align="center"><img src="images/cart_is_empty.png" class="img-fluid" style="width:100px; margin:0 auto;"></td></tr>';
  if(cartArray.length == 0)
  {
    output += "tr><td colspan='4' align='center'><img src='/assets/archanai/images/cart_is_empty.png' class='img-fluid' style='width:150px; margin:0 auto;'></td></tr>";
  }
  else
  {
    for(var i in cartArray) {
      output += "<tr style='background:#d4aa0014;'>"
        + "<td style='width:10%'><input type='hidden' name='arch["+i+"][id]' value='"+cartArray[i].product_id+"' ><img data-name=" + cartArray[i].name + " src='" + cartArray[i].src + "' style='width:35px; border:1px solid #e9e6e6; background:#FFF; border-radius:5px;'></td>"
      + "<td style='width:42%'><input type='hidden' name='arch["+i+"][amt]' value='"+(Number(cartArray[i].price).toFixed(2))+"' ><span class='archa_name' style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>" 
        + "RM : " + (Number(cartArray[i].price).toFixed(2)) + "</td>"
        + "<td style='width:35%'><div class='input-group'><button class='minus-item input-group-addon btn btn-primary' data-name=" + cartArray[i].name + ">-</button>"
        + "<input type='number' min='1' class='item-count_new' data-name='" + cartArray[i].name + "' value='"+cartArray[i].count+"'>"
        + "<button class='plus-item btn btn-primary input-group-addon' data-name=" + cartArray[i].name + ">+</button><input type='hidden' name='arch["+i+"][qty]' value='"+cartArray[i].count+"' class='item-count'><input type='hidden' class='archanai_category' value='"+cartArray[i].category+"'><input type='hidden' class='archanai_group' value='"+cartArray[i].group+"'></div></td>"
        + "<td style='width:8%'><button class='delete-item btn btn-danger' data-name=" + cartArray[i].name + ">X</button></td>"
        +  "</tr><tr><td colspan='4'></td></tr>";
      $('#submit, #submit_sep').removeAttr('disabled');
    }
    for(var i in cartArray) {
      popup += "<tr>"
        + "<td>" + i + "</td>"
      + "<td><span style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>RM : " + Number(cartArray[i].price).toFixed(2) + "</td>"
        + "<td><p data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p></td>"
      + "<td style='text-align:right;'>" + Number(cartArray[i].total).toFixed(2) + "</td></tr>";
    }
  }

  var sub_total = Number(shoppingCart.totalCart());
  var discount = ($('#discount_amount').val() != '') ? parseFloat($('#discount_amount').val()) : 0;
  var tot_amt = sub_total - discount;
  
  $('.show-cart').html(output);
  $('.total-cart').html(tot_amt.toFixed(2));
  $('#sub_total').val(sub_total.toFixed(2));
  $('#discount_amount').attr('max', sub_total.toFixed(2));
  if(discount > sub_total) $('#discount_amount').val(sub_total.toFixed(2));
  $('#tot_amt').val(tot_amt.toFixed(2));
  $('.total-count').html(shoppingCart.totalCount());
  $('.show-cart_popup').html(popup);
  
  paidamount();
  $("#paid_amount").val("");
  $("#balance_amount").val("");
  $("#paid_amount").prop("min",Number(shoppingCart.totalCart()).toFixed(2));

  var tot =  shoppingCart.totalCount();
  if(tot==0) { 
  	$('#submit, #submit_sep').prop('disabled', true); 
  }
  openVehicleEntryWithCategory2();
  openVehicleEntryWithCategory1();
}
$(document).ready(function() {
    paidamount();
    $(".paid_amount").on("keydown keyup", function() {
      paidamount();
    });
    $('#discount_amount').on('blur change', function(){
		displayCart();
	});
});
function paidamount(){
    var tot_val = parseFloat($("#tot_amt").val());
    var paid_amount = parseFloat($("#paid_amount").val());
    if(tot_val < paid_amount){
      var be_balance = tot_val - paid_amount;
      var balance = Math.abs(be_balance);
    }
    else{
      var balance = 0;
    }
    $("#balance_amount").val(Number(balance).toFixed(2));
}

function displayCart1() {
  var cartArray = shoppingCart.listCart();
  var output = '<tr><td colspan="4" align="center"><img src="images/cart_is_empty.png" class="img-fluid" style="width:100px; margin:0 auto;"></td></tr>';
  $('.show-cart').html(output);
  $('.total-cart').html(shoppingCart.totalCart());
  $('.total-count').html(shoppingCart.totalCount());
  $('.show-cart_popup').html(popup);
}

// Delete item button

$('.show-cart').on("click", ".delete-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.removeItemFromCartAll(name);
  displayCart();
  openVehicleEntryWithCategory2();
  openVehicleEntryWithCategory1();
})


// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.removeItemFromCart(name);
  displayCart();
  openVehicleEntryWithCategory2();
  openVehicleEntryWithCategory1();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.addItemToCart(name);
  displayCart();
  openVehicleEntryWithCategory2();
  openVehicleEntryWithCategory1();
})

// Item count input

$('.show-cart').on("change", ".item-count_new", function(event) {
   var name = $(this).data('name');
   var count = Number($(this).val());
   shoppingCart.setCountForItem(name, count);
    displayCart();
});

/* $('.show-cart').on("change", ".item-count", function(event) {
   var name = $(this).data('name');
   var count = Number($(this).val());
  shoppingCart.setCountForItem(name, count);
  displayCart();
}); */

displayCart();

function submit_modal()
{
	$('#modal').show().addClass('show');
}

function print_page()
{
  var cartArray = shoppingCart.listCart();
  var result = "";
  for(var i in cartArray) {
    result += "<tr>"
      + "<td>" + i + "</td>"
	  + "<td><span style='text-transform:uppercase;' class='archname'>" + cartArray[i].name + "</span><br>RM : " + cartArray[i].price + "</td>"
      + "<td><p data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p></td>"
	  + "<td style='text-align:right;'>" + cartArray[i].total + "</td></tr>";
  }
  $('#prin_page').html(result);
  shoppingCart.clearCart();
  displayCart();
  window.print();
}
</script>

<script>
    $(function () {
        $("[data-dismiss='modal']").on('click', function () {
             $('.modal').hide();
        })
    })
</script>

<script>
function userModalRasi()
{
  var rowCount = $('.rasi-table1 tbody tr').length;
  //alert(rowCount);
  if(rowCount >= "6")
  {
     alert("It allow's only 6 names."); 
  }
  else {
      $(".rasi-table").empty();
      $("#myModal").modal("show");
  }
}
</script>

<script>
$("#rasi_id").change(function(){
    var rasi = $("#rasi_id").val();
    if(rasi != "")
    {
      //console.log(rasi_id);
      $.ajax({
        url: '<?php echo base_url();?>/archanai_booking/get_natchathram',
        type: 'post',
        data: {rasi_id:rasi},
        dataType: 'json',
        success:function(response)
        {
          $('#natchathram_id').val(response.natchathra_id);
            var str = response.natchathra_id;
            if(str !="") {
                $("#natchathra_id").empty();
                $('#natchathra_id').append('<option value="">Select Natchathiram</option>');
                  $.each(str.split(','), function(key, value) {
                  $.ajax({
                    url: '<?php echo base_url();?>/archanai_booking/get_natchathram_name',
                    type: 'post',
                    data: {id:value},
                    dataType: 'json',
                    success:function(response)
                    {
                      $('#natchathra_id').append('<option value="' + response.id + '">' + response.name_eng + '</option>');
                    }
                  });
                });
            }
          }
      });
    }
});

$('#ar_add_btn').on('click', function(){
    var ar_name = $('#ar_name').val();
    var rasi_id = $('#rasi_id').val();
    var rasi_text = $( "#rasi_id option:selected" ).text();
    var natchathra_id = $('#natchathra_id').val();
    var natchathra_text = $( "#natchathra_id option:selected" ).text();
    var count1 = $('#count1').val(); 
    var max_fields      = 6;
    var rowCount = $('.rasi-table1 tbody tr').length;
    if(ar_name != "" && rasi_id != "" && natchathra_id != "")
    {
    if(rowCount <= "6") {
        if(count1 < max_fields) {
        var html = '';
        html += '<tr id="remove_row'+count1+'">';
        html += '<td style="width: 38%;"><input type="hidden" name="rasi['+count1+'][arc_name]" value="' + ar_name + '" />' + ar_name + '</td>';
        html += '<td style="width: 27%;"><input type="hidden" name="rasi['+count1+'][rasi_ids]" value="' + rasi_id + '" />' + rasi_text + '</td>';
        html += '<td style="width: 30%;"><input type="hidden" name="rasi['+count1+'][natchathra_ids]" value="' + natchathra_id + '" />' + natchathra_text + '</td>';
        html += '<td style="width: 5%;"><a class="" onclick="remove_arch('+ count1 +')" style="width:auto;"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';
        
        var html1 = '';
        html1 += '<tr>';
        html1 += '<td style="width: 38%;"><input type="hidden" name="rasi['+count1+'][arc_name]" value="' + ar_name + '" />' + ar_name + '</td>';
        html1 += '<td style="width: 27%;"><input type="hidden" name="rasi['+count1+'][rasi_ids]" value="' + rasi_id + '" />' + rasi_text + '</td>';
        html1 += '<td style="width: 30%;"><input type="hidden" name="rasi['+count1+'][natchathra_ids]" value="' + natchathra_id + '" />' + natchathra_text + '</td>';
        html1 += '</tr>';
        
        $('.rasi-table').append(html1);
        $('.rasi-table1').append(html);
        count1++;
        $("#count1").val(count1);
        $('#ar_name').val("");
        $('#rasi_id').val("");
        $('#natchathra_id').val("");
        } 
        else 
        { alert("It allow's only 6 names.");
            $('#ar_name').val("");
            $('#rasi_id').val("");
            $('#natchathra_id').val("");
        }
    }
    else 
    { alert("It allow's only 6 names.");
        $('#ar_name').val("");
        $('#rasi_id').val("");
        $('#natchathra_id').val("");
    }
    }
    

});

function remove_arch(id){
    $("#remove_row"+id).remove();
    var count1 = $('#count1').val(); 
    count1--;
    $("#count1").val(count1);
}




function remove_vehicle(id){
    $(".vehicle-table #remov_vehicle_"+id).remove();
    $("#count_vehicle").val(parseInt($("#count_vehicle").val())-1);
}
$('#remove_vehicle').click(function() {
  $(this).css({"display":"block"});
});
$('#vle_add_btn').on('click', function(){
var vle_name = $('#vle_name').val();
var vle_no = $('#vle_no_name').val();
var count2 = $('#count_vehicle').val(); 
    if(vle_name != "" && vle_no != "")
    {
        var html = '';
        html += '<tr id="remov_vehicle_'+count2 +'">';
        html += '<td width="50%"><input type="hidden" name="vehicle['+count2+'][vle_name]" value="' + vle_name + '" />' + vle_name + '</td>';
        html += '<td width="50%"><input type="hidden" name="vehicle['+count2+'][vle_no]" value="' + vle_no + '" />' + vle_no + '</td>';
        html += '</tr>';
        $('.vehicle-table').append(html);
        count2++;
        $("#count_vehicle").val(count2);
        $('#vle_name').val("");
        $('#vle_no_name').val("");
    }
});
function save_archanai(sep_print = 0){
	$.ajax
    ({
      type:"POST",
      url: "<?php echo base_url(); ?>/archanai_booking/save?sep_print=" + sep_print,
      //data: $("form").serialize(),
      data: $("form").serialize() + "&description=" + $("#description").val(),
      beforeSend: function() {    
        $("#submit, #submit_sep").prop('disabled', true);
        $("#loader").show();
      },
      success:function(data)
      {
        //return;
        obj = jQuery.parseJSON(data);
        if(obj.err != ''){
			$("#submit, #submit_sep").prop('disabled', false);
            $('#alert_modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text(obj.err);
        }else{
			$("#submit, #submit_sep").prop('disabled', false);
			shoppingCart.clearCart();
			displayCart();
			window.open("<?php echo base_url(); ?>/archanai_booking/payment_process/" + obj.id, "_blank", "width=680,height=500");
            window.location.reload(true);
        }
      },
      complete:function(data){
          // Hide image container
          $("#loader").hide();
      },
      error:function(err)
        {
          $("#submit, #submit_sep").prop('disabled', false);
          console.log('err');
          console.log(err);
        }
    });	
}
$("#submit").click(function(){
	save_archanai();
}); 
$("#submit_sep").click(function(){
	save_archanai(1);
}); 

//$('input[name=pay_method]').on('change', function(){
// 	if(this.value == 'qr' || this.value == 'card' || this.value == 'online'){
// 		$('.paid_ro').hide();
// 		var tot_amt = $('#tot_amt').val();
// 		$('#paid_amount').val(tot_amt);
// 		$('#paid_amount').prop('required', false);
// 	}else{
// 		$('#paid_amount').val(0.00);
// 		$('#paid_amount').prop('required', true);
// 		$('.paid_ro').show();
// 	}
// 	paidamount();
// });
</script>


  
</body>

