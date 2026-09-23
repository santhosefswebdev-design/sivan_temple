<!doctype html>
<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"  prefix="og: http://ogp.me/ns#" class="no-js">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>QR scanner</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<?php /* <script src="https://rawgit.com/kabachello/jQuery-Scanner-Detection/master/jquery.scannerdetection.js" ></script> */ ?>
		<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
	</head>
	<body>
<style>
ul.payment {
    list-style-type: none;
    width: 100%;
    display: flex;
    justify-content: space-between;
	margin-bottom:0;
	padding-left:0;
	flex-wrap: wrap;
}

.payment li {
    display: inline-block;
    text-align:center;
    width:25%;
}

input[type="radio"][id^="cb"] {
  display: none;
}

label {
  border: 1px solid #CCC;
  border-radius: 5px;
  line-height: 1;
  padding: 5px;
  display: block;
  position: relative;
  margin: 5px;
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
background:#f2f2f2;
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
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<form action="<?php echo base_url() . $submit_url; ?>" id="ipay_qr_form" method="post">
						<input type="hidden" name="barcode" id="barcode" value="" />
						<?php /* <input type="hidden" name="payment_id" id="payment_id" value="336" /> */ ?>
						<ul class="payment">
						  <?php
							$i=1;
							foreach($list as $row) {
						  ?>
						  <li><input type="radio" required name="payment_id" id="cb<?php echo $i; ?>"<?php echo ($row['pay_id'] == 336 ? ' checked' : ''); ?> value="<?php echo $row['pay_id']; ?>" />
							<label for="cb<?php echo $i; ?>"><img src="<?php echo base_url(); ?>/uploads/payment/<?php echo $row['image']; ?>" class="img-fluid"></label>
						  </li>
						  <?php
							$i++;
							}
						  ?>
						</ul>
					</form>
					<h1 style="display:none;">Pleaes Scan TochNGo QR</h1>
					<div class="mt-5" align="center">
                        <button onClick="scan_qr()" class="btn btn-info" type="submit">Scan QR Code</button>
                    </div>
                    
                    <div class="mt-5" id="loader" style="display:none;" align="center">
                        <img src='<?php echo base_url(); ?>/assets/Loading_2.gif' width='60px' height='60px'>
                    </div>
                    
                    <script>
                    function scan_qr() {
                        if(document. querySelector('input[name="payment_id"]:checked')) {
							/* $('#barcode').val('12324 324623847890');
							$( "#ipay_qr_form" ).trigger( "submit" ); */
                            document.getElementById("camera_scan").style.display = "block";
                        } else {
                            alert("Please select any payment mode");
                        }
                    }
                    </script>
					<div id="camera_scan" style="display:none;">
						<div class="col-sm-12">
							<video id="preview" class="p-1 border" style="width:100%;"></video>
						</div>
						
						<script type="text/javascript">
							var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
							scanner.addListener('scan',function(content){
								//alert(content);
								$('#barcode').val(content);
								$( "#ipay_qr_form" ).trigger( "submit" );
							});
							Instascan.Camera.getCameras().then(function (cameras){
								if(cameras.length>0){
									scanner.start(cameras[0]);
									$('[name="options"]').on('change',function(){
										if($(this).val()==1){
											if(cameras[0]!=""){
												scanner.start(cameras[0]);
											}else{
												alert('No Front camera found!');
											}
										}else if($(this).val()==2){
											if(cameras[1]!=""){
												scanner.start(cameras[1]);
											}else{
												alert('No Back camera found!');
											}
										}
									});
								}else{
									console.error('No cameras found.');
									alert('No cameras found.');
								}
							}).catch(function(e){
								console.error(e);
								alert(e);
							});
						</script>
						<div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
						  <label class="btn btn-primary active">
							<input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
						  </label>
						  <label class="btn btn-secondary">
							<input type="radio" name="options" value="2" autocomplete="off"> Back Camera
						  </label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
