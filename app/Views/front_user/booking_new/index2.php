<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css"/>
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
    /* padding: 5px; */
    font-size: 14px;
    background: #f7ebbb;
    color: #333232;
}
.pack, .pay {
    background: #fff;
    margin-bottom: 15px;
}
.form-label {
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 1px;
    color: rgb(62 60 60);
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
.cal_head { background:#f34c22; color:#FFF; padding:2px 5px; }
.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #F44336!important;
    outline: 0;
    box-shadow: none;
}
.error-input {
    border-color: #F44336!important;
}
.book_sts { float:right; margin-right:5px; padding:0px 5px; background:#07ce09; color:#FFF; }

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
	height:290px;
	overflow:auto;
}

.payment li {
    display: inline-block;
	width: 20%;
}

input[type="radio"][id^="cb"] {
  display: none;
}

input[type="checkbox"][class^="package_amt"] {
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

.back { 
	background: #00000087;
    padding: 15px;
    color: white;
	min-height:120px;
 }
.back h5 { min-height:80px; font-size:15px; font-weight:bold; color:#FFFFFF; }



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
.prod_img { width:90px; margin:0 auto; border-radius: 50%; min-height:90px; max-height:90px;
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
}
</style>
</head>
<body class="sidebar-icon-only">
  <div class="container-scroller">
    
    
    <div class="container-fluid page-body-wrapper">
      
      <div class="main-panel">
        <div class="content-wrapper">
        <div class="row">
				<div class="col-md-12">
					<div class="content w-100">
				    <div class="calendar-container">
				      <div class="calendar"> 
				        <div class="year-header"> 
				          <span class="left-button fa fa-chevron-left" id="prev"> << </span> 
				          <span class="year" id="label"></span> 
				          <span class="right-button fa fa-chevron-right" id="next"> >> </span>				        </div> 
				        <table class="months-table w-100"> 
				          <tbody>
				            <tr class="months-row">
				              <td class="month">Jan</td> 
				              <td class="month">Feb</td> 
				              <td class="month">Mar</td> 
				              <td class="month">Apr</td> 
				              <td class="month">May</td> 
				              <td class="month">Jun</td> 
				              <td class="month">Jul</td>
				              <td class="month">Aug</td> 
				              <td class="month">Sep</td> 
				              <td class="month">Oct</td>          
				              <td class="month">Nov</td>
				              <td class="month">Dec</td>
				            </tr>
				          </tbody>
				        </table> 
				        
				        <table class="days-table w-100"> 
				          <td class="day">Sun</td> 
				          <td class="day">Mon</td> 
				          <td class="day">Tue</td> 
				          <td class="day">Wed</td> 
				          <td class="day">Thu</td> 
				          <td class="day">Fri</td> 
				          <td class="day">Sat</td>
				        </table> 
				        <div class="frame"> 
				          <table class="dates-table w-100"> 
			              <tbody class="tbody">             
			              </tbody> 
				          </table>
				        </div> 
				        <button class="button" id="add-button">Add Event</button>
				      </div>
				    </div>
				    <div class="events-container"></div>
				    <div class="dialog prod" id="dialog">
				        <!--h4 class="dialog-header" style=" background:#d4aa00;color:#FFFFFF;"> Add New Event </h4-->
				        <form class="form" id="form">
				          <div class="form-container" align="center"> 
				            <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Choose Package</h4>
                                    <div class="pack">
                                       <div class="row">
                                            <ul class="payment prod">
                                              <?php 
                                              $rj=0;
                                              foreach($package as $row) { 
                                              ?>
                                              <input type="hidden" name="pay_for[<?php echo $rj; ?>][pack_id]" value="<?php echo $row['id']; ?>" id="pack_id<?php echo $row['id']; ?>" />
                                              <li>
                                                  <input type="checkbox" class="package_amt" name="pay_for[<?php echo $rj; ?>][pack_amt]" value="<?php echo $row['amount']; ?>" id="pay_for<?php echo $row['id']; ?>" />
                                                  <!--label class="" for="pay_for<?php echo $row['id']; ?>" style="background:url(<?php echo base_url(); ?>/uploads/booking/<?php echo $row['image']; ?>) no-repeat; background-size: cover;" onclick="payfor(<?php echo $row['id']; ?>)" >
                                                  <div class="back"><h5><?php echo $row['name']; ?></h5></div></label-->
                                                  <label class="card" for="pay_for<?php echo $row['id']; ?>" onclick="payfor(<?php echo $row['id']; ?>)" >
                                                  <img class="img-fluid prod_img" src="<?php echo base_url(); ?>/uploads/booking/<?php echo $row['image']; ?>">
                                                  <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                                                    <p class="mb-0 text-muted arch"><?php echo $row['name']; ?></p>
                                                  </div>
                                                  </labe>
                                              </li>
                                              <?php 
                                               $rj++; 
                                            } ?>
                                            </ul>
                                            
                                        </div>    
                                        
                                    </div>
                                    <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Choose Slot</h4>
                                    <div class="project">
                                        <div class="boxes" id="booking_slot">
                                        
                                        </div>
                                    </div>
                                    
                                </div>
                            
                            	<div class="col-md-4">
                                    
                                    <!--h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Enter Detail</h4-->
                                    <p style="text-align:right; margin-top:10px;"><button type="button" class="btn ar_btn btn-info btn-lg" onClick="userModalOpen();">Add Detail</button></p>

                                    <table class="show-cart table table-bordered" style="width:100%;display:none;"></table>
                                    
                                    <table class="show-cart1" style="width:100%;">
                                        <tbody>
                                            <tr style="background:#d4aa0014;">
                                                <td style="width:70%">Marriage</td>
                                                <td align="right" style="width:30%">300.00</td>
                                            </tr>
                                            <tr><td colspan="2"></td></tr>
                                            <tr style="background:#d4aa0014;">
                                                <td style="width:70%">Birthday</td>
                                                <td align="right" style="width:30%">300.00</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!--h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Total Amount</h4>
                                    <input type="number" min="0" readonly step="any" id="total_amt" class="form-control"  name="total_amt" value="0" style="margin-top:20px;font-weight:bold;font-size: 36px;text-align: center;"-->
                                    <div class="total d-flex justify-content-between align-items-center" style="width:100%; border-bottom:1px dashed #CCC;">
                                	<p class="mb-0">Total </p>
                                    <p class="mb-0">RM : <input type="number" min="0" readonly step="any" id="total_amt" class="form-control tot_amt_txt"  name="total_amt" value="0"></p>
                                    <input type="hidden" id="tot_amt" name="tot_amt">
                                 </div>
                                     <ul class="payment1">
									  <li><input type="radio" name="pay_method" id="cb1" value="cash" />
										<label for="cb1"><i class="mdi mdi-square-inc-cash"></i> Cash</label>
									  </li>
									  <li><input type="radio" name="pay_method" id="cb3" value="adyen" />
										<label for="cb3"><i class="mdi mdi-qrcode"></i> QR Code</label>
									  </li>
									</ul>
									<input type="button" value="Cancel" class="button" id="cancel-button">
                                    <input type="button" value="OK" class="button button-white" id="ok-button">
                                </div>
                            </div>
                            </div>
                            
                        </div>
                        <!--div class="container-fluid" style="margin-top:20px;">
                            <div class="row"> 
                                <div class="col-sm-12" align="center" style="margin:0 auto;">                          
                                    <input type="button" value="Cancel" class="button" id="cancel-button">
                                    <input type="button" value="OK" class="button button-white" id="ok-button">
                                </div>
                            </div>
                        </div-->

				        </div>
				        </form>
				      </div>
				  </div>
		        </div>
			</div>
        </div>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
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
                                <label class="form-label" for="event_name">Event name</label>
                                <input class="input1 form-control" type="text" name="event_name" id="event_name" maxlength="36" autocomplete="off">
                                <input type="hidden" class="form-control" id="event_date" name="event_date" readonly value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="name">Name</label>
                                <input class="input1 form-control" type="text" name="name" id="name" maxlength="36" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="address">Address</label>
                                <input class="input1 form-control" type="text" name="address" id="address" maxlength="36" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="city">City</label>
                                <input class="input1 form-control" type="text" name="city" id="city" maxlength="36" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="city">State</label>
                                <input class="input1 form-control" type="text" name="state" id="state" maxlength="36" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="city">Post Code</label>
                                <input class="input1 form-control" type="text" name="postcode" id="postcode" maxlength="36" autocomplete="off">
                            </div>
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
                                        <input class="input1 form-control" type="number" min="0" name="mobile" id="mobile" required pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="ic_num">IC No / Passport No</label>
                                <input class="input1 form-control" type="text" name="ic_num" id="ic_num" maxlength="36" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input class="input1 form-control email" type="email" name="email" id="email" maxlength="36" autocomplete="off">
                            </div>
                        </div>
                        
                    </div>
                    <button type="button"  name="ar_add_btn"  id="ar_add_btn" class="btn btn-info my-3"  style="width:100%; font-size:24px; height:auto;margin-bottom: 0 !important;" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
  </div>
</div>
  <div id="prin_page"></div>
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
  
  <script src="<?php echo base_url(); ?>/assets/archanai/js/popper.js"></script>

  <script>  
    function payfor(pay_id)
    {
        $.ajax({
            url: "<?php echo base_url()?>/booking/getpack_amt",
            type:"POST",
            data: {id: pay_id},
            success: function(data){
                sum_amount();
                // $("#pay_for"+pay_id).prop("checked",true);
                $("input[name='pay_for[]']").removeClass("error-input");
                $(".payment li label").removeClass("error-input");
            }
        });
        
    }
    function userModalOpen()
    {
        $("#myModal").modal("show");
        var cartArray = userDetail.listUser();
        if(cartArray.length > 0)
        {
            $('#event_name').val(cartArray[0].event_name);
            $('#register').val(cartArray[0].register);
            $('#name').val(cartArray[0].name);
            $('#address').val(cartArray[0].address);
            $('#city').val(cartArray[0].city);
            $('#state').val(cartArray[0].state);
            $('#phonecode').val(cartArray[0].phonecode);
            $('#mobile').val(cartArray[0].mobile);
            $('#ic_num').val(cartArray[0].ic_num);
            $('#email').val(cartArray[0].email);
            $('.show-cart').show();
        }
        else
        {
            $('#event_name').val("");
            $('#register').val("");
            $('#name').val("");
            $('#address').val("");
            $('#city').val("");
            $('#state').val("");
            $('#phonecode').val("+60");
            $('#mobile').val("");
            $('#ic_num').val("");
            $('#email').val("");
            $('.show-cart').empty();
            $('.show-cart').hide();
        }
    }
    var userDetail = (function() {
    user = [];
    // Constructor
    function Item(event_name,register,name,address,city,state,phonecode,mobile,ic_num,email) {
        this.event_name = event_name;
        this.register = register;
        this.name = name;
        this.address = address;
        this.city = city;
        this.state = state;
        this.phonecode = phonecode;
        this.mobile = mobile;
        this.ic_num = ic_num;
        this.email = email;
    }
    // Save user
    function saveUser() {
        sessionStorage.setItem('userdetails', JSON.stringify(user));
    }
        // Load user
    function loadUser() {
        user = JSON.parse(sessionStorage.getItem('userdetails'));
    }
    if (sessionStorage.getItem("userdetails") != null) {
        loadUser();
    }
    var obj = {};
    // Add to user
    obj.addUserToCart = function(event_name,register,name,address,city,state,phonecode,mobile,ic_num,email) {
        var item = new Item(event_name,register,name,address,city,state,phonecode,mobile,ic_num,email);
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

    $('#ar_add_btn').click(function(event) {
        userDetail.clearUser();
        event.preventDefault();
        var event_name = $('#event_name').val();
        var register = $('#register').val();
        var name = $('#name').val();
        var address = $('#address').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var phonecode = $('#phonecode').val();
        var mobile = $('#mobile').val();
        var ic_num = $('#ic_num').val();
        var email = $('#email').val();
        if(event_name.length === 0) {
            $("#event_name").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#event_name").focus().offset().top - 25
            }, 500);
        }
        else if(register.length === 0) {
            $("#register").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#register").focus().offset().top - 25
            }, 500);
        }
        else if(name.length === 0) {
            $("#name").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#name").focus().offset().top - 25
            }, 500);
        }
        else if(address.length === 0) {
            $("#address").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#address").focus().offset().top - 25
            }, 500);
        }
        else if(city.length === 0) {
            $("#city").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#city").focus().offset().top - 25
            }, 500);
        }
        else if(mobile.length === 0) {
            $("#mobile").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#mobile").focus().offset().top - 25
            }, 500);
        }
        /* else if(email.length === 0 || IsEmail(email)===0) { */
        else if(email.length === 0) {
            $("#email").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#email").focus().offset().top - 25
            }, 500);
        }
        else
        {
            userDetail.addUserToCart(event_name,register,name,address,city,state,phonecode,mobile,ic_num,email);
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
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Event Name </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].event_name+"</td>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Registered By</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].register+"</td>";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Name </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].name+"</td>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Address</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].address+"</td>"
            + "</tr>";
            /*output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>City </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].city+"</td>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>State</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].state+"</td>"
            + "</tr>";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Mobile No </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].phonecode+" "+cartArray[0].mobile+"</td>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Icno/Passportno</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].ic_num+"</td>"
            + "</tr>";
            output += "<tr>"
            + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Email ID </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;' colspan='3'>"+cartArray[0].email+"</td>"
            + "</tr>";*/
            $('.show-cart').html(output);
            $('.show-cart').show();
        }
        else
        {
            $('#event_name').val("");
            $('#register').val("");
            $('#name').val("");
            $('#address').val("");
            $('#city').val("");
            $('#state').val("");
            $('#phonecode').val("+60");
            $('#mobile').val("");
            $('#ic_num').val("");
            $('#email').val("");
            $('.show-cart').empty();
            $('.show-cart').hide();
        }
        //alert(cartArray.length);
    }
    displayCart();

    $("#add_one").change(function(){
        var id = $("#add_one").val();
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/booking/getpack_amt",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    console.log(data)
                    ////Number(data['amt']).toFixed(2)
                    $("#get_pack_amt").val(Number(data['amt']).toFixed(2));
                    $("#pack_name").val(data['name']);
                }
            });
        }else{
            $("#get_pack_amt").val(0);
        }
    });
    $("#pack_add").click(function(){
         //alert("a");
        //var id = $("#add_one option:selected").val();
		var id = $("#add_one option:selected").val();
        var cnt = parseInt($("#pack_row_count").val());
		amt = $("#get_pack_amt").val();
		//alert(amt);
        if(id != '' && parseFloat(amt)>0){
            var name = $("#pack_name").val();
            
            var html = '<tr id="rmv_packrow'+cnt+'">';
                html += '<td style="width: 60%;"><input type="hidden" readonly name="package['+cnt+'][pack_id]" value="'+id+'"> '+name+'</td>';
                html += '<td style="width: 25%;"><input type="text" style="border: none; width:100%" readonly class="package_amt12" name="package['+cnt+'][pack_amt]" value="'+Number(amt).toFixed(2)+'"></td>';
                html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack('+ cnt +')" style="width:auto;padding: 0px 3px !important; color:#fff;"><i class="mdi mdi-delete"></i></a></td>';
                html += '</tr>';
            $("#package_table").append(html);
            var ct = parseInt(cnt + 1);
            $("#pack_row_count").val(ct);
            sum_amount();
			$("#get_pack_amt").val('');
			$("#add_one").val('');
        }
    });

    function rmv_pack(id){
        $("#rmv_packrow"+id).remove();
        sum_amount();
    }

    function sum_amount(){
        var total = 0;
        var pay_tot = 0;
        $(".package_amt").each(function(){
            if (this.checked) {
                total += parseFloat($(this).val());
            }
        });
        $("#total_amt").val(Number(total).toFixed(2));
    }
    $("input[name='timing[]']").click(function(){
        //alert("haiiii");
        $("input[name='timing[]']").removeClass("error-input");
    });
    $("input[name='pay_for[]']").click(function(){
        //alert("haiiii");
        $("input[name='pay_for[]']").removeClass("error-input");
    });
