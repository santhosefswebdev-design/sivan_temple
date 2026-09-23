<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
if($edit == true){
    $readonly_edit = 'readonly';
    $disable_edit = "disabled";
}
?>
<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<style>
body div .bootstrap-select.btn-group .dropdown-menu.inner {
    padding-bottom: 0px!important;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
.inputbox_valid label.error{
    margin-bottom: -17px!important;
    margin-top: 0px!important;
}
.addon-dropdown option {
        display: flex;
        justify-content: space-between;
    }

.addon-dropdown .amount-right {
    margin-left: auto;
    color: gray;
    font-size: 12px;
}
.form-control.text-center {
        text-align: center;
}
.total-amount {
    padding: 8px;
    border: none;
    background: none;
}
.highlight {
    border: 2px solid red;
}
.modal-dialog {
        max-width: 300px; /* Adjust the width as needed */
        
    }
    .highlight {
        border: 2px solid red;
    }

.bootstrap-select .dropdown-header {
    font-weight: bold;  /* Make the text bold */
    color: #333;       /* Dark color for the text */
    background-color: #eaebeb;  /* Light background to make the text stand out */
}

</style>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Annathanam<small>Annathanam / <b>Add Annathanam</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/annathanam_new"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form id="form_validation" action="" method="post">
                        <input type="hidden" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line" id="bs_datepicker_component_container">
                                            <input type="event_date" name="event_date" class="form-control" value="<?php if($view == true) echo date("d-m-Y",strtotime($data['event_date'])); else echo date("d-m-Y");?>" <?php echo $readonly; ?> <?php echo $disable_edit; ?> required>
                                            <label class="form-label">Event Date <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="margin: 0px;">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="billno"  id="billno" class="form-control" value="<?php echo !empty($data['ref_no']) ? $data['ref_no'] : $bill_no; ?>" readonly>
                                            <label class="form-label">Bill No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float inputbox_valid">
                                        <div class="form-line">
                                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> required>
                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" name="phone_code" id="phone_code" <?php echo $disable; ?>>
                                                        <option value="0">select</option>
                                                        <?php
                                                            if(!empty($phone_codes))
                                                            {
                                                                foreach($phone_codes as $phone_code)
                                                                {
                                                            ?>
                                                            <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if($phone_code['dailing_code'] == "+65"){ echo "selected";}?>><?php echo $phone_code['dailing_code']; ?></option>
                                                            <?php
                                                                }
                                                            }              
                                                        ?>
                                                    </select>
                                                    <label class="form-label">&nbsp;</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group form-float inputbox_valid">
                                                <div class="form-line">
                                                    <input type="number" min="0" name="phone_no" id="phone_no" class="form-control " value="<?php echo $data['phone_no'];?>" <?php echo $readonly; ?> >
                                                    <label class="form-label">Mobile Number <span style="color: red;">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group form-float">
                                                <div class="form-line focused" >
                                                    <input type="date" name="dob" id="dob" class="form-control" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $data['dob'];?>">
                                                    <label class="form-label ">DOB <span style="color: red;"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            Time : 
                                        </div>
                                        <div class="col-md-5">
                                            <input type="checkbox" id="breakfast" name="time" value="Breakfast" class="check_time" <?php if($data['slot_time'] == "Breakfast"){ echo "checked"; } ?> <?php echo $disable; ?> >
									        <label for ='breakfast'> Breakfast &nbsp;&nbsp; </label>
                                            <input type="checkbox" id="lunch" name="time" value="Lunch" class="check_time" <?php if($data['slot_time'] == "Lunch"){ echo "checked"; } ?> <?php echo $disable; ?>>
									        <label for ='lunch'> Lunch &nbsp;&nbsp; </label>
                                            <input type="checkbox" id="dinner" name="time" value="Dinner" class="check_time" <?php if($data['slot_time'] == "Dinner"){ echo "checked"; } ?> <?php echo $disable; ?>>
									        <label for ='dinner'> Dinner &nbsp;&nbsp; </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-1">
                                    <div class="form-check" style="margin-top:15px;">
                                        <input class="form-check-input" id="special" name="special" type="checkbox" value="1">
                                        <label class="form-check-label" for="special">Special</label>
                                    </div>
                                </div> -->
                                <!-- <div class="col-sm-5">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="package_id" id="package_id" required onchange="fetchItemsByPackageId(this.value); updatePackageAmount(this)">
                                                <option value="">--select Annathanam Package --</option>
                                                <?php if(count($packages) > 0) { ?>
                                                    <?php foreach($packages as $pack) { ?>
                                                        <option value="<?php echo $pack['id']; ?>" data-amount="<?php echo $pack['amount']; ?>" <?php if($data['package_id'] == $pack['id']){ echo "selected"; } ?> ><?php echo $pack['name_eng'].' / '.$pack['name_tamil']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="package_id" id="package_id" required onchange="packageChanged(this)">
                                                <option value="">--select Annathanam Package--</option>
                                                <?php if (count($packages) > 0): ?>
                                                    <?php foreach ($packages as $pack): ?>
                                                        <option value="<?php echo $pack['id']; ?>" data-amount="<?php echo $pack['amount']; ?>" data-view="<?php echo $pack['view']; ?>" <?php echo ($data['package_id'] == $pack['id']) ? "selected" : ""; ?>> 
                                                            <?php echo $pack['name_eng'] . ' / ' . $pack['name_tamil']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="package_name" id="package_name" value="">
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" id="amount" min="0" step="any" name="amount" class="form-control amount" readonly value="<?php echo !empty($data['amount']) ? $data['amount'] : "0.00"; ?>">
                                            <label class="form-label">Package amount per pax</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="number" id="no_of_pax" min="30" name="no_of_pax" class="form-control" value="<?php echo !empty($data['no_of_pax']) ? $data['no_of_pax'] : ""; ?>" <?php echo $readonly; ?> required placeholder="0" oninput="calculateTotalAmount()">
                                            <label class="form-label">No of Pax (*Minimum 30 pax)<span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-md-12">&nbsp;</div> 
                                <h3>Annathanam Items<small><b></b></small></h3>
                                <?php if($view != true) { ?>  
                                    <div class="row clearfix">
                                        <div class="col-sm-5">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" id="annathanamDropdown">
                                                        <option value="">-- Select Service --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" align="left">
                                            <div class="form-group form-float">
                                                <a class="btn btn-info" id="add_annathanam_item" onclick="addAnnathanamItem()">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row" style="">
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table" id="annathanam_items_table" style="background: #fff; border: none; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">S.no</th>
                                                        <th width="70%">Service</th>
                                                        <th width="20%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    Items will be dynamically added here
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" id="pack_items" name="pack_items">
                                    </div>
                                </div> -->

                                
                                <div class="row" style="">
                                    <div class="col-sm-8">
                                    <h3>Annathanam Items<small><b></b></small></h3>
                                        <div class="table-responsive">
                                            <table class="table" id="annathanam_items_table" style="background: #fff; border: none; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">S.no</th>
                                                        <th width="50%">Items</th>
                                                        <th width="40%">Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Items will be dynamically added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" id="pack_items" name="pack_items">
                                    </div>
                                </div>

                                <div class="annathanam_special_items" style="display: none;">
                                    <div class="col-md-12">&nbsp;</div> 
                                    <h3>Annathanam Special Items<small><b></b></small></h3>
                                    <?php if($view != true) { ?>  
                                        <div class="row clearfix">
                                            <div class="col-sm-5">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" id="special_dropdown">
                                                            <option value="">-- Select Service --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2" align="left">
                                                <div class="form-group form-float">
                                                    <a class="btn btn-info" id="add_special_item">Add</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row" style="">
                                        <div class="col-sm-8">
                                            <div class="table-responsive">
                                                <table class="table" id="annathanam_special_table" style="background: #fff; border: none; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">S.no</th>
                                                            <th width="20%">Type</th>
                                                            <th width="30%">Service</th>
                                                            <th width="10%">Amount</th>
                                                            <th width="10%">Quantity</th>
                                                            <th width="10%">Total</th>
                                                            <th width="10%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Items will be dynamically added here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" id="special_items" name="special_items">
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <h3>Annathanam Add-on Items<small><b></b></small></h3>
                                <?php if($view != true) { ?>
                                    <div class="row clearfix">
                                        <div class="col-sm-5">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control addon-dropdown" id="annathanamAddonDropdown">                                            
                                                        <option value="">-- Select Service --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" align="left">
                                            <div class="form-group form-float">
                                                <a class="btn btn-info" id="add_annathanam_addon" onclick="addAnnathanamAddonItem()">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row" style="">
                                    <div class="col-sm-8">
                                        <div class="table-responsive">
                                            <table class="table" id="annathanam_addon_items_table" style="background: #fff; border: none; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">S.no</th>
                                                        <th width="30%">Addon</th>
                                                        <th width="15%">Quantity</th>
                                                        <th width="15%">Item Amount</th>
                                                        <th width="15%">Item Total</th>
                                                        <th width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Addon items will be dynamically added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" id="addon_pack_items" name="addon_pack_items" value="">
                                    </div>
                                </div>

                                <hr>
                                <div class="col-md-12"<?php if(!empty($setting['annathanam_discount'])){ echo ' style="display: block;"'; }else echo ' style="display: none;"'; ?>>
                                    <div style="display: flex; gap: 20px; align-items: center;">
                                        <!-- <div>
                                            <h5 style="text-align: center; margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#17a2b8;">Annathanam Amount</h5>
                                            <input style="text-align: center" type="number" min="0" step="any" id="sub_total" class="form-control" name="sub_total" value="0" readonly>
                                        </div> -->

                                        <div>
                                            <h5 style="text-align: center; margin-bottom:5px; margin-top:5px; color:#FFFFFF; background:#17a2b8;">Discount</h5>
                                            <input style="text-align: center" type="number" min="0" step="any" id="discount_amount" class="form-control" name="discount_amount" value="0">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="total_amount_hidden" id="total_amount_hidden" min="0" step=".01" class="form-control" value="0.00" readonly>

                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" min="0" id="total_amount" name="total_amount" class="form-control" step="any"  value="<?php echo !empty($data['total_amount']) ? $data['total_amount'] : "0.00"; ?>" readonly>
                                            <label class="form-label">Total Amount </label>
                                        </div>
                                    </div>
                                </div>
							</div>
                            
							
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="radio" name="payment_type" id="payment_type_2" class="payment_type" value="full" 
                                            <?php echo (empty($data['payment_type']) || $data['payment_type'] == 'full') ? 'checked' : ''; ?>>  
                                        <label for="payment_type_2" class="pay-label">Full Payment</label>  

                                        <input type="radio" name="payment_type" id="payment_type_1" class="payment_type" value="partial" 
                                            <?php echo ($data['payment_type'] == 'partial') ? 'checked' : ''; ?>>  
                                        <label for="payment_type_1" class="pay-label">Partial Payment</label>
                                    </div>
                                </div>
                                <div class="col-sm-4 partial_paid_sec" style="<?php echo (!empty($data['payment_type']) && $data['payment_type'] == 'partial') ? '' : 'display: none;'; ?>">
                                    <label class="form-label">Paid Amount</label>
                                    <input type="number" name="paid_amount" id="paid_amount" step=".01" class="form-control" value="<?php echo htmlspecialchars($data['paid_amount'] ?? '0.00'); ?>">
                                </div>
                            </div>

							<div class="row clearfix">
								<div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <select class="form-control" name="payment_mode" id="payment_mode" <?php echo $disable; ?> <?php echo $disable_edit; ?> required>
                                                <option value="">Select</option>
                                                <?php foreach($payment_modes as $payment_mode) { ?>
                                                <option value="<?php echo $payment_mode['id']; ?>" <?php if(!empty($booked_payment_mode['payment_mode_id'])){ if($booked_payment_mode['payment_mode_id'] == $payment_mode['id']){ echo "selected"; } } ?>><?php echo $payment_mode['name'];?></option>
                                                <?php } ?>
                                            </select>
                                            <label class="form-label">Paymentmode <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <?php if($view != true) { ?>
                                    <div class="col-sm-6" align="right">
                                        <button type="submit" id="saveButton" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                    </div>
                                    <div class="col-sm-6" align="left">
                                        <button type="button" id="clear_all" class="btn btn-success btn-lg waves-effect">Clear All</button>
                                    </div>
                                <?php } ?>
							</div>
                        </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
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

    <!-- Modal -->
    <div class="modal fade" id="validationModal" tabindex="-1" role="dialog" aria-labelledby="validationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="validationModalLabel" style="Text-align:center">Attention here!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="validationModalBody" style="Text-align:center; font-size: 16px;">
                    <!-- Validation messages will be inserted here -->
                </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div> -->
            </div>
        </div>
    </div>

    </section>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

<!-- Load Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
.bal_amnt_div{
	display: none;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
$(document).ready(function () {
        $("#clear_all").click(function () {
            $("input").val("");
            $("select").each(function () {
                $(this).prop("selectedIndex", 0); // Reset to the first option
            });
            $("#annathanam_items_table tbody").empty();
            $("#annathanam_addon_items_table tbody").empty();
            $("#package_name").val("");
            $("input[type='checkbox'], input[type='radio']").prop("checked", false);
        });
    });
</script>


<script>
    // $('#special').change(function() {
    //     if ($(this).is(':checked')) {
    //         $('#package_id').closest('.col-sm-5').hide();
    //         $('#amount').closest('.col-sm-2').hide();
    //         $('#annathanam_items_table').closest('.col-sm-8').hide();
    //         $('.annathanam_special_items').show();
    //         $('#package_id').removeAttr('required').hide();
    //         fetchSpecialItems();
    //         fetchAddonItems();
    //     } else {
    //         $('#package_id').closest('.col-sm-5').show();
    //         $('#amount').closest('.col-sm-2').show();
    //         $('#annathanam_items_table').closest('.col-sm-8').show();
    //         $('.annathanam_special_items').hide();
    //     }
    // });

    function packageChanged(element) {
        var selectedOption = $(element).find('option:selected');
        var packageId = selectedOption.val();
        var packageView = selectedOption.data('view');
        var packageName = selectedOption.text().trim();
        var englishName = packageName.split('/')[0].trim();
        //console.log('Package name:', englishName);

        $('#package_name').val(englishName);

        if (packageView == '0') {
            $('#no_of_pax').closest('.col-sm-4').hide();
            $('#amount').closest('.col-sm-2').hide();
            $('#annathanam_items_table').closest('.col-sm-8').hide();
            $('.annathanam_special_items').show();
            fetchSpecialItems();
            fetchAddonItems();
        } else {
            $('#amount').closest('.col-sm-2').show();
            $('#annathanam_items_table').closest('.col-sm-8').show();
            $('.annathanam_special_items').hide();
            if (packageId) {
                fetchItemsByPackageId(packageId);
                updatePackageAmount(element);
            }
        }
    }

    function fetchSpecialItems() {
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_new/get_special_items',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var $dropdown = $('#special_dropdown');
                $dropdown.empty().append('<option value="">-- Select Service --</option>'); 

                $.each(data, function(typeName, typeData) {
                    var $group = $('<optgroup>', {
                        label: typeName,
                        style: "font-weight: bold"
                    });

                    $.each(typeData.items, function(index, item) {
                        $group.append($('<option>', {
                            value: item.id,
                            text: item.name_eng + ' / ' + item.name_tamil,
                            'data-amount': item.amount,
                            'data-type-id': item.type_id
                        }));
                    });

                    $dropdown.append($group);
                    $("#special_dropdown").selectpicker("refresh"); // Refresh the select picker if you're using Bootstrap-select
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching special items: ' + textStatus);
            }
        });
    }


function fetchAddonItems() {
    
    $.ajax({
        url: '<?php echo base_url(); ?>/annathanam_new/get_addon_items',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('received addon data:', response);
            updateAddonItemsDropdown(response);
        },
        error: function(error) {
            console.log('Error fetching items:', error);
        }
    });
}
</script>

<script>
    $(document).ready(function() {
        function addItemToTable(itemName, itemId, type, typeId, amount) {
            const noOfPax = $('#no_of_pax').val() || 30; // Default to 1 if no_of_pax is empty
            const totalAmount = amount * noOfPax;
            const rowCount = $('#annathanam_special_table tbody tr').length + 1;

            const rowHtml = `
                <tr data-item-id="${itemId}" data-type-id="${typeId}">
                    <td>${rowCount}</td>
                    <td>${type}</td>
                    <td>${itemName}</td>
                    <td>${parseFloat(amount).toFixed(2)}</td>
                    <td><input type="number" class="form-control item-quantity" value="${noOfPax}" min="30" data-price="${amount}"></td>
                    <td class="item-total">${totalAmount.toFixed(2)}</td>
                    <td><button class="btn btn-danger remove-item">X</button></td>
                </tr>`;

            $('#annathanam_special_table tbody').append(rowHtml);
            updateTotalAmount(totalAmount, 'add');
            updateSpecialItems()
        }

        $('#add_special_item').click(function() {
            const selectedOption = $('#special_dropdown option:selected');
            const itemId = selectedOption.val();
            const itemName = selectedOption.text();
            const typeLabel = selectedOption.closest('optgroup').attr('label');
            const typeId = selectedOption.data('type-id'); // Assuming type ID is stored as a data attribute on the option
            const amount = parseFloat(selectedOption.data('amount')); // Ensure this is a number

            if (itemId) {
                addItemToTable(itemName, itemId, typeLabel, typeId, amount);
            } else {
                alert('Please select an item to add.');
            }
        });

        $('#annathanam_special_table').on('input', '.item-quantity', function() {
            const row = $(this).closest('tr');
            const oldTotal = parseFloat(row.find('.item-total').text()); // Fetch the old total
            const quantity = $(this).val();
            const price = parseFloat($(this).data('price'));
            const newTotal = quantity * price;
            row.find('.item-total').text(newTotal.toFixed(2));
            row.data('total', newTotal); // Update the data attribute
            updateTotalAmount(newTotal, 'update');
            updateSpecialItems()
        });

        $('#annathanam_special_table').on('click', '.remove-item', function() {
            const row = $(this).closest('tr');
            const total = parseFloat(row.find('.item-total').text()); // Fetch the current total directly from the text
            updateTotalAmount(total, 'remove');
            row.remove();
            updateSpecialItems();
        });

    });

    // function updateSpecialItems() {
    //     console.log('update special item function called');
    //     var table = document.getElementById('annathanam_special_table').getElementsByTagName('tbody')[0];
    //     var specialItems = [];
    //     for (var i = 0, row; row = table.rows[i]; i++) {
    //         var itemId = row.cells[0].getElementsByTagName('input')[0].value; // Assuming the first cell now has a hidden input storing type ID
    //         var typeId = row.cells[1].getElementsByTagName('input')[0].value; // Assuming you store typeId here
    //         var typeLabel = row.cells[1].innerText.trim(); // Textual representation
    //         var itemName = row.cells[2].innerText; // Service
    //         var amount = parseFloat(row.cells[3].innerText); // Amount
    //         var quantity = row.cells[4].getElementsByTagName('input')[0].value; // Quantity
    //         var total = parseFloat(row.cells[5].innerText); // Total

    //         var item = {
    //             item_id: itemId,
    //             type_id: typeId,  
    //             amount: amount,
    //             quantity: quantity,
    //             total: total
    //         };

    //         specialItems.push(item);
    //     }
    //     var specialItemsJSON = JSON.stringify(specialItems);
    //     console.log("SpecialItemsJSON: ", specialItemsJSON); // Debug log
    //     document.getElementById('special_items').value = specialItemsJSON;
    // }

    function updateSpecialItems() {
        var table = document.getElementById('annathanam_special_table').getElementsByTagName('tbody')[0];
        var specialItems = [];
        for (var i = 0, row; row = table.rows[i]; i++) {
            var itemId = $(row).data('item-id');  // Use jQuery to access data attributes
            var typeId = $(row).data('type-id');
            var type = row.cells[1].innerText;
            var itemName = row.cells[2].innerText;
            var amount = parseFloat(row.cells[3].innerText);
            var quantity = parseInt(row.cells[4].getElementsByTagName('input')[0].value, 10);
            var total = parseFloat(row.cells[5].innerText);

            var item = {
                item_id: itemId,
                type_id: typeId,
                //type: type,
                //item_name: itemName,
                amount: amount,
                quantity: quantity,
                total: total
            };

            specialItems.push(item);
        }
        var specialItemsJSON = JSON.stringify(specialItems);
        console.log("SpecialItemsJSON: ", specialItemsJSON);
        document.getElementById('special_items').value = specialItemsJSON;
    }

</script>

<script>

    function updatePackageAmount(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var packageAmount = selectedOption.getAttribute('data-amount');
    
        document.getElementById('amount').value = packageAmount;
        calculateTotalAmount();  // Example: Recalculate total amount based on the new package amount
    }


    function calculateTotalAmount() {
        var packageAmount = parseFloat(document.getElementById('amount').value);
        var noOfPax = parseInt(document.getElementById('no_of_pax').value);
        if (isNaN(noOfPax) || noOfPax < 30) {
            noOfPax = 0;
        }
        var totalAmount = packageAmount * noOfPax;
        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        document.getElementById('total_amount_hidden').value = totalAmount.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        updatePackageAmount();
    });
</script>

<script>
    var items = <?php echo json_encode($items); ?>;
    var addon_items = <?php echo json_encode($addon_items); ?>;

    function populateItemsTable(items) {
        var itemsTable = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
        itemsTable.innerHTML = ''; // Clear existing rows

        items.forEach(function(item, index) {
            var row = itemsTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            var itemName = (item.name_eng || '') + ' / ' + (item.name_tamil || '');

            cell1.innerHTML = index + 1;
            cell2.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + (item.item_id || '') + '","add_on":0}\'> ' + itemName;
            //cell3.innerHTML = '<a onclick="removeAnnathanamItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>';
        });
    }

    function populateAddonItemsTable(addonItems) {
        var addonItemsTable = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
        addonItemsTable.innerHTML = ''; // Clear existing rows

        addonItems.forEach(function(addonItem, index) {
            var row = addonItemsTable.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            var addonItemName = (addonItem.name_eng || '') + ' / ' + (addonItem.name_tamil || '');

            cell1.innerHTML = index + 1;
            cell2.innerHTML = `<input type="hidden" value="${addonItem.item_id}">` + addonItemName;
            cell3.innerHTML = `<input type="number" class="form-control text-center" value="${parseFloat(addonItem.item_amount).toFixed(2)}" onchange="updateItemTotalAmount(this, ${index})">`;
            cell4.innerHTML = `<input type="number" class="form-control total-amount" value="${parseFloat(addonItem.item_total_amount).toFixed(2)}" readonly>`;
            //cell5.innerHTML = `<a onclick="removeAnnathanamAddonItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>`;
        });
    }

    function loadDataFromBackend(items, addonItems) {
        if (items && items.length > 0) {
            populateItemsTable(items);
        }

        if (addonItems && addonItems.length > 0) {
            populateAddonItemsTable(addonItems);
        }
    }

    loadDataFromBackend(items, addon_items);
</script>

<script>

$('#discount_amount').on('change input blur', function(){
		sum_total();
	});

function fetchItemsByPackageId(packageId) {
    if (packageId) {
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_new/get_items_by_package_id/' + packageId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('received data:', response);
                // updateItemsDropdown(response);
                // updateAddonItemsDropdown(response);
                //updateItemsDropdown(response.items, response.package_details.veg_count);
                updateItemsTable(response.items)
                updateAddonItemsDropdown(response.items);
            },
            error: function(error) {
                console.log('Error fetching items:', error);
            }
        });
    }
}


// function updateItemsDropdown(items, vegCount) {
//     var itemsDropdown = document.getElementById('annathanamDropdown');
//     itemsDropdown.innerHTML = '<option value="">-- Select Service --</option>';

//     items.forEach(function(item) {
//         if (item.add_on == 0 && item.add_veg != 1) {
//             itemsDropdown.innerHTML += '<option value="' + item.id + '">' + item.name_eng + ' / ' + item.name_tamil + '</option>';
//         }
//     });

//     var vegItems = items.filter(function(item) {
//         return item.add_on == 0 && item.add_veg == 1;
//     });

//     if (vegItems.length > 0) {
//         itemsDropdown.innerHTML += '<option disabled class="dropdown-header">Vegetables (select any ' + vegCount + ')</option>';
        
//         vegItems.forEach(function(item) {
//             itemsDropdown.innerHTML += '<option value="' + item.id + '">' + item.name_eng + ' / ' + item.name_tamil + '</option>';
//         });
//     }
//     $("#annathanamDropdown").selectpicker("refresh");
// }

function updateItemsTable(items) {
    var itemsTableBody = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    itemsTableBody.innerHTML = ''; // Clear existing entries

    var serialNumber = 1;
    items.forEach(function(item) {
        if (item.add_on == 0) { // Assuming you want to filter out add-on items
            var row = itemsTableBody.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.innerHTML = serialNumber++; // S.no
            cell2.innerHTML = `<input type="hidden" value="${item.id}">${item.name_eng} / ${item.name_tamil}`; // Items with hidden input for ID
            cell3.innerHTML = item.description || "N/A"; // Description - assuming description is a property, or default to "N/A"
        }
    });
    updatePackItems()

}


function updateAddonItemsDropdown(items) {
    var addonItemsDropdown = document.getElementById('annathanamAddonDropdown');
    addonItemsDropdown.innerHTML = '<option value="">-- Select Addon --</option>';
    
    items.forEach(function(item) {
        if (item.add_on == 1) {
            addonItemsDropdown.innerHTML += '<option value="' + item.id + '" data-amount="' + item.amount + '">' + item.name_eng + ' / ' + item.name_tamil + '</option>';
        }
    });
    $("#annathanamAddonDropdown").selectpicker("refresh");
}

var itemCount = <?php echo !empty($items) ? count($items) : 0; ?>;
var addonItemCount = <?php echo !empty($items) ? count($items) : 0; ?>;

function getItemNameById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].name;
        }
    }
    return null;
}

