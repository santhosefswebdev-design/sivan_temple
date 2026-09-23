
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $_SESSION['site_title']; ?></title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css"/>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<style>
body { height:100vh; width:100%; }
/*.row { width:100%; }*/
.btn { padding: 0.5rem 0.5rem; height: 1.97rem; }
.product { /*height:500px;*/ max-height:80vh; overflow:auto; }
.cart { /*height:330px;*/ height:45vh; max-height:45vh; overflow:auto; width:100%; }
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
	font-size:14px;
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
.show-cart td { font-size:12px; padding:5px; }
.total { margin-top:15px; padding-bottom:10px; } 
.total p { font-size: 24px; font-weight: bold; }
.submit_btn { width:100%; font-size:32px; padding:7px; height:50px; background: #d4aa00; border:#d4aa00; margin-top:10px; }
.amt { padding:3px 5px; font-weight:bold; color:#333333 !important; }
.prod_img { width:90px; margin:0 auto; border-radius: 50%;
    background: #e1e1d68a;
    padding: 5px; }
.clear-cart i, .total_cart i { font-size:28px; color:#000000bd;  }
.item-count {
    background: #dfdbdb;
    padding: 5px;
    margin: 0 3px;
    border-radius: 5px;
    max-width: 25px;
    min-width: 25px;
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
</style>
</head>
<body class="sidebar-icon-only">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <!--<a class="navbar-brand brand-logo" href=""><img src="images/logo.png" alt="logo"/></a>-->
          <a class="navbar-brand brand-logo-mini" href=""><img src="<?php echo base_url(); ?>/assets/archanai/images/logo.png" alt="logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-profile dropdown">
              <img src="<?php echo base_url(); ?>/assets/archanai/images/logo.png" alt="logo"/>
              <span class="nav-profile-name"><?php echo $_SESSION['site_title']; ?></span>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown mr-0">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="typcn typcn-user mx-0"></i>            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="typcn typcn-cog-outline text-primary"></i>
                Settings              </a>
              <a class="dropdown-item">
                <i class="typcn typcn-eject text-primary"></i>
                Logout              </a>            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
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
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        <div class="row">
        	<div class="row">
            <div class="col-xl-8 col-sm-6 col-lg-7 col-md-7 grid-margin stretch-card flex-column">
              
              
                <ul id="filters" class="clearfix prod1">
                  <!--<li><span class="filter " data-filter=".app, .logo, .icon">All</span></li>-->
                  <li><span class="filter active" data-filter=".app"><img src="<?php echo base_url(); ?>/assets/archanai/images/icon0.png" style="width:auto; height:60px;"><br>Daily Archanai</span></li>
                  <li><span class="filter" data-filter=".logo"><img src="<?php echo base_url(); ?>/assets/archanai/images/icon1.png" style="width:auto; height:60px;"><br>Monthly Archanai</span></li>
                  <li><span class="filter" data-filter=".icon"><img src="<?php echo base_url(); ?>/assets/archanai/images/icon2.png" style="width:auto; height:60px;"><br>Vehicle Archanai</span></li>
                </ul>
              
              <div class="row prod product" id="portfoliolist">
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio app" data-cat="app">
                  <div class="card">
                     <a href="#" data-name="fruit_archanai" data-price="0.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/fruit_archanai.png">
                     <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/fruit_archanai.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Fruit Archanai</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio app" data-cat="app">
                  <div class="card">
                    <a href="#" data-name="moksha_vilakku" data-price="1.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/moksha_vilakku.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/moksha_vilakku.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Moksha Vilakku</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio app" data-cat="app">
                  <div class="card">
                    <a href="#" data-name="pradosham" data-price="7.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/pradosham.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/pradosham.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Pradosham</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio app" data-cat="app">
                  <div class="card">
                    <a href="#" data-name="ghee_lamp" data-price="2.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/ghee lamp.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/ghee lamp.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Ghee Lamp</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio logo" data-cat="logo">
                  <div class="card">
                    <a href="#" data-name="thengai_archanai" data-price="4.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/thengai archanai.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/thengai archanai.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Thengai Archanai</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio logo" data-cat="logo">
                  <div class="card">
                    <a href="#" data-name="yellu_vilakku" data-price="1.0" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/yellu vilakku.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/yellu vilakku.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Yellu Vilakku</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio logo" data-cat="logo">
                  <div class="card">
                    <a href="#" data-name="sesame_oil" data-price="1.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/sesame oil.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/sesame oil.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Sesame Oil</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio logo" data-cat="logo">
                  <div class="card">
                    <a href="#" data-name="agarbathi_sticks" data-price="1.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/agarbathi sticks.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/agarbathi sticks.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Agarbathi Sticks</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio icon" data-cat="icon">
                  <div class="card">
                    <a href="#" data-name="agarbathi_box" data-price="3.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/agarbathi box.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/agarbathi box.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Agarbathi Box</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio icon" data-cat="icon">
                  <div class="card">
                    <a href="#" data-name="bus_lorry_archanai" data-price="20.0" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/bus lorry.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/bus lorry.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Bus Lorry Archanai</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio icon" data-cat="icon">
                  <div class="card">
                    <a href="#" data-name="car_archanai" data-price="13.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/car archanai.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/car archanai.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Car Archanai</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio icon" data-cat="icon">
                  <div class="card">
                    <a href="#" data-name="motor_archanai" data-price="8.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/motor archanai.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/motor archanai.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Motor Archanai</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio app" data-cat="app">
                  <div class="card">
                    <a href="#" data-name="rose_water" data-price="8.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/rose water.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/rose water.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Rose Water</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio app" data-cat="app">
                  <div class="card">
                    <a href="#" data-name="tharpanam" data-price="8.5" class="add-to-cart" data-src="<?php echo base_url(); ?>/assets/archanai/icon/tharpanam.png">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/assets/archanai/icon/tharpanam.png">
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                        <p class="mb-0 text-muted arch">Tharpanam</p>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-lg-5 col-md-5 grid-margin stretch-card flex-column">
              <div class="h-100">
                <div class="stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start flex-wrap">
                         <!--<div class="d-flex justify-content-between" style="width:100%;">
                         <a class="count-indicator total_cart d-flex align-items-center justify-content-center" id="notificationDropdown" href="#">
                         <i class="typcn typcn-shopping-cart mx-0"></i>
                         <span class="count total-count"></span></a>
                         <a class="clear-cart"><i class="typcn typcn-trash"></i></a></div>-->
                         
                         
                         <div class="prod cart"><table class="show-cart" style="width:100%;">
          					
                         </table></div>
                         
                         <div class="total d-flex justify-content-between align-items-center" style="width:100%; border-bottom:1px dashed #CCC;">
                        	<p class="mb-0">Total </p>
                            <p class="mb-0">RM : <span class="total-cart"></span></p>
                         </div>
                        <h5 class="pay_mode">Payment Mode</h5>
                         <ul class="payment">
                          <li><input type="radio" name="test" id="cb1" />
                            <label for="cb1"><i class="mdi mdi-square-inc-cash"></i> Cash</label>
                          </li>
                          <li><input type="radio" name="test" id="cb3" />
                            <label for="cb3"><i class="mdi mdi-credit-card"></i> Debit Card</label>
                          </li>
                          <li><input type="radio" name="test" id="cb2" />
                            <label for="cb2"><i class="mdi mdi-wallet"></i> E-Wallet</label>
                          </li>
                        </ul>
                         <div class="d-flex justify-content-between align-items-center" style="width:100%; margin-top:5px;">
                        	<p class="mb-0">Amount : </p>
                            <input type="number" style="width:150px; font-size:14px;" name="amount">
                            <p class="mb-0">Balance :  </p>
                            <p class="mb-0">RM : <span class="total-cart"></span></p>
                         </div>
                         <input type="submit" disabled value="SUBMIT" class="btn btn-info submit_btn" id="submit" onClick="submit_modal()">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        
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
        <!-- content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <div id="prin_page"></div>
  <!-- container-scroller -->

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
  
  
  
  <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
  <script  src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>
  
<style>
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
}

#filters li span {
  display: block;
  padding: 5px 20px;
  text-decoration: none;
  color: #666;
  cursor: pointer;
  transition: color 300ms ease-in-out;
  text-align:center;
  line-height: 1.5em;
  font-size:14px;
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

.clearfix:after {
  clear: both;
}

.clearfix {
  zoom: 1;
}

.clear {
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
}

input[type="radio"][id^="cb"] {
  display: none;
}

ul.payment li:first-child label {
  margin-left:0px;	
}

label {
  border: 1px solid #CCC;
  border-radius: 5px;
  line-height: 1;
  padding: 5px;
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
  
</style>
  
  
  
  <!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>-->
<script>

var shoppingCart = (function() {
  cart = [];
  // Constructor
  function Item(name, price, count, src) {
    this.name = name;
    this.price = price;
    this.count = count;
	this.src = src;
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
  obj.addItemToCart = function(name, price, count, src) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart[item].count ++;
        saveCart();
        return;
      }
    }
    var item = new Item(name, price, count, src);
    cart.push(item);
    saveCart();
  }
  // Set count from item
  obj.setCountForItem = function(name, count) {
    for(var i in cart) {
      if (cart[i].name === name) {
        cart[i].count = count;
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
  shoppingCart.addItemToCart(name, price, 1, src);
  displayCart();
});

// Clear items
$('.clear-cart').click(function() {
  shoppingCart.clearCart();
  displayCart();
});


function displayCart() {
  var cartArray = shoppingCart.listCart();
  var output = "";
  var popup = "";
  //var output = '<tr><td colspan="4" align="center"><img src="images/cart_is_empty.png" class="img-fluid" style="width:100px; margin:0 auto;"></td></tr>';
  for(var i in cartArray) {
    output += "<tr style='background:#d4aa0014;'>"
      + "<td style='width:10%'><img data-name=" + cartArray[i].name + " src='" + cartArray[i].src + "' style='width:35px; border:1px solid #e9e6e6; background:#FFF; border-radius:5px;'></td>"
	  + "<td style='width:47%'><span style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>" 
      + "RM : " + cartArray[i].price + "</td>"
      + "<td style='width:35%'><div class='input-group'><button class='minus-item input-group-addon btn btn-primary' data-name=" + cartArray[i].name + ">-</button>"
      + "<p class='item-count' data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p>"
      + "<button class='plus-item btn btn-primary input-group-addon' data-name=" + cartArray[i].name + ">+</button></div></td>"
      + "<td style='width:8%'><button class='delete-item btn btn-danger' data-name=" + cartArray[i].name + ">X</button></td>"
      +  "</tr><tr><td colspan='4'></td></tr>";
	  $('#submit').removeAttr('disabled');
  }
  for(var i in cartArray) {
    popup += "<tr>"
      + "<td>" + i + "</td>"
	  + "<td><span style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>RM : " + cartArray[i].price + "</td>"
      + "<td><p data-name='" + cartArray[i].name + "'>" + cartArray[i].count + "</p></td>"
	  + "<td style='text-align:right;'>" + cartArray[i].total + "</td></tr>";
  }
  $('.show-cart').html(output);
  $('.total-cart').html(shoppingCart.totalCart());
  $('.total-count').html(shoppingCart.totalCount());
  $('.show-cart_popup').html(popup);
  
  var tot =  shoppingCart.totalCount();
  if(tot==0) { 
  	$('#submit').prop('disabled', true); 
  }
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
})


// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.removeItemFromCart(name);
  displayCart();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  shoppingCart.addItemToCart(name);
  displayCart();
})

// Item count input
$('.show-cart').on("change", ".item-count", function(event) {
   var name = $(this).data('name');
   var count = Number($(this).val());
  shoppingCart.setCountForItem(name, count);
  displayCart();
});

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
	  + "<td><span style='text-transform:uppercase;'>" + cartArray[i].name + "</span><br>RM : " + cartArray[i].price + "</td>"
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
</body>
</html>

