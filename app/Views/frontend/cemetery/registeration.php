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
.card { background: #fff !important; }
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
                <div class="col-md-12">
                    <h5>CEMETERY REGISTRATION</h5>
                </div>
            </div>
            <div class="row">
				<div class="col-md-12 card" style="padding:20px; background:#FFF !important;"> 
					<form action="<?php echo base_url(); ?>/cemeteryreg/save_register" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="reg_id" id="reg_id">
                    <div class="body"> 
                        <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Date <span style="color: red;"> *</span></label>
                                            <input type="date" class="form-control" required name="cemetery_date" id="cemetery_date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+3 days', strtotime(date('Y-m-d')))); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Booking Slot <span style="color: red;">*</span></label>
                                            <select name="slot_type" id="slot_type" class="form-control" required>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add_box" id="add_box" style="display:none;">
                                <!--FIRST SECTION START-->
                                <div class="row">
                                    <div class="col-md-12"><h4>Particulars of the deceased person to be Cremated</h4></div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Name of Deceased <span style="color: red;"> *</span></label>
                                                <input type="text"  class="form-control" required name="cemetery_name_deceased" id="cemetery_name_deceased">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Address </label>
                                                <textarea class="form-control" rows="1" name="cemetery_address" id="cemetery_address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Race <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" required name="cemetery_nationality" id="cemetery_nationality">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Age <span style="color: red;"> *</span></label>
                                                <input type="number" class="form-control" name="cemetery_age" id="cemetery_age" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <label class="form-label">&nbsp;</label>
                                            <input name="cemetery_gender" type="radio" id="radio_30" class="with-gap radio-col-red" value="Male" required/>
                                            <label for="radio_30">Male </label>
                                            <input name="cemetery_gender" type="radio" id="radio_31" class="with-gap radio-col-red" value="Female" />
                                            <label for="radio_31">Female</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <label class="form-label">&nbsp;</label>
                                            <input name="cemetery_marital" type="radio" id="radio_32" class="with-gap radio-col-purple" value="Married" required/>
                                            <label for="radio_32">Married</label>
                                            <input name="cemetery_marital" type="radio" id="radio_33" class="with-gap radio-col-purple" value="Single" />
                                            <label for="radio_33">Single</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">NRIC Old </label>
                                                <input type="text"  class="form-control" name="nric_old" id="nric_old">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">NRIC New <span style="color: red;"> *</span></label>
                                                <input type="text"  class="form-control" name="nric_new" id="nric_new">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Date of Demise <span style="color: red;"> *</span></label>
                                                <input type="date"  class="form-control" required name="cemetery_date_demise" id="cemetery_date_demise" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Occupation <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" name="occupation" id="occupation" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Date Certificate Number <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" name="d_certif_no" id="d_certif_no" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Issued by <span style="color: red;"> *</span></label>
                                                <input type="text"  class="form-control" required name="d_certif_issue" id="d_certif_issue" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Date of Issue <span style="color: red;"> *</span></label>
                                                <input type="date" class="form-control" name="d_certif_date" id="d_certif_date" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Burial Certificate Number <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" name="b_certif_no" id="b_certif_no" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Issued by <span style="color: red;"> *</span></label>
                                                <input type="text"  class="form-control" required name="b_certif_issue" id="b_certif_issue" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <label class="form-label">Date of Issue <span style="color: red;"> *</span></label>
                                                <input type="date" class="form-control" name="b_certif_date" id="b_certif_date" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--FIRST SECTION END-->
                                <!--SECOND SECTION START-->
                                <div class="row">
                                    <div class="col-sm-12"><h4>Particulars of the Applicant</h4></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Name of Applicant <span style="color: red;"> *</span></label>
                                                <input type="text"  class="form-control" required name="cemetery_name_applicant" id="cemetery_name_applicant">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">NRIC Old </label>
                                                <input type="text"  class="form-control" name="app_nric_old" id="app_nric_old">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">NRIC New <span style="color: red;"> *</span></label>
                                                <input type="text"  class="form-control" name="app_nric_new" id="app_nric_new" required>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Address </label>
                                                <input type="text"  class="form-control" required name="cemetery_applicant_address" id="cemetery_applicant_address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Relationship of deceased <span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" name="cemetery_relationship_deceased" id="cemetery_relationship_deceased" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Contact Number <span style="color: red;"> *</span></label>
                                                <input type="text"  class="form-control" name="app_phone" id="app_phone" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <label class="form-label" style="font-weight:200">Whether the applicant is an exetor of the estate of the deceased person</label><br>
                                            <input name="exetor_of_estate" type="radio" id="radio_34" class="with-gap radio-col-red" value="Yes" />
                                            <label for="radio_34">Yes</label>
                                            <input name="exetor_of_estate" type="radio" id="radio_35" class="with-gap radio-col-red" value="No" />
                                            <label for="radio_35">No</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <label class="form-label" style="font-weight:200">Whether the applicant is the nearest surviving relative of the deceased person</label><br>
                                            <input name="nearest_relative" type="radio" id="radio_36" class="with-gap radio-col-purple" value="Yes" />
                                            <label for="radio_36">Yes</label>
                                            <input name="nearest_relative" type="radio" id="radio_37" class="with-gap radio-col-purple" value="No" />
                                            <label for="radio_37">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <!--<label class="form-label">Signature <span style="color: red;"> *</span></label>-->
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tandatanganModal">Signature</button>
                                                <div class="sign_img_dis" style="display: inline;"></div>
                                                <input class="form-control" type="hidden" name="signature" id="signature">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float" style="margin: 2px;">
                                            <div class="form-line">
                                                <label class="form-label">Management<span style="color: red;"> *</span></label>
                                                <input type="text"  class="form-control" name="management" id="management" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--SECOND SECTION END-->
                                <!--THIRD SECTION START-->
                                <div class="row">&nbsp;</div>
                                <div class="row clearfix" style="background: #80808014;padding: 15px 0;">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <table class="table" style="width:100% !important; margin:0 auto;">
                                            <?php
                                                $db = \Config\Database::connect();
                                                $check_cemetery_settings = $db->table('cemetery_settings')->get()->getResultArray();
                                                if(count($check_cemetery_settings) > 0)
                                                {
                                                    $ii = 0;
                                                    foreach($check_cemetery_settings as $cemesett_row)
                                                    {
                                                ?>
                                                <tr>
                                                    <td style="width:5%;">
                                                        <input type="checkbox" name="cemetery_check[<?php echo $ii; ?>]" id="cemetery_check" class="cemetery_check" class="form-control" value="1">
                                                    </td>
                                                    <td style="width:70%;">
                                                        <input type="text" name="cemetery_text[<?php echo $ii; ?>]" id="cemetery_text" class="form-control" value="<?php echo $cemesett_row['meta_key']; ?>" readonly>
                                                    </td>
                                                    <td style="width:25%;">
                                                        <input type="text" name="cemetery_amount[<?php echo $ii; ?>]" id="cemetery_amount" class="form-control cemetery_amount" value="<?php echo $cemesett_row['meta_value']; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                        $ii++;
                                                    }
                                                }
                                                ?>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td colspan="2"><input type="text" name="cemetery_total" id="cemetery_total" class="form-control" value="0" readonly></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <div class="row">&nbsp;</div>
                                <!--THIRD SECTION END-->
                                <div class="row">
                                    <div class="col-md-12" style="text-align:right;">
                                        <button class="btn btn-success" type="submit">Submit</button>
                                        <label class="btn btn-primary" id="save_drafts">Save Drafts</label>
                                    </div>
                                </div>
                                <div class="row">&nbsp;</div>
                            </div>


                        </div>
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
  
  <div class="modal fade" id="tandatanganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title">Sigature</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		<div class="sign_sec">
		<canvas id="signature_img" style="border: 1px solid black;" class="techinicansign"></canvas>
		</div>
		<div class="progress" style="display: none;">
			<div class="sign-progress-bar"></div>
		</div>
		<div id="signUploadStatus"></div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" id="saveCustomerSig">Save changes</button>
		<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
		<button type="button" id="clear-signature"class="btn btn-secondary">Clear</button>
	  </div>
	</div>
  </div>
</div>

<div class="modal fade" id="tandatanganModal1"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title">Signature</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		<div class="sign_sec">
		<canvas id="signature_img1" style="border: 1px solid black;" class="techinicansign"></canvas>
		</div>
		<div class="progress" style="display: none;">
			<div class="sign-progress-bar"></div>
		</div>
		<div id="signUploadStatus_app"></div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" id="saveCustomerSig1">Save changes</button>
		<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
		<button type="button" id="clear-signature1" class="btn btn-secondary">Clear</button>
	  </div>
	</div>
  </div>
</div>

  <!--REPRINT SECTION START-->
<div id="myModal_specialtime" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!--div class="modal-header" style="background: #FFC107;padding: 5px 10px;">
                <button type="button" class="close" data-dismiss="modal" style="font-size: 30px;">&times;</button>
            </div-->
            <div class="modal-body p-4" style="padding-bottom:10px;">
                <div class="text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <h3 style="text-transform: uppercase;font-size: 18px;">Special time slot now closed.</h3>
                        </div>
                        <div class="col-md-12" style="text-align:center;">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- REPRINT SECTION END -->
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
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<script>
$('#slot_type').on('change', function () {
    if ($('#slot_type option:selected').attr('class') === "clk-option") {
        $("#add_box").hide();
        $("#myModal_specialtime").modal("show");
        $('#slot_type').prop('selectedIndex',0);
        $("#slot_type").selectpicker("refresh");
        
    }
    if ($('#slot_type option:selected').attr('class') === "open_cemetery_section") {
        $("#add_box").show();
    }
    else
    {
        $("#add_box").hide();
    }
});
$('#cemetery_date').change(function(){
    get_booking_slot();
});
function get_booking_slot(){
    var cemetry_date = $("#cemetery_date").val();
    var cemetry_id = $("#reg_id").val();
    if(cemetry_date != ''){
        $.ajax({
            url: "<?php echo base_url();?>/cemeteryreg/get_booking_slot",
            type: "post",
            data: {cemetrydate: cemetry_date,cemetryid:cemetry_id},
            success: function(data){
                $("#slot_type").html(data);
                $('#slot_type').prop('selectedIndex',0);
                $("#slot_type").selectpicker("refresh");
            }
        });
    }
}
$(document).ready(function () {
    get_booking_slot();
	$(document).on('click', '.cemetery_check', function(){
		var total = 0;
		$('.cemetery_check').each(function(){
			if($(this).prop('checked')){
				total += parseFloat($(this).parent().parent().find(".cemetery_amount").val());
			}
		});
		$('#cemetery_total').val(total);
	});
});

$("#save_drafts").click(function(){
    var cemetery_date       = $("#cemetery_date").val();
    var slot_type    = $("#slot_type").val();
    var cemetery_name_deceased         = $("#cemetery_name_deceased").val();
    if (cemetery_date =="" || slot_type =="" || cemetery_name_deceased==""){
        alert("please enter required fields.");
    }
    else
    {
        $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>/cemeteryreg/save_register",
            data: $("form").serialize() + "&save_drafts=1",
            beforeSend: function() {    
              //  $("#loader").show();
            },
            success:function(data)
            {
                location.reload();
            },
            complete:function(data){
                // Hide image container
              //  $("#loader").hide();
            }
        });
    }
});
var input = document.querySelector('input[type=file]'); // see Example 4
var canvas = document.getElementById("signature_img");