function getItemAmountById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].amount;
        }
    }
    return null;
}

function isItemInTable(itemId, tableId) {
    var table = document.getElementById(tableId);
    return Array.from(table.querySelectorAll('input[type="hidden"]')).some(input => {
        let itemData = JSON.parse(input.value);
        return itemData.item_id == itemId;
    });
}

function showValidationModal(messages) {
    var modalBody = document.getElementById('validationModalBody');
    modalBody.innerHTML = messages.join('<br>');
    $('#validationModal').modal('show');
}

function addAnnathanamItem() {
    var packageSelect = document.getElementById('package_id');
    var noOfPaxInput = document.getElementById('no_of_pax');
    var selectedPackageId = packageSelect.value;
    var noOfPax = noOfPaxInput.value;
    var select = document.getElementById('annathanamDropdown');
    var selectedItemId = select.value;
    var selectedText = select.options[select.selectedIndex].text;

    if (!selectedPackageId) {
        showValidationModal(["Please select a package."]);
        packageSelect.classList.add('highlight');
        return;
    } else {
        packageSelect.classList.remove('highlight');
    }

    if (!noOfPax || noOfPax < 30) {
        showValidationModal(["Please enter the number of pax (minimum 30)."]);
        noOfPaxInput.classList.add('highlight');
        return;
    } else {
        noOfPaxInput.classList.remove('highlight');
    }

    if (selectedItemId && !isItemInTable(selectedItemId, 'annathanam_items_table')) {
        var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);

        cell1.innerHTML = table.rows.length;
        cell2.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + selectedItemId + '","add_on":0}\'> ' + selectedText;
        cell3.innerHTML = '<a onclick="removeAnnathanamItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>';

        itemCount++;
        updatePackItems();
        select.selectedIndex = 0;
    } else {
        showValidationModal(["This item is already added."]);
    }
}

