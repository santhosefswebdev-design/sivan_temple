<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
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
    padding: 15px;
    color: white;
	min-height:120px;
 }
.back h5 { min-height:80px; font-size:15px; font-weight:bold; color:#FFFFFF; }
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
				<div class="col-md-12 card" style="padding:20px;"> 
					<form class="form" id="form" method="post" action="<?php echo base_url(); ?>/memberreg/save">
				          <div class="form-container card-body" align="center"> 
				            <div class="container-fluid">
                            <div class="row">
                                                            
                        <div class="body">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="form-label">Name <span style="color: red;">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" required>
                                </div></div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="form-label">Member Number</label>
                                    <input type="text" class="form-control" value="<?php echo $data['member_no'];?>" readonly>
                                </div></div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Member Type <span style="color: red;">*</span></label>
                                    <select class="form-control" id="member_type" name="member_type" required>
                                        <option value="">-- Select Type --</option>
										<?php 
										if(count($member_type_list) > 0){
											foreach($member_type_list as $mtl){
											?>
											<option value="<?php echo $mtl['id']; ?>"><?php echo $mtl['name']; ?></option>
											<?php 
											}
										}
										?>
                                    </select>
                                </div></div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="form-label">IC No / Passport No</label>
                                    <input type="text" name="ic_number" class="form-control" autocomplete="off" required>
                                </div></div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="form-label">Mobile Number</label>
                                    <div class="row">
                                        <div class="col-md-3">
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
                                        <div class="col-md-9">
                                            <input class="form-control" type="number" id="mobile" name="mobile" min="0" autocomplete="off" required>
                                        </div>
                                    </div>
                                   
                                </div></div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Email ID</label>
                                        <input type="email" name="email_address" id="email_address" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group"><label class="form-label">Address</label>
                                    <input type="text"  name="address" class="form-control" autocomplete="off">
                                </div></div>
                                <div class="col-sm-4">
                                    <div class="form-group"><div id="bs_datepicker_component_container">
                                        <label class="form-label">Start Date <span style="color: red;">*</span></label>
                                        <input type="date" name="start_date" class="form-control" value="<?php echo date("Y-m-d");?>" required>
                                    </div>
                                </div></div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group"><h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Total Amount</h4>
                                    <input type="number" step="0.1" readonly id="payment" name="payment" class="form-control" step=".01"  style="margin-top:20px;font-weight:bold;font-size: 36px;text-align: center;" required> 
                                </div></div>
                                
                            </div>   
                        </div> 
                        </div> 

                            </div> 
                            </div> 
                        
                    </div>
                        <div class="container-fluid">
                        <div class="row"> <div class="col-sm-12" align="center" style="margin:0 auto;">                             
				            <input type="submit" value="OK" class="button button-white greensubmit" id="submit">
                         </div></div>
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
	width: 33.33%;
}

input[type="radio"][id^="cb"] {
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
    background: #d8f7f7;
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
</style>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
$("#member_type").change(function(){
    var type = $(this).val();
    $.ajax({
        type: "post",
        url: "<?php echo base_url();?>/memberreg/get_member_amount",
        data: {id: type},
        success: function(data){
            obj = jQuery.parseJSON(data);
            $("#payment").val(obj.amount);
        }
    });
});

        
</script>
</body>
</html>

