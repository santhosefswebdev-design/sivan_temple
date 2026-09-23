<?php $db = db_connect();?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Member<small>Marriage Registration / <b>Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/marriage"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                    <form action="<?php echo base_url(); ?>/marriage/store" method="POST" id="form_validation" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo isset($marriage['id']) ? $marriage['id'] : ""; ?>" name="id" id="updateid">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="bri_name" id="bri_name" class="form-control" value="<?php echo isset($marriage['bri_name']) ? $marriage['bri_name'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Full Name of Bride <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="bri_ic" id="bri_ic" class="form-control" value="<?php echo isset($marriage['bri_ic']) ? $marriage['bri_ic'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">IC/Passport Number <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="date" name="bri_dob" id="bri_dob" class="form-control" value="<?php echo isset($marriage['bri_dob']) ? $marriage['bri_dob'] : ""; ?>" required <?php echo $readonly; ?> max="<?php echo $booking_calendar_range_year; ?>">
                                        <label class="form-label">Date of Birth <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="bri_nationality" id="bri_nationality" class="form-control" value="<?php echo isset($marriage['bri_nationality']) ? $marriage['bri_nationality'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Nationality </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="bri_religion" id="bri_religion" class="form-control" value="<?php echo isset($marriage['bri_religion']) ? $marriage['bri_religion'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Religion </label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="gro_name" id="gro_name" class="form-control" value="<?php echo isset($marriage['gro_name']) ? $marriage['gro_name'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Full Name of Groom <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="gro_ic" id="gro_ic" class="form-control" value="<?php echo isset($marriage['gro_ic']) ? $marriage['gro_ic'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">IC/Passport Number <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="date" name="gro_dob" id="gro_dob" class="form-control" value="<?php echo isset($marriage['gro_dob']) ? $marriage['gro_dob'] : ""; ?>" required <?php echo $readonly; ?> max="<?php echo $booking_calendar_range_year; ?>">
                                        <label class="form-label">Date of Birth <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="gro_nationality" id="gro_nationality" class="form-control" value="<?php echo isset($marriage['gro_nationality']) ? $marriage['gro_nationality'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Nationality </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="gro_religion" id="gro_religion" class="form-control" value="<?php echo isset($marriage['gro_religion']) ? $marriage['gro_religion'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Religion </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-3" style="margin: 0px;">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <?php $phonecode =  !empty($marriage['phonecode']) ? $marriage['phonecode'] : "+60"; ?>
                                                <select class="form-control" name="phonecode" id="phonecode">
                                                    <option value="">Dailing Code</option>
                                                    <?php
                                                    if (!empty($phone_codes)) {
                                                        foreach ($phone_codes as $phone_code) {
                                                            ?>
                                                    <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if ($phone_code['dailing_code'] == $phonecode) {
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
                                    <div class="col-md-9" style="margin: 0px;">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input class="form-control reg_det" type="number" min="0" name="phoneno" id="phoneno" required pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" autocomplete="off" value="<?php echo isset($marriage['phoneno']) ? $marriage['phoneno'] : ""; ?>">
                                                <label class="form-label">Phone Number</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="date" name="date_of_mrg" id="date_of_mrg" class="form-control" value="<?php echo isset($marriage['date_of_mrg']) ? $marriage['date_of_mrg'] : ""; ?>" required <?php echo $readonly; ?> max="<?php echo $booking_calendar_range_year; ?>">
                                        <label class="form-label">Date of Intended Marriage </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="time" name="time_of_mrg" id="time_of_mrg" class="form-control" value="<?php echo isset($marriage['time_of_mrg']) ? $marriage['time_of_mrg'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Time of Marriage</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="place_of_mrg" id="place_of_mrg" class="form-control" value="<?php echo isset($marriage['place_of_mrg']) ? $marriage['place_of_mrg'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Place of Marriage (Venue)</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <h3 style="margin-bottom:5px; margin-top:5px;">Attach documents Details</h3>
                                </div>
                                <?php if($view != true) { ?>
                                <div class="col-sm-12" style="text-align:right; margin-bottom:27px;">
                                    <div class="form-group form-float">
                                        <div class="form-line" style="border: none;">
                                            <label id="document_upload" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <input type="hidden" id="doc_row_count" value="1">
                                <div class="">
                                    <table style="width:100%" class="table table-bordered" id="doc_table">
                                        <thead>
                                            <tr>
                                                <th width="40%">Description</th>
                                                <th width="40%">Document</th>
                                                <?php if($view != true) { ?><th width="20%">Action</th><?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            foreach($mrg_documents as $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['description']; ?></td>
                                                <td><a href="<?php echo base_url(); ?>/uploads/marriage/<?php echo $row['document_name']; ?>" download><?php echo $row['document_name']; ?></a></td>
                                                <?php if($view != true) { ?><td></td><?php } ?>
                                            </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                        
                                        <div class="products row">
                                            <div class="col-sm-12">
                                                <h3 style="margin-bottom:5px; margin-top:5px;">Pay Details</h3>
                                            </div>
                                            <?php if($view != true) { ?>
                                            <div class="col-sm-4">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="date" class="form-control" id="pay_date" value="<?php echo date('Y-m-d'); ?>" max="<?php echo $booking_calendar_range_year; ?>">
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
                                                            <?php 
															if(count($payment_modes) > 0){
																foreach($payment_modes as $payment_mode) { ?>
																<option value="<?php echo $payment_mode['id']; ?>"><?php echo $payment_mode['name'];?></option>
																<?php 
																}
															}else echo '<option value="">Select</option>';
															?>
                                                        </select>
                                                        <label class="form-label">Paymentmode</label>
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
                                            <?php } ?>
                                        </div>
                                        
                                        <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                            <div class="table-responsive"><table style="width:100%" class="table table-bordered" id="pay_table" style="height: 150px;">
                                                <thead>
                                                    <tr>
                                                        <th width="15%">Date</th>
                                                        <th width="25%">Total RM</th>
                                                        <th width="25%">Payment Mode</th>
                                                        <?php if($view != true) { ?>
                                                        <th width="15%">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php //if($view == true) { ?>
                                                    <?php foreach($payment as $row) {
                                                        $payment_mode_check = $db->table("payment_mode")->where("id", $row['payment_mode'])->get()->getResultArray();
                                                        if(count($payment_mode_check) > 0)
                                                        {
                                                            $payment_mode_row = $payment_mode_check[0]['name'];
                                                        }
                                                        else
                                                        {
                                                            $payment_mode_row = "";
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo date("d/m/Y", strtotime($row['date'])); ?></td>
                                                            <td><?php echo $row['amount']; ?></td>
                                                            <td><?php echo $payment_mode_row; ?></td>
                                                            <?php if($view != true) { ?><td></td><?php } ?>
                                                        </tr>
                                                <?php } //} ?>
                                                </tbody>
                                            </table></div>
                                            <input type="hidden" id="pay_row_count" value="1">
                                        </div>
                                    </div>
                        </div>
                        <?php if($view != true) { ?>
                        <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                            <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                        </div>
                        <?php } ?>
                    </div>
                    </form>
                    
                    </div>
             
            </div>
        </div>
    </div>
    </div>

</section>

<script type="text/javascript">
$("#document_upload").click(function(){
    var cnt = parseInt($("#doc_row_count").val());
    var html = '<tr id="rmv_docrow'+cnt+'">';
    html += '<td style="width: 20%;"><input type="text" style="border: none;" name="description[]"></td>';
    html += '<td style="width: 60%;"><input type="file" style="border: none;" name="file[]"></td>';
    html += '<td style="width: 20%;"><a class="btn btn-danger btn-rad" onclick="rmv_doc('+ cnt +')" style="width:auto;"><i class="material-icons"></i></a></td>';
    html += '</tr>';
    $("#doc_table").append(html);
    var ct = parseInt(cnt + 1);
    $("#doc_row_count").val(ct);
});
function rmv_doc(id){
    $("#rmv_docrow"+id).remove();
}

function get_payment_mode(id,cntno){
    //alert(id);
    if(id != ''){
        $.ajax({
            url: "<?php echo base_url();?>/marriage/get_payment_mode",
            type: "post",
            data: {id: id},
            dataType: "json",
            success: function(data){
                $("#payment_mode_"+cntno).val(id);
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
        get_payment_mode(paymentmode,cnt);
        var html = '<tr id="rmv_payrow'+cnt+'">';
            html += '<td style="width: 15%;"><input type="date" style="border: none;" readonly name="pay['+cnt+'][date]" value="'+date+'" ></td>';
            html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="pay['+cnt+'][pay_amt]" value="'+Number(amt).toFixed(2)+'"></td>';
            html += '<td style="width: 25%;"><input type="hidden" style="border: none;" readonly id="payment_mode_'+cnt+'" name="pay['+cnt+'][payment_mode]"><span id="payment_mode_label_'+cnt+'"></span></td>';
            html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay('+ cnt +')" style="width:auto;"><i class="material-icons"></i></a></td>';
            html += '</tr>';
        $("#pay_table").append(html);
        var ct = parseInt(cnt + 1);
        $("#pay_row_count").val(ct);
        sum_amount();
		$("#pay_amt").val('');
        $('#paymentmode').prop('selectedIndex',0);
        $("#paymentmode").selectpicker("refresh");
    }
});

function rmv_pay(id){
    $("#rmv_payrow"+id).remove();
    sum_amount();
}

$("form").on("submit", function(){
        $('input[type=submit]').prop('disabled', true);
        $("#loader").show();
    });
</script>