function removeAnnathanamItem(rowId) {
    var row = document.getElementById(rowId);
    row.parentNode.removeChild(row);
    updatePackItems();
    updateSno('annathanam_items_table');
}

function updatePackItems() {
    var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[1].getElementsByTagName('input')[0].value;
        var itemObject = {
            item_id: itemId,
            add_on: 0  // If needed, you can dynamically set this based on some row data
        };
        items.push(itemObject);
    }
    var itemsJSON = JSON.stringify(items);
    document.getElementById('pack_items').value = itemsJSON;
}

// function addAnnathanamAddonItem() {
//     console.log("addAnnathanamAddonItem function called"); // Debug log
//     var packageSelect = document.getElementById('package_id');
//     var noOfPaxInput = document.getElementById('no_of_pax');
//     var selectedPackageId = packageSelect.value;
//     var noOfPax = noOfPaxInput.value;

//     var select = document.getElementById('annathanamAddonDropdown');
//     var selectedItemId = select.value;
//     var selectedText = select.options[select.selectedIndex].text;
//     var itemAmount = parseFloat(select.options[select.selectedIndex].getAttribute('data-amount'));
//     var noOfPax = parseInt(document.getElementById('no_of_pax').value || 0);
//     var totalAmount = itemAmount * noOfPax;

