<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
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
#error_msg, .form_error { color:red; }
.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    text-transform: uppercase;
    color: #fa6742;
    font-weight: bold;
}
.nav-tabs .nav-link {
    color: #000000;
    text-transform: uppercase;
    font-weight: bold;
}
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
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link  active" href="#archanai" role="tab" data-toggle="tab" aria-selected="true">Archanai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#hall" role="tab" data-toggle="tab">Hall</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#ubayam" role="tab" data-toggle="tab">Ubayam</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#prasadam " role="tab" data-toggle="tab">Prasadam</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#cash_donation " role="tab" data-toggle="tab">Cash Donation</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <!--ARCHANAI START SECTION-->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="archanai">
                                <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="fdt_archanai" id="fdt_archanai" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="tdt_archanai" id="tdt_archanai" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>

									<div class="col-md-2 col-sm-3">
										<div class="form-group">                                        
										<label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_archanai">Submit</label></div>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="datatables_archanai">
                                                
                                            <thead>
                                                    <tr>
                                                        <th style="width:5%;">S.No</th>
                                                        <th style="width:10%;">Date</th>
                                                        <th style="width:36%;">Product Name in English</th>
                                                        <th style="width:35%;">Product Name in Tamil</th>
                                                        <th style="width:7%;">Quantity</th>
                                                        <th style="width:7%;">Amount</th>
                                                        <th style="width:7%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >                                    

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--ARCHANAI END SECTION-->
                            <!--HALLBOOKING START SECTION-->
                            <div role="tabpanel" class="tab-pane fade" id="hall">
                                <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="fdt_hall" id="fdt_hall" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="tdt_hall" id="tdt_hall" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>

									<div class="col-md-2 col-sm-3">
										<div class="form-group">                                        
										<label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_hall">Submit</label></div>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="datatables_hall">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%;">SNo</th>
                                                        <th style="width:11%;">Booking Date</th>
                                                        <th style="width:10%;">Entry Date</th>
                                                        <th style="width:10%;">Name</th>
                                                        <th style="width:28%;">Event Details</th>
                                                        <th style="width:9%;">Status</th>
                                                        <th style="width:12%;">Total Amount</th>
                                                        <th style="width:12%;">Paid Amount</th>
                                                        <th style="width:13%;">Balance Amount</th>
                                                        <th style="width:7%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >                                    

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--HALLBOOKING END SECTION-->
                            <!--UBAYAM START SECTION-->
                            <div role="tabpanel" class="tab-pane fade" id="ubayam">
                            <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="fdt_ubayam" id="fdt_ubayam" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="tdt_ubayam" id="tdt_ubayam" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>

									<div class="col-md-2 col-sm-3">
										<div class="form-group">                                        
										<label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_ubayam">Submit</label></div>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="datatables_ubayam">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%;">SNo</th>
                                                        <th style="width:8%;">Date</th>
                                                        <th style="width:27%;">Pay For</th>
                                                        <th style="width:24%;">Name</th>
                                                        <th style="width:9%;">Amount</th>
                                                        <th style="width:9%;">Paid</th>
                                                        <th style="width:9%;">Balance</th>
                                                        <th style="width:9%;">Status</th>
                                                        <th style="width:7%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >                                    

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--UBAYAM END SECTION-->
                            <!--PRASADAM START SECTION-->
                            <div role="tabpanel" class="tab-pane fade" id="prasadam">
                            <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="fdt_prasadam" id="fdt_prasadam" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="tdt_prasadam" id="tdt_prasadam" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>

									<div class="col-md-2 col-sm-3">
										<div class="form-group">                                        
										<label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_prasadam">Submit</label></div>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="datatables_prasadam">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%;">SNo</th>
                                                        <th style="width:8%;">Date</th>
                                                        <th style="width:9%;">Customer Name</th>
                                                        <th style="width:12%;">Collection Date</th>
                                                        <th style="width:15%;text-align:left;">Pay For</th>
                                                        <th style="width:10%;">Amount</th>
                                                        <th style="width:7%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >                                    

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--PRASADAM END SECTION-->
                            <!--CASH DONATION START SECTION-->
                            <div role="tabpanel" class="tab-pane fade" id="cash_donation">
                            <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="fdt_cash_donation" id="fdt_cash_donation" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" name="tdt_cash_donation" id="tdt_cash_donation" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                            </div>                                                        
                                        </div>                                            
                                    </div>

									<div class="col-md-2 col-sm-3">
										<div class="form-group">                                        
										<label type="submit" class="btn btn-success btn-lg waves-effect" id="submit_cash_donation">Submit</label></div>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="datatables_cash_donation">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%;">SNo</th>
                                                        <th style="width:8%;">Date</th>
                                                        <th style="width:10%;">Paid For</th>
                                                        <th style="width:15%;">Name</th>
                                                        <th style="width:10%;">Amount</th>
                                                        <th style="width:7%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >                                    

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--PRASADAM END SECTION-->







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
  <!-- container-scroller -->

<!-- REPRINT SECTION END -->   
<!-- base:js -->
<script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/datatable/jquery.dataTables.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/datatable/responsive.bootstrap4.min.css">
<script src="<?php echo base_url(); ?>/assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/datatable/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/datatable/responsive.bootstrap4.min.js"></script>

<script>
    $(document).ready(function(){
        report_one = $('#datatables_archanai').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/customer_mybooking/get_archanai_booking",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt_archanai').val();
                    data.tdt = $('#tdt_archanai').val();
                }
            },
        });
        $('#submit_archanai').click(function() {
            report_one.ajax.reload();
        });
    });

    $(document).ready(function(){
        report_two = $('#datatables_hall').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/customer_mybooking/get_hall_booking",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt_hall').val();
                    data.tdt = $('#tdt_hall').val();
                }
            },
        });
        $('#submit_hall').click(function() {
            report_two.ajax.reload();
        });
    });
    
    $(document).ready(function(){
        report_three = $('#datatables_ubayam').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/customer_mybooking/get_ubayam_booking",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt_ubayam').val();
                    data.tdt = $('#tdt_ubayam').val();
                }
            },
        });
        $('#submit_ubayam').click(function() {
            report_three.ajax.reload();
        });
    });

    $(document).ready(function(){
        report_four = $('#datatables_prasadam').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/customer_mybooking/get_prasadam_booking",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt_prasadam').val();
                    data.tdt = $('#tdt_prasadam').val();
                }
            },
        });
        $('#submit_prasadam').click(function() {
            report_four.ajax.reload();
        });
    });

    $(document).ready(function(){
        report_five = $('#datatables_cash_donation').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/customer_mybooking/get_cash_donation_booking",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt_cash_donation').val();
                    data.tdt = $('#tdt_cash_donation').val();
                }
            },
        });
        $('#submit_cash_donation').click(function() {
            report_five.ajax.reload();
        });
    });
</script>
</body>
</html>

