<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/mdi/css/materialdesignicons.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
<link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">
<style>
     .custom-checkbox {
    position: relative;
    padding-left: 25px;
    cursor: pointer;
    font-size: 16px;
    user-select: none;
}

.custom-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.custom-checkbox input:checked ~ .checkmark {
    background-color: #2196F3;
}

.custom-checkbox input:checked ~ .checkmark:after {
    display: block;
}

.custom-checkbox .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #eee;
    border: 1px solid #ddd;
}

.custom-checkbox .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    left: 7px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    transform: rotate(45deg);
}
    .itemcountrr .value-button {
display: inline-block;
    border: 1px solid #ddd;
    margin: 0px;
    width: 25px;
    height: 25px;
    text-align: center;
    vertical-align: middle;
    padding: 0px 0px 8px 0px;
    background: #eee;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.itemcountrr .value-button:hover {
  cursor: pointer;
}

.itemcountrr #decrease {
  margin-right: 0px;
  border-radius: 4px 0 0 4px;
  margin-top:-2px;
}

.itemcountrr #increase {
  margin-left: 0px;
  border-radius: 0 4px 4px 0;
  margin-top:-2px;
}

.itemcountrr #input-wrap {
  margin: 0px;
  padding: 0px;
}

.itemcountrr input.number {
    text-align: center;
    border: none;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin: 0px;
    width: 35px;
    height: 25px;
}

.itemcountrr input[type=number]::-webkit-inner-spin-button,
.itemcountrr input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
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
        padding: 13px;
        color: white;
        min-height: 120px;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #F44336 !important;
        outline: 0;
        box-shadow: none;
    }

    select.form-control:focus {
        outline: 1px solid #F44336;
    }

    .error-input {
        border-color: #F44336 !important;
    }

    .back h5 {
        min-height: 80px;
        font-size: 15px;
        font-weight: bold;
        color: #FFFFFF;
    }

    #error_msg,
    .form_error {
        color: red;
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




    #filters {
        margin: 0 0 10px;
        padding: 0;
        list-style: none;
        width: 100%;
        overflow: auto;
        display: inherit;
    }

    #filters li:first-child {
        margin-left: 0;
    }

    #filters li {
        float: left;
        background: white;
        margin: 0 7px;
        /*width:100px;
  max-height:95px;
  min-width:95px;*/
    }

    #filters li span {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: #000;
        cursor: pointer;
        transition: color 300ms ease-in-out;
        text-align: center;
        line-height: 1.5em;
        font-size: 14px;
        text-transform: uppercase;
        font-weight: bold;
    }

    #filters li span:hover {
        color: #d4aa00;
    }

    #filters li span.active {
        /*background: #d4aa00;*/
        background: linear-gradient(179deg, rgb(212 170 0) 0%, rgb(197 191 16) 35%, rgb(252 245 6) 100%);
        color: #000;
    }



    #portfoliolist .portfolio {
        display: none;
        float: left;
        overflow: hidden;
        width: 20%;
        padding: 10px;
    }

    .portfolio-wrapper {
        overflow: hidden;
        position: relative !important;
        cursor: pointer;
    }

    .portfolio img {
        max-width: 100%;
        position: relative;
        top: 0;
    }

    .portfolio .label {
        position: absolute;
        width: 100%;
        height: 40px;
        bottom: -40px;
    }

    .portfolio .label-bg {
        background: #222;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .portfolio .label-text {
        color: #fff;
        position: relative;
        z-index: 500;
        padding: 5px 8px;
    }

    .portfolio .text-category {
        display: block;
        font-size: 9px;
    }
</style>
</head>