//     if (!selectedPackageId) {
//         showValidationModal(["Please select a package."]);
//         packageSelect.classList.add('highlight');
//         return;
//     } else {
//         packageSelect.classList.remove('highlight');
//     }

//     if (!noOfPax || noOfPax < 50) {
//         showValidationModal(["Please enter the number of pax (minimum 50)."]);
//         noOfPaxInput.classList.add('highlight');
//         return;
//     } else {
//         noOfPaxInput.classList.remove('highlight');
//     }

//     if (selectedItemId && !isItemInTable(selectedItemId, 'annathanam_addon_items_table')) {
//         var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
//         var row = table.insertRow(-1);
//         var cell1 = row.insertCell(0);
//         var cell2 = row.insertCell(1);
//         var cell3 = row.insertCell(2);
//         var cell4 = row.insertCell(3);
//         var cell5 = row.insertCell(4);

//         cell1.innerHTML = table.rows.length;
//         cell2.innerHTML = `<input type="hidden" value="${selectedItemId}">` + selectedText;
//         cell3.innerHTML = `<input type="number" class="form-control text-center" value="${itemAmount.toFixed(2)}" onchange="updateItemTotalAmount(this, ${table.rows.length})">`;
//         cell4.innerHTML = `<input type="number" class="form-control total-amount" value="${totalAmount.toFixed(2)}" readonly>`;
//         cell5.innerHTML = `<a onclick="removeAnnathanamAddonItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>`;