var signaturePad = new SignaturePad(canvas,{
    dotSize: 1
});

$('#clear-signature').on('click', function(){
    signaturePad.clear();
});
$("#saveCustomerSig").click(function () {
	var signature_img = canvas.toDataURL("image/png");
	var formData = new FormData();
	var elm = this;
	formData.append('signature_img', signature_img);
	$.ajax({
		type: "POST",
		url: "<?php echo base_url('cemeteryreg/upload_sign'); ?>",
		data: formData,
		dataType: 'json',
		contentType: false,
		cache: false,
		processData: false,
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(elm).parents('.modal-content').find(".sign-progress-bar").width(percentComplete + '%');
					$(elm).parents('.modal-content').find(".sign-progress-bar").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		beforeSend: function(){
			$(elm).parents('.modal-content').find(".sign-progress-bar").width('0%');
			$('#signUploadStatus').html('');
			$(elm).parents('.modal-content').find('.progress').show();
		},
		success: function (data) {
			console.log(data);
			if(typeof data.image_url != 'undefined'){
				$('#signUploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
				$("#tandatanganModal").modal("hide");
				update_signature(data.image_url);
			}else $('#signUploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
		},
		error: function (data) {
			console.log('An error occurred.');
			console.log(data);
			$('#signUploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again....</p>');
		},

	});

});

function update_signature(sign){
    if(sign != '' && sign != null){
        $('.sign_img_dis').addClass('formline');
        $('.sign_img_dis').html('<img src="' + sign + '" style="max-height: 36px;">');
        $('#signature').val(sign);
    }else{
        $('.sign_img_dis').empty();
    }
}

var input = document.querySelector('input[type=file]'); // see Example 4
var canvas1 = document.getElementById("signature_img1");

var signaturePad1 = new SignaturePad(canvas1,{
    dotSize: 1
});

$('#clear-signature1').on('click', function(){
    signaturePad1.clear();
});
$("#saveCustomerSig1").click(function () {
	var signature_img1 = canvas1.toDataURL("image/png");
	var formData = new FormData();
	var elm = this;
	formData.append('signature_img1', signature_img1);
	$.ajax({
		type: "POST",
		url: "<?php echo base_url('cemeteryreg/upload_app_sign'); ?>",
		data: formData,
		dataType: 'json',
		contentType: false,
		cache: false,
		processData: false,
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = ((evt.loaded / evt.total) * 100);
					$(elm).parents('.modal-content').find(".sign-progress-bar").width(percentComplete + '%');
					$(elm).parents('.modal-content').find(".sign-progress-bar").html(percentComplete+'%');
				}
			}, false);
			return xhr;
		},
		beforeSend: function(){
			$(elm).parents('.modal-content').find(".sign-progress-bar").width('0%');
			$('#signUploadStatus_app').html('');
			$(elm).parents('.modal-content').find('.progress').show();
		},
		success: function (data) {
			console.log(data);
			if(typeof data.image_url != 'undefined'){
				$('#signUploadStatus_app').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
				$("#tandatanganModal1").modal("hide");
                //$('.modal').remove();
                //$('.modal-backdrop').remove();
                $('#tandatanganModal1').removeClass("show");
                $(".modal-backdrop").remove();
                $("#tandatanganModal1").hide();
                //$("#tandatanganModal").attr('aria-hidden', 'true').show();
                //$(".fade.show").css("opacity", "0");
                //("#tandatanganModal1").css("display", "none");
				update_app_signature(data.image_url);
			}else $('#signUploadStatus_app').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
		},
		error: function (data) {
			console.log('An error occurred.');
			console.log(data);
			$('#signUploadStatus_app').html('<p style="color:#EA4335;">File upload failed, please try again....</p>');
		},

	});

});

function update_app_signature(sign){
    if(sign != '' && sign != null){
        $('.sign_img_dis_app').addClass('form-line');
        $('.sign_img_dis_app').html('<img src="' + sign + '" style="max-height: 36px;">');
        $('#ash_signature').val(sign);
    }else{
        $('.sign_img_dis_app').empty();
    }
}

</script>

</body>
</html>

