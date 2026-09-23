<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
<link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<style>
	body {
		height: 100vh;
		width: 100%;
	}

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

	a {
		text-decoration: none !important;
	}

	.table tr th {
		border: 1px solid #f7e086;
		font-size: 14px;
		background: #f7ebbb;
		color: #333232;
	}

	.pack,
	.pay {
		margin-bottom: 15px;
	}

	.form-label {
		text-transform: uppercase;
		font-size: 13px;
		letter-spacing: 1px;
		color: #333333;
		text-align: left;
		width: 100%;
	}

	.input {
		width: 100%;
		text-align: left;
	}

	select.input {
		color: #000;
	}

	.sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title {
		display: block !important;
		font-size: 11px;
		color: #FFFFFF;
	}

	.sidebar .nav .nav-item.active>.nav-link i.menu-icon {
		background: #edc10f;
		padding: 1px;
		list-style: outside;
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
		min-height: 120px;
	}

	.back h5 {
		min-height: 80px;
		font-size: 15px;
		font-weight: bold;
		color: #FFFFFF;
	}

	.greensubmit {
		background: #ab8a04 !important;
		font-weight: bold !important;
		color: #ffffff !important;
		box-shadow: -1px 10px 20px #ab8a04;
		background: #ab8a04 !important;
		background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
		background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
		background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
	}

	.ar_btn {
		background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
		border-radius: 15px;
		font-weight: bold;
		height: 2.75em;
		margin: 10px;
	}

	.modal {
		display: none;
		position: fixed;
		z-index: 1;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;

		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
	}

	.modal-content {
		background-color: #fefefe;
		margin: 155px auto 20px auto;
		padding: 20px;
		border: 1px solid #888;
		width: 80%;
		max-height: 60vh;
		overflow-y: auto;
	}

	.modal-backdrop {
		position: fixed;
		top: 0;
		left: 0;
		z-index: -1;
		width: 100vw;
		height: 100vh;
		background-color: #000;
	}

	.body-no-scroll {
		overflow: hidden;
		height: 100%;
	}


	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}
	.capitalize{
		text-transform: capitalize;
		text-align: center;
	}
    .card .header1 {
    color: #555;
    padding: 10px 20px;
    position: relative;
    border-bottom: 1px solid rgba(204, 204, 204, 0.35);
}

.card .body {
    font-size: 14px;
    color: #222222;
    padding: 20px;
}
</style>