//         cell3.querySelector('input').addEventListener('input', function() {
//             updateItemTotalAmount(this, table.rows.length - 1);
//         });

//         updateTotalAmount(totalAmount, 'add');
//         select.selectedIndex = 0;
//         updateAddonPackItems(); // Call to update hidden field after adding item
//     } else {
//         alert("This addon is already added or not selected.");
//     }
// }

function addAnnathanamAddonItem() {
    console.log("addAnnathanamAddonItem function called"); // Debug log
    var packageSelect = document.getElementById('package_id');
    var noOfPaxInput = document.getElementById('no_of_pax');
    var selectedPackageId = packageSelect.value;
    var noOfPax = parseInt(noOfPaxInput.value || 30);

    var select = document.getElementById('annathanamAddonDropdown');
    var selectedItemId = select.value;
    var selectedText = select.options[select.selectedIndex].text;
    var itemAmount = parseFloat(select.options[select.selectedIndex].getAttribute('data-amount'));
    var totalAmount = itemAmount * noOfPax;

    // if (!selectedPackageId) {
    //     showValidationModal(["Please select a package."]);
    //     packageSelect.classList.add('highlight');
    //     return;
    // } else {
    //     packageSelect.classList.remove('highlight');
    // }

    // if (!noOfPax || noOfPax < 50) {
    //     showValidationModal(["Please enter the number of pax (minimum 50)."]);
    //     noOfPaxInput.classList.add('highlight');
    //     return;
    // } else {
    //     noOfPaxInput.classList.remove('highlight');
    // }

    if (selectedItemId && !isItemInTable(selectedItemId, 'annathanam_addon_items_table')) {
        var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);

        cell1.innerHTML = table.rows.length;
        cell2.innerHTML = `<input type="hidden" value="${selectedItemId}">` + selectedText;
        cell3.innerHTML = `<input type="number" class="form-control text-center quantity-input" value="${noOfPax}" min="30" oninput="updateItemAndTotalAmounts(this)">`;
        cell4.innerHTML = `<input type="number" class="form-control text-center" value="${itemAmount.toFixed(2)}" oninput="updateItemAndTotalAmounts(this)">`;
        cell5.innerHTML = `<input type="number" class="form-control total-amount" value="${totalAmount.toFixed(2)}" readonly>`;
        cell6.innerHTML = `<a onclick="removeAnnathanamAddonItem(this.parentElement.parentElement)" class="btn btn-danger">Remove</a>`;

        updateTotalAmount(totalAmount, 'add'); // Update the total amount
        select.selectedIndex = 0; // Reset the dropdown
        updateAddonPackItems(); // Update hidden field after adding item
    } else {
        alert("This addon is already added or not selected.");
    }
}

// function removeAnnathanamAddonItem(row) {
//     var totalAmount = parseFloat(row.cells[3].querySelector('.total-amount').value);
//     var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    
//     table.removeChild(row);
//     updateTotalAmount(totalAmount, 'remove');
//     updateSno('annathanam_addon_items_table');
// }

function removeAnnathanamAddonItem(rowElement) {
    var totalCell = rowElement.cells[4].querySelector('input');
    var amountToRemove = parseFloat(totalCell.value) || 0; // Get the total amount from the row to be removed
    updateTotalAmount(amountToRemove, 'remove'); // Subtract this amount from the overall total

    rowElement.parentNode.removeChild(rowElement);
    updateSno('annathanam_addon_items_table'); 
}


function updateAddonPackItems() {
    var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[1].querySelector('input').value; // Correct extraction of item_id
        var itemQuantity = row.cells[2].querySelector('input').value; 
        var itemAmount = row.cells[3].querySelector('input').value; // Correct extraction of item_amount
        var itemTotalAmount = row.cells[4].querySelector('input').value; // Correct extraction of item_total_amount
        items.push({
            item_id: itemId,
            item_quantity: itemQuantity,
            item_amount: parseFloat(itemAmount),
            item_total_amount: parseFloat(itemTotalAmount),
            add_on: 1
        });
    }
    var addonItemsJSON = JSON.stringify(items);
    console.log('Addon items:', addonItemsJSON)
    document.getElementById('addon_pack_items').value = addonItemsJSON;
}

// function updateItemTotalAmount(input, rowIndex) {
//     var noOfPax = parseInt(document.getElementById('no_of_pax').value || '0');
//     var newAmount = parseFloat(input.value || 0);
//     var row = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0].rows[rowIndex];
//     var totalCell = row.cells[3].querySelector('.total-amount');
//     var oldTotal = parseFloat(totalCell.value);
//     var newTotal = newAmount * noOfPax;

//     totalCell.value = newTotal.toFixed(2);
//     updateTotalAmount(newTotal - oldTotal, 'update');
//     updateAddonPackItems(); // Ensure the hidden field is updated
// }

function updateItemAndTotalAmounts(inputElement) {
    var row = inputElement.closest('tr'); // Get the closest row to the input element
    var quantityInput = row.cells[2].querySelector('input'); // Quantity input
    var priceInput = row.cells[3].querySelector('input'); // Price input
    var totalCell = row.cells[4].querySelector('input'); // Total amount input

    var oldTotal = parseFloat(totalCell.value) || 0; // Current total of the row before update
    var quantity = parseInt(quantityInput.value) || 0; // Parse quantity, default to 0
    var price = parseFloat(priceInput.value) || 0; // Parse price, default to 0
    var newTotal = quantity * price; // Calculate the new total

    totalCell.value = newTotal.toFixed(2); // Set the new total for the row

    var totalDifference = newTotal - oldTotal; // Calculate the difference to adjust the overall total
    updateTotalAmount(totalDifference, 'update');
}

function updateTotalAmount(newAmount, action, oldAmount = 0) {
    var totalAmountField = document.getElementById('total_amount');
    var currentTotal = parseFloat(totalAmountField.value) || 0;
    console.log('old amount:', oldAmount);

    if (action === 'add') {
        totalAmountField.value = (currentTotal + newAmount).toFixed(2);
    } else if (action === 'remove') {
        totalAmountField.value = (currentTotal - newAmount).toFixed(2);
    } else if (action === 'update') {
        totalAmountField.value = (currentTotal - oldAmount + newAmount).toFixed(2);
    }
    sum_total() 
}

function updateSno(tableId) {
    var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
    var i = 0;
    Array.from(table.rows).forEach(row => {
        row.cells[0].innerText = ++i;
    });
}

document.addEventListener('DOMContentLoaded', function () {
    updatePackItems();
    updateAddonPackItems();
});

// function sum_total() {

//     var totalAmount = 0;
//     var totalAmountField = 0;
//     $('#annathanam_addon_items_table .total-amount').each(function () {
//         totalAmount += parseFloat($(this).val() || 0); // Sum up the values
//     });
//     var discount = parseFloat($('#discount_amount').val()) || 0;
//     var totalAmountFields = parseFloat($('#total_amount_hidden').val()) || 0;
//     totalAmountField = (totalAmountFields + totalAmount - discount).toFixed(2);
//     document.getElementById('total_amount').value = totalAmountField;
//     $(".tot_amt_txt").text(totalAmountField.toFixed(2));
// }


