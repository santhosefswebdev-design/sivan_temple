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

#totalsDisplay {
        display: flex;          /* Using flexbox to align children in a row */
        justify-content: space-around; /* Spacing out the children evenly */
        margin-top: 20px;      /* Adding some space above the totals display */
        font-size: 1.2em;      /* Making the font larger */
        font-weight: bold;     /* Making the font bolder */
    }
.total-item {
	padding: 10px;         /* Adding padding around each total item */
	background-color: #f0f0f0; /* Light grey background for each item */
	border-radius: 5px;    /* Rounded corners for the total items */
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
							<h3 style="text-align: center" >Offering Report</h3>
						</div><br>

						<div class="header1">
						    <form action="<?php echo base_url(); ?>/report_online/print_offeringreport" method="post" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  >
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select id="offering_id" name="offering_id" class="form-control">
            										    <option value="">-- Select Offering Category --</option>
            										    <?php foreach($offer as $row) { ?>
            										    <option <?php if($data['off_cat_id']==$row['id']) { echo "selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            										    <?php } ?>
            										</select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select id="product_id" name="product_id" class="form-control">
            										    <option value="">-- Select Product Category --</option>
            										</select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" style="margin-bottom:0px;">
                                            <div class="form-group form-float">                                        
                                                <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit">Filter</label>                                                		
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12" style="margin-bottom:0px;">                                    
											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
											<input name="pdf_stockreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_stockreport" value="PDF">
											<input name="excel_stockreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_stockreport" value="EXCEL">
										</div>
                                        </div>
                                    </div>
                            	</form>
                            
								<div class="body">			
                                    <div class="table-responsive col-md-12 det" align="center" style="background:#FFF; float:none;">
										<div id="totalsDisplay"></div>
                                        <table style="width:100%;" align="center" class="table table-striped dataTable" id="datatables">       
											<thead>
												<tr> 
													<th style="width:10%;">S.No</th>
													<th style="width:15%;">Name</th>
													<th style="width:15%;">Phone</th>
													<th style="width:15%;">Category</th>
													<th style="width:15%;">Product</th> 
													<th style="width:15%;">Grams</th>
													<th style="width:15%;">ACtion</th>
												</tr>
											</thead>
                                    			<tbody id="userTable" >                                    
                                    			</tbody>
                                		</table>
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
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

<!-- Load jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Load DataTables -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script>
$("#offering_id").change(function(){
var id = $("#offering_id").val();
if(id != "")
	{
        $.ajax({
			url: '<?php echo base_url();?>/offering_online/get_category',
			type: 'post',
			data: {id:id},
			dataType: 'json',
			success:function(data)
			{
				console.log(data.data);
                $('#product_id').empty();
                $('#product_id').append('<option value="">Select Product Category</option>');
                data.data.forEach(function(item) {
                    $('#product_id').append(
                        $('<option></option>').val(item.id).text(item.name)
                    );
                });
                $('#product_id').selectpicker('refresh');
				//$('#product_id').append('<option value="' + data.data.pid + '">' + data.data.pname + '</option>');
		    }
		});
	}
});
// $(document).ready(function() {        
//     report = $('#datatables').DataTable({
//         dom: 'Bfrtip',
//         buttons: [],
//         "ajax":{
//             url: "<?php echo base_url(); ?>/report_online/offering_rep_ref",
//             dataType: "json",
//             type: "POST",
//             data: function ( data ) {
//                 data.fdt = $('#fdt').val();
//                 data.tdt = $('#tdt').val();
//                 data.type = $('#offering_id').val();
//                 data.ptype = $('#product_id').val();
//             }
//         },
//     });

//     $('#submit').click(function() {
//     report.ajax.reload();
//     });
// });

// $(document).ready(function() {
//     report = $('#datatables').DataTable({
//         dom: 'Bfrtip',
//         buttons: [],
//         "ajax": {
//             url: "<?php echo base_url(); ?>/report_online/offering_rep_ref",
//             dataType: "json",
//             type: "POST",
//             data: function (data) {
//                 data.fdt = $('#fdt').val();
//                 data.tdt = $('#tdt').val();
//                 data.type = $('#offering_id').val();
//                 data.ptype = $('#product_id').val();
//             },
//             dataSrc: function (json) {
//                 console.log("Data received:", json);
//                 return json.data;
//             },
//             error: function (xhr, error, thrown) {
//                 console.error("Error occurred:", xhr, error, thrown);
//             }
//         },
//     });

//     $('#submit').click(function() {
//         report.ajax.reload();
//     });
// });

$(document).ready(function() {        
    var report = $('#datatables').DataTable({
        dom: 'Bfrtip',
        buttons: [],
        "ajax": {
            url: "<?php echo base_url(); ?>/report_online/offering_rep_ref",
            dataType: "json",
            type: "POST",
            data: function (data) {
                data.fdt = $('#fdt').val();
                data.tdt = $('#tdt').val();
                data.type = $('#offering_id').val();
                data.ptype = $('#product_id').val();
            },
            dataSrc: function (json) {
                // Assuming you have a place to display totals
                updateCategoryTotals(json.totals);
                return json.data;
            }
        }
    });

    $('#submit').click(function() {
        report.ajax.reload();
    });
});

function updateCategoryTotals(totals) {
    $('#totalsDisplay').empty();

    $.each(totals, function(category, grams) {
        $('#totalsDisplay').append('<div class="total-item">' + category + ': ' + grams + ' grams</div>');
    });
}
</script>

</body>
