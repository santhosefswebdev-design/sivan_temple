<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css"/>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
  <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<style>
body { height:100vh; width:100%; }
.prod::-webkit-scrollbar {
  width: 3px;
}
.prod::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
.prod::-webkit-scrollbar-thumb {
  background: #d4aa00; 
}
.prod::-webkit-scrollbar-thumb:hover {
  background: #e91e63; 
}
a { text-decoration:none !important; }
.table tr th {
    border: 1px solid #f7e086;
    font-size: 14px;
    background: #f7ebbb;
    color: #333232;
}
.pack, .pay {
    margin-bottom: 15px;
}
.form-label {
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 1px;
    color:#333333;
    text-align: left;
    width: 100%;
}
.input { width:100%; text-align:left; }
select.input { color:#000; }

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
.sidebar-icon-only .main-panel {
    width: calc(100% - 0px);
}
.back { 
	background: #00000087;
    padding: 13px;
    color: white;
	min-height:120px;
 }
.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #F44336!important;
    outline: 0;
    box-shadow: none;
}
select.form-control:focus {
    outline: 1px solid #F44336;
}
.error-input {
    border-color: #F44336!important;
}
.back h5 { min-height:80px; font-size:15px; font-weight:bold; color:#FFFFFF; }
#error_msg, .form_error { color:red; }

.greensubmit{
    background: #ab8a04!important;
    font-weight: bold!important;
    color: #ffffff!important;
    box-shadow: -1px 10px 20px #ab8a04;
    background: #ab8a04!important;
    background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
    background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
    background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
}
</style>
</head>
<body class="sidebar-icon-only">
  <div class="container-scroller">
    
    <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
      
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <?php if($_SESSION['succ'] != '') { ?>
              <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
                  <div class="suc-alert" style="width: 100%;">
                      <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <p><?php echo $_SESSION['succ']; ?></p> 
                  </div>
              </div>
          <?php } ?>
            <?php if($_SESSION['fail'] != '') { ?>
              <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
                  <div class="alert" style="width: 100%;">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <p><?php echo $_SESSION['fail']; ?></p>
                  </div>
              </div>
          <?php } ?>
            <div class="row">
				<div class="col-md-12 card" style="padding:10px;"> 
					<form class="form" id="form" method="post">
                        <input type="hidden" name="dt" id="ubhayam_date" class="form-control"  value="<?php echo date("Y-m-d"); ?>" >
				        <div class="form-container card-body" align="center"> 
				            <div class="container-fluid">
                                <div class="row">                  
                                    <div class="col-md-8">
                                        <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Choose Any Ubayam for Pay</h4>
                                        <ul class="payment prod" id="pay_for"></ul>
                                        
                                        <div class="pack">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Family Details</h4>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="family_name" >
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="form-label">Relationship</label>
                                                    <input type="text" class="form-control" id="family_relationship" >
                                                </div>
                                                <div class="col-sm-2 smal_marg">
                                                    <div class="form-group form-float">
                                                        <div class="form-line" style="border: none;">
                                                            <br><label id="family_add" class="btn btn-warning" style="padding: 6px 12px !important;height: 2.35rem; margin-top: 6px;">Add</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive"> 
                                                    <table class="table table-bordered" style="width:100%; height: 150px;" id="family_table"> 
                                                        <thead>
                                                            <tr>
                                                                <th width="40%">Name</th>
                                                                <th width="25%">Relationship</th>
                                                                <th width="15%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="prod" style="overflow-y:scroll; overflow-x:hidden; max-height: 200px;">
                                                        </tbody>
                                                    </table>   
                                                </div>
                                                <input type="hidden" id="family_row_count" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">  
                                        
                                        <div class="row">
                                            <div class="col-md-6" style="text-align:left;">
                                                <p style=" margin-top:10px;">
                                                    <button type="button" class="btn btn-danger btn-lg ar_btn" onClick="rePrint();" style="background: #f44336;border: 1px solid #f44336;color: #fff;">Reprint</button>
                                                </p>
                                            </div>
                                            <div class="col-md-6" style="text-align:right;">
                                                <p style="margin-top:10px;">
                                                    <button type="button" class="btn ar_btn btn-info btn-lg" onClick="userModalOpen();">Add Detail</button>
                                                </p>
                                            </div>
                                        </div>

                                        <table class="show-cart table table-bordered" style="width:100%;display:none;"></table>
                                        
                                        <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Total Amount</h4>
                                        <input type="number" min="0" step="any" id="total_amt" class="form-control"  name="total_amt" value="0" style="margin-top:20px;font-weight:bold;font-size: 36px;text-align: center;">
                                    
                                        <!--ul class="payment1">
    									  <li><input type="radio" name="pay_method" id="cb1" value="cash" />
    										<label for="cb1"><i class="mdi mdi-square-inc-cash"></i> Cash</label>
    									  </li>
    									  <li><input type="radio" name="pay_method" id="cb3" value="adyen" />
    										<label for="cb3"><i class="mdi mdi-qrcode"></i> QR Code</label>
    									  </li>
    									</ul-->

				                    <input type="button" value="OK" class="button button-white greensubmit" id="submit" >
                                    </div>  
                                </div> 
                            </div> 
                            
                        </div>
                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body p-4" style="padding-bottom:10px;">
                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="dt">Ubayam Date <span style="color:red;">*</span></label>
                                                        <input class="input1 form-control" type="date" id="dt" name="dt" autocomplete="off">
                                                    <span id="error_msg"></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="name">Name <span style="color:red;">*</span></label>
                                                        <input class="input1 form-control" type="text" id="name" name="name" autocomplete="off" >
                                                    <span id="error_msg"></span></div>
                                                </div>
                                            
                                                <div class="col-md-6">
                                                    <div class="form-group">  
                                                        <label class="form-label" for="email_id">Email Address <span style="color:red;">*</span></label>
                                                        <input class="form-control" type="email" id="email_id" name="email_id" autocomplete="off" >
                                                    <span id="error_msg"></span><span class="form_error" id="invalid_email">This email is not valid</span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="mobile">Mobile No<span style="color:red;">*</span></label>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <select class="form-control" name="phonecode" id="phonecode">
                                                                    <option value="">Dialing code</option>
                                                                    <?php
                                                                    if(!empty($phone_codes))
                                                                    {
                                                                        foreach($phone_codes as $phone_code)
                                                                        {
                                                                    ?>
                                                                    <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if($phone_code['dailing_code'] == "+60"){ echo "selected";}?>><?php echo $phone_code['dailing_code']; ?></option>
                                                                    <?php
                                                                        }
                                                                    }              
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input class="form-control" type="number" id="mobile" name="mobile" min="0" autocomplete="off" >
                                                            <span id="error_msg"></span></div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="ic_number">Ic No / Passport No</label>
                                                        <input class="form-control" type="text" id="ic_number" name="ic_number" autocomplete="off">
                                                    <span id="error_msg"></span></div>
                                                </div>
                                            
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="rasi_id">Rasi <span style="color:red;">*</span></label>
                                                        <select class="form-control" name="rasi_id" id="rasi_id" >
                                                            <option value="">Select Rasi</option>
                                                            <?php foreach($rasi as $row) { ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng'];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <span id="error_msg"></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="natchathra_id">Natchathram <span style="color:red;">*</span></label>
                                                        <input type="hidden" id="natchathram_id" name="natchathram_id" class="form-control">
                                                        <select class="form-control" name="natchathra_id" id="natchathra_id" >
                                                            <option value="">Select Natchiram</option>
                                                        </select>
                                                    <span id="error_msg"></span></div>
                                                </div>
                                               
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="address">Address</label>
                                                        <textarea class="form-control" id="address" name="address" style="width:100%;" autocomplete="off"></textarea>
                                                    <span id="error_msg"></span></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">  
                                                        <label class="form-label" for="description">Remarks</label>
                                                        <textarea class="form-control" id="description" name="description" style="width:100%;" autocomplete="off"></textarea>
                                                    <span id="error_msg"></span></div>
                                                </div>  
                                            </div>  
                                            
                                            
                                            <button type="button"  name="ar_add_btn"  id="ar_add_btn" class="btn btn-info my-3"  style="width:100%; font-size:24px; height:auto;margin-bottom: 0 !important;">Submit</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </div>
				    </form> 
                </div>
			</div>
		</div>
	</div>
        
        
    </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<div id="alertModal" class="modal fade" tabindex="-1" rele="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div-->
            <div class="modal-body">
                <p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline" style="font-size:42px; color:red;"></i></p>
                <h5 style="text-align:center;" id="modalMsg"></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
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
                                  <td style="width: 40%;padding: 5px 0px!important;text-align:center;"><?php echo $reprintlist['paidamount']; ?></td>
                                  <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                                    <a class='btn btn-primary' style='font-size: 13px;font-weight: bold;padding: 6px 10px;background: #2196F3;border: 1px solid #2196F3;' title='Print' href='<?php echo base_url(); ?>/ubayam_online_cust/reprint_booking/<?php echo $reprintlist['id']; ?>' target='_blank'>Print</a>
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
  
<style>
ul.payment {
    list-style-type: none;
    width: 100%;
    display: flex;
    justify-content: flex-start;
	margin-bottom:0;
	padding-left:0;
	-webkit-column-count: 3;
    column-count: 3;
	flex-wrap: wrap;
	height:300px;
	overflow:auto;
}

.payment li {
    display: inline-block;
	width: 20%;
}

input[type="radio"][id^="pay_for"] {
  display: none;
}
input[type="radio"] {
  display: none;
}


.payment li label {
    border: 1px solid #CCC;
    border-radius: 5px;
    line-height: 1.5;
    display: block;
    position: relative;
    margin:10px 10px;
    font-family: inherit;
    min-height: 120px;
    background: #fff;
    cursor: pointer;
    color: #6d5804;
    font-weight: bold;
}
.payment li label p {
	font-size:18px;
	margin-bottom:0;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -10px;
  left: -5px;
  width: 30px;
  height: 30px;
  text-align: center;
  line-height: 28px;
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
background:#f6ef08 !important;
transition-duration: 0.4s;
}

:checked + label:before {
  content: "✓";
  background-color: green;
  transform: scale(1);
}

:checked + i.mdi{
  transform: scale(0.9);
}

ul.payment1 {
    list-style-type: none;
    width: 100%;
    display: flex;
    justify-content: space-between;
	margin-bottom:0;
	padding-left:0;
}

.payment1 li {
    display: inline-block;
    text-align:center;
    width:50%;
}

.payment1 li label {
  border: 1px solid #CCC;
  border-radius: 5px;
  line-height: 1;
  padding: 15px 20px;
  display: block;
  position: relative;
  margin: 15px 15px;
  cursor: pointer;
  font-weight:bold;
}

.payment1 li label:before {
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

.payment1 li label i.mdi {
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
  font-size:18px;
  color:#0d2f95;
}

.payment1 li :checked + label {
background:#f6ef08;
}

.payment1 li :checked + label:before {
  content: "✓";
  background-color: green;
  transform: scale(1);
}

.payment1 li label :checked + i.mdi{
  transform: scale(0.9);
}
.prod_img { width:90px; min-width:90px; margin:0 auto; border-radius: 50%; min-height:90px; max-height:90px;
    background: #e1e1d68a;
    padding: 5px; }
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
.ar_btn {
    background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
    border-radius: 15px;
    font-weight: bold;
    height: 1.75em;
}
.btn { padding: 0.25rem 0.5rem; height: 2rem; }
.show-cart1 { max-height:350px; overflow:auto; }
.show-cart1 tr { border-radius:10px; }
.show-cart1 td { font-size:13px; padding:3px 10px; }
.total { margin-top:15px; padding-bottom:10px; } 
.total p { font-size: 24px; font-weight: bold; }
.tot_amt_txt {
    display: inline;
    width: 126px;
    text-align: right;
    font-size: 26px;
    font-weight: bold;
    border: 0;
    background: white;
    color: black;
}

@media (max-width: 960px) {
.prod_img { width:50px; min-width:50px; margin:0 auto; border-radius: 50%; min-height:50px; max-height:50px;}
.payment li { width: 25%; }
.payment1 li label { padding: 15px 1px; margin: 15px 5px; }
}
</style>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
    function rePrint()
    {
        $("#myModal_reprint").modal("show");
    }
    var userDetail = (function() {
        user = [];
        // Constructor
        function Item(dt,name,email_id,phonecode,mobile,ic_number,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description) {
            this.dt = dt;
            this.name = name;
            this.email_id = email_id;
            this.phonecode = phonecode;
            this.mobile = mobile;
            this.ic_number = ic_number;
            this.rasi_id = rasi_id;
            this.rasi_text = rasi_text;
            this.natchathra_id = natchathra_id;
            this.natchathra_text = natchathra_text;
            this.address = address;
            this.description = description;
        }
        // Save user
        function saveUser() {
            sessionStorage.setItem('ubayam_userdetails', JSON.stringify(user));
        }
            // Load user
        function loadUser() {
            user = JSON.parse(sessionStorage.getItem('ubayam_userdetails'));
        }
        if (sessionStorage.getItem("ubayam_userdetails") != null) {
            loadUser();
        }
        var obj = {};
        // Add to user
        obj.addUserToCart = function(dt,name,email_id,phonecode,mobile,ic_number,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description) {
            var item = new Item(dt,name,email_id,phonecode,mobile,ic_number,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description);
            user.push(item);
            saveUser();
        }
        // clear user
        obj.clearUser = function() {
            user = [];
            saveUser();
        }
        // List user
        obj.listUser = function() {
            return user;
        }
        return obj;
    })();
    function userModalOpen()
    {
        $("#myModal").modal("show");
        var cartArray = userDetail.listUser();
        if(cartArray.length > 0)
        {
            $('#dt').val(cartArray[0].dt);
            $('#name').val(cartArray[0].name);
            $('#email_id').val(cartArray[0].email_id);
            $('#phonecode').val(cartArray[0].phonecode);
            $('#mobile').val(cartArray[0].mobile);
            $('#ic_number').val(cartArray[0].ic_number);
            $('#rasi_id').val(cartArray[0].rasi_id);
            $('#natchathra_id').val(cartArray[0].natchathra_id);
            $('#address').val(cartArray[0].address);
            $('#description').val(cartArray[0].description);
            $('.show-cart').show();
        }
        else
        {
            $('#dt').val("");
            $('#name').val("");
            $('#email_id').val("");
            $('#phonecode').val("+60");
            $('#mobile').val("");
            $('#ic_number').val("");
            $('#rasi_id').val("");
            $('#natchathra_id').val("");
            $('#address').val("");
            $('#description').val("");
            $('.show-cart').empty();
            $('.show-cart').hide();
        }
    }
    
$('.form_error').hide();
$('#ar_add_btn').click(function(event) {
    userDetail.clearUser();
    event.preventDefault();
    var dt = $('#dt').val();
    var name = $('#name').val();
    var email_id = $('#email_id').val();
    var ic_number = $('#ic_number').val();
    var address = $('#address').val();
    var rasi_id = $('#rasi_id').val();
    var rasi_text = $( "#rasi_id option:selected" ).text();
    var natchathra_id = $('#natchathra_id').val();
    var natchathra_text = $( "#natchathra_id option:selected" ).text();
    var phonecode = $('#phonecode').val();
    var mobile = $('#mobile').val();
    var description = $('#description').val();
    
    //if(name == "") { $(this).siblings("#error_msg").html("Field needs filling"); }
    //if(email_id == "") { $(this).siblings("#error_msg").html("Field needs filling"); }
    
    
    $('.form-control').each(function() {
        if ($(this).val() == "") {
          $(this).siblings('#error_msg').text('Field needs to Fill');
        } else {    
          $(this).siblings('#error_msg').text('');
        }
    });
    
    if(email_id != "") {
        if(IsEmail(email_id)==false){
            $('#invalid_email').show();
            return false;
        }
    }
    
    function IsEmail(email_id) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email_id)) {
           return false;
        }else{
           return true;
        }
    }
  
    
    if(dt != "" && name != "" && email_id !="" && ic_number != "" && address != "" && rasi_id !="" && natchathra_id !="" && mobile !="" && description !="") {
        $("#myModal").modal("hide");
        userDetail.addUserToCart(dt,name,email_id,phonecode,mobile,ic_number,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description);
        displayCart();
    }
});
    function displayCart() {
        var cartArray = userDetail.listUser();
        if(cartArray.length > 0)
        {
            //console.log(cartArray);
            var output = "";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Date </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].dt+"</td>"
            + "</tr>";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Name </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].name+"</td>"
            + "</tr>";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Email ID</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].email_id+"</td>"
            + "</tr>";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Mobile No </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].phonecode+" "+cartArray[0].mobile+"</td>"
            + "</tr>";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Rasi </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].rasi_text+"</td>"
            + "</tr>";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Natchathiram</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].natchathra_text+"</td>"
            + "</tr>";
            //output += "<tr>"
           // + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Address </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].address+"</td>"
            //+ "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Remarks</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].description+"</td>"
            //+ "</tr>";
            $('.show-cart').html(output);
            $('.show-cart').show();
        }
        else
        {
            $('#name').val("");
            $('#email_id').val("");
            $('#phonecode').val("+60");
            $('#mobile').val("");
            $('#ic_number').val("");
            $('#rasi_id').val("");
            $('#natchathra_id').val("");
            $('#address').val("");
            $('#description').val("");
            $('.show-cart').empty();
            $('.show-cart').hide();
        }
        //alert(cartArray.length);
    }
    displayCart();