function sum_total() {
    var totalAmount = 0;

    // Sum up the values from .total-amount fields
    $('#annathanam_addon_items_table .total-amount').each(function () {
        totalAmount += parseFloat($(this).val()) || 0; // Add 0 if value is invalid
    });

    // Get the discount amount, default to 0 if invalid
    var discount = parseFloat($('#discount_amount').val()) || 0;

    // Get the hidden total amount, default to 0 if invalid
    var totalAmountFields = parseFloat($('#total_amount_hidden').val()) || 0;

    // Calculate totalAmountField
    var totalAmountField = (totalAmountFields + totalAmount - discount).toFixed(2);

    // Update the total_amount field and text
    document.getElementById('total_amount').value = totalAmountField;
    $(".tot_amt_txt").text(totalAmountField);
}


</script>

<script>



$(document).ready(function() {
    $('#saveButton').click(function(event) {
        event.preventDefault();  // Prevent the default form submission

        var packageSelect = document.getElementById('package_id');
        var noOfPaxInput = document.getElementById('no_of_pax');
        var selectedPackageId = packageSelect.value;
        var noOfPax = parseInt(noOfPaxInput.value);

        var errors = [];
        var highlightClass = 'highlight'; // Class to add for highlighting fields

        if (!selectedPackageId) {
            errors.push("Please select a package.");
            packageSelect.classList.add(highlightClass);
        } else {
            packageSelect.classList.remove(highlightClass);
        }

        if (!noOfPax || noOfPax < 30) {
            errors.push("Please enter the number of pax (minimum 30).");
            noOfPaxInput.classList.add(highlightClass);
        } else {
            noOfPaxInput.classList.remove(highlightClass);
        }

        var timeSlots = document.querySelectorAll('.check_time');
        var timeSelected = Array.from(timeSlots).some(slot => slot.checked);
        
        if (!timeSelected) {
            errors.push("Please select any time slot.");
            timeSlots.forEach(slot => slot.classList.add(highlightClass));
        } else {
            timeSlots.forEach(slot => slot.classList.remove(highlightClass));
        }

        var paymentModeSelect = document.getElementById('payment_mode');
        if (!paymentModeSelect.value) {
            errors.push("Please select a payment mode.");
            paymentModeSelect.classList.add(highlightClass);
        } else {
            paymentModeSelect.classList.remove(highlightClass);
        }

        if (errors.length > 0) {
            event.preventDefault(); // Prevent form submission
            showValidationModal(errors); // Function to show modal with errors
        }

        

        var totalAmount = parseFloat($("#total_amount").val());
        var paidAmount = parseFloat($("#paid_amount").val());

        // Validation to check if the paid amount is greater than the total amount
        if (paidAmount > totalAmount) {
            $('#alert-modal').modal('show', { backdrop: 'static' });
            $("#spndeddelid").text("Pay Amount should be less than the Total Amount.");
            return;
        }

        // AJAX call to send form data to the server
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_new/save_annathanam',
            type: 'post',
            data: $('#form_validation').serialize(),  // Serialize the data in the form
            success: function(response) {
                console.log("Success response:", response);
                try {
                    var obj = jQuery.parseJSON(response);
                    if (obj.err) {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                        $("#spndeddelid").text(obj.err);
                    } else {
                        window.open("<?php echo base_url(); ?>/annathanam_new/print_annathanam/" + obj.id);
                        window.location.replace("<?php echo base_url(); ?>/annathanam_new");
                    }
                } catch (e) {
                    console.error("Response parsing error:", e);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    });
});




</script>


<!-- <script>
  $('#form_validation').validate({
		rules: {
			"name": {
				required: true,
			},
      "package_id": {
				required: true,
			},
      "no_of_pax": {
				required: true,
			},
      "phone_no": {
				required: true,
			},
        "time": {
				required: true,
			},
		},
		messages: {
			"name": {
				required: "Name is required"
			},
      "package_id": {
				required: "Package is required"
			},
      "no_of_pax": {
				required: "No of pax is required"
			},
      "phone_no": {
				required: "Phone no is required"
			},
        "time": {
				required: "Session is required"
			}
		},
		submitHandler: function (form) {

        var totalAmount = parseFloat($("#total_amount").val());
        var paidAmount = parseFloat($("#paid_amount").val());

        if (paidAmount > totalAmount) {
            $('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text("Pay Amount should be less than the Total Amount.");
            return;
        }
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_new/save_annathanam',
            type: 'post',
            data: $('#form_validation').serialize(),
            success: function (response) {
              obj = jQuery.parseJSON(response);
              console.log('Final response', obj);
              if(obj.err != ''){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text(obj.err);
              }else{
                window.open("<?php echo base_url(); ?>/annathanam_new/print_annathanam/" + obj.id);
                window.location.replace("<?php echo base_url(); ?>/annathanam_new");
              }
            }
        });
		}
	});
</script> -->


<script>
    $("#clear").click(function(){
        $("input").val("");
    });
    $(document).ready(function(){
        $('.check_time').click(function() {
            $('.check_time').not(this).prop('checked', false);
        });
		$(document).on('change', '.payment_type', function(){
			if(this.value == 'partial'){
				$('.partial_paid_sec').show();
				$('#full_paid_amount').prop('disabled', true);
			}else{
				$('.partial_paid_sec').hide();
				$('#full_paid_amount').prop('disabled', false);
			}
		});
    });
</script>
<!-- <script>
  $('#form_validation').validate({
		rules: {
			"name": {
				required: true,
			},
      "package_id": {
				required: true,
			},
      "no_of_pax": {
				required: true,
			},
      "phone_no": {
				required: true,
			}
		},
		messages: {
			"name": {
				required: "Name is required"
			},
      "package_id": {
				required: "Rice type is required"
			},
      "no_of_pax": {
				required: "No of fax is required"
			},
      "phone_no": {
				required: "Phone no is required"
			}
		},
		submitHandler: function (form) {
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_new/save_annathanam',
            type: 'post',
            data: $('#form_validation').serialize(),
            success: function (response) {
              obj = jQuery.parseJSON(response);
              console.log('Final response', obj);
              if(obj.err != ''){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text(obj.err);
              }else{
                //window.open("<?php echo base_url(); ?>/annathanam_new/print_annathanam/" + obj.id);
                window.location.replace("<?php echo base_url(); ?>/annathanam_new");
              }
            }
        });
		}
	});
</script> -->


<!-- <script>

function fetchItemsByPackageId(packageId) {
    if (packageId) {
        $.ajax({
            url: '<?php echo base_url(); ?>/annathanam_new/get_items_by_package_id/' + packageId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('received date:', response)
                updateItemsDropdown(response);
                updateAddonItemsDropdown(response);
            },
            error: function(error) {
                console.log('Error fetching items:', error);
            }
        });
    }
}

function updateItemsDropdown(items) {
    var itemsDropdown = document.getElementById('annathanamDropdown');
    itemsDropdown.innerHTML = '<option value="">-- Select Service --</option>';
    
    items.forEach(function(item) {
        if (item.add_on == 0) {
            itemsDropdown.innerHTML += '<option value="' + item.id + '">' + item.name + '</option>';
        }
    });
    $("#annathanamDropdown").selectpicker("refresh");
}