<body class="sidebar-icon-only">
	<?php if($_SESSION['succ'] != '') { ?>
	  <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
		  <div class="suc-alert" style="width: 100%;">
			  <span class="suc-closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
			  <p><?php echo $_SESSION['succ']; ?></p> 
		  </div>
	  </div>
  <?php } ?>
	<?php if($_SESSION['fail'] != '') { ?>
	  <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
		  <div class="alert" style="width: 100%;">
			  <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
			  <p><?php echo $_SESSION['fail']; ?></p>
		  </div>
	  </div>
  <?php } ?>
    <div class="container-scroller">


        <div class="container-fluid page-body-wrapper">

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content w-100">
                                <div class="calendar-container">
                                    <div class="calendar">
                                        <div class="year-header">
                                            <span class="left-button fa fa-chevron-left" id="prev">
                                                << </span>
                                                    <span class="year" id="label"></span>
                                                    <span class="right-button fa fa-chevron-right" id="next"> >> </span>
                                        </div>
                                        <table class="months-table w-100">
                                            <tbody>
                                                <tr class="months-row">
                                                    <td class="month">Jan</td>
                                                    <td class="month">Feb</td>
                                                    <td class="month">Mar</td>
                                                    <td class="month">Apr</td>
                                                    <td class="month">May</td>
                                                    <td class="month">Jun</td>
                                                    <td class="month">Jul</td>
                                                    <td class="month">Aug</td>
                                                    <td class="month">Sep</td>
                                                    <td class="month">Oct</td>
                                                    <td class="month">Nov</td>
                                                    <td class="month">Dec</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="days-table w-100">
                                            <td class="day">Sun</td>
                                            <td class="day">Mon</td>
                                            <td class="day">Tue</td>
                                            <td class="day">Wed</td>
                                            <td class="day">Thu</td>
                                            <td class="day">Fri</td>
                                            <td class="day">Sat</td>
                                        </table>
                                        <div class="frame">
                                            <table class="dates-table w-100">
                                                <tbody class="tbody">
                                                </tbody>
                                            </table>
                                        </div>
                                        <button class="button" disabled id="add-button">Add Event</button>
                                    </div>
                                </div>
                                <div class="events-container"></div>
                                <div class="dialog prod" id="dialog"> 
                                    <!--h4 class="dialog-header" style=" background:#d4aa00;color:#FFFFFF;"> Add New Event </h4-->
                                    <form class="form" id="form" method="post">
                                <input type="hidden" id="ubhayam_date" name="ubhayam_date" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                <input type="hidden" id="booking_date" name="booking_date" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                <input type="hidden" id="booking_type" name="booking_type" value="1">
                                <input type="hidden" id="save_booking" name="save_booking" value="1">
                                <input type="hidden" id="payment_type" name="payment_type" value="full">
                                <input type="hidden" id="booking_through" name="booking_through" value="COUNTER">
                                <?php $user_id = $_SESSION['log_id_frend']; ?>
                                <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

								<input class="input1" type="hidden" id="dt" name="dt" value="<?php echo date('Y-m-d'); ?>">
                                <div class="form-container card-body" align="center">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-8">
                                            <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">Choose Slot</h4>
                                            <table class="table table-bordered " id="booking_slot">
                                                <tbody>
                                                    <tr>
                                                        <?php // echo print_r($time_list);
                                                         $i=0; foreach($time_list as $row) { 
                                                            // if (in_array($row['id'], $data_time)) { $disabled = ""; $t_name = $time_name[$row['id']];}
                                                            // else  { $disabled = ""; $t_name = ''; };
                                                        
                                                        ?>
                                                        <td>
                                                            <input style="left: 2%; opacity: 1;position: inherit;" type="radio" class="booking_slot" name="booking_slot[]" value="<?php echo $row['id']; ?>">
                                                            <?php echo $row['slot_name'];?>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                                <h4
                                                    style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">
                                                    Choose Any Ubayam for Pay</h4>
                                                <!-- <ul class="payment prod" id="pay_for"></ul> -->

                                                <div class="row prod product" id="add_one">
                                                <?php // print_r($package); 
                                                foreach($package as $row) { ?>
                                                            
                                                                <div class="portfolio" data-cat="">
                                                                    <input type="radio" class="ubayam_slot" name="pay_for" value="<?php echo $row['id']; ?>"
                                                                        id="pay_for<?php echo $row['id']; ?>" />
                                                                    <label class="card" for="pay_for<?php echo $row['id']; ?>" onclick="payfor(<?php echo $row['id']; ?>)">
                                                                        <img class="img-fluid prod_img" src="<?php  echo base_url(); ?>/uploads/package/<?php  echo $row['image']; ?>">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                                                                            <p class="mb-0 text-muted arch" id="pay_name<?php echo $row['id']; ?>"><?php echo $row['name']; ?></p>
                                                                        </div>
                                                                        </labe>
                                                                </div>
                                                                <?php
                                                            }
                                                        
                                                    
                                                    ?>
                <?php 
                  foreach($package as $row) { ?>
                <!-- <div class="col-xl-3 col-sm-6 col-lg-3 col-md-4 grid-margin stretch-card portfolio <?php if(!empty($key)) { echo str_replace(' ', '_', strtolower($key)); } ?>" data-cat="<?php if(!empty($key)) { echo str_replace(' ', '_', strtolower($key)); } ?>" >
                  <div class="card">
                     <a href="#" data-product_id="<?php echo $row['id']; ?>" data-name="<?php echo str_replace(' ', '_', strtolower($row['name'])); ?>" data-price="<?php echo number_format((float)($row['amount']), 2);?>" class="add-to-cart"  data-category="<?php echo $row['name']; ?>" data-group="<?php echo $row['name']; ?>">
                     <div class="card-body d-flex flex-column justify-content-between">
                      
                      <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                    <?php
                    $englishName = $row['name'];
                    $tamilName = "";
                    
                    if (strlen($englishName) > 15) {
                       
                        echo '<p class="mb-0 text-muted arch">' . $englishName . '</p>';
                    } else {
                        
                        echo '<p class="mb-0 text-muted arch">' . $englishName . '<br>' . $tamilName . '</p>';
                    }
                    ?>
                </div>
                    </div>
                    </a>
                  </div>
                </div> -->
                <?php } ?>
                
</div>
                <div class="scroll products row">
                    <div class="col-sm-12">
                        <h3 style="margin-bottom:5px; margin-top:5px;">Add-on Details</h3>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <!--<label class="form-lable">Package Name</label>-->
                                <select class="form-control" id="add_one_addon">
                                    <option value="">Select From</option> 
                                    <?php foreach($package_addon as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="pack_amount" name="pack_amount" class="form-control">
                    <div class="col-sm-3 ">
                        <div class="form-group form-float">
                        
                            <div class="form-line focused">
                                <input type="hidden" id="pack_name_addon">
                                <input type="number" class="form-control" id="get_pack_amt_addon" placeholder="0.00" >
                                <!-- <label class="form-label">RM</label> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 ">
                        <div class="form-group form-float">
                            <div class="form-line" style="border: none;">
                                <label id="pack_add_addon" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:100%" id="package_table_addon" style="height: 150px;">
                                <thead>
                                    <tr>
                                        <th width="20%">Name</th>
                                        <th width="30%">Description</th>
                                        <th width="20%">Qty</th>
                                        <th width="20%">Total RM</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" id="pack_row_count_addon" value="0">
                    </div>
                </div>

                                                <div class="pack" style="display:none;">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h4
                                                                style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">
                                                                Family Details</h4>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control" id="family_name">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="form-label">Relationship</label>
                                                            <input type="text" class="form-control"
                                                                id="family_relationship">
                                                        </div>
                                                        <div class="col-sm-2 smal_marg">
                                                            <div class="form-group form-float">
                                                                <div class="form-line" style="border: none;">
                                                                    <br><label id="family_add" class="btn btn-warning"
                                                                        style="padding: 6px 12px !important;height: 2.35rem; margin-top: 6px;">Add</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 table-responsive">
                                                            <table class="table table-bordered"
                                                                style="width:100%; height: 150px;" id="family_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="40%">Name</th>
                                                                        <th width="25%">Relationship</th>
                                                                        <th width="15%">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="prod"
                                                                    style="overflow-y:scroll; overflow-x:hidden; max-height: 200px;">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <input type="hidden" id="family_row_count" value="0">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">

                                                <div class="row">
                                                    <div class="col-md-6" style="text-align:left;">
                                                        <p style=" margin-top:10px;">
                                                            <button type="button" class="btn btn-danger btn-lg ar_btn"
                                                                onClick="rePrint();"
                                                                style="background: #f44336;border: 1px solid #f44336;color: #fff;">Reprint</button>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6" style="text-align:right;">
                                                        <p style="margin-top:10px;">
                                                            <button type="button" class="btn ar_btn btn-info btn-lg"
                                                                onClick="userModalOpen();">Add Detail</button>
                                                        </p>
                                                    </div>
                                                </div>
                                                

                                                <table class="show-cart table table-bordered"
                                                    style="width:100%;display:none;"></table>
                                                
                                                <table class="table table-bordered"
                                                style="width:100%;">
                                                <tr><th style='padding: 5px 10px;line-height: 20px;width:10%'>Package Name </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'><span id="packname"></span></td>
                                                </table>
                                                </tr>    

                                                <h4 style="margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#d4aa00;">
                                                    Total Amount</h4>
                                                <input type="number" min="0" step="any" id="total_amt"
                                                    class="form-control" name="total_amt" value="0"
                                                    style="margin-top:20px;font-weight:bold;font-size: 36px;text-align: center;"
                                                    readonly>

                                                <ul class="payment1">
                                              <li><input type="radio" name="pay_method" id="cb1" value="1" />
                                                        <label for="cb1"><i class="mdi mdi-square-inc-cash"></i>
                                                            Cash</label>
                                                    </li>
                                                    <?php /*   <li><input type="radio" name="payment_mode" id="cb3" value="2" />
                                                   <label for="cb3"><i class="mdi mdi-web"></i>Online</label>
                                               </li>
                                               <li><input type="radio" name="payment_mode" id="cb2" value="3" />
                                                   <label for="cb2"><i class="mdi mdi-book-open"></i> Cheque</label>
                                               </li>
                                                */ ?>
                                                     	<li><input type="radio" name="pay_method" id="cb3" value="online" />
														<label for="cb3"><i class="mdi mdi-web"></i> QR/Card</label>
                                                    </li>
                                                </ul>
                                                <div class="col-sm-12" style="text-align: left;color: #f44336;">
                                                    <div class="form-group">
                                                        <label for="termsLink" id="termsLabel" style="cursor: pointer;"><i class="fa fa-check-square-o" style="color:red"></i>Terms and conditions</label>
                                                    </div>
                                                </div>
                                                <input type="button" value="OK" class="button button-white greensubmit"
                                                    id="submit">
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
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:fit-content;">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Terms and conditions will be populated here by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

	<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close"
						data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body p-4" style="padding-bottom:10px;">
					<div class="text-center">
						<div class="row">
                             <!-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="dt">Ubayam Date <span style="color:red;">*</span></label>
                                                        <input class="input1 form-control" type="date" id="dt" name="dt" autocomplete="off" >
                                                        <span id="error_msg"></span>
                                                    </div>
                                                </div> -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="name">Name <span
											style="color:red;">*</span></label>
									<input class="input1 form-control" type="text" id="name"
										name="name" autocomplete="off">
									<span id="error_msg"></span>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="email_id">Email Address
										<!-- <span style="color:red;">*</span> -->
									</label>
									<input class="form-control" type="email" id="email_id"
										name="email" autocomplete="off">
									<!-- <span id="error_msg"></span> -->
									<span class="form_error" id="invalid_email">This email
										is not valid</span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="mobile">Mobile No<span
											style="color:red;"> *</span></label>
									<div class="row">
										<div class="col-md-4">
											<select class="form-control" name="mobile_code"
												id="phonecode">
												<option value="">Dialing code</option>
												<?php
												if (!empty($phone_codes)) {
													foreach ($phone_codes as $phone_code) {
														?>
														<option
															value="<?php echo $phone_code['dailing_code']; ?>"
															<?php if ($phone_code['dailing_code'] == "+60") {
																echo "selected";
															} ?>>
															<?php echo $phone_code['dailing_code']; ?>
														</option>
														<?php
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-8">
											<input class="form-control" type="number"
												id="mobile" name="mobile_no" min="0"
												autocomplete="off">
											<span id="error_msg"></span>
										</div>
									</div>

								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="ic_number">Ic No /
										Passport No</label>
									<input class="form-control" type="text" id="ic_number"
										name="ic_number" autocomplete="off">
									<span id="error_msg"></span>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="rasi_id">Rasi <span
											style="color:red;"></span></label>
									<select class="form-control" name="rasi_id"
										id="rasi_id">
										<option value="">Select Rasi</option>
										<?php foreach ($rasi as $row) { ?>
											<option value="<?php echo $row['id']; ?>">
												<?php echo $row['name_eng']; ?>
											</option>
										<?php } ?>
									</select>
									<span id="error_msg"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label"
										for="natchathra_id">Natchathram <span
											style="color:red;"></span></label>
									<input type="hidden" id="natchathram_id"
										name="natchathram_id" class="form-control">
									<select class="form-control" name="natchathra_id"
										id="natchathra_id">
										<option value="">Select Natchiram</option>
									</select>
									<span id="error_msg"></span>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="address">Address</label>
									<textarea class="form-control" id="address"
										name="address" style="width:100%;"
										autocomplete="off"></textarea>
									<span id="error_msg"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label"
										for="description">Remarks</label>
									<textarea class="form-control" id="description"
										name="description" style="width:100%;"
										autocomplete="off"></textarea>
									<span id="error_msg"></span>
								</div>
							</div>
						</div>


						<button type="button" name="ar_add_btn" id="ar_add_btn"
							class="btn btn-info my-3"
							style="width:100%; font-size:24px; height:auto;margin-bottom: 0 !important;">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 127%;">
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
    <div id="alertModal" class="modal fade" tabindex="-1" rele="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!--div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div-->
                <div class="modal-body">
                    <p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline"
                            style="font-size:42px; color:red;"></i></p>
                    <h5 style="text-align:center;" id="modalMsg"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!--REPRINT SECTION START-->
    <div id="myModal_reprint" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"> 
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4" style="padding-bottom:10px;">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="font-size: 13px;text-align: left;background: #3F51B5;color: #fff;">
                                            <th style="width: 10%;padding: 5px 10px;text-align:center;">S.No</th>
                                            <th style="width: 40%;padding: 5px 10px;text-align:center;">Invoice No</th>
                                            <th style="width: 40%;padding: 5px 10px;text-align:center;">Amount</th>
                                            <th style="width: 10%;padding: 5px 10px;text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="height:auto; margin-bottom:30px;">
                                        <?php
                                        if (count($reprintlists) > 0) {
                                            $ire = 1;
                                            foreach ($reprintlists as $reprintlist) {
                                                ?>
                                                <tr>
                                                    <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                                                        <?php echo $ire; ?>
                                                    </td>
                                                    <td style="width: 40%;padding: 5px 0px!important;text-align:center;">
                                                        <?php echo $reprintlist['ref_no']; ?>
                                                    </td>
                                                    <td style="width: 40%;padding: 5px 0px!important;text-align:center;">
                                                        <?php echo $reprintlist['paidamount']; ?>
                                                    </td>
                                                    <td style="width: 10%;padding: 5px 0px!important;text-align:center;">
                                                        <a class='btn btn-primary'
                                                            style='font-size: 13px;font-weight: bold;padding: 6px 10px;background: #2196F3;border: 1px solid #2196F3;'
                                                            title='Print'
                                                            href='<?php echo base_url(); ?>/ubayam_online/reprint_booking/<?php echo $reprintlist['id']; ?>'
                                                            target='_blank'>Print</a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $ire++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="prin_page"></div>
    <!-- container-scroller -->
    <script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
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
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="<?php echo base_url(); ?>/assets/archanai/js/dashboard.js"></script>
    <script  src="<?php echo base_url(); ?>/assets/archanai/script.js"></script>

    <script src="<?php echo base_url(); ?>/assets/archanai/js/popper.js"></script>
    
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/ui_jquery/jquery-ui.css">
    <script src="<?php echo base_url(); ?>/assets/ui_jquery/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>/assets/ui_jquery/moment.min.js"></script>
    
 <style>
ul.payment {
    list-style-type: none;
    width: 100%;
    display: flex;
    justify-content: flex-start;
    margin-bottom:0;
    padding-left:0;
    -webkit-column-count: 3;
    column-count: 3;
    flex-wrap: wrap;
    height:300px;
    overflow:auto;
}

.payment li {
    display: inline-block;
    width: 20%;
}

input[type="radio"][id^="pay_for"] {
  display: none;
}
input[type="radio"][name="payment_mode"] {
  display: none;
}
input[type="radio"] {
  /* display: none; */
}


.payment li label {
    border: 1px solid #CCC;
    border-radius: 5px;
    line-height: 1.5;
    display: block;
    position: relative;
    margin:10px 10px;
    font-family: inherit;
    min-height: 120px;
    background: #fff;
    cursor: pointer;
    color: #6d5804;
    font-weight: bold;
}
.payment li label p {
    font-size:18px;
    margin-bottom:0;
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
  font-size:18px;
  color:#0d2f95;
}

:checked + label {
background:#f6ef08 !important;
transition-duration: 0.4s;
}

:checked + label:before {
  content: "✓";
  background-color: green;
  transform: scale(1);
}

:checked + i.mdi{
  transform: scale(0.9);
}

ul.payment1 {
    list-style-type: none;
    width: 100%;
    display: flex;
    justify-content: space-between;
    margin-bottom:0;
    padding-left:0;
}

.payment1 li {
    display: inline-block;
    text-align:center;
    width:50%;
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
  font-weight:bold;
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
  font-size:18px;
  color:#0d2f95;
}

.payment1 li :checked + label {
background:#f6ef08;
}

.payment1 li :checked + label:before {
  content: "✓";
  background-color: green;
  transform: scale(1);
}

.payment1 li label :checked + i.mdi{
  transform: scale(0.9);
}
.prod_img { width:90px; min-width:90px; margin:0 auto; border-radius: 50%; min-height:90px; max-height:90px;
    background: #e1e1d68a;
    padding: 5px; }
.text-muted.arch { 
    color:#000000 !important; 
    font-size:14px;
    text-align:center; padding:10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis; 
    max-height:50px;
    min-height:50px;
    text-transform:uppercase;
}
.ar_btn {
    background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
    border-radius: 15px;
    font-weight: bold;
    height: 1.75em;
}
.btn { padding: 0.25rem 0.5rem; height: 2rem; }
.show-cart1 { max-height:350px; overflow:auto; }
.show-cart1 tr { border-radius:10px; }
.show-cart1 td { font-size:13px; padding:3px 10px; }
.total { margin-top:15px; padding-bottom:10px; } 
.total p { font-size: 24px; font-weight: bold; }
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
.prod_img { width:50px; min-width:50px; margin:0 auto; border-radius: 50%; min-height:50px; max-height:50px;}
.payment li { width: 25%; }
.payment1 li label { padding: 15px 1px; margin: 15px 5px; }
}
  .cal_head {
        background: #f34c22;
        color: #FFF;
        padding: 2px 5px;
    }
</style>
    
   <script>

//$(function() {
//var filterList = {
//   init: function() {
    // MixItUp plugin
    // http://mixitup.io
//     $('#portfoliolist').mixItUp({
//       selectors: {
//         target: '.portfolio',
//         filter: '.filter'
//       },
//       load: {
//         filter: '.<?php /*echo $default;*/ ?>'
//       }
//     });

//   }

//};
// Run the show!
//filterList.init();
//});




    function rePrint()
    {
        $("#myModal_reprint").modal("show");
    }
    var userDetail = (function() {
        user = [];
        // Constructor
        function Item(dt,name,email_id,phonecode,mobile,ic_number,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description) {
            this.dt = dt;
            this.name = name;
            this.email_id = email_id;
            this.phonecode = phonecode;
            this.mobile = mobile;
            this.ic_number = ic_number;
            this.rasi_id = rasi_id;
            this.rasi_text = rasi_text;
            this.natchathra_id = natchathra_id;
            this.natchathra_text = natchathra_text;
            this.address = address;
            this.description = description;
        }
        // Save user
        function saveUser() {
            sessionStorage.setItem('ubayam_userdetails', JSON.stringify(user));
        }
            // Load user
        function loadUser() {
            user = JSON.parse(sessionStorage.getItem('ubayam_userdetails'));
        }
        if (sessionStorage.getItem("ubayam_userdetails") != null) {
            loadUser();
        }
        var obj = {};
        // Add to user
        obj.addUserToCart = function(dt,name,email_id,phonecode,mobile,ic_number,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description) {
            var item = new Item(dt,name,email_id,phonecode,mobile,ic_number,rasi_id,rasi_text,natchathra_id,natchathra_text,address,description);
            user.push(item);
            saveUser();
        }
        // clear user
        obj.clearUser = function() {
            user = [];
            saveUser();
        }
        // List user
        obj.listUser = function() {
            return user;
        }
        return obj;
    })();
             function userModalOpen() {
                $("#myModal").modal("show");
                var cartArray = userDetail.listUser();
                if (cartArray.length > 0) {
                    $('#name').val(cartArray[0].name);
                    $('#email_id').val(cartArray[0].email_id);
                    $('#phonecode').val(cartArray[0].phonecode);
                    $('#mobile').val(cartArray[0].mobile);
                    $('#ic_number').val(cartArray[0].ic_number);
                    $('#rasi_id').val(cartArray[0].rasi_id);
                    $('#natchathra_id').val(cartArray[0].natchathra_id);
                    $('#address').val(cartArray[0].address);
                    $('#description').val(cartArray[0].description);
                    $('.show-cart').show();
                } else {
                    $('#name').val("");
                    $('#email_id').val("");
                    $('#phonecode').val("+60");
                    $('#mobile').val("");
                    $('#ic_number').val("");
                    $('#rasi_id').val("");
                    $('#natchathra_id').val("");
                    $('#address').val("");
                    $('#description').val("");
                    $('.show-cart').empty();
                    $('.show-cart').hide();
                }
            }

            $('.form_error').hide();

            $('#ar_add_btn').click(function (event) {
                userDetail.clearUser();
                event.preventDefault();

                var name = $('#name').val();
                var mobile = $('#mobile').val();

                // Validate required fields
                if (name == "") {
                    $('#name').siblings('#error_msg').text('Name is required');
                } else {
                    $('#name').siblings('#error_msg').text('');
                }

                if (mobile == "") {
                    $('#mobile').siblings('#error_msg').text('Mobile is required');
                } else {
                    $('#mobile').siblings('#error_msg').text('');
                }

                // Validate optional fields
                $('.form-control').not('#name, #mobile').each(function () {
                    if ($(this).val() != "") {
                        $(this).siblings('#error_msg').text('');
                    }
                });

                // Check if any required field is empty
                if (name == "" || mobile == "") {
                    return; // Stop form submission if required fields are not filled
                }

                var email_id = $('#email_id').val();
                var ic_number = $('#ic_number').val();
                var address = $('#address').val();
                var rasi_id = $('#rasi_id').val();
                var rasi_text = $("#rasi_id option:selected").text();
                var natchathra_id = $('#natchathra_id').val();
                var natchathra_text = $("#natchathra_id option:selected").text();
                var phonecode = $('#phonecode').val();
                var description = $('#description').val();

                //if(name == "") { $(this).siblings("#error_msg").html("Field needs filling"); }
                //if(email_id == "") { $(this).siblings("#error_msg").html("Field needs filling"); }


                // $('.form-control').each(function () {
                //     if ($(this).val() == "") {
                //         $(this).siblings('#error_msg').text('Field needs to Fill');
                //     } else {
                //         $(this).siblings('#error_msg').text('');
                //     }
                // });

                // if(email_id != "") {
                //     if(IsEmail(email_id)==false){
                //         $('#invalid_email').show();
                //         return false;
                //     }
                // }

                function IsEmail(email_id) {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if (!regex.test(email_id)) {
                        return false;
                    } else {
                        return true;
                    }
                }


                if (name != "" && mobile != "") {
                    $("#myModal").modal("hide");
                    userDetail.addUserToCart(dt, name, email_id, phonecode, mobile, ic_number, rasi_id, rasi_text, natchathra_id, natchathra_text, address, description);
                    displayCart();
                }
            });




            function displayCart() {
                var cartArray = userDetail.listUser();
                if (cartArray.length > 0) {
                    //console.log(cartArray);
                    var output = "";
                    output += "<tr>"
                        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Name </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].name + "</td>"
                        + "</tr>";
                    output += "<tr>"
                        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Email ID</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].email_id + "</td>"
                        + "</tr>";
                    output += "<tr>"
                        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Mobile No </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].phonecode + " " + cartArray[0].mobile + "</td>"
                        + "</tr>";
                    output += "<tr>"
                        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Rasi </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].rasi_text + "</td>"
                        + "</tr>";
                    output += "<tr>"
                        + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Natchathiram</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>" + cartArray[0].natchathra_text + "</td>"
                        + "</tr>";
                    //output += "<tr>"
                    // + "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Address </th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].address+"</td>"
                    //+ "<th style='padding: 5px 10px;line-height: 20px;width:10%'>Remarks</th><td style='background: #fff;border: 1px solid #dee2e6;padding: 5px 10px;line-height: 20px;'>"+cartArray[0].description+"</td>"
                    //+ "</tr>";
					output += '<input type="hidden" name="name" value="' + cartArray[0].name + '" />\
						<input type="hidden" name="email" value="' + cartArray[0].email_id + '" />\
						<input type="hidden" name="mobile_code" value="' + cartArray[0].phonecode + '" />\
						<input type="hidden" name="mobile_no" value="' + cartArray[0].mobile + '" />\
						<input type="hidden" name="ic_number" value="' + cartArray[0].ic_number + '" />\
						<input type="hidden" name="mobile_code" value="' + cartArray[0].phonecode + '" />\
						<input type="hidden" name="rasi_id" value="' + cartArray[0].rasi_id + '" />\
						<input type="hidden" name="natchathra_id" value="' + cartArray[0].natchathra_id + '" />\
						<input type="hidden" name="address" value="' + cartArray[0].address + '" />\
						<input type="hidden" name="description" value="' + cartArray[0].description + '" />';
                    $('.show-cart').html(output);
                    $('.show-cart').show();
                }
                else {
                    $('#name').val("");
                    $('#email_id').val("");
                    $('#phonecode').val("+60");
                    $('#mobile').val("");
                    $('#ic_number').val("");
                    $('#rasi_id').val("");
                    $('#natchathra_id').val("");
                    $('#address').val("");
                    $('#description').val("");
                    $('.show-cart').empty();
                    $('.show-cart').hide();
                }
                //alert(cartArray.length);
            }
            displayCart();
           /*  $('#ubhayam_date').change(function () {
                get_booking_ubhayam();
            }); */
            function formatDate(dateString) {
                var options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                var date = new Date(dateString);
                return date.toLocaleDateString('en-GB', options);
            }

            function get_booking_ubhayam(date) {
				// ubhayam_date = $("#ubhayam_date").val(date);
				console.log('ubhayam_date');
				console.log(date);
                if (date != '') {
                    $.ajax({
                        url: "<?php echo base_url(); ?>/ubayam_online/get_booking_ubhayam",
                            type: "post",
                            data: { ubhayamdate: date },
                            success: function (data) {
                                console.log('ubhayam_date');
                                console.log(date);
                                $("#pay_for").html(data);
                            }
                        });
                }
            }
                /* $(document).ready(function () {
                    get_booking_ubhayam();
                }); */

            function payfor(pay_id) {
                
                $.ajax({
                    url: "<?php echo base_url() ?>/hallbooking_online/get_payfor_collection",
                    type: "POST",
                    data: { id: pay_id },
                    dataType: "json",
                    success: function (data) {
                        $("#total_amt").val(Number(data.amt).toFixed(2));
                        $("#pack_amount").val(Number(data.amt).toFixed(2));
                        $("#packname").text(data.name);
                        $("#total_amt").prop("max", Number(data.amt).toFixed(2));
                        $("#pay_for" + pay_id).prop("checked", true);
                        $("input[name='pay_for']").removeClass("error-input");
                        $(".payment li label").removeClass("error-input");
                        
                        if (data.addons.length > 0) {
                            var a_html = '<option value="">Select From</option>';
                            data.addons.forEach(function(value, key) {
                                a_html += '<option value="' + value.id + '">' + value.name + '</option>';
                            });
                        } else {
                            var a_html = '<option value="">No Addons Found</option>';
                        }
                        $('#add_one_addon').html(a_html);  

                        $("#package_table_addon tbody").empty();
                        $("#pack_row_count_addon").val(0);
                        sum_amount();
                        if (data.terms.length > 0) {
                            var t_html = '';
                            data.terms.forEach(function(value, key) {
                                t_html += '<div class="form-group">' +
                                        '<label class="custom-checkbox">' +
                                        value +
                                        '<input type="checkbox" class="term-checkbox" name="terms[]" value="' + value + '">' +
                                        '<span class="checkmark"></span>' +
                                        '</label>' +
                                        '</div>';
                            });
                            $('#termsModal .modal-body').html(t_html);
                            // $('#termsModal').modal('show');
                        }
                    }
                });
            }

                $("#family_add").click(function () {
                    var family_name = $("#family_name").val();
                    var family_relationship = $("#family_relationship").val();
                    var cnt_fmy = parseInt($("#family_row_count").val());
                    if (family_name != '' && family_relationship != '') {
                        var html = '<tr id="rmv_familyrow' + cnt_fmy + '">';
                        html += '<td style="width: 33%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][name]" value="' + family_name + '"></td>';
                        html += '<td style="width: 33%;"><input type="text" style="border: none;" readonly name="familly[' + cnt_fmy + '][relationship]" value="' + family_relationship + '"></td>';
                        html += '<td style="width: 33%;"><a class="btn btn-danger btn-rad" onclick="rmv_family(' + cnt_fmy + ')" style="width:auto;padding: 0px 3px !important; color:#fff;"><i class="fa fa-remove"></i></a></td>';
                        html += '</tr>';
                        $("#family_table").append(html);
                        var ct_fmy = parseInt(cnt_fmy + 1);
                        $("#family_row_count").val(ct_fmy);
                        $("#family_name").val('');
                        $("#family_relationship").val('');
                    }
                });
                function rmv_family(id) {
                    $("#rmv_familyrow" + id).remove();
                }
                $(document).ready(function () {
                    $("#rasi_id").change(function () {
                        var rasi = $("#rasi_id").val();
                        if (rasi != "") {
                            $.ajax({
                                url: '<?php echo base_url(); ?>/ubayam_online/get_natchathram',
                                type: 'post',
                                data: { rasi_id: rasi },
                                dataType: 'json',
                                success: function (response) {
                                    $('#natchathram_id').val(response.natchathra_id);

                                    var str = response.natchathra_id;
                                    console.log(str);
                                    //return;
                                    if (str != "") {
                                        $("#natchathra_id").empty();

                                        $('#natchathra_id').append('<option value="">Select Natchiram</option>');
                                        $.each(str.split(','), function (key, value) {
                                            //$('#natchathra_id').append('<option value="' + value + '">' + value + '</option>');
                                            $.ajax({
                                                url: '<?php echo base_url(); ?>/ubayam_online/get_natchathram_name',
                                                type: 'post',
                                                data: { id: value },
                                                dataType: 'json',
                                                success: function (response) {
                                                    $('#natchathra_id').append('<option value="' + response.id + '">' + response.name_eng + '</option>');
                                                    //$('#natchathra_id').prop('selectedIndex',0);
                                                    //$("#natchathra_id").selectpicker("refresh");
                                                }
                                            });
                                        });
                                    }
                                }
                            });
                        }
                    });
                });

                // $("#submit").click(function () {
                //     var total_amt = parseFloat($("#total_amt").val());

                //     var pack_row_count = parseInt($("#pack_row_count").val());
                //     var pay_for = $('.ubayam_slot').filter(':checked').length;
                //     var name = $("#name").val();
                //     //var email_id = $("#email_id").val();
                //     var mobile = $("#mobile").val();
                //     //var rasi_id = $("#rasi_id").val();
                //     //var natchathra_id = $("#natchathra_id").val();
                //     var dt = $("#dt").val();
                //     if (pay_for === 0) {
                //         $("input[name='pay_for']").addClass("error-input");
                //         $(".payment li label").addClass("error-input");
                //         $('html, body').animate({
                //             scrollTop: $("input[name='pay_for']").focus().offset().top - 25
                //         }, 500);
                //     }
                //     else if (total_amt.length === 0 || total_amt == '') {
                //         $("#total_amt").addClass("error-input");
                //         $('html, body').animate({
                //             scrollTop: $("#total_amt").focus().offset().top - 25
                //         }, 500);
                //     }
                //     // else if (dt == "") {
                //     //     //alert("Please enter user details.");
                //     //     $("#modalMsg").text('Please enter user details.');
                //     //     $('#alertModal').modal();
                //     // }
                //     else if (name == "") {
                //         //alert("Please enter user details.");
                //         $("#modalMsg").text('Please enter user details.');
                //         $('#alertModal').modal();
                //     }
                //     // else if(email_id == "")
                //     // {
                //     //     //alert("Please enter user details.");
                //     //     $("#modalMsg").text('Please enter user details.');
                //     //     $('#alertModal').modal();
                //     // }
                //     else if (mobile == "") {
                //         //alert("Please enter user details.");
                //         $("#modalMsg").text('Please enter user details.');
                //         $('#alertModal').modal();
                //     }
                //     // else if(rasi_id == "")
                //     // {
                //     //     //alert("Please enter user details.");
                //     //     $("#modalMsg").text('Please enter user details.');
                //     //     $('#alertModal').modal();
                //     // }
                //     // else if(natchathra_id == "")
                //     // {
                //     //     //alert("Please enter user details.");
                //     //     $("#modalMsg").text('Please enter user details.');
                //     //     $('#alertModal').modal();
                //     // }
                //     else {
                //         $.ajax
                //             ({
                //                 type: "POST",
                //                 url: "<?php echo base_url(); ?>/ubayam_online/save",
                //                 data: $("form").serialize(),
                //                 beforeSend: function () {
                //                     $("#loader").show();
                //                 },
                //                 success: function (data) {
                //                     userDetail.clearUser();
                //                     //location.reload();
                //                     obj = jQuery.parseJSON(data);
                //                     if (obj.err != '') {
                //                         $('#alert-modal').modal('show', { backdrop: 'static' });
                //                         $("#spndeddelid").text(obj.err);
                //                     } else {
                //                         window.open("<?php echo base_url(); ?>/ubayam_online/payment_process/" + obj.id, "_blank", "width=680,height=500");
                //                         window.location.reload(true);
                //                     }
                //                 },
                //                 complete: function (data) {
                //                     // Hide image container
                //                     $("#loader").hide();
                //                 }
                //             });
                //     }
                // });
                
$("#submit").click(function(){


    var checkboxes = document.querySelectorAll('.term-checkbox');
    var allChecked = true;

    checkboxes.forEach(function(checkbox) {
        if (!checkbox.checked) {
            allChecked = false;
        }
    });

    if (!allChecked) {
        event.preventDefault();
        alert('Please check all Terms & Conditions before saving.');
        exit();
    }
    var pack_row_count = parseInt($("#pack_row_count").val());
    var pay_for = $('.ubayam_slot').filter(':checked').length;
    var name = $("#name").val();
    //var email_id = $("#email_id").val();
    var mobile = $("#mobile").val();
    //var rasi_id = $("#rasi_id").val();
    //var natchathra_id = $("#natchathra_id").val();
    var dt = $("#dt").val();
	var total_amt       = parseFloat($("#total_amt").val());
	var check_dep       = parseFloat((total_amt / 100) * 30).toFixed(2);
	console.log(check_dep);
    // if (pay_for === 0) {
    //     $("input[name='pay_for']").addClass("error-input");
    //     $(".payment li label").addClass("error-input");
    //     $('html, body').animate({
    //         scrollTop: $("input[name='pay_for']").focus().offset().top - 25
    //     }, 500);
    // }
    // else if (total_amt.length === 0 || total_amt == '') {
    //     $("#total_amt").addClass("error-input");
    //     $('html, body').animate({
    //         scrollTop: $("#total_amt").focus().offset().top - 25
    //     }, 500);
    // }
                
    // else
     if (name == "") {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    }
    
    else if (mobile == "") {
        //alert("Please enter user details.");
        $("#modalMsg").text('Please enter user details.');
        $('#alertModal').modal();
    } else {
               


                    
	
	$.ajax({
		type: "POST",
		url: "<?php echo base_url();?>/ajax/save_booking",
		data: $("form").serialize(),
		beforeSend: function() {    
			$("#loader").show();
		},
		success: function(data) {
			console.log(data);
			if (typeof data === 'string') {
				try {
					data = JSON.parse(data);
				} catch (e) {
					console.error("Failed to parse JSON response: ", e);
					$('#alert-modal').modal('show', { backdrop: 'static' });
					$("#spndeddelid").text("An error occurred while processing the response.");
					$("#spndeddelid").css("color", "red");
					return;
				}
			}

			if (data.success) {
				if (data.data.status) {
					$('#alert-modal').modal('show', { backdrop: 'static' });
					$("#spndeddelid").text(data.data.message);
					$("#spndeddelid").css("color", "green");
					/* setTimeout(function(){
						
					}, 2000); */
					var bookingId = data.data.booking_id;
					console.log("Booking ID: " + bookingId);
					// window.location.replace("<?php echo base_url();?>/templeubayam/ubayambook_list?date="+$('#event_date').val());
					// Perform additional actions if needed, e.g., redirect to a confirmation page
                    window.open("<?php echo base_url();?>/hallbooking_online/print_page_hall/" + bookingId, '_blank');
				} else {
					$('#alert-modal').modal('show', { backdrop: 'static' });
					$("#spndeddelid").text(data.data.message);
					$("#spndeddelid").css("color", "red");
				}
			} else {
				$('#alert-modal').modal('show', { backdrop: 'static' });
				$("#spndeddelid").text("An error occurred. Please try again later");
				$("#spndeddelid").css("color", "red");
			}
		},
		error: function() {
			$('#alert-modal').modal('show', { backdrop: 'static' });
			$("#spndeddelid").text("An error occurred. Please try again later");
			$("#spndeddelid").css("color", "red");
		},
		complete: function() {
			$("#loader").hide();
		}
	});

}
		
	
	
});   
                function IsEmail(email) {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if (!regex.test(email)) {
                        return 0;
                    } else {
                        return 1;
                    }
                }
                $("#cancel-button").click(function () {
                    $("#name").removeClass("error-input");
                    $("#address").removeClass("error-input");
                    $("#mobile").removeClass("error-input");
                    $("#ic_number").removeClass("error-input");
                    $("#email_id").removeClass("error-input");
                    $("#total_amt").removeClass("error-input");
                    $("input[name='pay_for']").removeClass("error-input");
                    $(".payment li label").removeClass("error-input");
                });
                $('#name').keyup(function () {
                    $("#name").removeClass("error-input");
                });
                $('#address').keyup(function () {
                    $("#address").removeClass("error-input");
                });
                $('#mobile').keyup(function () {
                    $("#mobile").removeClass("error-input");
                });
                $('#ic_number').keyup(function () {
                    $("#ic_number").removeClass("error-input");
                });
                $('#email_id').keyup(function () {
                    $("#email_id").removeClass("error-input");
                });
                $('#total_amt').keyup(function () {
                    $("#total_amt").removeClass("error-input");
                });
            </script>
    
    
    <script>
        



        
        // MAIN JS FILE START
        (function($) {

	"use strict";
 $(document).ready(function(){
    var date = new Date();
    var today = date.getDate();
    // Set click handlers for DOM elements
    $(".right-button").click({date: date}, next_year);
    $(".left-button").click({date: date}, prev_year);
    $(".month").click({date: date}, month_click);
    $("#add-button").click({date: date}, new_event);
    // Set current month as active
    $(".months-row").children().eq(date.getMonth()).addClass("active-month");
    init_calendar(date);
    var events = check_events(today, date.getMonth()+1, date.getFullYear());
    show_events(events, months[date.getMonth()], today);
});

// Initialize the calendar by appending the HTML dates
function init_calendar(date) {
    $(".tbody").empty();
    $(".events-container").empty();
    var calendar_days = $(".tbody");
    var month = date.getMonth();
    var year = date.getFullYear();
    var day_count = days_in_month(month, year);
    var row = $("<tr class='table-row'></tr>");
    var today = date.getDate();
    // Set date to 1 to find the first day of the month
    date.setDate(1);
	// get_booking_ubhayam(today);
    var first_day = date.getDay();
    // 35+firstDay is the number of date elements to be added to the dates table
    // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
    for(var i=0; i<35+first_day; i++) {
        // Since some of the elements will be blank, 
        // need to calculate actual date from index
        var day = i-first_day+1;
        // If it is a sunday, make a new row
        if(i%7===0) {
            calendar_days.append(row);
            row = $("<tr class='table-row'></tr>");
        }
        // if current index isn't a day in this month, make it blank
        if(i < first_day || day > day_count) {
            var curr_date = $("<td class='table-date nil'>"+"</td>");
            row.append(curr_date);
        }   
        else {
            var curr_date = $("<td class='table-date'>"+day+"</td>");
            var events = check_events(day, month+1, year);
            if(today===day && $(".active-date").length===0) {
                curr_date.addClass("active-date");
                show_events(events, months[month], day);
            }
            // If this date has any events, style it with .event-date
            if(events.length!==0) {
                curr_date.addClass("event-date");
            }
            // Set onClick handler for clicking a date
            curr_date.click({events: events, month: months[month], day:day, year: year}, date_click);
            row.append(curr_date);
        }
    }
    // Append the last row and set the current year
    calendar_days.append(row);
    $(".year").text(year);
}

// Get the number of days in a given month/year
function days_in_month(month, year) {
    var monthStart = new Date(year, month, 1);
    var monthEnd = new Date(year, month + 1, 1);
    return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);    
}

// Event handler for when a date is clicked
function date_click(event) {
	var today = new Date();
    var cur_day = new Date(event.data.year + '-' + event.data.month + '-' + event.data.day);

    var threeDaysAfterToday = new Date(today);
    threeDaysAfterToday.setDate(today.getDate() + 30); // Add 3 days to today

    if (cur_day <= threeDaysAfterToday) {
        $('#add-button').prop('disabled', true);
        // alert("You can book 3 days after today's date");
    } else {
        $('#add-button').prop('disabled', false);
    }
    console.log(cur_day);
    // console.log(threeDaysAfterCurDay);

    $(".events-container").show(250);
    $("#dialog").hide(250);
    $(".active-date").removeClass("active-date");
    $(this).addClass("active-date");
	console.log(event);
    show_events(event.data.events, event.data.month, event.data.day);
};

// Event handler for when a month is clicked
function month_click(event) {
    $(".events-container").show(250);
    $("#dialog").hide(250);
    var date = event.data.date;
    $(".active-month").removeClass("active-month");
    $(this).addClass("active-month");
    var new_month = $(".month").index(this);
    date.setMonth(new_month);
    init_calendar(date);
}

// Event handler for when the year right-button is clicked
function next_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()+1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for when the year left-button is clicked
function prev_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()-1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for clicking the new event button
function new_event(event) {
    // if a date isn't selected then do nothing
    if($(".active-date").length===0)
        return;
    // remove red error input on click
    $("input").click(function(){
        $(this).removeClass("error-input");
    });
    $(function() {
var filterList = {
  init: function() {
    // MixItUp plugin
    // http://mixitup.io
    $('#portfoliolist').mixItUp({
      selectors: {
        target: '.portfolio',
        filter: '.filter'
      },
      load: {
        filter: '.<?php echo $default; ?>'
                    }
                });

            }

        };
        // Run the show!
        filterList.init();
    });
	console.log('event.data.date');
	console.log(event.data);
	var curdate = event.data.date;
	var curday = parseInt($(".active-date").html());
	var event_date = curdate.getFullYear() + "-" + (curdate.getMonth() + 1) + "-" + curday;
	/* $('#dt').val(event_date); */
	$("#ubhayam_date").val(event_date);
	$("#booking_date").val(event_date);
	get_booking_ubhayam(event_date);
    loadbookingslots(event_date);
    // empty inputs and hide events
    $("#dialog input[type=text]").val('');
    $("#dialog input[type=number]").val('');
    $(".events-container").hide(250);
    $("#dialog").show(250);
    // Event handler for cancel button
    $("#cancel-button").click(function() {
        $("#name").removeClass("error-input");
        $("#count").removeClass("error-input");
        $("#dialog").hide(250);
        $(".events-container").show(250);
    });
    // Event handler for ok button
    $("#ok-button").unbind().click({date: event.data.date}, function() {
        var date = event.data.date;
        var name = $("#name").val().trim();
        var count = parseInt($("#count").val().trim());
        var day = parseInt($(".active-date").html());
        // Basic form validation
        if(name.length === 0) {
            $("#name").addClass("error-input");
        }
        else if(isNaN(count)) {
            $("#count").addClass("error-input");
        }
        else {
            $("#dialog").hide(250);
            console.log("new event");
            new_event_json(name, count, date, day);
            date.setDate(day);
            init_calendar(date);
        }
    });
}
function loadbookingslots(date)
{
    $.ajax({
        type:"POST",
        url: "<?php echo base_url(); ?>/hallbooking_online/loadbookingslots",
        data: {bookeddate:date},
        success:function(data)
        {
			console.log(data);
			var result = JSON.parse(data);
			if(result.status){
				if(result.html != ''){
					$("#booking_slot").html(result.html);
				} else {
					alert("Selected date is not available, Kindly select various date!");
					window.location.replace("<?php echo base_url();?>/hallbooking_online/hall");
				}
			}else{
				alert(result.error_msg);
				window.location.replace("<?php echo base_url();?>/hallbooking_online/hall");
			}
        },
		error: function(err){
			console.log('err');
			console.log(err);
		}
		
    });
}
	// Setup the calendar with the current date
// $(document).ready(function(){
//     var date = new Date();
//     var today = date.getDate();
//     // Set click handlers for DOM elements
//     $(".right-button").click({date: date}, next_year);
//     $(".left-button").click({date: date}, prev_year);
//     $(".month").click({date: date}, month_click);
//     $("#add-button").click({date: date}, new_event);
//     // Set current month as active
//     $(".months-row").children().eq(date.getMonth()).addClass("active-month");
//     init_calendar(date);
//     var events = check_events(today, date.getMonth()+1, date.getFullYear());
//     show_events(events, months[date.getMonth()], today);
// });

// // Initialize the calendar by appending the HTML dates
// function init_calendar(date) {
//     $(".tbody").empty();
//     $(".events-container").empty();
//     var calendar_days = $(".tbody");
//     var month = date.getMonth();
//     var year = date.getFullYear();
//     var day_count = days_in_month(month, year);
//     var row = $("<tr class='table-row'></tr>");
//     var today = date.getDate();
//     // Set date to 1 to find the first day of the month
//     date.setDate(1);
// 	get_booking_ubhayam(today);
//     var first_day = date.getDay();
//     // 35+firstDay is the number of date elements to be added to the dates table
//     // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
//     for(var i=0; i<35+first_day; i++) {
//         // Since some of the elements will be blank, 
//         // need to calculate actual date from index
//         var day = i-first_day+1;
//         // If it is a sunday, make a new row
//         if(i%7===0) {
//             calendar_days.append(row);
//             row = $("<tr class='table-row'></tr>");
//         }
//         // if current index isn't a day in this month, make it blank
//         if(i < first_day || day > day_count) {
//             var curr_date = $("<td class='table-date nil'>"+"</td>");
//             row.append(curr_date);
//         }   
//         else {
//             var curr_date = $("<td class='table-date'>"+day+"</td>");
//             var events = check_events(day, month+1, year);
//             if(today===day && $(".active-date").length===0) {
//                 curr_date.addClass("active-date");
//                 show_events(events, months[month], day);
//             }
//             // If this date has any events, style it with .event-date
//             if(events.length!==0) {
//                 curr_date.addClass("event-date");
//             }
//             // Set onClick handler for clicking a date
//             curr_date.click({events: events, month: months[month], day:day, year: year}, date_click);
//             row.append(curr_date);
//         }
//     }
//     // Append the last row and set the current year
//     calendar_days.append(row);
//     $(".year").text(year);
// }

// // Get the number of days in a given month/year
// function days_in_month(month, year) {
//     var monthStart = new Date(year, month, 1);
//     var monthEnd = new Date(year, month + 1, 1);
//     return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);    
// }

// // Event handler for when a date is clicked
// function date_click(event) {
// 	var today = new Date();
//     var cur_day = new Date(event.data.year + '-' + event.data.month + '-' + event.data.day);

//     var threeDaysAfterToday = new Date(today);
//     threeDaysAfterToday.setDate(today.getDate() + 30); // Add 3 days to today

//     if (cur_day <= threeDaysAfterToday) {
//         $('#add-button').prop('disabled', true);
//         // alert("You can book 3 days after today's date");
//     } else {
//         $('#add-button').prop('disabled', false);
//     }
//     console.log(cur_day);
//     // console.log(threeDaysAfterCurDay);

//     $(".events-container").show(250);
//     $("#dialog").hide(250);
//     $(".active-date").removeClass("active-date");
//     $(this).addClass("active-date");
// 	console.log(event);
//     show_events(event.data.events, event.data.month, event.data.day);
// };

// // Event handler for when a month is clicked
// function month_click(event) {
//     $(".events-container").show(250);
//     $("#dialog").hide(250);
//     var date = event.data.date;
//     $(".active-month").removeClass("active-month");
//     $(this).addClass("active-month");
//     var new_month = $(".month").index(this);
//     date.setMonth(new_month);
//     init_calendar(date);
// }

// // Event handler for when the year right-button is clicked
// function next_year(event) {
//     $("#dialog").hide(250);
//     var date = event.data.date;
//     var new_year = date.getFullYear()+1;
//     $("year").html(new_year);
//     date.setFullYear(new_year);
//     init_calendar(date);
// }

// // Event handler for when the year left-button is clicked
// function prev_year(event) {
//     $("#dialog").hide(250);
//     var date = event.data.date;
//     var new_year = date.getFullYear()-1;
//     $("year").html(new_year);
//     date.setFullYear(new_year);
//     init_calendar(date);
// }

// // Event handler for clicking the new event button
// function new_event(event) {
//     // if a date isn't selected then do nothing
//     if($(".active-date").length===0)
//         return;
//     // remove red error input on click
//     $("input").click(function(){
//         $(this).removeClass("error-input");
//     });
//     $(function() {
// var filterList = {
//   init: function() {
//     // MixItUp plugin
//     // http://mixitup.io
//     $('#portfoliolist').mixItUp({
//       selectors: {
//         target: '.portfolio',
//         filter: '.filter'
//       },
//       load: {
//         filter: '.<?php echo $default; ?>'
//                     }
//                 });

//             }

//         };
//         // Run the show!
//         filterList.init();
//     });
// 	console.log('event.data.date');
// 	console.log(event.data);
// 	var curdate = event.data.date;
// 	var curday = parseInt($(".active-date").html());
// 	var event_date = curdate.getFullYear() + "-" + (curdate.getMonth() + 1) + "-" + curday;
// 	/* $('#dt').val(event_date); */
// 	$("#ubhayam_date").val(event_date);
// 	$("#booking_date").val(event_date);
// 	get_booking_ubhayam(event_date);
//     loadbookingslots(event_date);
//     // empty inputs and hide events
//     $("#dialog input[type=text]").val('');
//     $("#dialog input[type=number]").val('');
//     $(".events-container").hide(250);
//     $("#dialog").show(250);
//     // Event handler for cancel button
//     $("#cancel-button").click(function() {
//         $("#name").removeClass("error-input");
//         $("#count").removeClass("error-input");
//         $("#dialog").hide(250);
//         $(".events-container").show(250);
//     });
//     // Event handler for ok button
//     $("#ok-button").unbind().click({date: event.data.date}, function() {
//         var date = event.data.date;
//         var name = $("#name").val().trim();
//         var count = parseInt($("#count").val().trim());
//         var day = parseInt($(".active-date").html());
//         // Basic form validation
//         if(name.length === 0) {
//             $("#name").addClass("error-input");
//         }
//         else if(isNaN(count)) {
//             $("#count").addClass("error-input");
//         }
//         else {
//             $("#dialog").hide(250);
//             console.log("new event");
//             new_event_json(name, count, date, day);
//             date.setDate(day);
//             init_calendar(date);
//         }
//     });
// }
// function loadbookingslots(date)
// {
//     $.ajax({
//         type:"POST",
//         url: "<?php echo base_url(); ?>/hallbooking_online/loadbookingslots",
//         data: {bookeddate:date},
//         success:function(data)
//         {
//           // console.log(data);
//           if(data){
//                 $("#booking_slot").html(data);
//             } else {
//                 alert("Selected date is not available, Kindly select various date!");
//                 window.location.replace("<?php echo base_url();?>/hallbooking_online/hall");


//             }
//         }
//     });
// }
// Adds a json event to event_data
function new_event_json(name, count, date, day) {
    var event = {
        "occasion": name,
        "invited_count": count,
        "year": date.getFullYear(),
        "month": date.getMonth()+1,
        "day": day
    };
    event_data["events"].push(event);
}

// Display all events of the selected date in card views
function show_events(events, month, day) {
    // Clear the dates container
    $(".events-container").empty();
    $(".events-container").show(250);
    console.log(event_data["events"]);
    // If there are no events for this date, notify the user
    if(events.length===0) {
        var event_card = $("<div class='event-card'></div>");
        var event_name = $("<div class='event-name'>There are no events planned for "+month+" "+day+".</div>");
        $(event_card).css({ "border-left": "10px solid #FF1744" });
        $(event_card).append(event_name);
        $(".events-container").append(event_card);
    }
    else {
        // Go through and add each event as a card to the events container
        for(var i=0; i<events.length; i++) {
            var event_card = $("<div class='event-card'></div>");
            var event_name = $("<div class='event-name'>Event Detail: "+events[i]["event_name"]+":</div>");
            var event_count = $("<div class='cal_head'>Booked By: "+events[i]["name"]+"</div>");
            $(event_card).append(event_name).append(event_count);
            $(".events-container").append(event_card);
        }
    }
}

// Checks if a specific date has any events
function check_events(day, month, year) {
    var events = [];
    for(var i=0; i<event_data["events"].length; i++) {
        var event = event_data["events"][i];
        if(event["day"]===day &&
            event["month"]===month &&
            event["year"]===year) {
                events.push(event);
            }
    }
    return events;
}

// Given data for events in JSON format
var event_data = <?php echo $ubayams; ?>;

const months = [ 
    "January", 
    "February", 
    "March", 
    "April", 
    "May", 
    "June", 
    "July", 
    "August", 
    "September", 
    "October", 
    "November", 
    "December" 
];

})(jQuery);

