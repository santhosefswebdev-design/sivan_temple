<?php //print_r($max['max_num']); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<style>
.table tr:nth-child(odd) { background:#FFEAEA; }
.table tr td { padding:5px; }
</style>
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Cemetery Registration</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">New Cemetery Registration</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div>
<section class="content">
    <div class="container my-5">
    <div class="row clearfix">
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
		
        <!-- Basic Examples -->
        
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <form action="<?php echo base_url(); ?>/cemeteryreg/save_register" method="POST" enctype="multipart/form-data">
                    <div class="body">  
                        <div class="container-fluid">
                        <div class="row clearfix">
                        <div class="add_box">
							<div class="row">
                                <div class="col-sm-6">
                                            <label class="form-label">Application No <span style="color: red;"> *</span></label>
                                            <input type="text" class="form-control" required name="cemetery_application_no" readonly="readonly" value="<?php echo $max['max_num']; ?>" id="cemetery_application_no" >
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Date <span style="color: red;"> *</span></label>
                                            <input type="date" class="form-control" required name="cemetery_date" id="cemetery_date" value="<?php echo date('Y-m-d'); ?>">
                                       
                                </div>
                            </div>
    						<div class="row">
                                <div class="col-sm-6">
                                            <label class="form-label">Name of Deceased <span style="color: red;"> *</span></label>
                                            <input type="text"  class="form-control" required name="cemetery_name_deceased" id="cemetery_name_deceased">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Address <span style="color: red;"> *</span></label>
                                            <textarea class="form-control" rows="1" name="cemetery_address" id="cemetery_address"></textarea>
                                       
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                            <label class="form-label">Nationality <span style="color: red;"> *</span></label>
                                            <input type="text" class="form-control" required name="cemetery_nationality" id="cemetery_nationality">
                                       
                                </div>
                                <div class="col-sm-3">
                                            <label class="form-label">Age <span style="color: red;"> *</span></label>
                                            <input type="number" class="form-control" name="cemetery_age" id="cemetery_age">
                                       
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <input name="cemetery_gender" type="radio" id="radio_30" class="with-gap radio-col-red" value="Male" />
                                        <label for="radio_30">Male</label>
                                        <input name="cemetery_gender" type="radio" id="radio_31" class="with-gap radio-col-red" value="Female" />
                                        <label for="radio_31">Female</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <input name="cemetery_marital" type="radio" id="radio_32" class="with-gap radio-col-purple" value="Married" />
                                        <label for="radio_32">Married</label>
                                        <input name="cemetery_marital" type="radio" id="radio_33" class="with-gap radio-col-purple" value="Single" />
                                        <label for="radio_33">Single</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                            <label class="form-label">Date of Demise <span style="color: red;"> *</span></label>
                                            <input type="date"  class="form-control" required name="cemetery_date_demise" id="cemetery_date_demise" value="<?php echo date('Y-m-d'); ?>">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Date/Time for Cremation <span style="color: red;"> *</span></label>
                                            <input type="datetime-local" class="form-control" name="cemetery_date_cremation" id="cemetery_date_cremation" value="<?php echo date('Y-m-d h:i'); ?>">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Burial Permit Number <span style="color: red;"> *</span></label>
                                            <input type="text"  class="form-control" required name="cemetery_burial_permit_no" id="cemetery_burial_permit_no">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Place of Demise <span style="color: red;"> *</span></label>
                                            <input type="text" class="form-control" name="cemetery_place_demise" id="cemetery_place_demise">
                                       
                                </div>
                                
                                <div class="col-sm-6">
                                            <label class="form-label">Demise Registered at <span style="color: red;"> *</span></label>
                                            <input type="text"  class="form-control" required name="cemetery_demise_registered" id="cemetery_demise_registered">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Funeral arrangements entrusted to <span style="color: red;"> *</span></label>
                                            <input type="text" class="form-control" name="cemetery_funeral" id="cemetery_funeral">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Name of Applicant <span style="color: red;"> *</span></label>
                                            <input type="text"  class="form-control" required name="cemetery_name_applicant" id="cemetery_name_applicant">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Relationship of deceased <span style="color: red;"> *</span></label>
                                            <input type="text" class="form-control" name="cemetery_relationship_deceased" id="cemetery_relationship_deceased">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">Address <span style="color: red;"> *</span></label>
                                            <input type="text"  class="form-control" required name="cemetery_applicant_address" id="cemetery_applicant_address">
                                       
                                </div>
								<div class="col-sm-6">
                                            <label class="form-label">Overtime Fee <span style="color: red;"> *</span></label>
                                            <input type="text"  class="form-control" name="cemetery_overtime_fee" id="cemetery_overtime_fee">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">I.C Number <span style="color: red;"> *</span></label>
                                            <input type="text"  class="form-control" name="ic_no" id="ic_no">
                                       
                                </div>
                                <div class="col-sm-6">
                                            <label class="form-label">&nbsp;</label> 
                                            <button type="button" class="btn btn-primary" style="margin-top:40px;" data-toggle="modal" data-target="#tandatanganModal">Signature</button>
                                            <div class="sign_img_dis"></div>
                                            <input class="form-control" type="hidden" name="signature" id="signature">
                                       
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                            <table class="table" style="width:100% !important; margin:20px auto;">
							<?php
							$db = \Config\Database::connect();
							$check_cemetery_settings = $db->table('cemetery_settings')->get()->getResultArray();
							if(count($check_cemetery_settings) > 0)
							{
								foreach($check_cemetery_settings as $cemesett_row)
								{
							?>
                            <tr>
								<td style="width:75%;">
									<input type="text" name="cemetery_text[]" id="cemetery_text" class="form-control" value="<?php echo $cemesett_row['meta_key']; ?>" readonly>
								</td>
								<td style="width:25%;">
									<input type="text" name="cemetery_amount[]" id="cemetery_amount" class="form-control" value="<?php echo $cemesett_row['meta_value']; ?>">
								</td>
							</tr>
							<?php
								}
							}
							?>
                            </table>
                            </div>
                            <div class="col-md-3"></div>
                            </div>
                        </div>
                        </div>
						<br>
						<p style="text-align:center">
                       <button class="btn btn-success" type="submit" >Submit</button>
					   </p>
                    
					<br>
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
        $('.sign_img_dis').html('<img src="' + sign + '" style="max-height: 50px;">');
        $('#signature').val(sign);
    }else{
        $('.sign_img_dis').empty();
    }
}

</script>