// MAIN JS FILE START
(function($) {
"use strict";
// Setup the calendar with the current date
$(document).ready(function(){
    var date = new Date();
    var today = date.getDate();
    // Set click handlers for DOM elements
    $(".right-button").click({date: date}, next_year);
    $(".left-button").click({date: date}, prev_year);
    $(".month").click({date: date}, month_click);
    $("#add-button").click({date: date}, new_event);
    // Set current month as active
    $(".months-row").children().eq(date.getMonth()).addClass("active-month");
    init_calendar(date);
    var events = check_events(today, date.getMonth()+1, date.getFullYear());
    show_events(events, months[date.getMonth()], today);
});
// Get the number of days in a given month/year
function days_in_month(month, year) {
    var monthStart = new Date(year, month, 1);
    var monthEnd = new Date(year, month + 1, 1);
    return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);    
}
// Event handler for when a date is clicked
function date_click(event) {
    $(".events-container").show(250);
    $("#dialog").hide(250);
    $(".active-date").removeClass("active-date");
    $(this).addClass("active-date");
    show_events(event.data.events, event.data.month, event.data.day);
};
// Event handler for when a month is clicked
function month_click(event) {
    $(".events-container").show(250);
    $("#dialog").hide(250);
    var date = event.data.date;
    $(".active-month").removeClass("active-month");
    $(this).addClass("active-month");
    var new_month = $(".month").index(this);
    date.setMonth(new_month);
    init_calendar(date);
}
// Event handler for when the year right-button is clicked
function next_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()+1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}
// Event handler for when the year left-button is clicked
function prev_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()-1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}
// Display all events of the selected date in card views
function show_events(events, month, day) {
    // Clear the dates container
    $(".events-container").empty();
    $(".events-container").show(250);
    //console.log(event_data["events"]);
    // If there are no events for this date, notify the user
    if(events.length===0) {
        var event_card = $("<div class='event-card'></div>");
        var event_name = $("<div class='event-name'>There are no events planned for "+month+" "+day+".</div>");
        $(event_card).css({ "border-left": "10px solid #FF1744" });
        $(event_card).append(event_name);
        $(".events-container").append(event_card);
    }
    else {
        // Go through and add each event as a card to the events container
        for(var i=0; i<events.length; i++) {
            var event_card = $("<div class='event-card'></div>");
            var event_name = $("<div class='event-name'><span class='cal_head'>Event Name</span> : "+events[i]["event_name"]+" , </div>");
            var event_count = $("<div class='event-name'> <span class='cal_head'>Booked Time</span> : "+events[i]["register_by"]+"<span class='book_sts'>Booked</span></div>");
            if(events[i]["cancelled"]===true) {
                $(event_card).css({
                    "border-left": "10px solid #FF1744"
                });
                event_count = $("<div class='event-cancelled'>Cancelled</div>");
            }
            $(event_card).append(event_name).append(event_count);
            $(".events-container").append(event_card);
        }
    }
}
// Initialize the calendar by appending the HTML dates
function init_calendar(date) {
    $(".tbody").empty();
    $(".events-container").empty();
    var calendar_days = $(".tbody");
    var month = date.getMonth();
    var year = date.getFullYear();
    var day_count = days_in_month(month, year);
    var row = $("<tr class='table-row'></tr>");
    var today = date.getDate();
    // Set date to 1 to find the first day of the month
    date.setDate(1);
    var first_day = date.getDay();
    // 35+firstDay is the number of date elements to be added to the dates table
    // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
    for(var i=0; i<35+first_day; i++) {
        // Since some of the elements will be blank, 
        // need to calculate actual date from index
        var day = i-first_day+1;
        // If it is a sunday, make a new row
        if(i%7===0) {
            calendar_days.append(row);
            row = $("<tr class='table-row'></tr>");
        }
        // if current index isn't a day in this month, make it blank
        if(i < first_day || day > day_count) {
            var curr_date = $("<td class='table-date nil'>"+"</td>");
            row.append(curr_date);
        }   
        else {
            var curr_date = $("<td class='table-date'>"+day+"</td>");
            var events = check_events(day, month+1, year);
            if(today===day && $(".active-date").length===0) {
                curr_date.addClass("active-date");
                show_events(events, months[month], day);
            }
            // If this date has any events, style it with .event-date
            if(events.length!==0) {
                curr_date.addClass("event-date");
            }
            // Set onClick handler for clicking a date
            curr_date.click({events: events, month: months[month], day:day}, date_click);
            row.append(curr_date);
        }
    }
    // Append the last row and set the current year
    calendar_days.append(row);
    $(".year").text(year);
}
// Event handler for clicking the new event button
function new_event(event) {
    // if a date isn't selected then do nothing
    if($(".active-date").length===0)
        return;
    // remove red error input on click
    $("input").click(function(){
        $(this).removeClass("error-input");
    })
    // empty inputs and hide events
    $("#dialog input[type=text]").val('');
    $("#dialog input[type=number]").val('');
    $(".events-container").hide(250);
    $("#dialog").show(250);
    var curdate = event.data.date;
    var curday = parseInt($(".active-date").html());
    var event_date = curdate.getFullYear()+"-"+(curdate.getMonth()+1)+"-"+curday;
    $("#event_date").val(event_date);
    loadbookingslots(event_date);
    // Event handler for cancel button
    $("#cancel-button").click(function() {
        $("#name").removeClass("error-input");
        $("#event_name").removeClass("error-input");
        $("#event_date").removeClass("error-input");
        $("#mobile").removeClass("error-input");
        $("#email").removeClass("error-input");
        $("#address").removeClass("error-input");
        $("#city").removeClass("error-input");
        $("#pack_row_count").removeClass("error-input");
        $("#total_amt").removeClass("error-input");
        $("input[name='timing[]']").removeClass("error-input");
        $("input[name='pay_for[]']").removeClass("error-input");
        $("#dialog").hide(250);
        $(".events-container").show(250);
        $("#event_date").val("");
        $(".payment li label").removeClass("error-input");
    });
    // Event handler for ok button
    $("#ok-button").unbind().click({date: event.data.date}, function() {
        //alert($('.slot').filter(':checked').length);
       // return;
        var date = event.data.date;
        var name = $("#name").val().trim();
        var event_name = $("#event_name").val().trim();
        var event_date = $("#event_date").val();
        var mobile = $("#mobile").val().trim();
        var email = $("#email").val().trim();
        var address = $("#address").val().trim();
        var city = $("#city").val().trim();
        var pack_row_count = parseInt($("#pack_row_count").val());
        var total_amt = parseFloat($("#total_amt").val());
        var day = parseInt($(".active-date").html());
        var month = $(".active-month").html();
        var register_by =$("#register").val().trim();
        var timings = $('.slot').filter(':checked').length;
        var package_amt = $('.package_amt').filter(':checked').length;
        
        if(timings === 0) {
            $("input[name='timing[]']").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("input[name='timing[]']").focus().offset().top - 25
            }, 500);
        }
        else if(package_amt === 0) {
            $("input[name='pay_for[]']").addClass("error-input");
            $(".payment li label").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("input[name='pay_for[]']").focus().offset().top - 25
            }, 500);
        }
        else if(pack_row_count.length === 0 || pack_row_count == '') {
            $("#get_pack_amt").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#get_pack_amt").focus().offset().top - 25
            }, 500);
        }
        else if(total_amt.length === 0) {
            $("#total_amt").addClass("error-input");
            $('html, body').animate({
                scrollTop: $("#total_amt").focus().offset().top - 25
            }, 500);
        }
        else {
            $.ajax({
				type:"POST",
				url: "<?php echo base_url();?>/booking/save_booking",
				data: $("form").serialize(),
                beforeSend: function() {    
                    $("#loader").show();
                },
				success:function(data)
				{
                    userDetail.clearUser();
                    displayCart();
                    $("#dialog").hide(250);
                    /* location.reload(); */
					var obj = jQuery.parseJSON(data);
					console.log(data);
					if(obj.err != ''){
						$('#alert-modal').modal('show', {backdrop: 'static'});
						$("#spndeddelid").text(obj.err);
					}else{
						window.open("<?php echo base_url();?>/booking/payment_process/" + obj.id, "_blank", "width=680,height=500");
						//window.location.reload(true);
					}
				},
                complete:function(data){
                    // Hide image container
                    $("#loader").hide();
                },
			});
            //$("#dialog").hide(250);
            //new_event_json(name, date, day, slot);
            //date.setDate(day);
            //init_calendar(date);
        }
    });
}
function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return 0;
    }else{
        return 1;
    }
}
function loadbookingslots(date)
{
    $.ajax({
        type:"POST",
        url: "<?php echo base_url();?>/booking/loadbookingslots",
        data: {bookeddate:date},
        success:function(data)
        {
            $("#booking_slot").html(data);
        }
    });
}
// Adds a json event to event_data
function new_event_json(name, date, day, slot) {
    var event = {
        "event_name": name,
        "register_by": slot,
        "year": date.getFullYear(),
        "month": date.getMonth()+1,
        "day": day
    };
    event_data["events"].push(event);
}
// Checks if a specific date has any events
function check_events(day, month, year) {
    var events = [];
    for(var i=0; i<event_data["events"].length; i++) {
        var event = event_data["events"][i];
        if(event["day"]===day &&
            event["month"]===month &&
            event["year"]===year) {
                events.push(event);
            }
    }
    return events;
}

// Given data for events in JSON format
var event_data = <?php echo $hall_booking; ?>;
//occasion
const months = [ 
"January", 
"February", 
"March", 
"April", 
"May", 
"June", 
"July", 
"August", 
"September", 
"October", 
"November", 
"December" 
];

})(jQuery);

</script>
</body>
</html>