function increaseValue(cnt) {
    var quantity = $("#quantity" + cnt);
    var currentVal = parseInt(quantity.val());
    if (!isNaN(currentVal)) {
		if((currentVal + 1) > quantity.attr('max')) quantity.val(quantity.attr('max'));
        else quantity.val(currentVal + 1);
        updateAmount(cnt);
    } else {
        quantity.val(1);
    }
    sum_amount();
}

        function decreaseValue(cnt) {
            console.log("decreaseValue called with cnt: " + cnt);
            var quantity = $("#quantity" + cnt);
            var currentVal = parseInt(quantity.val());
            if (!isNaN(currentVal) && currentVal > 1) {
                quantity.val(currentVal - 1);
                updateAmount(cnt);
            } else {
                quantity.val(1);
            }
            sum_amount();
        }

        function qtykeyup(cnt) {
    var quantity = $("#quantity" + cnt);
    var currentVal = parseInt(quantity.val());
	console.log(currentVal);
	console.log();
    if (!isNaN(currentVal) && currentVal >= 0) {
		if(currentVal > quantity.attr('max')) quantity.val(quantity.attr('max'));
        updateAmount(cnt);
    } else {
        quantity.val(1);
    }
    sum_amount();
}

        function updateAmount(cnt) {
            console.log("updateAmount called with cnt: " + cnt);
            var quantity = $("#quantity" + cnt).val();
            var unitPrice = parseFloat($("#service_name_addon_" + cnt).data('amount'));
            var totalPrice = quantity * unitPrice;
            $("#package_amt_addon_" + cnt).val(Number(totalPrice).toFixed(2));
        }
        
        function rmv_pack_addon(id) {
            console.log("rmv_pack_addon called with id: " + id);
            $("#rmv_packrow_addon" + id).remove();
            sum_amount();
        }

        function serviceamount() {
            sum_amount();
        }

        function sum_amount() {
    var total = 0;

    // Sum the amounts from the package_amt_addon fields
    $(".package_amt_addon").each(function() {
        var amount = parseFloat($(this).val());
        if (!isNaN(amount)) {
            total += amount;
        }
    });
    
    var pack_amount = parseFloat($("#pack_amount").val());
    var total_val = total + pack_amount;
    // Update the total amount field with the new total
    $("#total_amt").val(Number(total_val).toFixed(2));
    console.log("Total Amount: " + total);
}

        function get_service_name_addon(id, cmlp) {
            console.log("get_service_name_addon called with id: " + id + " and cmlp: " + cmlp);
            if (id != '') {
                $.ajax({
                    url: "<?php echo base_url();?>/hallbooking_online/get_service_name_addon",
                    type: "post",
                    data: {id: id},
                    dataType: "json",
                    success: function(data){
                        $("#service_name_addon_" + cmlp).val(data['name']);
                        $("#service_description_addon_" + cmlp).val(data['description']);
                    }
                });
            }
        }
        $("#add_one_addon").change(function(){
            var id = $("#add_one_addon").val();
            if(id != ''){
                $.ajax({
                    url: "<?php echo base_url();?>/hallbooking_online/getpack_amt_addon",
                    type: "post",
                    data: {id: id},
                    dataType: "json",
                    success: function(data){
                        console.log(data)
                        $("#get_pack_amt_addon").val(Number(data['amt']).toFixed(2));
                        $("#pack_name_addon").val(data['name']);
                    }
                });
            }else{
                $("#get_pack_amt_addon").val(0);
            }
            sum_amount();
        });
        $("#pack_add_addon").click(function(){
            var id = $("#add_one_addon option:selected").val();
            var cnt = parseInt($("#pack_row_count_addon").val());
            var amt = $("#get_pack_amt_addon").val();
            var package_id = $('.package_id').val();

            if (id != '' && parseFloat(amt) > 0) {
                var status_check = 0;
                var rowId;

                $(".package_category_addon").each(function() {
                    var arcat = parseInt($(this).val());
                    if (arcat == id) {
                        status_check++;
                        rowId = $(this).closest('tr').attr('id').replace('rmv_packrow_addon', '');
                    }
                });

                if (status_check > 0) {
                    var quantity = $("#quantity" + rowId);
                    var currentVal = parseInt(quantity.val());
                    quantity.val(currentVal + 1);
                    updateAmount(rowId);
                    sum_amount();
                    $("#get_pack_amt_addon").val('');
                    $('#add_one_addon').prop('selectedIndex', 0);
                    // $("#add_one_addon").selectpicker("refresh");
                } else {
                    $.ajax({
                        url: "<?php echo base_url();?>/hallbooking_online/get_service_list_addon",
                        type: "post",
                        data: {id: id, package_id: package_id},
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.length > 0) {
                                $.each(response, function(key, value) {
                                    var countid = value.id;
                                    var serviceid = value.id;
                                    var quantity = value.quantity;
                                    var serviceamount = value.amount;
                                    get_service_name_addon(serviceid, countid);
                                    var html = '<tr id="rmv_packrow_addon' + countid + '">';
                                    html += '<td style="width: 20%;"><input type="hidden" readonly name="add_on[' + countid + '][id]" value="' + serviceid + '"><input type="text" style="border: none;width: 100%;" readonly id="service_name_addon_' + countid + '" data-amount="' + serviceamount + '"></td>';
                                    html += '<td style="width: 45%;"><input type="text" style="border: none;width: 100%;" id="service_description_addon_' + countid + '"></td>';
                                    html += '<td><div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue(' + countid + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="add_on[' + countid + '][quantity]" min="1" id="quantity' + countid + '" value="1" pattern="[0-9]*" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="qty_amt" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" max="' + quantity + '" onkeyup="qtykeyup(' + countid + ')" /><div class="value-button" id="increase" onclick="increaseValue(' + countid + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>';
                                    html += '<td style="width: 25%;"><input type="text" style="border: none;width: 100%;" class="package_amt_addon" id="package_amt_addon_' + countid + '" value="' + Number(serviceamount).toFixed(2) + '" onkeyup="serviceamount()"></td>';
                                    html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack_addon(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons">X</i></a><input type="hidden" class="package_category_addon" value=' + id + '></td>';
                                    html += '</tr>';
                                    $("#package_table_addon").append(html);
                                });
                                sum_amount();
                            }
                        }
                    });
                    $("#get_pack_amt_addon").val('');
                    $('#add_one_addon').prop('selectedIndex', 0);
                    // $("#add_one_addon").selectpicker("refresh");
                }
            }
        });
        $(document).on('click', '.booking_slot', function(){
    var booking_slot = this.value;
    var booking_date = $('#ubhayam_date').val();
    console.log(booking_slot);
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>/ajax/get_packages_list",
        data: {slot_id: booking_slot, booking_date: booking_date, package_type: 1},
        dataType: 'json',
        beforeSend: function() {    
            // $("#loader").show();
        },
        success: function(data) {
            console.log(data);
            if (data.success) {
                // Generate HTML for packages
                var packageHtml = '';
                if(data.data.packages.length > 0){
                    data.data.packages.forEach(function(value, key){
                        packageHtml += '<div class="portfolio" data-cat="">';
                        packageHtml += '<input type="radio" class="ubayam_slot" name="pay_for" value="' + value.id + '" id="pay_for' + value.id + '" onclick="createHiddenInput(' + value.id + ')"/>';
                        packageHtml += '<label class="card" for="pay_for' + value.id + '" onclick="payfor(' + value.id + ')">';
                        packageHtml += '<img class="img-fluid prod_img" src="<?php echo base_url(); ?>/uploads/package/' + value.image + '">';
                        packageHtml += '<div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">';
                        packageHtml += '<p class="mb-0 text-muted arch" id="pay_name' + value.id + '">' + value.name + '</p>';
                        packageHtml += '</div></label></div>';
                    });
                } else {
                    packageHtml = '<p>No Packages Found</p>';
                    alert("This slot was not available for booking. Please choose another slot.");
                }
                $('#add_one').html(packageHtml);
                // $("#add_one").selectpicker("refresh");

                // Generate HTML for addons
                var addonHtml = '<option value="">Select From</option>';
                if(data.data.addons.length > 0){
                    data.data.addons.forEach(function(value, key){
                        addonHtml += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                } else {
                    addonHtml += '<option value="">No Addons Found</option>';
                }
                $('#add_one_addon').html(addonHtml);
                // $("#add_one_addon").selectpicker("refresh");
                
                $("#pack_amount").val(0);
                $("#package_table_addon tbody").empty();
                $("#pack_row_count_addon").val(0);
                sum_amount();
            }
        },
        error: function() {
            // $('#alert-modal').modal('show', { backdrop: 'static' });
            // $("#spndeddelid").text("An error occurred. Please try again later");
            // $("#spndeddelid").css("color", "red");
            // var packageHtml = '<p>No Packages Found</p>';
            // $('#add_one').html(packageHtml);
            // $("#add_one").selectpicker("refresh");
            // var addonHtml = '<option value="">No Addons Found</option>';
            // $('#add_one_addon').html(addonHtml);
            // $("#add_one_addon").selectpicker("refresh");
        },
        complete: function() {
            // $("#loader").hide();
        }
    });
});

