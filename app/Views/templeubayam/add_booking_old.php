<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--> 
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
.heading { text-align:center; background:#000; color:#FFF; padding:10px; }
.products { 
	background:#FFF;
	display: flex;
    flex-wrap: wrap;
    align-items: center; }
.prod { background:#CCCCCC; padding:10px 3px; margin-top:10px; margin-bottom:10px; cursor:pointer; }
.prod img { width:30%; float:left; border-right:1px dashed #999999; }
.prod .detail { width:60%; position:relative; margin-left:40%; }
.prod .detail h4,.prod .detail h5 { font-weight:bold; }
.vl { border-left: 2px dashed #999999; height: 82%; position: absolute; left: 38%; margin-left: -3px; top: 0; bottom:0; margin-top:10px; }
.cart-table { width:100%; } 
.cart-table tr th { font-weight:normal; padding:10px;  }
.cart-table tr td { padding:10px; font-size:12px; border :none;}
.row_amt {border :none;width: 40%;}
.row_qty{border :none;width: 40%;}
.row_tot {border :none;width: 60%;}
.detail h5 { font-size:12px; }
form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 90%;
  background: #f1f1f1;
}

form.example button {
  float: left;
  width: 10%;
  padding: 10px;
  background: #000;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.example button:hover {
  background:#333333;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}
.form-group{
    margin-bottom: 0;
}
.btn-rad{
    padding: 6px !important;
    border-radius: 13% !important;
    width: 23%;
    color: #fff !important;
}
.products .smal_marg{
	padding-right: 4px;
    padding-left: 4px;
}


.time tr td, .time tr th {
    padding: 3px 7px !important;
    border: 1px solid #eee;
}
.card .body .col-xs-12, .card .body .col-sm-12, .card .body .col-md-12, .card .body .col-lg-12 {
    margin-bottom: 10px !important;
}
.card .body .col-xs-8, .card .body .col-sm-8, .card .body .col-md-8, .card .body .col-lg-8 {
    margin-bottom: 10px !important;
}
.sub tr th { padding:1px 5px !important; }
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}


</style>
<section class="content">
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
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
                            <div class="row">
                                <form id="termsForm">
                                <div class="col-md-8 det">
                                    <div class="scroll products row" >
                                        <div class="col-sm-12">
                                            <h3 style="margin-bottom:5px; margin-top:5px;">Slot Details</h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <table class="table table-bordered ">
                                                <!-- <tbody>
                                                    <?php if(empty($time_list)) { ?>
                                                        <tr id="empty-list">
                                                            <td colspan="5">No slots available.</td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <?php $i = 0; foreach($time_list as $row) { ?>
                                                                <td>
                                                                    <input style="left: 2%; opacity: 1; position: inherit;" type="radio" class="booking_slot" name="booking_slot[]" value="<?php echo $row['id']; ?>">
                                                                    <?php echo $row['slot_name']; ?>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody> -->
                                                <tbody>
                                                    <?php if(empty($time_list)) { ?>
                                                        <tr>
                                                            <td colspan="5" style="color: red; text-align: center;">Today's slot has been blocked by Management, please choose other dates.</td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <?php $i = 0; foreach($time_list as $row) { ?>           
                                                                <td>
                                                                    <input style="left: 2%; opacity: 1; position: inherit;" type="radio" class="booking_slot" name="booking_slot[]" value="<?php echo $row['id']; ?>">
                                                                    <?php echo $row['slot_name']; ?>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="scroll products row">
                                        <div class="col-sm-12">
                                            <h3 style="margin-bottom:5px; margin-top:5px;">Package Details</h3>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <!--<label class="form-lable">Package Name</label>-->
                                                    <select class="form-control" id="add_one">
                                                        <option value="">Select From</option> 
                                                        <?php foreach($package as $row) { ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 ">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="hidden" id="pack_name">
                                                    <input type="number" class="form-control" id="get_pack_amt" placeholder="0.00">
                                                    <label class="form-label">RM</label>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="booking_type" name="booking_type" value="2">
                                        <input type="hidden" id="save_booking" name="save_booking" value="1">
                                        <div class="col-sm-3 ">
                                            <div class="form-group form-float">
                                                <div class="form-line" style="border: none;">
                                                    <label id="pack_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">Success</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Package added successfully!
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="width:100%" id="package_table" style="height: 150px;">
                                                    <thead>
                                                        <tr>
                                                            <th width="20%">Name</th>
                                                            <th width="45%">Description</th>
                                                            <th width="25%">Total RM</th>
                                                            <th width="10%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" id="pack_row_count" value="0">
                                        </div>
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
                                        <div class="col-sm-3 ">
                                            <div class="form-group form-float">
                                            
                                                <div class="form-line focused">
                                                    <input type="hidden" id="pack_name_addon">
                                                    <input type="number" class="form-control" id="get_pack_amt_addon" placeholder="0.00">
                                                    <label class="form-label">RM</label>
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



                                    <div class="products row">
    <div class="col-sm-12">
        <h3 style="margin-bottom: 5px; margin-top: 5px;">Pay Details</h3>
        <label>
            <input style="left: 2%; opacity: 1;position: inherit;" type="radio" name="payment_type" value="full" checked onclick="togglePayDetails()"> Full
        </label>
        <?php /* <label>
            <input style="left: 2%; opacity: 1;position: inherit;" type="radio" name="payment_type" value="partial" onclick="togglePayDetails()"> Partial
        </label> */ ?>
    </div>
    <div class="col-sm-4 partial-payment-details">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="date" class="form-control" id="pay_date" value="<?php echo date('Y-m-d'); ?>">
                <label class="form-label">Pay Date</label>
            </div>
        </div>
    </div>
    <div class="col-sm-3 partial-payment-details">
        <div class="form-group form-float">
            <div class="form-line focused">
                <input type="number" id="pay_amt" min="0" class="form-control" step=".01" placeholder="0.00">
                <label class="form-label">Amount</label>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group form-float">
            <div class="form-line">
                <select class="form-control" name="payment_mode" id="paymentmode">
                    <!--option value="0">Select</option-->
                    <?php foreach($payment_modes as $payment_mode) { ?>
                    <option value="<?php echo $payment_mode['id']; ?>"><?php echo $payment_mode['name'];?></option>
                    <?php } ?>
                </select>
                <label class="form-label">Payment Mode</label>
            </div>
        </div>
    </div>
    <div class="col-sm-2 partial-payment-details">
        <div class="form-group form-float">
            <div class="form-line" style="border: none;">
                <label id="pay_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
            </div>
        </div>
    </div>
</div>
<div class="row scroll partial-payment-details" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table style="width:100%" class="table table-bordered" id="pay_table" style="height: 150px;">
                <thead>
                    <tr>
                        <th width="25%">Date</th>
                        <th width="25%">Total RM</th>
                        <th style="width: 30%!important;">Payment Mode</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <input type="hidden" id="pay_row_count" value="1">
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="total_amt" class="form-control" readonly name="total_amt" value=0>
                <label class="form-label">Total Amount</label>
            </div>
        </div>
    </div>
    <div class="col-sm-4 partial-payment-details">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="deposite_amt" class="form-control" readonly name="deposie_amt" value="0">
                <label class="form-label">Deposite RM</label>
            </div>
        </div>
    </div>
    <div class="col-sm-4 partial-payment-details">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" id="balance" class="form-control" readonly name="balance" value="0">
                <label class="form-label">Balance RM</label>
            </div>
        </div>
    </div>
</div>

                                </div>
                                                        
                                <div class="col-md-4 det">
                                    
                                    <div class="cart">
                                        <h3 style="margin-top:0px;">Register Details</h3>
                                        <form action="" method="post"></form>
                                            <div class="row" style="margin-top: 25px;">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="date" class="form-control reg_det" id="event_date" name="booking_date" value="<?= $date; ?>" required readonly>
                                                            <label class="form-label">Event Date <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="event_name" value="" required>
                                                            <label class="form-label">Event Details <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="register" value="" required>
                                                            <label class="form-label">Register By <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="name" id="name" value="" required>
                                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                        <label class="form-label" style="display: contents; font-size: 14px;">Status</label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option value="1">Booked</option>
                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="address" value="">
                                                            <label class="form-label">Address</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4" style="margin: 0px;">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <select class="form-control" name="mobile_code" id="phonecode">
                                                                        <?php
                                                                        if (!empty($phone_codes)) {
                                                                            foreach ($phone_codes as $phone_code) {
                                                                                ?>
                                                                        <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if ($phone_code['dailing_code'] == "+60") {
                                                                            echo "selected";
                                                                        } ?>><?php echo $phone_code['dailing_code']; ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8" style="margin: 0px;">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input class="form-control reg_det" type="number" min="0" name="mobile_no" id="mobile" required pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" autocomplete="off">
                                                                    <label class="form-label">Mobile Number <span style="color: red;">*</span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="email" value="" > 
                                                            <label class="form-label">Email ID [optional]</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="ic_number" id="ic_number" value="" required>
                                                            <label class="form-label">IC Number  <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <textarea class="form-control" id="description" name="description" style="width:100%;" autocomplete="off"></textarea>
															<label class="form-label">Remarks</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                        <label class="form-label" style="display: contents; font-size: 14px;">Commission To</label>
                                                            <select class="form-control" multiple="multiple" id="commission_to" onChange="getSelectedOptions(this)" name="commission_to[]" required>
                                                                <option value="">--Select Staff--</option>
                                                                <?php foreach($staff as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <!-- <div class="col-sm-12">
                                                    <?php foreach ($terms as $term): ?>
                                                        <div class="form-group">
                                                            <label class="custom-checkbox">
                                                                <?php echo htmlspecialchars($term); ?>
                                                                <input type="checkbox" class="term-checkbox" name="terms[]" value="<?php echo htmlspecialchars($term); ?>">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div> -->
                                                <div class="col-sm-12" style="text-align: left;color: #f44336;">
                                                    <div class="form-group">
                                                        <label for="termsLink" id="termsLabel" style="cursor: pointer;"><i class="fa fa-check-square-o" style="color:red"></i>Terms and conditions</label>
                                                    </div>
                                                </div>        

                                                <div class="col-md-12 scroll" style="overflow-y:scroll; overflow-x:hidden; height: 100px;">
                                                    <div id="commission_append_input_box"></div>
                                                </div>
                                                <div class="col-sm-3 col-md-3 col-xs-3">
                                                    <div class="form-group">
                                                        <div class="form-line" style="border: none;">
                                                            <a class="btn btn-info" onclick="history.go(-1)" style="color: #fff;" >Back</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-md-3 col-xs-3">
                                                    <div class="form-group">
                                                        <div class="form-line" style="border: none;">
                                                            <!-- <button class="btn btn-primary" id="clear">Clear</button> -->
                                                            <a class="btn btn-danger" id="clear" style="color: #fff;"  >Clear</a>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-sm-3 col-md-3 col-xs-3">
                                                    <div class="form-group">
                                                        <div class="form-line" style="border: none;">
                                                            <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
															<label for ='print'> Print &nbsp;&nbsp; </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-md-3 col-xs-3">
                                                    <div class="form-group">
                                                        <div class="form-line" style="border: none; text-align: right;">															
															<label class="btn btn-success btn-lg" id="submit">Save</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </form>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
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
                <div class="modal-body-terms">
                   <?php foreach ($terms as $term): ?>
                    <div class="form-group">
                        <label class="custom-checkbox">
                            <?php echo strip_tags($term); ?>
                            <input type="checkbox" class="term-checkbox" name="terms[]" value="<?php echo strip_tags($term); ?>">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
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
    <!-- Modal Structure -->
<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-warning h1 text-warning"></i>
                    <h4 class="mt-2">Attention!</h4>
                    <p class="mb-4">Today's slot has been blocked by Management, please choose other dates.</p>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>

</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    if ($('#empty-list').length > 0) {
        $('#alert-modal').modal('show');
    }
});
</script>

<script>

    document.getElementById('termsForm').addEventListener('submit', function(event) {
    
});
    function togglePayDetails() {
    var payType = document.querySelector('input[name="payment_type"]:checked').value;
    var partialDetails = document.querySelectorAll('.partial-payment-details');
    
    if (payType === 'full') {
        partialDetails.forEach(function(element) {
            element.style.display = 'none';
        });
        clearPartialPaymentDetails();
        recalculateBalanceFull();
    } else {
        partialDetails.forEach(function(element) {
            element.style.display = 'block';
        });
    }
}

function clearPartialPaymentDetails() {
    document.querySelector("#pay_table tbody").innerHTML = '';
    document.querySelector("#pay_row_count").value = '1';
    
    document.querySelector("#deposite_amt").value = '0';
}

function recalculateBalanceFull() {
    var totalAmount = parseFloat(document.querySelector("#total_amt").value) || 0;
    document.querySelector("#balance").value = totalAmount.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    togglePayDetails();
});


    function get_staff_commision_name(id,cmlp){
        //alert(id);
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/hallbooking/get_staff_commision_name",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    //$("#commisiion_name_"+cmlp).addClass("focused");
                    $("#commisiion_name_"+cmlp).text("Commission to "+data['name']+" * ");
                }
            });
        }
    }
    function getSelectedOptions(sel) {
        $("#commission_append_input_box").empty();
        var opts = [],
            opt;
        var length = $('#commission_to > option').length;
        for (var i = 1; i < length; i++) {
            opt = sel.options[i];
            if (opt.selected) {
                opts.push(opt);
                //alert(opt);
                //alert(i);
                //if(opt.value == i)
                //{
                    var staff_id = opt.value;
                    //alert(staff_id);
                    get_staff_commision_name(staff_id,i);
                    var html = '<div class="row" id="rmv_commins'+i+'">';
                    html += '<div class="col-md-4"><p id="commisiion_name_'+i+'"></p></div>';
                    html += '<div class="col-md-8"><input type="hidden" name="staff_additional['+i+'][id]" value="'+staff_id+'"><input type="number" min="0" step="any" style="width:100%" class="form-control" name="staff_additional['+i+'][amount]" >';
                    html += '</div>';
                    html += '</div>';
                    $("#commission_append_input_box").append(html);
               // }
            }
        }
        //return opts;
    }

        $("#clear").click(function() {
        //alert(0);
        //$("input:text").val("");
		$(".reg_det").val("");
        });

        
    $("#add_one").change(function(){
        var id = $("#add_one").val();
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/templeubayam/getpack_amt",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    console.log(data)
                    ////Number(data['amt']).toFixed(2)
                    $("#get_pack_amt").val(Number(data['amt']).toFixed(2));
                    $("#pack_name").val(data['name']);
                }
            });
        }else{
            $("#get_pack_amt").val(0);
        }
    });
    $("#add_one_addon").change(function(){
        var id = $("#add_one_addon").val();
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/templeubayam/getpack_amt_addon",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    console.log(data)
                    ////Number(data['amt']).toFixed(2)
                    $("#get_pack_amt_addon").val(Number(data['amt']).toFixed(2));
                    $("#pack_name_addon").val(data['name']);
                }
            });
        }else{
            $("#get_pack_amt_addon").val(0);
        }
    });
    function get_package_description_name(id,cmlp){
        //alert(id);
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/hallbooking/get_package_description_name",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    $("#package_description_name_"+cmlp).text(data['description']);
                }
            });
        }
    }
    function get_service_name(id,cmlp){
        //alert(id);
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/templeubayam/get_service_name",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    $("#service_name_"+cmlp).val(data['name']);
                    $("#service_description_"+cmlp).val(data['description']);
                }
            });
        }
    }
    function get_service_name_addon(id,cmlp){
        //alert(id);
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/templeubayam/get_service_name_addon",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    $("#service_name_addon_"+cmlp).val(data['name']);
                    $("#service_description_addon_"+cmlp).val(data['description']);
                }
            });
        }
    }
    $("#pack_add").click(function(){
        // alert(0);
        //var id = $("#add_one option:selected").val();
		var id = $("#add_one option:selected").val();
        var cnt = parseInt($("#pack_row_count").val());
		amt = $("#get_pack_amt").val();
		//alert(amt);
        if(id != '' && parseFloat(amt)>0){
            var status_check = 0;
            $( ".package_category").each(function() {
                arcat = parseInt($(this).val());
                // if(arcat == id){
                if(arcat){
                    status_check++;
                }
            });
            if(status_check > 0)
            {
                alert("You can choose only one package.");
                // alert("Already choosed this package please choose another package.");
            }
            else
            {
                $.ajax({
                    url: "<?php echo base_url();?>/templeubayam/get_service_list",
                    type: "post",
                    data: {id: id},
                    //dataType: "json",
                    success: function(response){
                        response = JSON.parse(response);
                        if(response.data.services.length > 0) {
                            $.each(response.data.services, function(key,value) {
                                var countid = value.id;
                                var serviceid = value.id;
                                var serviceamount = value.amount;
                                get_service_name(serviceid,countid);
                                var html = '<tr id="rmv_packrow'+countid+'">';
                                    html += '<td style="width: 20%;"><input type="hidden" readonly name="packages['+countid+'][id]" class="package_id" value="'+serviceid+'"><input type="text" style="border: none;width: 100%;" readonly id="service_name_'+countid+'"></td>';
                                    html += '<td style="width: 45%;"><input type="text" style="border: none;width: 100%;" id="service_description_'+countid+'" ></td>';
                                    html += '<td style="width: 25%;"><input type="text" style="border: none;width: 100%;" class="package_amt" value="'+Number(serviceamount).toFixed(2)+'" onkeyup="serviceamount()"></td>';
                                    html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack('+ countid +')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a><input type="hidden" class="package_category" value='+id+'></td>';
                                    html += '</tr>';
                                $("#package_table").append(html);
                            });
                            
                        }
						if(response.data.addons.length > 0){
							var a_html = '<option value="">Select From</option>';
							response.data.addons.forEach(function(value, key){
								a_html += '<option value="' + value.id + '">' + value.name + '</option>';
							});
						}else var a_html = '<option value="">No Addons Found</option>';
						$('#add_one_addon').html(a_html);
						$("#add_one_addon").selectpicker("refresh");

                        $("#package_table_addon tbody").empty();
                        $("#pack_row_count_addon").val(0);
                        sum_amount();
                    }
                });
                  $('#successModal').modal('show');
                $("#get_pack_amt").val('');
                $('#add_one').prop('selectedIndex',0);
                $("#add_one").selectpicker("refresh");
            }
        }
    });
    $("#pack_add_addon").click(function(){
		var id = $("#add_one_addon option:selected").val();
		var package_id = $('.package_id').val();
		var cnt = parseInt($("#pack_row_count_addon").val());
		amt = $("#get_pack_amt_addon").val();

		if (id != '' && parseFloat(amt) > 0) {
			var status_check = 0;
			var rowId;

			$(".package_category_addon").each(function() {
				arcat = parseInt($(this).val());
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
				$("#add_one_addon").selectpicker("refresh");
			} else {
				$.ajax({
					url: "<?php echo base_url();?>/templeubayam/get_service_list_addon",
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
								html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack_addon(' + countid + ')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a><input type="hidden" class="package_category_addon" value=' + id + '></td>';
								html += '</tr>';
								$("#package_table_addon").append(html);
							});
							sum_amount();
						}
					}
				});
				$("#get_pack_amt_addon").val('');
				$('#add_one_addon').prop('selectedIndex', 0);
				$("#add_one_addon").selectpicker("refresh");
			}
		}
	});
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
    var quantity = $("#quantity" + cnt).val();
    var unitPrice = parseFloat($("#service_name_addon_" + cnt).data('amount'));
    var totalPrice = quantity * unitPrice;
    $("#package_amt_addon_" + cnt).val(Number(totalPrice).toFixed(2));
}
    function rmv_pack(id){
        $("#rmv_packrow"+id).remove();
        sum_amount();
    }
    function rmv_pack_addon(id){
        $("#rmv_packrow_addon"+id).remove();
        sum_amount();
    }
    function serviceamount()
    {
        sum_amount(); 
    }
   
    function get_payment_mode(id,cntno){
        //alert(id);
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/hallbooking/get_payment_mode",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    $("#payment_mode_"+cntno).val(data['id']);
                    $("#payment_mode_label_"+cntno).text(data['name']);
                }
            });
        }
    }
    $("#pay_add").click(function(){
        var date = $("#pay_date").val();
        var amt = $("#pay_amt").val();
        var paymentmode = $("#paymentmode").val();  
        var cnt = parseInt($("#pay_row_count").val());
        if(date != '' && amt != 0 && paymentmode != 0){
            var total_amt = parseFloat($('#total_amt').val());
			var deposite_amt = parseFloat($('#deposite_amt').val());
			amt = parseFloat(amt);
            if(amt <= (total_amt - deposite_amt)){
                get_payment_mode(paymentmode,cnt);
                var html = '<tr id="rmv_payrow'+cnt+'">';
                    html += '<td style="width: 30%;"><input type="date" style="border: none;" readonly name="payment_details['+cnt+'][paid_date]" value="'+date+'"></td>';
                    html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="payment_details['+cnt+'][amount]" value="'+Number(amt).toFixed(2)+'"></td>';
                    html += '<td style="width: 30%!important;"><input type="hidden" style="border: none; width:100%;" readonly id="payment_mode_'+cnt+'" name="payment_details['+cnt+'][payment_mode]"><span id="payment_mode_label_'+cnt+'"></span></td>';
                    html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay('+ cnt +')" style="width:auto;"><i class="material-icons"></i></a></td>';
                    html += '</tr>';
                $("#pay_table").append(html);
                var ct = parseInt(cnt + 1);
                $("#pay_row_count").val(ct);
                sum_amount();
                $("#pay_amt").val('');
                $('#paymentmode').prop('selectedIndex',0);
                $("#paymentmode").selectpicker("refresh");
            }else{
				alert('Can\'t add deposit amount more than Total amount');
			}
        }
    });

    function rmv_pay(id){
        $("#rmv_payrow"+id).remove();
        sum_amount();
    }

    function sum_amount() {
    var total = 0;
    var pay_tot = 0;
    $(".package_amt").each(function() {
       total += parseFloat($(this).val());
    });

    $(".package_amt_addon").each(function() {
       total += parseFloat($(this).val());
    });

    $(".pay_amt").each(function() {
        pay_tot += parseFloat($(this).val());
    });

    $("#total_amt").val(Number(total).toFixed(2));
    $("#deposite_amt").val(Number(pay_tot).toFixed(2));

    var balance = total - pay_tot;
    $("#balance").val(Number(balance).toFixed(2));
}

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



	var pre_sts = $("#status option:selected").val();
	var total_amt       = parseFloat($("#total_amt").val());
	var deposite_amt    = parseFloat($("#deposite_amt").val());
	var balance         = parseFloat($("#balance").val());
	var check_dep       = parseFloat((total_amt / 100) * 30).toFixed(2);
	console.log(check_dep);
	
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


});   