function updateAddonItemsDropdown(items) {
    var addonItemsDropdown = document.getElementById('annathanamAddonDropdown');
    addonItemsDropdown.innerHTML = '<option value="">-- Select Addon --</option>';
    
    items.forEach(function(item) {
        if (item.add_on == 1) {
            addonItemsDropdown.innerHTML += '<option value="' + item.id + '" data-amount="' + item.amount + '">' + item.name + '</option>';
        }
    });
    $("#annathanamAddonDropdown").selectpicker("refresh");
}

var itemCount = <?php echo !empty($items) ? count($items) : 0; ?>;
var addonItemCount = <?php echo !empty($items) ? count($items) : 0; ?>;
var items = <?php echo json_encode($items); ?>;

// Function to get item name by ID
function getItemNameById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].name;
        }
    }
    return null;
}

// Function to get item amount by ID
function getItemAmountById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].amount;
        }
    }
    return null;
}

// Function to check if item already exists in the table
function isItemInTable(itemId, tableId) {
    var table = document.getElementById(tableId);
    return Array.from(table.querySelectorAll('input[type="hidden"]')).some(input => {
        let itemData = JSON.parse(input.value);
        return itemData.item_id == itemId; // Ensure this comparison is correct based on your data structure
    });
}

// Function to add items to the table
function addItemsToTable() {
    var itemsTable = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    var addonItemsTable = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    
    items.forEach(function(item) {
        var row, cell1, cell2, cell3, itemName;
        if (item.add_on == 0) {
            itemName = getItemNameById(item.item_id, annathanamItems);
            row = itemsTable.insertRow();
            row.id = 'itemRow' + itemCount;

            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);
            cell3 = row.insertCell(2);

            cell1.innerHTML = itemCount + 1;
            cell2.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + item.item_id + '","add_on":0}\'>' + itemName;
            cell3.innerHTML = '<a onclick="removeAnnathanamItem(\'itemRow' + itemCount + '\')" class="btn btn-danger">Remove</a>';

            itemCount++;
        } else if (item.add_on == 1) {
            itemName = getItemNameById(item.item_id, annathanamAddonItems);
            var itemAmount = getItemAmountById(item.item_id, annathanamAddonItems);
            var noOfPax = parseInt(document.getElementById('no_of_pax').value || '0');
            var totalAmount = itemAmount * noOfPax;

            row = addonItemsTable.insertRow();
            row.id = 'addonItemRow' + addonItemCount;

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            cell1.innerHTML = addonItemCount + 1;
            cell2.innerHTML = itemName;
            cell3.innerHTML = `<input type="number" step="0.01" class="form-control" value="${itemAmount.toFixed(2)}" onchange="updateItemTotalAmount(this, ${addonItemCount})">`;
            cell4.innerHTML = `<input type="number" step="0.01" class="form-control total-amount" readonly value="${totalAmount.toFixed(2)}">`;
            cell5.innerHTML = '<a onclick="removeAnnathanamAddonItem(\'addonItemRow' + addonItemCount + '\')" class="btn btn-danger">Remove</a>';

            addonItemCount++;
            updateTotalAmount(totalAmount, 'add');
        }
    });
}

function updateItemTotalAmount(input, rowIndex) {
    var noOfPax = parseInt(document.getElementById('no_of_pax').value || '0');
    var newAmount = parseFloat(input.value);
    var totalCell = document.querySelector(`#addonItemRow${rowIndex} .total-amount`);
    var oldTotal = parseFloat(totalCell.value);
    var newTotal = newAmount * noOfPax;

    totalCell.value = newTotal.toFixed(2);
    updateTotalAmount(newTotal - oldTotal, 'add');
}

function addAnnathanamItem() {
    var select = document.getElementById('annathanamDropdown');
    var tableId = 'annathanam_items_table';
    var selectedItemId = select.options[select.selectedIndex].value;
    var selectedText = select.options[select.selectedIndex].text;

    if (selectedItemId !== "" && !isItemInTable(selectedItemId, tableId)) {
        var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        var row = table.insertRow();
        row.id = 'itemRow' + itemCount;

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);

        cell1.innerHTML = itemCount + 1;
        cell2.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + selectedItemId + '","add_on":0}\'>' + selectedText;
        cell3.innerHTML = '<a onclick="removeAnnathanamItem(\'itemRow' + itemCount + '\')" class="btn btn-danger">Remove</a>';

        itemCount++;
        updatePackItems();
        select.selectedIndex = 0;
    } else {
        alert("This item is already added.");
    }
}

function removeAnnathanamItem(rowId) {
    var row = document.getElementById(rowId);
    row.parentNode.removeChild(row);
    updatePackItems();
    updateSno('annathanam_items_table');
}

function updatePackItems() {
    var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[1].getElementsByTagName('input')[0].value;
        items.push(JSON.parse(itemId));
    }
    document.getElementById('pack_items').value = JSON.stringify(items);
}



function addAnnathanamAddonItem() {
    var select = document.getElementById('annathanamAddonDropdown');
    var selectedItemId = select.value;
    var selectedText = select.options[select.selectedIndex].text;
    var itemAmount = parseFloat(select.options[select.selectedIndex].getAttribute('data-amount'));
    var noOfPax = parseInt(document.getElementById('no_of_pax').value || 0);
    var totalAmount = itemAmount * noOfPax;

    if (selectedItemId && !isItemInTable(selectedItemId, 'annathanam_addon_items_table')) {
        var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);

        cell1.innerHTML = table.rows.length;
        cell2.innerHTML = selectedText;
        cell3.innerHTML = `<input type="number" class="form-control" value="${itemAmount.toFixed(2)}" onchange="updateItemTotalAmount(this, ${table.rows.length - 1})">`;
        cell4.innerHTML = totalAmount.toFixed(2);
        cell5.innerHTML = `<a onclick="removeAnnathanamAddonItem(this.parentNode.parentNode)" class="btn btn-danger">Remove</a>`;

        updateTotalAmount(totalAmount, 'add');
        select.selectedIndex = 0;
    } else {
        alert("This addon is already added or not selected.");
    }
}

function updateItemAmount(input, itemId, noOfPax) {
    var newAmount = parseFloat(input.value);
    var totalCell = input.parentElement.nextElementSibling;
    var newTotalAmount = newAmount * noOfPax;
    var oldTotalAmount = parseFloat(totalCell.innerText);

    totalCell.innerText = newTotalAmount.toFixed(2);
    updateTotalAmount(newTotalAmount - oldTotalAmount, 'add');
}


function removeAnnathanamAddonItem(element, addonItemId) {
    var row = element.parentNode.parentNode;
    var totalAmount = parseFloat(row.cells[3].innerText);
    var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    
    table.removeChild(row);
    updateTotalAmount(totalAmount, 'remove');
    updateSno('annathanam_addon_items_table');
}


function updateAddonPackItems() {
    var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[1].getElementsByTagName('input')[0].value;
        items.push(JSON.parse(itemId));
    }
    document.getElementById('addon_pack_items').value = JSON.stringify(items);
}

function updateTotalAmount(amount, action) {
    var totalAmountField = document.getElementById('total_amount');
    var currentTotal = parseFloat(totalAmountField.value);
    if (action === 'add') {
        totalAmountField.value = (currentTotal + amount).toFixed(2);
    } else if (action === 'remove') {
        totalAmountField.value = (currentTotal - amount).toFixed(2);
    }
}

function updateSno(tableId) {
    var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
    var i = 0;
    Array.from(table.rows).forEach(row => {
        row.cells[0].innerText = ++i;
    });
}

// Initialize pack_items and addon_pack_items
document.addEventListener('DOMContentLoaded', function () {
    addItemsToTable();
    updatePackItems();
    updateAddonPackItems();
});