$('#ubhayam_date').change(function(){
    get_booking_ubhayam();
});
function get_booking_ubhayam(){
    var ubhayam_date = $("#ubhayam_date").val();
    if(ubhayam_date != ''){
        $.ajax({
            url: "<?php echo base_url();?>/ubayam_online_cust/get_booking_ubhayam",
            type: "post",
            data: {ubhayamdate: ubhayam_date},
            success: function(data){
                $("#pay_for").html(data);
            }
        });
    }
}
$(document).ready(function () {
    get_booking_ubhayam();
});

function payfor(pay_id)
{
    $.ajax({
        url: "<?php echo base_url()?>/ubayam_online/get_payfor_collection",
        type:"POST",
        data: {id: pay_id},
        success: function(data){
            $("#total_amt").val(data);
            $("#total_amt").prop("max", data);
            $("#pay_for"+pay_id).prop("checked",true);
            $("input[name='pay_for']").removeClass("error-input");
            $(".payment li label").removeClass("error-input");
        }
    });
}
$("#family_add").click(function(){
    var family_name = $("#family_name").val();
    var family_relationship = $("#family_relationship").val();  
    var cnt_fmy = parseInt($("#family_row_count").val());
    if(family_name != '' && family_relationship != ''){
        var html = '<tr id="rmv_familyrow'+cnt_fmy+'">';
            html += '<td style="width: 33%;"><input type="text" style="border: none;" readonly name="familly['+cnt_fmy+'][name]" value="'+family_name+'"></td>';
            html += '<td style="width: 33%;"><input type="text" style="border: none;" readonly name="familly['+cnt_fmy+'][relationship]" value="'+family_relationship+'"></td>';
            html += '<td style="width: 33%;"><a class="btn btn-danger btn-rad" onclick="rmv_family('+ cnt_fmy +')" style="width:auto;padding: 0px 3px !important; color:#fff;"><i class="fa fa-remove"></i></a></td>';
            html += '</tr>';
        $("#family_table").append(html);
        var ct_fmy = parseInt(cnt_fmy + 1);
        $("#family_row_count").val(ct_fmy);
        $("#family_name").val('');
        $("#family_relationship").val('');
    }
});
function rmv_family(id){
    $("#rmv_familyrow"+id).remove();
}
$(document).ready(function() {
    $("#rasi_id").change(function(){
	    var rasi = $("#rasi_id").val();
        if(rasi != "")
        {
            $.ajax({
                url: '<?php echo base_url();?>/ubayam_online_cust/get_natchathram',
                type: 'post',
                data: {rasi_id:rasi},
                dataType: 'json',
                success:function(response)
                {
                    $('#natchathram_id').val(response.natchathra_id);
                    
                    var str = response.natchathra_id;
                    console.log(str);
                    //return;
                    if(str !="") {
                        $("#natchathra_id").empty();
                        
                        $('#natchathra_id').append('<option value="">Select Natchiram</option>');
                        $.each(str.split(','), function(key, value) {
                            //$('#natchathra_id').append('<option value="' + value + '">' + value + '</option>');
                            $.ajax({
                                url: '<?php echo base_url();?>/ubayam_online_cust/get_natchathram_name',
                                type: 'post',
                                data: {id:value},
                                dataType: 'json',
                                success:function(response)
                                {
                                $('#natchathra_id').append('<option value="' + response.id + '">' + response.name_eng + '</option>');
                                //$('#natchathra_id').prop('selectedIndex',0);
                                //$("#natchathra_id").selectpicker("refresh");
                                }
                            });
                        });
                    }
                }
            });
        }
    });
});

