<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<style>
  table tr th {
    padding: 10px;
    background: #000000;
    color: #FFFFFF;
  }

  .form-group {
    width: 100%;
    margin: 5px auto;
    height: calc(3rem + 2px);
  }
</style>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="block-header">
        <h2> KAVADI <small>Kavadi / <b>Kavadi Registration</b>
          </small>
        </h2>
      </div>
      <!-- Basic Examples -->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <div class="row">
              <div class="col-md-12" align="center">
                <h2>PENANG THAIPUSAM 2023 – KAVADI REGISTRATION FORM</h2>
              </div>
            </div>
          </div>
          <form method="POST" enctype="multipart/form-data" action="
						<?php echo base_url(); ?>/kavadi/store">
            <div class="body">
              <div class="container-fluid">
                <div class="row clearfix">
                  <div class="col-sm-3">
                    <div class="form-group form-float">
                      <span style="font-size:18px; font-weight:bold;">Application for : </span>
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <div class="form-group form-float">
                      <input name="application_for" type="radio" id="radio_8" class="radio-col-pink" value="Kovil Kavadi" />
                      <label for="radio_8" style="font-size:18px; font-weight:bold; margin-right:25px;">Kovil Kavadi</label>
                      <input name="application_for" type="radio" id="radio_20" class="radio-col-amber" value="Own Kavadi" />
                      <label for="radio_20" style="font-size:18px; font-weight:bold;">Own Kavadi</label>
                    </div>
                  </div>
                  <table style="width:100%; border-collapse:collapse; border:1px solid #F0F0F0;" border="1">
                    <tr>
                      <th style="width:50%;">Description</th>
                      <th style="width:50%;">Details</th>
                    </tr>
                    <tr>
                      <td>Full Name</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="text" class="form-control" name="full_name" id="full_name">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Native Village in India</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="text" class="form-control" name="native" id="native">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Kovil & Pirivu</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="text" class="form-control" name="kovil_pirivu" id="kovil_pirivu">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Date of Birth</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="date" class="form-control" name="dob" id="dob">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Age</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="number" class="form-control" name="age" id="age">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Identification No ( IC – If Malaysian / Passport – If Non-Malaysian ) </td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="text" class="form-control" name="icnum" id="icnum">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Nationality / Citizenship </td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="text" class="form-control" name="nationality" id="nationality">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Residential Address</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <textarea rows="3" class="form-control" name="address" id="address" style="width:100%"></textarea>
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Contact Number </td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="text" class="form-control" name="contact_no" id="contact_no">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Email Address</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="email" class="form-control" name="email_address" id="email_address">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>No of Years Kavadi was carried in Penang Thaipusam</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="text" class="form-control" name="no_of_years_carring_kavadi" id="no_of_years_carring_kavadi">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Most Recent Year in which Kavadi was carried in Penang</td>
                      <td>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <input type="text" class="form-control" name="recent_year_kavadi_carring" id="recent_year_kavadi_carring">
                          <!--</div>
                        </div>-->
                      </td>
                    </tr>
                    <tr>
                      <td>Date :</td>
                      <td>
                        <br>
                        <!--<div class="form-group form-float">
                          <div class="form-line">-->
                            <!--<label class="form-label">Signature <span style="color: red;"> *</span></label>-->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tandatanganModal">Signature</button>
                            <div class="sign_img_dis"></div>
                            <input class="form-control" type="hidden" name="signature" id="signature">
                          <!--</div>
                        </div>-->
                        <br>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <i>Office Use Only :</i>
                        <br>Acknowledgement Receipt with Date
                      </td>
                      <td></td>
                    </tr>
                  </table>
                  <p style="margin-top:20px;">
                    <i>All applications should be submitted and received by the Temple before <strong>12.00pm on 06Dec22</strong> as follows: </i>
                  </p>
                  <p>
                    <i>If via POST – Managing Trustee, Registered Trustees Nattukottai Chettiar Temples, Penang , 138 Penang Street, 10200 Penang </i>
                  </p>
                  <p>
                    <i>If via EMAIL – rtnctpenang@gmail.com</i>
                  </p>
                  <p>
                    <i>*All received applications would be acknowledged via email while balloting for kavadi would take place on the 6th December 2022, after which the successful applicants would be notified accordingly.</i>
                  </p>
                </div>
              </div>
			  <p style="text-align:right">
				<input type="submit" name="submit_form" value="submit" class="btn btn-success">
			  </p>
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
		url: "<?php echo base_url('kavadi/upload_sign'); ?>",
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