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
	.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
}

.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    table-layout: fixed; /* Ensures the table adjusts based on content */
}

.table th, .table td {
    vertical-align: top; /* Aligns content to the top */
    white-space: normal; /* Ensures text wraps */
    word-wrap: break-word; /* Breaks long words */
    padding: 8px; /* Adds padding for better spacing */
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05); /* Ensures striping still works */
}
.modal-backdrop.show {
    opacity: 0;
    z-index: -1;
}
@media (min-width: 576px) {
    .modal-dialog {
        max-width: 80%;
        margin: 1.75rem auto;
    }
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
                            <h3 style="text-align: center" >Hall Booking Report</h3>
                        </div><br>

                        <div class="header1">
                            <form action="<?php echo base_url(); ?>/report_online/print_hallreport_temple" method="POST">
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
                                                <div class="form-line" id="bs_datepicker_container">
                                                    <label class="form-label" for="cdt" style="margin-top: -28px;">Event Date</label>
                                                    <input style="margin-top: -28px;" type="date" name="cdt" id="cdt" class="form-control" value="<?php echo $cdt; ?>" >
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <input type="hidden" name="booking_type" id="booking_type" class="form-control" value="1" >
                                        <input type="hidden" name="report_type" id="report_type" class="form-control" value="1" >
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" name="group_filter" id="group_filter">
                                                        <option value="0">Select Type</option>
                                                        <option <?php if($group_filter == 'full') { echo "selected"; } ?> value="full">Fully Paid</option>
                                                        <option <?php if($group_filter == 'partial') { echo "selected"; } ?> value="partial">Partially paid</option>                
                                                    </select>
                                                    <label class="form-label"></label>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="col-md-1 col-sm-2">
                                            <!-- <button type="submit" class="btn btn-success">Filter</button> -->
                                            <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit">Filter</label>
                                        </div>

                                        <div class="col-md-3 col-sm-4" align="right">
                                            <label class="btn btn-primary" style="cursor: pointer;" onclick="fetchCompletedBookings()">Manage booking</label>
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-sm-12" style="margin:0px;">                                    
                                        <button type="submit" class="btn btn-primary btn-lg waves-effect" target="_blank" id="submit">PRINT</button>
                                        <input name="pdf_ubayamreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_ubayamreport" value="PDF">
                                        <input name="excel_ubayamreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_ubayamreport" value="EXCEL">
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                        
                        <div class="body">      
                           <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table style="width:100%;" align="center" class="table table-striped dataTable" id="datatables">
                                    <thead>
                                        <tr>
                                            <th style="width:4%;">S.No</th>
                                            <th style="width:10%;">Booking Date</th>
                                            <th style="width:10%;">Event date</th>
                                            <th style="width:10%;">Event Name</th>
                                            <th style="width:10%;">Name</th>
                                            <th style="width:8%;">Amount (RM)</th>
                                            <th style="width:8%;">Paid Amount (RM)</th>
                                            <th style="width:10%;">Status</th>
                                            <th style="width:14%;">Action</th>
                                            <th style="width:6%;">Admin Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- <?php $i = 1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['entry_date'])); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['booking_date'])); ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['payment_type']; ?></td>
                                            <td><?php echo $row['package_name']; ?></td>
                                            <td><?php echo $row['amount']; ?></td>
                                            <td><?php echo $row['paid_amount']; ?></td>
                                            <?php if($row['booking_status'] == 3) { ?>
                                            <td style="width: 12%;">
                                                
                                                <a class="btn btn-primary btn-rad" href="<?= base_url()?>/templeubayam_online/print_page_hall/<?php echo $row['id'];?>" target="_blank"><i class="fa fa-print"></i> </a>
                                                <?php if ($row['amount'] - $row['paid_amount'] && $row['payment_type'] == "partial" || $row['payment_type'] == "only_booking") { ?>
                                                     <a class="btn btn-warning btn-payment btn-rad" title="Pay" href="<?= base_url()?>/annathanam_new/payment/<?php echo $row['id'];?>" target="_blank"><i class="fa fa-credit-card"></i> </a> 
                                                <?php } ?>       
                                            </td>
                                            <?php } else { ?>
                                                <td><span style="color:red;" class="cancel_text">Cancelled</span></td>
                                            <?php } ?> 
                                        </tr>
                                    <?php } ?> -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="modal fade" id="alert-modal_payment" tabindex="-1" role="dialog" aria-labelledby="repaymentModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="text-align: center;" id="repaymentModalLabel">Temple Booking Repayment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <table>
                                            <tr>
                                                <td><b>Total Amount (RM): <span id="totalAmount"></span></b></td>
                                                <td><b>(Deposit Amount (RM): <span id="depositAmount"></span>)</b></td>
                                                <td><b>Paid Amount (RM): <span id="paidAmount"></span></b></td>
                                                <td><b>Balance Amount (RM): <span id="balAmount"></span></b></td>
                                            </tr>
                                        </table>
                                        <div class="modal-body">
                                            <form id="repaymentForm">
                                                <div class="form-group">
                                                    <label for="repaymentDate">Date</label>
                                                    <input type="date" class="form-control" id="repaymentDate" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                                <div class="form-group form-float">
                                                    <label for="payAmount">Amount</label>
                                                    <input type="number" id="payAmount" min="0" class="form-control" step=".01" placeholder="0.00" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="paymentMode">Payment Mode</label>
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

                            <div class="modal fade" id="alert-modal_deposit" tabindex="-1" role="dialog" aria-labelledby="repaymentModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="text-align: center;" id="repaymentModalLabel">Deposit Repayment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <table>
                                            <tr>
                                                <td align="center"><b>Deposit Amount (RM: <span id="deposit_repay"></span>)</b></td>
                                            </tr>
                                        </table>
                                        <div class="modal-body">
                                            <form id="repaymentForm">
                                                <div class="form-group">
                                                    <label for="repaymentDate">Date</label>
                                                    <input type="date" class="form-control" id="repaymentDate" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                                <!-- <div class="form-group form-float">
                                                    <label for="payAmount">Amount</label>
                                                    <input type="number" id="payAmount" min="0" class="form-control" step=".01" placeholder="0.00" required>
                                                </div> -->
                                                <div class="form-group">
                                                    <label for="paymentMode">Payment Mode</label>
                                                    <select class="form-control" id="paymentMode" name="payment_mode" required>
                                                        <?php foreach($payment_modes as $payment_mode) { ?>
                                                            <option value="<?php echo $payment_mode['id']; ?>"><?php echo $payment_mode['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" id="bookingId" name="booking_id">
                                                <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">Cancel</a>
                                                <button type="button" class="btn btn-primary" id="saveDeppayment">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content" style="width: 30%;">
                                        <div class="modal-body p-4">
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
                                
                            <!-- Bootstrap Modal for Booking Details -->
                            <div class="modal fade" id="bookingDetailsModal" tabindex="-1" role="dialog" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="bookingDetailsModalLabel">Bookings</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th syle="width: 5% !important">S.No</th>
                                                        <th syle="width: 10%">Booking Date</th>
                                                        <th syle="width: 15%">Event Date</th>
                                                        <th syle="width: 15%">Package Name</th>
                                                        <th syle="width: 15%">Name</th>
                                                        <th syle="width: 15%">Payment Status</th>
                                                        <th syle="width: 20%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bookingDetailsTableBody">
                                                    <!-- Data will be inserted here -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                
                        </div>
                            
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

    $(document).on('click', '.btn-cancel', function(e) {
        e.preventDefault(); // Prevent default action
        var bookingId = $(this).attr('href').split('/').pop();

        if (confirm('Are you sure you want to cancel this booking?')) {
            $.ajax({
                url: "<?php echo base_url(); ?>/hallbooking_online/update_booking_status", 
                type: 'POST',
                data: {
                    id: bookingId,
                    status: 3
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    console.log(response);
                    if(res.success) {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").css("color", "green").text('Successfully cancelled. Thank you.');
                        setTimeout(function() {
                            $('#alert-modal').modal('hide');  // Optionally hide the modal before reloading
                            window.location.reload();  // Reload the current page
                        }, 2000);
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

    $(document).ready(function(){
        $(document).on('click', '.btn-payment', function(e) {
            e.preventDefault();
            var bookingId = $(this).attr('href').split('/').pop();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/hallbooking_online/gtpaymentdata",
                data: { id: bookingId },

                success: function(response){
                    console.log(response);
                    var obj = JSON.parse(response);
                    var totalAmount = formatAmount(obj.amt);
                    var paidAmount = formatAmount(obj.paid_amount);
                    var depositAmount = formatAmount(obj.deposit_amount);
                    var balAmount = formatAmount(obj.amt - obj.paid_amount);

                    $("#bookingId").val(bookingId);
                    $("#totalAmount").text(totalAmount);
                    $("#paidAmount").text(paidAmount);
                    $("#depositAmount").text(depositAmount);
                    $("#balAmount").text(balAmount);
                    $("#alert-modal_payment").modal('show');
                },
                error: function(){
                    $("#spndeddelid").css("color", "red").text('Error while fetching repayment data.');
                }
            });
        });

        function formatAmount(amount){
            amount = parseFloat(amount);
            return isNaN(amount) ? '0.00' : amount.toFixed(2);
        }

        $("#saveRepayment").click(function(){
            var date = $("#repaymentDate").val();
            var payAmount = parseFloat($("#payAmount").val());
            var paymentMode = $("#paymentMode").val();
            var bookingId = $("#bookingId").val();
            var balAmount = parseFloat($("#balAmount").text());

            if (payAmount > balAmount) {
                $("#alert-modal_payment").modal('hide');
                $('#alert-modal').modal('show', { backdrop: 'static' });
                $("#spndeddelid").css("color", "red").text('Pay amount cannot be greater than balance amount.');
                return;
            }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/hallbooking_online/save_repayment", 
                data: {
                    date: date,
                    pay_amount: payAmount,
                    payment_mode: paymentMode,
                    booking_id: bookingId
                },
                success: function(response){
                    var obj = JSON.parse(response);
                    if(obj.status){
                        $("#payAmount").val("");
                        $("#alert-modal_payment").modal('hide');
                        $("#spndeddelid").css("color", "green").text(obj.message);
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").css("color", "green");
                        setTimeout(function() {
                            $('#alert-modal').modal('hide');  // Optionally hide the modal before reloading
							window.open('<?php echo base_url(); ?>/hallbooking_online/print_page_hall/' + bookingId, '_blank');
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
    });


    $(document).ready(function(){  

        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            paging: false,
            "ajax":{
                url: "<?php echo base_url(); ?>/report_online/hall_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.cdt = $('#cdt').val();
                    data.group_filter = $('#group_filter').val();
                    //  data.payfor = $('#payfor').val();
                    //data.booking_type = $('#booking_type').val();
                    //  data.fltername = $('#fltername').val();
                    }
            },
        });

        $('#submit').click(function() {
        report.ajax.reload();

        $("#prt").attr("href", '<?php base_url()?>/report/print/ubayam/'+$('#fdt').val()+'/'+$('#tdt').val());
        });

    });

    function fetchCompletedBookings() {
        $.ajax({
            url: "<?php echo base_url(); ?>/report_online/hall_event_status", // Adjust URL as necessary
            type: "POST",
            data: {
                fdt: $('#fdt').val(),
                tdt: $('#tdt').val()
            },
            dataType: "json",
            success: function (data) {
                console.log('return data', data);
                populateBookingTable(data); // Assuming 'data.data' contains the booking details
                $('#bookingDetailsModal').modal('show');
            },
            error: function (error) {
                console.error("Error fetching bookings:", error);
            }
        });
    }

    function populateBookingTable(bookings) {
        const tableBody = $('#bookingDetailsTableBody');
        tableBody.empty(); // Clear previous entries

        bookings.forEach((booking, index) => {
            let completedButton = '';

            if (booking.isPastBooking && booking.paidFull && !booking.iscompleted) {
                completedButton = `<button class="btn btn-success" onclick="completeBooking(${booking.id})">Complete</button>`;
            } else if (booking.iscompleted) {
                completedButton = `<button class="btn btn-primary disabled">Completed</button>`;
            } else {
                completedButton = `<button class="btn btn-secondary disabled">Complete</button>`;
            }

            const row = `
                <tr>
                    <td syle="width: 5%">${booking['S.No']}</td> 
                    <td syle="width: 10%">${booking['Booking Date']}</td> 
                    <td syle="width: 15%">${booking['Event Date']}</td>
                    <td syle="width: 15%">${booking['Package Name']}</td> 
                    <td syle="width: 15%">${booking['Name']}</td> 
                    <td syle="width: 15%">${booking['Payment Status']}</td> 
                    <td syle="width: 20%">${completedButton}</td> 
                </tr>
            `;
            tableBody.append(row);
        });
    }

    function completeBooking(bookingId) {
        if (confirm('Are you sure this event is completed?')) {
            console.log('booking id', bookingId);
            $.ajax({
                url: "<?php echo base_url(); ?>/hallbooking_online/update_booking_status", 
                type: 'POST',
                data: {
                    id: bookingId,
                    status: 2
                },
                success: function(response) {
                    const res = JSON.parse(response);
                    console.log('return data2', response);
                    if (res.success) {
                        alert('Booking marked as completed.');
                    } else {
                        alert('Failed to mark booking as completed.');
                    }
                },
                error: function() {
                    alert('Error in marking booking completed.');
                }
            });
        }
    }

    $(document).ready(function(){
        $(document).on('click', '.btn-deprepay', function(e) {
            e.preventDefault();
            var bookingId = $(this).attr('href').split('/').pop();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/hallbooking_online/gtdepositdata",
                data: { id: bookingId },

                success: function(response){
                    var obj = JSON.parse(response);
                    var depositAmount = formatAmount(obj.deposit_amount);
                    console.log(depositAmount);

                    $("#bookingId").val(bookingId);
                    $("#deposit_repay").text(depositAmount);
                    $("#alert-modal_deposit").modal('show');
                },
                error: function(){
                    $("#spndeddelid").css("color", "red").text('Error while fetching repayment data.');
                }
            });
        });

        function formatAmount(amount){
            amount = parseFloat(amount);
            return isNaN(amount) ? '0.00' : amount.toFixed(2);
        }

        $("#saveDeppayment").click(function(){
            var date = $("#repaymentDate").val();
            var payAmountText = $("#deposit_repay").text();
            var payAmount = parseFloat(payAmountText);
            var paymentMode = $("#paymentMode").val();
            var bookingId = $("#bookingId").val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/hallbooking_online/save_deposit_repayment", 
                data: {
                    date: date,
                    pay_amount: payAmount,
                    payment_mode: paymentMode,
                    booking_id: bookingId
                },
                success: function(response){
                    var obj = JSON.parse(response);
                    if(obj.status){
                        $("#alert-modal_deposit").modal('hide');
                        $("#spndeddelid").css("color", "green").text(obj.message);
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").css("color", "green");
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
    });

</script>

</body>

