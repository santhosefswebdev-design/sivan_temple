<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--> 
<style>
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
                                <form>
                                <div class="col-md-8 det">
                                    <div class="scroll products row" >
                                        <div class="col-sm-12">
                                            <h3 style="margin-bottom:5px; margin-top:5px;">Slot Details</h3>
                                        </div>
                                        <div class="col-sm-12">
                                            <table class="table table-bordered ">
                                                <tbody>
                                                    <tr>
                                                        <?php $i=0; foreach($time_list as $row) { 
                                                            if (in_array($row['id'], $data_time)) { $disabled = "disabled"; $t_name = $time_name[$row['id']];}
                                                            else  { $disabled = ""; $t_name = ''; };
                                                        
                                                        ?>
                                                        <td>
                                                            <input style="left: 2%; opacity: 1;position: inherit;" type="radio"  <?= $disabled ?> name="timing" value="<?php echo $row['id']; ?>">
                                                            <?php echo date("g:i A", strtotime($row['name'])) .' - '.date("g:i A", strtotime($row['description'])); ?> (<?php echo $row['slot_season']?>)
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    
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
                                        <div class="col-sm-3 ">
                                            <div class="form-group form-float">
                                                <div class="form-line" style="border: none;">
                                                    <label id="pack_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
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
                                    <div class="products row">
                                        <div class="col-sm-12">
                                            <h3 style="margin-bottom:5px; margin-top:5px;">Pay Details</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" id="pay_date" value="<?php echo date('Y-m-d'); ?>">
                                                    <label class="form-label">Pay Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="number" id="pay_amt" min="0" class="form-control" step=".01"  placeholder="0.00">
                                                    <label class="form-label">Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" name="paymentmode" id="paymentmode">
                                                        <!--option value="0">Select</option-->
                                                        <?php foreach($payment_modes as $payment_mode) { ?>
                                                        <option value="<?php echo $payment_mode['id']; ?>"><?php echo $payment_mode['name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label class="form-label">Payment Mode</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group form-float">
                                                <div class="form-line" style="border: none;">
                                                    <label id="pay_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
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
                                                    <input type="text" id="total_amt" class="form-control" readonly  name="total_amt" value=0>
                                                    <label class="form-label">Total Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" id="deposite_amt" class="form-control" readonly name="deposie_amt" value="0">
                                                    <label class="form-label">Deposite RM</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
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
                                                            <input type="date" class="form-control reg_det" id="event_date" name="event_date" value="<?= $date; ?>" required readonly>
                                                            <label class="form-label">Event Date <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="event_name" value="" required>
                                                            <label class="form-label">Event Details <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="register" value="" required>
                                                            <label class="form-label">Register By <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control reg_det" name="name" value="" required>
                                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                        <label class="form-label" style="display: contents; font-size: 14px;">Status</label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option value="1">Booked</option>
                                                                <!-- <option value="2">Completed</option>
                                                                <option value="3">Cancelled</option> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                                    <select class="form-control" name="phonecode" id="phonecode">
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
                                                                    <input class="form-control reg_det" type="number" min="0" name="mobile" id="mobile" required pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" autocomplete="off">
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
                                                            <input type="text" class="form-control reg_det" name="ic_num" value="">
                                                            <label class="form-label">IC Number [optional]</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
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
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
<script>
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
                url: "<?php echo base_url();?>/hallbooking/getpack_amt",
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
                url: "<?php echo base_url();?>/hallbooking/get_service_name",
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
                if(arcat == id){
                    status_check++;
                }
            });
            if(status_check > 0)
            {
                alert("Already choosed this package please choose another package.");
            }
            else
            {
                $.ajax({
                    url: "<?php echo base_url();?>/hallbooking/get_service_list",
                    type: "post",
                    data: {id: id},
                    //dataType: "json",
                    success: function(response){
                        response = JSON.parse(response);
                        if(response.length > 0) {
                            $.each(response, function(key,value) {
                                var countid = value.id;
                                var serviceid = value.service_id;
                                var serviceamount = value.service_amount;
                                get_service_name(serviceid,countid);
                                var html = '<tr id="rmv_packrow'+countid+'">';
                                    html += '<td style="width: 20%;"><input type="hidden" readonly name="service['+countid+'][service_id]" value="'+serviceid+'"><input type="text" style="border: none;width: 100%;" readonly id="service_name_'+countid+'" name="service['+countid+'][service_name]"></td>';
                                    html += '<td style="width: 45%;"><input type="text" style="border: none;width: 100%;" id="service_description_'+countid+'" name="service['+countid+'][description]" ></td>';
                                    html += '<td style="width: 25%;"><input type="text" style="border: none;width: 100%;" class="package_amt" name="service['+countid+'][service_amt]" value="'+Number(serviceamount).toFixed(2)+'" onkeyup="serviceamount()"></td>';
                                    html += '<td style="width: 10%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack('+ countid +')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a><input type="hidden" class="package_category" value='+id+'></td>';
                                    html += '</tr>';
                                $("#package_table").append(html);
                            });
                            sum_amount();
                        }
                    }
                });
                $("#get_pack_amt").val('');
                $('#add_one').prop('selectedIndex',0);
                $("#add_one").selectpicker("refresh");
            }
        }
    });
    function rmv_pack(id){
        $("#rmv_packrow"+id).remove();
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
                    html += '<td style="width: 30%;"><input type="date" style="border: none;" readonly name="pay['+cnt+'][date]" value="'+date+'"></td>';
                    html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="pay['+cnt+'][pay_amt]" value="'+Number(amt).toFixed(2)+'"></td>';
                    html += '<td style="width: 30%!important;"><input type="hidden" style="border: none; width:100%;" readonly id="payment_mode_'+cnt+'" name="pay['+cnt+'][payment_mode]"><span id="payment_mode_label_'+cnt+'"></span></td>';
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

    function sum_amount(){
        var total = 0;
        var pay_tot = 0;
        $(".package_amt").each(function(){
           total += parseFloat($(this).val());
        });

        $(".pay_amt").each(function(){
            pay_tot += parseFloat($(this).val());
        });

        $("#total_amt").val(Number(total).toFixed(2));
        $("#deposite_amt").val(Number(pay_tot).toFixed(2));

        var balance = total - pay_tot;
        $("#balance").val(Number(balance).toFixed(2));
    }

$("#submit").click(function(){
        var pre_sts = $("#status option:selected").val();
        var total_amt       = parseFloat($("#total_amt").val());
        var deposite_amt    = parseFloat($("#deposite_amt").val());
        var balance         = parseFloat($("#balance").val());
        var check_dep       = parseFloat((total_amt / 100) * 30).toFixed(2);
        console.log(check_dep);
        if (pre_sts == 3 && deposite_amt > 0){
            $('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text("Unable to cancel Please sure remove the Pay Amount");
        }else{
        
			// if(pre_sts != 3 && deposite_amt < total_amt){
            //     $('#alert-modal').modal('show', {backdrop: 'static'});
            //     $("#spndeddelid").text("Partial Payment Not allowed. Please Pay Full Amount.");
            // }
                if(pre_sts != 3 && deposite_amt < check_dep){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text("Minimum Deposit Amount RM "+check_dep);
            }else{
                 $.ajax({
                    type:"POST",
                    url: "<?php echo base_url();?>/hallbooking/save_booking",
                    data: $("form").serialize(),
                    beforeSend: function() {    
                        $("#loader").show();
                    },
                    success:function(data)
                    {
                        //return;
                        obj = jQuery.parseJSON(data);
                        if(obj.err != ''){
                            $('#alert-modal').modal('show', {backdrop: 'static'});
                            $("#spndeddelid").text(obj.err);
                        }else{
								if ($("#print").prop('checked')==true)	
									{
										printData(obj.id);
									}
									else 
										window.location.replace("<?php echo base_url();?>/hallbooking/hallbook_list?date="+$('#event_date').val());
                            
                        }
                    },
                    complete:function(data){
                        // Hide image container
                        $("#loader").hide();
                    }
                });
            }
        }
        
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

</script>