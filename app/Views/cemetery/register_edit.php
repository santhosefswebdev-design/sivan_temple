<?php //print_r($max['max_num']); ?>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<style>
.table tr:nth-child(odd) { background:#FFEAEA; }
.table tr td { padding:5px; }
</style>
<section class="content">
    <div class="container-fluid">
			<?php if($_SESSION['succ'] != '') { ?>
                <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                    <div class="suc-alert">
                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p><?php echo $_SESSION['succ']; ?></p> 
                    </div>
                </div>
            <?php } ?>
            <?php if($_SESSION['fail'] != '') { ?>
                <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p><?php echo $_SESSION['fail']; ?></p>
                    </div>
                </div>
            <?php } ?>
            <div class="block-header">
            <h2>CEMETERY<small>Cemetery / <a href="#" target="_blank">Cemetery Registration</a></small></h2>
        </div>
		
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><h2>Cemetery Registration</h2></div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>/cemetery/update_register" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="reg_id" id="reg_id" value="<?php echo $data['id']; ?>">
                    <div class="body"> 
                        <div class="container-fluid">
                        <div class="row clearfix">
                        <div class="add_box">
							<div class="row">
                                <div class="col-md-12"><h4>Application to Cremate the body of a deceased person</h4></div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" required name="cemetery_application_no" 
                                            value="<?php echo !empty($data['num']) ? $data['num'] : $data['max']; ?>" id="cemetery_application_no" >
                                            <label class="form-label">Application No <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="date" class="form-control" disabled name="cemetery_date" id="cemetery_date" value="<?php echo $data['date']; ?>">
                                            <label class="form-label">Date <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select name="slot_type" id="slot_type" class="form-control" disabled readonly>
                                                
                                            </select>
                                            <label class="form-label">Booking Slot <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" required name="reg_no" id="reg_no" value="<?php echo $data['reg_no']; ?>">
                                            <label class="form-label">Register No.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" required name="receipt_no" id="receipt_no" value="<?php echo $data['receipt_no']; ?>">
                                            <label class="form-label">Receipt No. </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
    						<div class="row">
                                <div class="col-md-12"><h4>Particulars of the deceased person to be Cremated</h4></div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="cemetery_name_deceased" id="cemetery_name_deceased" value="<?php echo $data['name_of_deceased']; ?>" readonly>
                                            <label class="form-label">Name of Deceased <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" rows="1" name="cemetery_address" id="cemetery_address" readonly><?php echo $data['address_of_deceased']; ?></textarea>
                                            <label class="form-label">Address <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="cemetery_nationality" id="cemetery_nationality" value="<?php echo $data['nationality']; ?>" readonly>
                                            <label class="form-label">Race <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="cemetery_age" id="cemetery_age" value="<?php echo $data['age']; ?>" readonly>
                                            <label class="form-label">Age <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <input name="cemetery_gender" type="radio" id="radio_30" class="with-gap radio-col-red" value="Male" <?php if($data['sex'] == "Male"){ echo "checked"; } ?> />
                                        <label for="radio_30">Male</label>
                                        <input name="cemetery_gender" type="radio" id="radio_31" class="with-gap radio-col-red" value="Female" <?php if($data['sex'] == "Female"){ echo "checked"; } ?>/>
                                        <label for="radio_31">Female</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <input name="cemetery_marital" type="radio" id="radio_32" class="with-gap radio-col-purple" value="Married" <?php if($data['marital_status'] == "Married"){ echo "checked"; } ?>/>
                                        <label for="radio_32">Married</label>
                                        <input name="cemetery_marital" type="radio" id="radio_33" class="with-gap radio-col-purple" value="Single" <?php if($data['marital_status'] == "Single"){ echo "checked"; } ?> />
                                        <label for="radio_33">Single</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="nric_old" id="nric_old" value="<?php echo $data['nric_old']; ?>" readonly>
                                            <label class="form-label">NRIC Old <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="nric_new" id="nric_new" value="<?php echo $data['nric_new']; ?>" readonly>
                                            <label class="form-label">NRIC New <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="date"  class="form-control" name="cemetery_date_demise" id="cemetery_date_demise" value="<?php echo $data['date_of_demise']; ?>" readonly>
                                            <label class="form-label">Date of Demise <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="occupation" id="occupation" value="<?php echo $data['occupation']; ?>" readonly>
                                            <label class="form-label">Occupation <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="d_certif_no" id="d_certif_no" value="<?php echo $data['d_certif_no']; ?>" readonly>
                                            <label class="form-label">Date Certificate Number <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="d_certif_issue" id="d_certif_issue" value="<?php echo $data['d_certif_issue']; ?>" readonly>
                                            <label class="form-label">Issued by <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="date" class="form-control" name="d_certif_date" id="d_certif_date" value="<?php echo $data['d_certif_date']; ?>" readonly>
                                            <label class="form-label">Date of Issue <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="b_certif_no" id="b_certif_no" value="<?php echo $data['b_certif_no']; ?>" readonly>
                                            <label class="form-label">Burial Certificate Number <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="b_certif_issue" id="b_certif_issue" value="<?php echo $data['b_certif_issue']; ?>" readonly>
                                            <label class="form-label">Issued by <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="date" class="form-control" name="b_certif_date" id="b_certif_date" value="<?php echo $data['b_certif_date']; ?>" readonly>
                                            <label class="form-label">Date of Issue <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12"><h4>Particulars of the Applicant</h4></div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control"  name="cemetery_name_applicant" id="cemetery_name_applicant" value="<?php echo $data['name_of_applicant']; ?>" readonly>
                                            <label class="form-label">Name of Applicant <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="app_nric_old" id="app_nric_old" value="<?php echo $data['app_nric_old']; ?>" readonly>
                                            <label class="form-label">NRIC Old </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="app_nric_new" id="app_nric_new" value="<?php echo $data['app_nric_new']; ?>" readonly>
                                            <label class="form-label">NRIC New <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="cemetery_applicant_address" id="cemetery_applicant_address" value="<?php echo $data['address_of_applicant']; ?>" readonly>
                                            <label class="form-label">Address <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="cemetery_relationship_deceased" id="cemetery_relationship_deceased" value="<?php echo $data['relationship']; ?>" readonly>
                                            <label class="form-label">Relationship of deceased <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="app_phone" id="app_phone" value="<?php echo $data['app_phone']; ?>" readonly>
                                            <label class="form-label">Contact Number <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <label class="form-label" style="font-weight:200">Whether the applicant is an exetor of the estate of the deceased person</label><br>
                                        <input name="exetor_of_estate" type="radio" id="radio_34" class="with-gap radio-col-red" value="Yes" <?php if($data['exetor_of_estate'] == "Yes"){ echo "checked"; } ?> />
                                        <label for="radio_34">Yes</label>
                                        <input name="exetor_of_estate" type="radio" id="radio_35" class="with-gap radio-col-red" value="No" <?php if($data['exetor_of_estate'] == "No"){ echo "checked"; } ?> />
                                        <label for="radio_35">No</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <label class="form-label" style="font-weight:200">Whether the applicant is the nearest surviving relative of the deceased person</label><br>
                                        <input name="nearest_relative" type="radio" id="radio_36" class="with-gap radio-col-purple" value="Yes" <?php if($data['nearest_relative'] == "Yes"){ echo "checked"; } ?> />
                                        <label for="radio_36">Yes</label>
                                        <input name="nearest_relative" type="radio" id="radio_37" class="with-gap radio-col-purple" value="No" <?php if($data['nearest_relative'] == "No"){ echo "checked"; } ?> />
                                        <label for="radio_37">No</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tandatanganModal" >Signature</button-->
                                            <?php
											if (!empty($data['signature'])) {
												echo '<div class="sign_img_dis" style="display: inline;"><img src="' . $data['signature'] . '" style="max-height: 50px;"></div>';
											} else {
												echo '<div class="sign_img_dis" style="display: inline;"></div>';
											}
											?>
                                            <input class="form-control" type="hidden" name="signature" id="signature" value="<?php echo $data['signature']; ?>">
                                        </div>
                                    </div>
                                </div>
								<div class="col-sm-6">
									<div class="form-group form-float" style="margin: 2px;">
										<div class="form-line">
											<input type="text"  class="form-control" name="management" id="management" value="<?php echo $data['management']; ?>" readonly>
                                            <label class="form-label">Management<span style="color: red;"> *</span></label>
										</div>
									</div>
								</div>
								<div class="col-sm-12"><h4>Ash Collection</h4></div>
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="datetime-local" class="form-control" name="ash_collect_dete" id="ash_collect_dete" value="<?php echo $data['ash_collect_dete']; ?>">
                                            <label class="form-label">Date/Time <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="ash_collect_by" id="ash_collect_by" value="<?php echo $data['ash_collect_by']; ?>">
                                            <label class="form-label">Collected By<span style="color: red;"> *</span></label>
										</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tandatanganModal1">Signature</button>
                                            <?php
											if (!empty($data['ash_signature'])) {
												echo '<div class="sign_img_dis_app" style="display: inline;"><img src="' . $data['ash_signature'] . '" style="max-height: 50px;"></div>';
											} else {
												echo '<div class="sign_img_dis_app" style="display: inline;"></div>';
											}
											?>
                                            <input class="form-control" type="hidden" name="ash_signature" id="ash_signature" value="<?php echo $data['ash_signature']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row"><button class="btn btn-warning" type="submit">Update</button>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="tandatanganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title">Sinature</h5>
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

<script>
$('#cemetery_date').change(function(){
    get_booking_slot();
});
function get_booking_slot(){
    var cemetry_date = $("#cemetery_date").val();
    var cemetry_id = $("#reg_id").val();
    if(cemetry_date != ''){
        $.ajax({
            url: "<?php echo base_url();?>/cemetery/get_booking_slot",
            type: "post",
            data: {cemetrydate: cemetry_date,cemetryid:cemetry_id},
            success: function(data){
                $("#slot_type").html(data);
                //$('#slot_type').prop('selectedIndex',0);
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
		url: "<?php echo base_url('cemetery/upload_sign'); ?>",
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
		url: "<?php echo base_url('cemetery/upload_app_sign'); ?>",
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