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
					    <form class="form" id="form" method="post">
				          <div class="form-container card-body" align="center"> 
				            <div class="container-fluid">
                            <div class="row">
                                                            
                            	<div class="col-md-6">
                                    <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Select Any Donation for Pay</h4>
                                    <ul class="payment prod">
                                      <?php foreach($sett_don as $row) { ?>
                                      <li>
                                          <input type="radio" class="donation_slot" name="pay_for" value="<?php echo $row['id']; ?>" id="pay_for<?php echo $row['id']; ?>" />
                                          <label class="" for="pay_for<?php echo $row['id']; ?>" style="background:url(<?php echo base_url(); ?>/uploads/donation/<?php echo $row['image']; ?>) no-repeat; background-size: cover;" onclick="payfor(<?php echo $row['id']; ?>)" >
                                          <div class="back"><h5><?php echo $row['name']; ?></h5></div></label>
                                      </li>
                                      <?php } ?>
                                    </ul>
                                </div>
                                
                                <div class="col-md-6">  
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="name">Name</label>
                                            <input class="form-control" type="text" id="name" name="name" autocomplete="off">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">  
                                                <label class="form-label" for="email_id">Email Address</label>
                                                <input class="form-control" type="email" id="email_id" name="email_id" autocomplete="off" >
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label class="form-label" for="ic_number">Ic No / Passport No</label>
                                            <input class="form-control" type="text" id="ic_number" name="ic_number" autocomplete="off">
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
                                                    <input class="form-control" type="number" id="mobile" name="mobile" min="0" autocomplete="off" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">   
                                         
                                    </div> 
                                    <div class="row">   
                                        <div class="col-md-6"><div class="form-group">
                                        <label class="form-label" for="address">Address</label>
                                        <textarea class="form-control" id="address" name="address" style="width:100%;" rows="2">  </textarea>
                                        </div></div>
                                        <div class="col-md-6"><div class="form-group">  
                                        <label class="form-label" for="description">Remarks</label>
                                        <textarea class="form-control" id="description" name="description" style="width:100%;" rows="2" autocomplete="off"></textarea>
                                        </div></div>  
                                    </div> 
                                    <div class="row">
                                       <div class="col-md-12">
                                          <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Amount Pay for Donation</h4>
                                          <input type="number" step="0.1" name="total_amount" id="total_amount" class="form-control" step=".01" value="0.00" style="margin-top:20px;font-weight:bold;font-size: 36px;text-align: center;">
                                       </div>
                                    </div>
                                </div>  

                            </div> 
                            </div> 
                        
                    </div>
                        <div class="container-fluid">
                          <div class="row"> <div class="col-sm-12" align="center" style="margin:0 auto;">                           
                            <input type="button" value="Cancel" class="button" id="cancel-button">
                            <input type="button" value="OK" class="button button-white" id="submit">
                          </div></div>
                         </div>
				         
				        </form> </div>
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
	height:350px;
	overflow:auto;
}

.payment li {
    display: inline-block;
	width: 33.33%;
}

input[type="radio"][id^="pay_for"] {
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
$('#total_amount').click(function(){
    $(this).val('');
});
/*function payfor(pay_id)
{
    $.ajax({
        type:"POST",
        url: "<?php echo base_url(); ?>/donation_online/get_donation_amount",
        data: {id: pay_id},
        success:function(data){
          $('#total_amount').val(data);
          $("#pay_for"+pay_id).prop("checked",true);
          $("input[name='pay_for']").removeClass("error-input");
          $(".payment li label").removeClass("error-input");
        }
    });
}*/
$("#submit").click(function(){
    var name = $("#name").val().trim();
    var ic_number = $("#ic_number").val().trim();
    var address = $("#address").val().trim();
    var mobile = $("#mobile").val().trim();
    var email_id = $("#email_id").val().trim();
    var total_amt = parseFloat($("#total_amount").val());
    var pay_for = $('.donation_slot').filter(':checked').length;
    if(pay_for === 0) {
        $("input[name='pay_for']").addClass("error-input");
        $(".payment li label").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("input[name='pay_for']").focus().offset().top - 25
        }, 500);
    }
    else if(name.length === 0) {
        $("#name").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("#name").focus().offset().top - 25
        }, 500);
    }
    else if(ic_number.length === 0) {
        $("#ic_number").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("#ic_number").focus().offset().top - 25
        }, 500);
    }
    else if(mobile.length === 0) {
        $("#mobile").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("#mobile").focus().offset().top - 25
        }, 500);
    }
    else if(email_id.length === 0 || IsEmail(email_id)===0) {
        $("#email_id").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("#email_id").focus().offset().top - 25
        }, 500);
    }
    else if(address.length === 0) {
        $("#address").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("#address").focus().offset().top - 25
        }, 500);
    }
    else if(total_amt.length === 0 || total_amt == '') {
        $("#total_amt").addClass("error-input");
        $('html, body').animate({
            scrollTop: $("#total_amt").focus().offset().top - 25
        }, 500);
    }
    else
    {
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/donation_online/save",
            data: $("form").serialize(),
            beforeSend: function() {    
                $("#loader").show();
            },
            success:function(data)
            {
                //obj = jQuery.parseJSON(data);
                location.reload();
                /*obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    //$('#alert-modal').modal('show', {backdrop: 'static'});
                    //$("#spndeddelid").text(obj.err);
                }else{					
                    window.location.replace("<?php echo base_url();?>/donation_online");
                            
                }*/
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