$("#submit_old").click(function(){
  
	$("#loader").show();
	
});   

function printData(id) {
	$.ajax({
		url: "<?php echo base_url(); ?>/hallbooking/print_page/"+id,
		type: 'POST',
		success: function (result) {
			//console.log(result)
			popup(result);
		}
	});
}
$('#termsLabel').on('click', function(event) {
    event.preventDefault();
    var name = $("#name").val();
    var ic_number = $("#ic_number").val();
    
    if (name && ic_number) {
        // Both name and IC number are provided
        $.ajax({
            url: '<?php echo base_url(); ?>/templeubayam/get_terms',
            method: 'POST',
            data: { name: name, ic_number: ic_number },
            success: function(response) {
                if (response.success) {
                    $('.modal-body-terms').html(response.terms);
                    $('#termsModal').modal('show');
                } else {
                    alert('Failed to load terms. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    } else {
        alert('Please enter both name and IC number.');
    }
});

function popup(data)
{
	var frame1 = $('<iframe />');
	frame1[0].name = "frame1";
	frame1.css({"position": "absolute", "top": "-1000000px"});
	$("body").append(frame1);
	var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
	frameDoc.document.open();
	//Create a new HTML document.
	frameDoc.document.write('<html>');
	frameDoc.document.write('<head>');
	frameDoc.document.write('<title></title>');
	frameDoc.document.write('</head>');
	frameDoc.document.write('<body >');
	frameDoc.document.write(data);
	frameDoc.document.write('</body>');
	frameDoc.document.write('</html>');
	frameDoc.document.close();
	setTimeout(function () {
		window.frames["frame1"].focus();
		window.frames["frame1"].print();
		frame1.remove();
		window.location.reload(true);
	}, 500);

	frame1.remove();
	var dt = $('#event_date').val();
	window.location.replace("<?php echo base_url();?>/hallbooking/hallbook_list?date="+dt);
	//return true;
}
$(document).ready(function(){
	$(document).on('click', '.booking_slot', function(){
		var booking_slot = this.value;
		var booking_date = $('#event_date').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>/ajax/get_packages_list",
			data: {slot_id: booking_slot, booking_date: booking_date, package_type: 2},
			dataType: 'json',
			beforeSend: function() {    
				// $("#loader").show();
			},
			success: function(data) {
				console.log(data);
				if (data.success) {
					// console.log(data);
					if(data.data.packages.length > 0){
						var html = '<option value="">Select From</option>';
						data.data.packages.forEach(function(value, key){
							html += '<option value="' + value.id + '">' + value.name + '</option>';
						});
					}else var html = '<option value="">No Packages Found</option>';
					$('#add_one').html(html);
					$("#add_one").selectpicker("refresh");
					if(data.data.addons.length > 0){
						var a_html = '<option value="">Select From</option>';
						data.data.addons.forEach(function(value, key){
							a_html += '<option value="' + value.id + '">' + value.name + '</option>';
						});
					}else {

                        var a_html = '<option value="">No Addons Found</option>';
                        alert("This slot was not available for booking. Please choose another slot.");
                    }
					$('#add_one_addon').html(a_html);
					$("#add_one_addon").selectpicker("refresh");

                    $("#package_table tbody").empty();
                $("#pack_row_count").val(0);
                $("#package_table_addon tbody").empty();
                $("#pack_row_count_addon").val(0);
                sum_amount();
				}
			},
			error: function() {
				$('#alert-modal').modal('show', { backdrop: 'static' });
				$("#spndeddelid").text("An error occurred. Please try again later");
				$("#spndeddelid").css("color", "red");
				var html = '<option value="">No Packages Found</option>';
				$('#add_one').html(html);
				$("#add_one").selectpicker("refresh");
				var a_html = '<option value="">No Addons Found</option>';
				$('#add_one_addon').html(a_html);
				$("#add_one_addon").selectpicker("refresh");

                // $("#pack_amount").val(0);
                $("#package_table tbody").empty();
                $("#pack_row_count").val(0);
                $("#package_table_addon tbody").empty();
                $("#pack_row_count_addon").val(0);
                sum_amount();
			},
			complete: function() {
				// $("#loader").hide();
			}
		});
	});
});
</script>