<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Hall Booking</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">Hall Booking Repayment</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div> 
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                            <div class="row"><div class="col-md-8 col-xs-6"><h2><a href="<?php echo base_url(); ?>/booking"><button type="button" class="btn bg-blue waves-effect">Back</button></a></h2></div>
                            <div class="col-md-4" align="right"></div></div>
                        </div>
                        <div class="body">
                             <?php if($_SESSION['succ'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="suc-alert">
                                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['succ']; ?></p> 
                                    </div>
                                </div> 
                             <?php } ?>
                             <?php if($_SESSION['fail'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['fail']; ?></p>
                                    </div>
                                </div>
                             <?php } ?>
                        <div class="container-fluid">
                            <form action="<?php echo base_url();?>/booking/save_repay/<?php echo $hall_datas['id']; ?>">
								<div class="row">
									<div class="col-md-8 col-lg-8 det"> 
										<div class="row">
											<div class="col-sm-12">
												<h3 class="heading">Booking Details</h3>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Event Name:</label>
									<div class="col-4"><span><?php echo $hall_datas['event_name']; ?></span></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Registerer Name:</label>
									<div class="col-4"><span><?php echo $hall_datas['name']; ?></span></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Total Amount:</label>
									<div class="col-4"><span><?php echo $hall_datas['total_amount']; ?></span></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Paid Amount:</label>
									<div class="col-4"><span><?php echo $hall_datas['paid_amount']; ?></span></div>
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Balance Amount:</label>
									<div class="col-4"><span><?php echo $hall_datas['balance_amount']; ?></span></div>
									<input type="hidden" class="form-control" id="balance_amount" value="<?php echo $hall_datas['balance_amount']; ?>">
								</div>
								<div class="form-group row">
									<label class="col-2 col-form-label" for="animals">Enter the Amount:</label>
									<div class="col-4"><input type="number" class="form-control" id="pay_amount" value="0.00"></div>
								</div>
								<div class="form-group row">
									<div class="col-7">
										<ul class="payment1">
											<li><input type="radio" name="pay_method" id="cb1" value="cash">
												<label for="cb1"><i class="mdi mdi-square-inc-cash"></i>
													Cash</label>
											</li>
											<li><input type="radio" name="pay_method" id="cb3" value="online">
												<label for="cb3"><i class="mdi mdi-web"></i>Online</label>
											</li>
										</ul>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-3 col-md-3 col-xs-3">
										<div class="form-group">
											<div class="form-line" style="border: none; text-align: right;">
												<label class="btn btn-success" id="submit">Save</label>
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
    </div>
	<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 360px;">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
<link rel="stylesheet" href="https://selvavinayagar.grasp.com.my/assets/archanai/vendors/mdi/css/materialdesignicons.min.css" />
<style>
	ul.payment {
		list-style-type: none;
		width: 100%;
		display: flex;
		justify-content: flex-start;
		margin-bottom: 0;
		padding-left: 0;
		-webkit-column-count: 3;
		column-count: 3;
		flex-wrap: wrap;
		height: 300px;
		overflow: auto;
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
		margin: 10px 10px;
		font-family: inherit;
		min-height: 120px;
		background: #fff;
		cursor: pointer;
		color: #6d5804;
		font-weight: bold;
	}

	.payment li label p {
		font-size: 18px;
		margin-bottom: 0;
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
		font-size: 18px;
		color: #0d2f95;
	}

	:checked+label {
		background: #f6ef08 !important;
		transition-duration: 0.4s;
	}

	:checked+label:before {
		content: "✓";
		background-color: green;
		transform: scale(1);
	}

	:checked+i.mdi {
		transform: scale(0.9);
	}

	ul.payment1 {
		list-style-type: none;
		width: 100%;
		display: flex;
		justify-content: space-between;
		margin-bottom: 0;
		padding-left: 0;
	}

	.payment1 li {
		display: inline-block;
		text-align: center;
		width: 50%;
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
		font-weight: bold;
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
		font-size: 18px;
		color: #0d2f95;
	}

	.payment1 li :checked+label {
		background: #f6ef08;
	}

	.payment1 li :checked+label:before {
		content: "✓";
		background-color: green;
		transform: scale(1);
	}

	.payment1 li label :checked+i.mdi {
		transform: scale(0.9);
	}

	.prod_img {
		width: 90px;
		min-width: 90px;
		margin: 0 auto;
		border-radius: 50%;
		min-height: 90px;
		max-height: 90px;
		background: #e1e1d68a;
		padding: 5px;
	}

	.text-muted.arch {
		color: #000000 !important;
		font-size: 14px;
		text-align: center;
		padding: 10px;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
		text-overflow: ellipsis;
		max-height: 50px;
		min-height: 50px;
		text-transform: uppercase;
	}

	.ar_btn {
		background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
		border-radius: 15px;
		font-weight: bold;
		height: 1.75em;
	}

	.btn {
		padding: 0.25rem 0.5rem;
		height: 2rem;
	}

	.show-cart1 {
		max-height: 350px;
		overflow: auto;
	}

	.show-cart1 tr {
		border-radius: 10px;
	}

	.show-cart1 td {
		font-size: 13px;
		padding: 3px 10px;
	}

	.total {
		margin-top: 15px;
		padding-bottom: 10px;
	}

	.total p {
		font-size: 24px;
		font-weight: bold;
	}

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
		.prod_img {
			width: 50px;
			min-width: 50px;
			margin: 0 auto;
			border-radius: 50%;
			min-height: 50px;
			max-height: 50px;
		}

		.payment li {
			width: 25%;
		}

		.payment1 li label {
			padding: 15px 1px;
			margin: 15px 5px;
		}
	}
</style>
<script>
$(document).ready(function(){
	$("#submit").click(function(e){
		e.preventDefault();
		var elm = $(this);
        var pay_amount       = parseFloat($("#pay_amount").val());
        var balance_amount       = parseFloat($("#balance_amount").val());
        var pay_method       = $("input[name=pay_method]:checked").val();
        if (pay_amount > 0 && pay_amount <= balance_amount){
			elm.prop('disabled', true);
			elm.text('Processing...');
			$.ajax({
				type:"POST",
				url: "<?php echo base_url();?>/booking/save_repay/<?php echo $hall_datas['id']; ?>",
				data: {pay_amount: pay_amount, pay_method: pay_method},
				success:function(data){
					elm.prop('disabled', false);
					elm.text('Save');
					console.log(data);
					obj = jQuery.parseJSON(data);
					$('#alert-modal').find('button').removeClass('btn-danger').addClass('btn-success');
					$('#alert-modal').modal('show', {backdrop: 'static'});
					setTimeout(function(){
						window.location.href = '<?php echo base_url();?>/booking/';
					}, 1500);
					$("#spndeddelid").text(obj.succ);
				},
				error:function(err){
					elm.prop('disabled', false);
					elm.text('Save');
					$('#alert-modal').modal('show', {backdrop: 'static'});
					$("#spndeddelid").text("Please try again later.");
					console.log('err');
					console.log(err);
				}
			});
        }else{
			$('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text("Pay amount must less than or equal the balance amount.");
        }
    });
});
</script>