<body class="sidebar-icon-only">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
                             
          <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<!-- Popup Modal -->
					

					
						<div class="col-md-12">
							<h3 style="text-align: center" >Donation Report</h3>
						</div><br>

						<div class="header1">
                            <form action="<?php echo base_url(); ?>/report_online/print_cashreport" method="POST">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                    <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo $from_date; ?>"  >
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo $to_date; ?>"  >
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
										<div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="payfor" id="payfor">
                                                        <option value="0">Select Paid For</option>
                                                        <?php
                                                        foreach($dons_set as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
													<label class="form-label"></label>
												</div>
											</div>                                            
                                        </div>
                                        <div class="col-md-5 col-sm-4">
                                            <!-- <button type="submit" class="btn btn-success">Filter</button> -->
											<label type="submit" class="btn btn-success btn-lg waves-effect" id="submit">FILTER</label>
                                        </div>

                                        <!-- <div class="col-md-1 col-sm-2" align="right">                                
                                            
											
                                        </div> -->
                                        <!-- <div class="col-md-1 col-sm-2" align="right"> 
                                            <input name="pdf_prasadamreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_prasadamreport" value="PDF">
                                        </div>
                                        <div class="col-md-1 col-sm-2" align="right"> 
                                            <input name="excel_prasadamreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_prasadamreport" value="EXCEL">
                                        </div> -->
										<div class="col-md-12 col-sm-12" style="margin:0px;">                                    
											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">PRINT</button>
											<input name="pdf_cashdonationreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_cashdonationreport" value="PDF">
											<input name="excel_cashdonationreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_cashdonationreport" value="EXCEL">
										</div>

                                    </div>
                                </div>
                            </div>
                        </form>
                        
						<div class="body">		
						   <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table style="width:100%;" align="center" class="table table-striped dataTable" id="datatables">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">S.No</th>
                                            <th style="width:15%;">Date</th>
                                            <!-- <th style="width:20%;">Invoice No</th> -->
                                            <th style="width:15%;">Category</th>
                                            <th style="width:15%;">Name</th>
                                            <th style="width:10%;">Amount(RM)</th>
											<th style="width:10%;">Payment Mode</th>
											<th style="width:20%;">Action</th>

										</tr>
                                    </thead>
                                    <tbody>
                                        <!-- <?php $i = 1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['ref_no']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['type_name']; ?></td>
											<td><?php echo $row['amount']; ?></td>
											<td style="width: 12%;">
                                                <a class="btn btn-primary btn-rad" href="<?= base_url()?>/donation_online/print_booking/<?php echo $row['id'];?>" target="_blank"><i class="fa fa-print"></i></a>          
                                            </td>
                                        </tr>
                                        <?php } ?> -->
                                    </tbody>
                                </table>
                            </div>            
                        </div>
                            
                </div>   
            </div>

			<div class="modal" id="alert-modal_payment" tabindex="-1" role="dialog" aria-labelledby="repaymentModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" style="text-align: center;" id="repaymentModalLabel">Change Payment Mode</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<table>
							<tr>
								<!-- <td><b>Payment Method: <span id="paymentMethod"></span></b></td> -->
								<!-- <td><b>Invoice No: <span id="refNo"></span></b></td> -->
							</tr>
						</table>
						<div class="modal-body">
							<form id="repaymentForm">
								<input type="hidden" id="paymentMethod" class="form-control" readonly>
								<input type="hidden" id="amount" class="form-control" readonly>
								<div class="form-group">
									<label for="repaymentDate">Date</label>
									<input type="date" class="form-control" id="repaymentDate" name="date" value="<?php echo date('Y-m-d'); ?>" readonly required>
								</div>
								<div class="form-group form-float">
									<label for="oldPaymentMethod">Old Payment Method</label>
									<input type="text" id="oldPaymentMethod" class="form-control" readonly> <!-- Non-editable payment method field -->
								</div>
								<div class="form-group">
									<label for="paymentMode">New Payment Mode</label>
									<select class="form-control" id="paymentMode" name="payment_mode" required>
										<?php foreach($payment_modes as $payment_mode) { ?>
											<option value="<?php echo $payment_mode['id']; ?>"><?php echo $payment_mode['name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<input type="hidden" id="bookingId" name="booking_id">
								<a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">Cancel</a>
								<button type="button" class="btn btn-primary" id="saveRepayment">Save</button>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content" style="width: 100%;">
						<div class="modal-body">
							<div class="text-center">
								<i class="dripicons-information h1 text-info"></i>
								<table>
									<tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
								</table>
							</div>
						</div>
					</div><!-- /.modal-content -->
				</div>
			</div>
            
        </div>
        </div>
        
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  
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
  <!-- Custom js for this page-->
  <script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>
  
  
  
<!--script src='https://code.jquery.com/jquery-2.2.4.min.js'></script-->
<script  src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>
  
<link href="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">  
  
<!-- Jquery DataTable Plugin Js -->
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="https://panel.srimuneeswaran.org/dev/assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<!-- Custom Js -->
<script src="https://panel.srimuneeswaran.org/dev/assets/js/pages/tables/jquery-datatable.js"></script>
<script>
	
function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'Del('+id+')');
        $("#spndelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " prasadam?" );    
    }    
    function Del(id)
    {
        var act = "<?php echo base_url(); ?>/prasadam/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"'>submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }

    $('.btn-cancel').click(function(e) {
        e.preventDefault(); // Prevent default action

        var bookingId = $(this).attr('href').split('/').pop();

        if (confirm('Are you sure you want to cancel this booking?')) {
            // If "Yes" is clicked, send an AJAX request to update the booking status
            $.ajax({
                url: "<?php echo base_url(); ?>/templeubayam/update_booking_status", 
                type: 'POST',
                data: {
                    id: bookingId,
                    status: 3
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res.success) {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                       $("#spndeddelid").css("color", "green").text('Successfully cancelled. Thank you.');
                    } else {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                       $("#spndeddelid").css("color", "red").text('Error while updating booking status.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });
</script>
<script>
    
$(document).ready
(
    function()
    {        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
			paging: false,
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report_online/cash_don_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.payfor = $('#payfor').val();
                    data.fltername = $('#fltername').val();
                    }
            },
        });

        $('#submit').click(function() {
			report.ajax.reload();
			
			if($("#payfor").val() != "0")
			{
				$("#cash_donation_setting").css("display", "block");
				var setting_id = $("#payfor").val();
				$.ajax({
					type:"POST",
					url: "<?php echo base_url(); ?>/donation/get_donation_amount",
					data: {setting_id, setting_id},
					dataType: 'json',
					success:function(data){
						console.log(data.data);
						if(typeof data.data != 'undefined'){
							$('#targetamt').val(data.data.total_amount);
							$('#collectedamt').val(data.data.collected_amount);
							var balance_amount = parseFloat(data.data.total_amount) - parseFloat(data.data.collected_amount);
							if(balance_amount >= 0){
								$('.bal_amnt_div').show();
								$('#balanceamt').val(balance_amount);
							}
							else 
							{	
								$('#balanceamt').val(0);
								$('.bal_amnt_div').show();
							}
						}else{
							$('#targetamt').val(0);
							$('#collectedamt').val(0);
							$('#balanceamt').val(0);
							$('.bal_amnt_div').hide();
						}
					},
					error:function(err){
						console.log('err');
						console.log(err);
						$('#targetamt').val(0);
						$('#collectedamt').val(0);
						$('#balanceamt').val(0);
						$('.bal_amnt_div').hide();
					}
				});
			}
			else
			{
				$("#cash_donation_setting").css("display", "none");
			}
			
        });
    });

	$(document).on("click", ".btn-payment", function(e) {
			e.preventDefault();  // Prevent default anchor click behavior
			var bookingId = $(this).attr('href').split('/').pop();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>/report_online/get_donation_payment_mode",
				data: {
					id: bookingId
				},
				success: function(response) {
					console.log('return:', response);
					var obj = JSON.parse(response);
					var totalAmount = obj.amt;
					var paymentMethod = obj.pay_method;
					var paymentMode = obj.payment_mode;
					var refNo = obj.ref_no;

					$("#bookingId").val(bookingId);
					$("#amount").val(totalAmount);
					$("#paymentMethod").val(paymentMode);
					$("#oldPaymentMethod").val(paymentMethod); 
					$("#refNo").text(refNo);
					$("#alert-modal_payment").modal('show');
				},
				error: function() {
					$("#spndeddelid").css("color", "red").text('Error while fetching payment data.');
				}
			});
		});


    // function formatAmount(amount){
    //     amount = parseFloat(amount);
    //     return isNaN(amount) ? '0.00' : amount.toFixed(2);
    // }

	$(document).on("click", "#saveRepayment", function() {
    //$("#saveRepayment").click(function(){
	console.log("save button clicked");
        var date = $("#repaymentDate").val();
        var oldPaymentMode = parseFloat($("#paymentMethod").val());
		var oldPaymentMethod = $("#oldPaymentMethod").val();
        var paymentMode = $("#paymentMode").val();
        var bookingId = $("#bookingId").val();
		var amount = $("#amount").val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/report_online/save_donation_payment_mode", 
            data: {
                date: date,
                old_paymode: oldPaymentMode,
				old_paymethod: oldPaymentMethod,
                payment_mode: paymentMode,
                booking_id: bookingId,
				amount: amount
            },
            success: function(response){
                var obj = JSON.parse(response);
				console.log(response);
                if(obj.status){
                    $("#payAmount").val("");
                    $("#alert-modal_payment").modal('hide');
                    $("#spndeddelid").css("color", "green").text(obj.message);
                    $('#alert-modal').modal('show', { backdrop: 'static' });
					setTimeout(function() {
						$('#alert-modal').modal('hide');  // Optionally hide the modal before reloading
						window.location.reload();  // Reload the current page
					}, 2000);
                    
                } else {
                    $("#spndeddelid").css("color", "red").text(obj.message);
                }
            },
            error: function(){
                $("#spndeddelid").css("color", "red").text('Error while saving repayment.');
            }
        });
    });
    
    
</script>
</body>