</script> -->


<!-- <script>

// function addAnnathanamAddonItem() {
//     var select = document.getElementById('annathanamAddonDropdown');
//     var selectedItemId = select.value;
//     var selectedText = select.options[select.selectedIndex].text;
//     var itemAmount = parseFloat(getItemAmountById(selectedItemId, annathanamAddonItems));
//     var noOfPax = parseInt(document.getElementById('no_of_pax').value || 0);
//     var totalAmount = itemAmount * noOfPax;

//     if (selectedItemId && !isItemInTable(selectedItemId, 'annathanam_addon_items_table')) {
//         var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
//         var row = table.insertRow(-1);
//         var cell1 = row.insertCell(0);
//         var cell2 = row.insertCell(1);
//         var cell3 = row.insertCell(2);
//         var cell4 = row.insertCell(3);
//         var cell5 = row.insertCell(4);

//         cell1.innerHTML = table.rows.length;
//         cell2.innerHTML = selectedText;
//         cell3.innerHTML = `<input type="number" class="form-control" value="${itemAmount.toFixed(2)}" onchange="updateItemTotalAmount(this, ${table.rows.length - 1})">`;
//         cell4.innerHTML = totalAmount.toFixed(2);
//         cell5.innerHTML = `<a onclick="removeAnnathanamAddonItem(this.parentNode.parentNode)" class="btn btn-danger">Remove</a>`;

//         // Update totals and reset the selector
//         updateTotalAmount(totalAmount, 'add');
//         select.selectedIndex = 0;
//     } else {
//         alert("This addon is already added or not selected.");
//     }
// }


var itemCount = <?php echo !empty($items) ? count($items) : 0; ?>;
var addonItemCount = <?php echo !empty($items) ? count($items) : 0; ?>;
var items = <?php echo json_encode($items); ?>;
var annathanamItems = <?php echo json_encode($annathanam_items); ?>;
var annathanamAddonItems = <?php echo json_encode($annathanam_addon_items); ?>;

// Function to get item name by ID
function getItemNameById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].name;
        }
    }
    return null;
}

// Function to get item amount by ID
function getItemAmountById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].amount;
        }
    }
    return null;
}

// Function to check if item already exists in the table
function isItemInTable(itemId, tableId) {
    var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var existingItemId = row.cells[0].getElementsByTagName('input')[0].value;
        if (JSON.parse(existingItemId).item_id == itemId) {
            return true;
        }
    }
    return false;
}

// Function to add items to the table
function addItemsToTable() {
    var itemsTable = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    var addonItemsTable = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    
    items.forEach(function(item) {
        var row, cell1, cell2, itemName;
        if (item.add_on == 0) {
            itemName = getItemNameById(item.item_id, annathanamItems);
            row = itemsTable.insertRow();
            row.id = 'itemRow' + itemCount;

            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);
            cell3 = row.insertCell(2);

            cell1.innerHTML = itemCount + 1;
            cell2.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + item.item_id + '","add_on":0}\'>' + itemName;
            cell3.innerHTML = '<a onclick="removeAnnathanamItem(\'itemRow' + itemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

            itemCount++;
        } else if (item.add_on == 1) {
            itemName = getItemNameById(item.item_id, annathanamAddonItems);
            var itemAmount = getItemAmountById(item.item_id, annathanamAddonItems);
            var totalAmount = itemAmount * parseInt(document.getElementById('no_of_pax').value);

            row = addonItemsTable.insertRow();
            row.id = 'addonItemRow' + addonItemCount;

            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);
            cell3 = row.insertCell(2);
            cell4 = row.insertCell(3);

            cell1.innerHTML = addonItemCount + 1;
            cell2.innerHTML = '<input type="hidden" name="addon_pack_items[]" value=\'{"item_id":"' + item.item_id + '","add_on":1}\'>' + itemName;
            cell3.innerHTML = totalAmount.toFixed(2);
            cell4.innerHTML = '<a onclick="removeAnnathanamAddonItem(\'addonItemRow' + addonItemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

            addonItemCount++;
            updateTotalAmount(totalAmount, 'add');
        }
    });
}

function addAnnathanamItem() {
    var select = document.getElementById('annathanamDropdown');
    var tableId = 'annathanam_items_table';
    var selectedItemId = select.options[select.selectedIndex].value;
    var selectedText = select.options[select.selectedIndex].text;

    if (selectedItemId !== "" && !isItemInTable(selectedItemId, tableId)) {
        var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        var row = table.insertRow();
        row.id = 'itemRow' + itemCount;

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);

        cell1.innerHTML = itemCount + 1;        
        cell2.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + selectedItemId + '","add_on":0}\'>' + selectedText;
        cell3.innerHTML = '<a onclick="removeAnnathanamItem(\'itemRow' + itemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

        itemCount++;
        updatePackItems();
        select.selectedIndex = 0;
    } else {
        alert("This item is already added.");
    }
}

function removeAnnathanamItem(rowId) {
    var row = document.getElementById(rowId);
    row.parentNode.removeChild(row);
    updatePackItems();
}

function updatePackItems() {
    var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[0].getElementsByTagName('input')[0].value;
        items.push(JSON.parse(itemId));
    }
    document.getElementById('pack_items').value = JSON.stringify(items);
}

function addAnnathanamAddonItem() {
    var select = document.getElementById('annathanamAddonDropdown');
    var tableId = 'annathanam_addon_items_table';
    var selectedItemId = select.options[select.selectedIndex].value;
    var selectedText = select.options[select.selectedIndex].text;
    var itemAmount = parseFloat(select.options[select.selectedIndex].getAttribute('data-amount'));
    var noOfPax = parseInt(document.getElementById('no_of_pax').value);
    var totalAmount = itemAmount * noOfPax;

    if (selectedItemId !== "" && !isItemInTable(selectedItemId, tableId)) {
        var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        var row = table.insertRow();
        row.id = 'addonItemRow' + addonItemCount;

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        cell1.innerHTML = addonItemCount + 1;
        cell2.innerHTML = '<input type="hidden" name="addon_pack_items[]" value=\'{"item_id":"' + selectedItemId + '","add_on":1}\'>' + selectedText;
        cell3.innerHTML = totalAmount.toFixed(2);
        cell4.innerHTML = '<a onclick="removeAnnathanamAddonItem(\'addonItemRow' + addonItemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

        addonItemCount++;
        updateAddonPackItems();
        updateTotalAmount(totalAmount, 'add');
        select.selectedIndex = 0;
    } else {
        alert("This addon is already added.");
    }
}

function removeAnnathanamAddonItem(rowId) {
    var row = document.getElementById(rowId);
    var totalAmount = parseFloat(row.cells[1].innerHTML);
    row.parentNode.removeChild(row);
    updateAddonPackItems();
    updateTotalAmount(totalAmount, 'remove');
}

function updateAddonPackItems() {
    var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[0].getElementsByTagName('input')[0].value;
        items.push(JSON.parse(itemId));
    }
    document.getElementById('addon_pack_items').value = JSON.stringify(items);
}

function updateTotalAmount(amount, action) {
    var totalAmountField = document.getElementById('total_amount');
    var currentTotal = parseFloat(totalAmountField.value);
    if (action === 'add') {
        totalAmountField.value = (currentTotal + amount).toFixed(2);
    } else if (action === 'remove') {
        totalAmountField.value = (currentTotal - amount).toFixed(2);
    }
}

// Initialize pack_items and addon_pack_items
document.addEventListener('DOMContentLoaded', function () {
    addItemsToTable();
    updatePackItems();
    updateAddonPackItems();
});
</script> -->