function createHiddenInput(packageId) {
    // Remove any existing hidden input
    $('input[name^="packages["]').remove();

    // Create a new hidden input with the selected package ID
    var hiddenInput = '<input type="hidden" name="packages[' + packageId + '][id]" class="package_id" value="' + packageId + '">';
    $('form').append(hiddenInput);
}
 $('#termsLabel').on('click', function(event) {
    event.preventDefault();
    var name = $("#name").val();
    var today = new Date();
    var formattedDate = today.getFullYear() + '-' 
                    + ('0' + (today.getMonth() + 1)).slice(-2) + '-' 
                    + ('0' + today.getDate()).slice(-2);
    var ic_number = $("#ic_number").val();
    var address = $("#address").val();
    var booking_date = $("#ubhayam_date").val();
    var booking_slot = $('input[name="booking_slot[]"]:checked').closest('td').text().trim();
    var package_id = $('.package_id').val();
    var pay_id = $("input[name='pay_for']:checked").val();
    if(name && ic_number){
        $.ajax({
        url: "<?php echo base_url() ?>/hallbooking_online/get_payfor_collection",
        type: "POST",
        data: { id: pay_id },
        dataType: "json",
        success: function (data) {
           
            if (data.terms.length > 0) {
                var t_html = '';
                data.terms.forEach(function(value, key) {
                    var replacedValue = value.replace(/\[person_name\]/g, name).replace(/\[ic_number\]/g, ic_number).replace(/\[Address\]/g, address).replace(/\[booking_date\]/g, booking_date).replace(/\[booking_slot\]/g, booking_slot).replace(/\[entry_date\]/g, formattedDate);
                    t_html += '<div class="form-group">' +
                            '<label class="custom-checkbox">' +
                            replacedValue +
                            '<input type="checkbox" class="term-checkbox" name="terms[]" value="' + replacedValue + '">' +
                            '<span class="checkmark"></span>' +
                            '</label>' +
                            '</div>';
                });
                $('#termsModal .modal-body').html(t_html);
                $('#termsModal').modal('show');
            }
        }
    });
    } else{
        alert("Kindly fill all details");
    }
    });
    </script>

<script>
    $(document).ready(function(){

        
        console.log("Script loaded successfully");

        

        

        

        
    });
</script>
</body>

</html>