$("#submit").click(function(){
    var total_amt = parseFloat($("#total_amt").val());
    
    var pack_row_count = parseInt($("#pack_row_count").val());
    var pay_for = $('.ubayam_slot').filter(':checked').length;
    var name = $("#name").val();
    var email_id = $("#email_id").val();
    var mobile = $("#mobile").val();
    var rasi_id = $("#rasi_id").val();
    var natchathra_id = $("#natchathra_id").val();
    var dt = $("#dt").val();
    if(pay_for === 0) {
        $("input[name='pay_for']").addClass("error-input");
        $(".payment li label").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("input[name='pay_for']").focus().offset().top - 25
        }, 500);
    }
    else if(total_amt.length === 0 || total_amt == '') {
        $("#total_amt").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("#total_amt").focus().offset().top - 25
        }, 500);
    }
    else if(dt == "" )
    {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    }
    else if(name == "")
    {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    }
    else if(email_id == "")
    {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    }
    else if(mobile == "")
    {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    }
    else if(rasi_id == "")
    {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    }
    else if(natchathra_id == "")
    {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    }
    else
    {
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/ubayam_online_cust/save",
            data: $("form").serialize(),
            beforeSend: function() {    
                $("#loader").show();
            },
            success:function(data)
            {
                userDetail.clearUser();
                //location.reload();
                obj = jQuery.parseJSON(data);
				if(obj.err != ''){
					$('#alert-modal').modal('show', {backdrop: 'static'});
					$("#spndeddelid").text(obj.err);
				}else{		
					window.open("<?php echo base_url(); ?>/ubayam_online_cust/payment_process/" + obj.id, "_blank", "width=680,height=500");
					window.location.reload(true);
				}
            },
            complete:function(data){
                // Hide image container
                $("#loader").hide();
            }
        });
    }
});
function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return 0;
    }else{
        return 1;
    }
}
$("#cancel-button").click(function() {
    $("#name").removeClass("error-input");
    $("#address").removeClass("error-input");
    $("#mobile").removeClass("error-input");
    $("#ic_number").removeClass("error-input");
    $("#email_id").removeClass("error-input");
    $("#total_amt").removeClass("error-input");
    $("input[name='pay_for']").removeClass("error-input");
    $(".payment li label").removeClass("error-input");
});
$('#name').keyup(function() {
    $("#name").removeClass("error-input");
});
$('#address').keyup(function() {
    $("#address").removeClass("error-input");
});
$('#mobile').keyup(function() {
    $("#mobile").removeClass("error-input");
});
$('#ic_number').keyup(function() {
    $("#ic_number").removeClass("error-input");
});
$('#email_id').keyup(function() {
    $("#email_id").removeClass("error-input");
});
$('#total_amt').keyup(function() {
    $("#total_amt").removeClass("error-input");
});
</script>
</body>
</html>

