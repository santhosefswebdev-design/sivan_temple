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
            <h2>CEMETERY<small>Cemetery / <a href="#" target="_blank">Cemetery Specialtime</a></small></h2>
        </div>
		
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><h2>Cemetery Specialtime</h2></div>
                        </div>
                    </div>
                    <div class="body"> 
                        <div class="container-fluid">
                        <div class="row clearfix">
                        <div class="add_box">
							<div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="cemetery_application_no" readonly="readonly" value="<?php echo $data['num']; ?>" id="cemetery_application_no" >
                                            <label class="form-label">Application No <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="date" class="form-control" name="cemetery_date" id="cemetery_date" value="<?php echo $data['date']; ?>" disabled>
                                            <label class="form-label">Date <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="slot_type" id="slot_type" value="<?php echo isset($specialtime['name']) ? $specialtime['name'] : ""; ?>" disabled>
                                            <label class="form-label">Booking Slot <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
    						<div class="row">
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
                                            <input type="text" class="form-control"  name="cemetery_nationality" value="<?php echo $data['nationality']; ?>" id="cemetery_nationality" readonly>
                                            <label class="form-label">Nationality <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="<?php echo $data['age']; ?>" name="cemetery_age" id="cemetery_age" readonly>
                                            <label class="form-label">Age <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <input name="cemetery_gender" type="radio" id="radio_30" class="with-gap radio-col-red" value="Male" <?php if ($data['sex'] == 'Male') {echo 'checked';} ?> disabled/>
                                        <label for="radio_30">Male</label>
                                        <input name="cemetery_gender" type="radio" id="radio_31" class="with-gap radio-col-red" value="Female" <?php if ($data['sex'] == 'Female') {echo 'checked';} ?> disabled/>
                                        <label for="radio_31">Female</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <input name="cemetery_marital" type="radio" id="radio_32" class="with-gap radio-col-purple" value="Married" <?php if ($data['marital_status'] == 'Married') {echo 'checked';} ?> disabled />
                                        <label for="radio_32">Married</label>
                                        <input name="cemetery_marital" type="radio" id="radio_33" class="with-gap radio-col-purple" value="Single" <?php if ($data['marital_status'] == 'Single') {echo 'checked';} ?> disabled />
                                        <label for="radio_33">Single</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="date"  class="form-control"  name="cemetery_date_demise" id="cemetery_date_demise" value="<?php echo $data['date_of_demise']; ?>" readonly>
                                            <label class="form-label">Date of Demise <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="datetime-local" class="form-control" name="cemetery_date_cremation" id="cemetery_date_cremation" value="<?php echo $data['date_for_cremation']; ?>" readonly>
                                            <label class="form-label">Date/Time for Cremation <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control"  name="cemetery_burial_permit_no" value="<?php echo $data['burial_no']; ?>" id="cemetery_burial_permit_no" readonly>
                                            <label class="form-label">Burial Permit Number <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="cemetery_place_demise" value="<?php echo $data['place_of_demise']; ?>" id="cemetery_place_demise" readonly>
                                            <label class="form-label">Place of Demise <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control"  name="cemetery_demise_registered" value="<?php echo $data['demise_registered']; ?>" id="cemetery_demise_registered" readonly>
                                            <label class="form-label">Demise Registered at <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="cemetery_funeral" value="<?php echo $data['funeral_arrangements']; ?>" id="cemetery_funeral" readonly>
                                            <label class="form-label">Funeral arrangements entrusted to <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control"  name="cemetery_name_applicant" value="<?php echo $data['name_of_applicant']; ?>" id="cemetery_name_applicant" readonly>
                                            <label class="form-label">Name of Applicant <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="cemetery_relationship_deceased" value="<?php echo $data['relationship']; ?>" id="cemetery_relationship_deceased" readonly>
                                            <label class="form-label">Relationship of deceased <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control"  name="cemetery_applicant_address" value="<?php echo $data['address_of_applicant']; ?>" id="cemetery_applicant_address" readonly>
                                            <label class="form-label">Address <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
								<div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="cemetery_overtime_fee" value="<?php echo $data['overtime_fee']; ?>" id="cemetery_overtime_fee" readonly>
                                            <label class="form-label">Overtime Fee <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="ic_no" id="ic_no" value="<?php echo $data['ic_no']; ?>" readonly>
                                            <label class="form-label">I.C Number <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line" style="border-bottom:none;">
                                            <!--<label class="form-label">Signature <span style="color: red;"> *</span></label>-->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tandatanganModal" style="display:none;">Signature</button>
                                            <?php
											if (!empty($data['signature'])) {
												echo '<div class="sign_img_dis formline"><img src="' . $data['signature'] . '" style="max-height: 50px;"></div>';
											} else {
												echo '<div class="sign_img_dis"></div>';
											}
											
											?>
                                            <input class="form-control" type="hidden" name="signature" id="signature" disabled>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-6">
                            <table class="table" style="width:100% !important; margin:0 auto;">
							<?php
							$db = \Config\Database::connect();
							$check_cemetery_settings = $db->table('cemetery_fee_details')->where('cemetery_id', $data['id'])->get()->getResultArray();
                            $total_amt = 0.00;
							if(count($check_cemetery_settings) > 0)
							{
								foreach($check_cemetery_settings as $cemesett_row)
								{
                                    $total_amt = $total_amt + $cemesett_row['fee_amount'];
							?>
                            <tr>
								<td style="width:75%;">
									<input type="text" name="cemetery_text[]" id="cemetery_text" class="form-control" value="<?php echo $cemesett_row['fee_text']; ?>" readonly>
								</td>
								<td style="width:25%;">
									<input type="text" name="cemetery_amount[]" id="cemetery_amount" class="form-control" value="<?php echo $cemesett_row['fee_amount']; ?>" readonly>
								</td>
							</tr>
							<?php
								}
							}
							?>
                            <tr>
                                <td>Total</td>
                                <td><input type="number" min="0" step="any" name="cemetery_total" id="cemetery_total" class="form-control" value="<?php echo number_format((float)$total_amt, 2, '.', ''); ?>" readonly></td>
                            </tr>
                            </table>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>/cemetery/update_specialtime_status" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="reg_id" id="reg_id" value="<?php echo $data['id'];?>">       
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select name="special_time_status" id="special_time_status" class="form-control" required>
                                            <option value="">select status</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                            <option value="0">Pending</option>
                                        </select>
                                        <!--label class="form-label">Booking Slot <span style="color: red;">*</span></label-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-success" type="submit">Update</button>
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

<script>
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
                $("#slot_type").selectpicker("refresh");
            }
        });
    }
}
$(document).ready(function () {
    get_booking_slot();
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

</script>