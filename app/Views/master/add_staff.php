<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disabled = 'disabled';
}
?>
<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>

.form-line.focused input[type=date]::-webkit-datetime-edit {
    color: black;
}

.form-line input[type=date]::-webkit-datetime-edit {
    color: transparent;
}


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
        <div class="block-header">
            <h2>STAFF SETTING<small>Finance / <b>Add Staff  Setting</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Staff</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/staff"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/master/save_staff" method="POST" id="form_validation">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <div class="body">
                        <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-2">
                                <input  type="radio" name="stafftype" id="local" value="1" <?php if(!empty($data['staff_type'])){ if($data['staff_type'] == 1) { echo "checked";}}else { echo "checked";} ?> >
								<label for ='local'> Malaysian </label>
                            </div>
                            <div class="col-sm-2">
                                <input  type="radio" name="stafftype" id="foreigner" value="2" <?php if(!empty($data['staff_type'])){ if($data['staff_type'] == 2) { echo "checked";}} ?> >
								<label for ='foreigner'> Foreigner </label>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Staff Name <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="mobile" value="<?php echo $data['mobile'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Mobile</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email"  class="form-control" name="email" value="<?php echo $data['email'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="designation" value="<?php echo $data['designation'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Designation</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="address1" value="<?php echo $data['address1'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Address1</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="address2" value="<?php echo $data['address2'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Address2</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="city" value="<?php echo $data['city'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">City Name</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="date"  class="form-control" name="date_of_birth" value="<?php echo !empty($data['date_of_birth']) ? $data['date_of_birth'] : "1990-01-01";?>" <?php echo $readonly; ?> max="<?php echo $booking_calendar_range_year; ?>">
                                        <label class="form-label">Date of Birth</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="date"  class="form-control" name="date_of_join" value="<?php echo $data['date_of_join'];?>" <?php echo $readonly; ?> max="<?php echo date('Y-m-d'); ?>" >
                                        <label class="form-label">Date of Join <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control amount_keyup" name="basic_pay" id="basic_pay" value="<?php echo $data['basic_pay'];?>" min="0" step="any" <?php echo $readonly; ?>>
                                        <label class="form-label">Basic Pay <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control amount_keyup" name="allowance" id="allowance" value="<?php echo $data['allowance'];?>" min="0" step="any" <?php echo $readonly; ?>>
                                        <label class="form-label">Allowance </label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <div id="local_div" style="display:<?php if(!empty($data['staff_type'])){ if($data['staff_type'] == 1){ echo 'block'; } else { echo 'none'; } } else{ echo 'block'; }?>">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  class="form-control" name="ic_number" id="ic_number" value="<?php echo $data['ic_number'];?>" <?php echo $readonly; ?> required>
                                            <label class="form-label">IC Number <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input  type="checkbox" id="epf" name="epf" value="1" <?php if(!empty($data['is_epf'])){ if($data['is_epf'] == 1) { echo "checked";}} ?> <?php echo $disabled; ?>>
                                    <label for ='epf'> EPF &nbsp;&nbsp; </label>
                                </div>
                                <div class="col-sm-10" style="display:<?php if(!empty($data['is_epf'])){ if($data['is_epf'] == 1) { echo "block";} else { echo "none"; } }else{ echo "none"; } ?>" id="epf_hide_show">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="epf_no" id="epf_no" value="<?php echo $data['epf_no'];?>" <?php echo $readonly; ?>>
                                                    <label class="form-label">EPF No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="number" class="form-control amount_dedection_keyup" name="epf_amount" id="epf_amount" min="0" step="any" value="<?php echo $data['epf_amount'];?>" placeholder="EPF Amount" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="col-sm-2">
                                    <input  type="checkbox" id="socso" name="socso" value="1" <?php if(!empty($data['is_socso'])){ if($data['is_socso'] == 1) { echo "checked";}} ?> <?php echo $disabled; ?>>
                                    <label for ='socso'> SOCSO &nbsp;&nbsp; </label>
                                </div>
                                <div class="col-sm-10" style="display:<?php if(!empty($data['is_socso'])){ if($data['is_socso'] == 1) { echo "block";} else { echo "none"; } }else{ echo "none"; } ?>" id="socso_hide_show">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="socso_no" id="socso_no" value="<?php echo $data['socso_no'];?>" <?php echo $readonly; ?>>
                                                    <label class="form-label">SOCSO No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="number" class="form-control amount_dedection_keyup" name="socso_amount" id="socso_amount" min="0" step="any" value="<?php echo $data['socso_amount'];?>" placeholder="SOCSO Amount" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="col-sm-2">
                                    <input  type="checkbox" id="eis" name="eis" value="1" <?php if(!empty($data['is_eis'])){ if($data['is_eis'] == 1) { echo "checked";}} ?> <?php echo $disabled; ?>>
                                    <label for ='eis'> EIS &nbsp;&nbsp; </label>
                                </div>
                                <div class="col-sm-10" style="display:<?php if(!empty($data['is_eis'])){ if($data['is_eis'] == 1) { echo "block";} else { echo "none"; } }else{ echo "none"; } ?>" id="eis_hide_show">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="eis_no" id="eis_no" value="<?php echo $data['eis_no'];?>" <?php echo $readonly; ?>>
                                                    <label class="form-label">EIS No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="number" class="form-control amount_dedection_keyup" name="eis_amount" id="eis_amount" min="0" step="any" value="<?php echo $data['eis_amount'];?>" placeholder="EIS Amount" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <div id="forieigner_div" style="display:<?php if(!empty($data['staff_type'])){ if($data['staff_type'] == 2){ echo 'block'; } else { echo 'none'; } } else{ echo 'none'; }?>">
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select id="country_id" name="country_id" class="form-control search_box" data-live-search="true" <?php echo $readonly; ?>>
                                                <option value="">--select country name--</option>
                                                <?php
                                                if(!empty($countries))
                                                {
                                                    foreach($countries as $country)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $country['id']; ?>" <?php if(!empty($data['foreign_country_id'])){ if($data['foreign_country_id'] == $country['id']) { echo "selected";}}else{ if($country['id'] == 100){ echo "selected"; } } ?>><?php echo $country['name']; ?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="passport_no" name="passport_no" class="form-control" value="<?php echo $data['foreign_passport_no'];?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Passport No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="date" id="passport_expiry_date" name="passport_expiry_date" class="form-control" value="<?php echo $data['foreign_passport_expiry_date'];?>" <?php echo $readonly; ?> 
                                            min="<?php if(!empty($data['foreign_passport_expiry_date'])){ echo $data['foreign_passport_expiry_date']; }else{ echo date('Y-m-d'); }  ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                            <label class="form-label">Passport Expiry Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="visa_no" name="visa_no" class="form-control" value="<?php echo $data['foreign_visa_no'];?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Visa No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="date" id="visa_expiry_date" name="visa_expiry_date" class="form-control" value="<?php echo $data['foreign_visa_expiry_date'];?>" <?php echo $readonly; ?> min="<?php if(!empty($data['foreign_visa_expiry_date'])){ echo $data['foreign_visa_expiry_date']; }else{ echo date('Y-m-d'); }  ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                            <label class="form-label">Visa Expiry Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select id="types_of_visa" name="types_of_visa" class="form-control" <?php echo $readonly; ?>>
                                                <option value="">--Select types of visa--</option>
                                                <option value="1" <?php if(!empty($data['foreign_types_of_visa'])){ if($data['foreign_types_of_visa'] == 1) { echo "selected";}} ?>>SOCIAL VISA</option>
                                                <option value="2" <?php if(!empty($data['foreign_types_of_visa'])){ if($data['foreign_types_of_visa'] == 2) { echo "selected";}} ?>>EMPLOYMENT PASS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                            <p style="margin:0px;">&nbsp;</p>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" step="any" class="form-control" name="salary" id="salary" value="<?php echo $data['salary'];?>" readonly>
                                        <label class="form-label">Salary <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <?php if($staff_status == true) { ?>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select id="status_staff" name="status_staff" class="form-control" <?php echo $readonly; ?>>
                                            <option value="">--Select status--</option>
                                            <option value="1" <?php if(!empty($data['status'])){ if($data['status'] == 1) { echo "selected";}} ?>>Active</option>
                                            <option value="2" <?php if(!empty($data['status'])){ if($data['status'] == 2) { echo "selected";}} ?>>Resigned</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float" style="display:<?php if(!empty($data['status'])){ if($data['status'] == 2) { echo 'block';}else{ echo 'none'; }}else{ echo 'none'; } ?>;" id="display_resigned_date">
                                    <div class="form-line">
                                        <input type="date" id="resign_date" name="resign_date" class="form-control" value="<?php echo $data['resigned_date'];?>" max="<?php echo date('Y-m-d'); ?>" >
                                        <label class="form-label">Resigned Date</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group form-float" style="display:<?php if(!empty($data['status'])){ if($data['status'] == 2) { echo 'block';}else{ echo 'none'; }}else{ echo 'none'; } ?>;" id="display_resigned_remark">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="resigned_remark" id="resigned_remark" value="<?php echo $data['resigned_remark'];?>">
                                        <label class="form-label">Remark</label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        

                    </div>
                    </div>

                    <?php if($view != true) { ?>
                    <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                        <button type="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
                        <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                    </div>
                    <?php } ?>
                    </form>
                    
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
                </div>
            </div>
        </div>
    </div>
</section>
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});

    $(document).ready(function() {
		$("input[name$='stafftype']").click(function() {
			var staff_type = $(this).val();
			if(staff_type == 1)
			{
				$("#forieigner_div").hide();
				$("#local_div").show();
				$("#ic_number").prop("required", true);
				$("#country_id").prop("required", false);
				$("#passport_no").prop("required", false);
				$("#passport_expiry_date").prop("required", false);
				$("#visa_no").prop("required", false);
				$("#visa_expiry_date").prop("required", false);
				$("#types_of_visa").prop("required", false);
			}
			else
			{
				$("#forieigner_div").show();
				$("#local_div").hide();
				$("#ic_number").prop("required", false);
				$("#country_id").prop("required", true);
				$("#passport_no").prop("required", true);
				$("#passport_expiry_date").prop("required", true);
				$("#visa_no").prop("required", true);
				$("#visa_expiry_date").prop("required", true);
                $("#types_of_visa").prop("required", true);
			}
		});
	});
    $(document).ready(function() {
        $('#status_staff').on('change', function () {
            var status_staff = $("#status_staff option:selected").val();
            if(status_staff == 2)
			{
				$("#display_resigned_date").show();
				$("#display_resigned_remark").show();
				$("#resign_date").prop("required", true);
				$("#resigned_remark").prop("required", true);
			}
			else
			{
				$("#display_resigned_date").hide();
				$("#display_resigned_remark").hide();
				$("#resign_date").prop("required", false);
				$("#resigned_remark").prop("required", false);
			}
        });
	});
</script>

<script>
    $('#form_validation').validate({
        rules: {
            "name": {
                required: true,
            },
            "date_of_join": {
                required: true,
            },
            "basic_pay": {
                required: true,
                /*remote: {
                    url: "<?php echo base_url(); ?>/paymentmodesetting/findledgernameExists",
                    data: {
                        update_id: function() {
                            return $("#updateid").val();
                        },
                        ledger_name: $(this).data('ledger_name')
                    },
                    type: "post",
                },*/
            },
        },
        messages: {
            "name": {
                required: "name is required"
            },
            "date_of_join": {
                required: "DOJ is required"
            },
            "basic_pay": {
                required: "basic pay is required"
                //remote: "already ledger name exist"
            }
        },
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });

    function validations(){
        $.ajax
            ({
            type:"POST",
            url: "<?php echo base_url(); ?>/master/staff_validation",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                console.log(obj);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    $("form").submit();
                }
            }
        })
            
    }

    $("#epf").click(function () {
        if ($(this).is(":checked")) {
            $("#epf_hide_show").show();
            var basic_pay = $("#basic_pay").val();
            if(basic_pay !="")
            {
                //alert(basic_pay);
                $.ajax({
                    type:"POST",
                    url: "<?php echo base_url(); ?>/master/get_salary_epf_amount",
                    data: {basicpay:basic_pay},
                    success:function(data)
                    {
                        $("#epf_amount").val(data);
                        calculateSum();
                    }
                });
            }
            else
            {
                $("#epf_amount").val("0.00");
                calculateSum();
            }
        } else {
            $("#epf_hide_show").hide();
            $("#epf_no").val("");
            $("#epf_amount").val("");
            calculateSum();
        }
    });
    $("#socso").click(function () {
        if ($(this).is(":checked")) {
            $("#socso_hide_show").show();
            var basic_pay = $("#basic_pay").val();
            if(basic_pay !="")
            {
                $.ajax({
                    type:"POST",
                    url: "<?php echo base_url(); ?>/master/get_salary_socso_amount",
                    data: {basicpay:basic_pay},
                    success:function(data)
                    {
                        $("#socso_amount").val(data);
                        calculateSum();
                    }
                });
            }
            else
            {
                $("#socso_amount").val("0.00");
                calculateSum();
            }
        } else {
            $("#socso_hide_show").hide();
            $("#socso_no").val("");
            $("#socso_amount").val("");
            calculateSum();
        }
    });
    $("#eis").click(function () {
        if ($(this).is(":checked")) {
            $("#eis_hide_show").show();
            var basic_pay = $("#basic_pay").val();
            if(basic_pay !="")
            {
                $.ajax({
                    type:"POST",
                    url: "<?php echo base_url(); ?>/master/get_salary_eis_amount",
                    data: {basicpay:basic_pay},
                    success:function(data)
                    {
                        $("#eis_amount").val(data);
                        calculateSum();
                    }
                });
            }
            else
            {
                $("#eis_amount").val("0.00");
                calculateSum();
            }
        } else {
            $("#eis_hide_show").hide();
            $("#eis_no").val("");
            $("#eis_amount").val("");
            calculateSum();
        }
    });

    $(document).ready(function() {
        //this calculates values automatically 
        calculateSum();
        $(".amount_keyup").on("keydown keyup", function() {
            var basic_pay = $("#basic_pay").val();
            if ($("#epf").is(":checked")) {
                if(basic_pay !="")
                {
                    $.ajax({
                        type:"POST",
                        url: "<?php echo base_url(); ?>/master/get_salary_epf_amount",
                        data: {basicpay:basic_pay},
                        success:function(data)
                        {
                            $("#epf_amount").val(data);
                            calculateSum();
                        }
                    });
                }
                else
                {
                    $("#epf_amount").val("0.00");
                    calculateSum();
                }
            }
            else
            {
                calculateSum();
            }
            if ($("#socso").is(":checked")) {
                if(basic_pay !="")
                {
                    $.ajax({
                        type:"POST",
                        url: "<?php echo base_url(); ?>/master/get_salary_socso_amount",
                        data: {basicpay:basic_pay},
                        success:function(data)
                        {
                            $("#socso_amount").val(data);
                            calculateSum();
                        }
                    });
                }
                else
                {
                    $("#socso_amount").val("0.00");
                    calculateSum();
                }
            }
            else
            {
                calculateSum();
            }
            if ($("#eis").is(":checked")) {
                if(basic_pay !="")
                {
                    $.ajax({
                        type:"POST",
                        url: "<?php echo base_url(); ?>/master/get_salary_eis_amount",
                        data: {basicpay:basic_pay},
                        success:function(data)
                        {
                            $("#eis_amount").val(data);
                            calculateSum();
                        }
                    });
                }
                else
                {
                    $("#eis_amount").val("0.00");
                    calculateSum();
                }
            }
            else
            {
                calculateSum();
            }
        });
        $(".amount_dedection_keyup").on("keydown keyup", function() {
            calculateSum();
        });
    });
    function calculateSum() {
        var sum_add = 0;
        var sum_ded = 0;
        $(".amount_keyup").each(function() {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum_add += parseFloat(this.value);
            }
        });
        $(".amount_dedection_keyup").each(function() {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum_ded += parseFloat(this.value);
            }
        });
        var add_ded = sum_add - sum_ded;
        $("#salary").val(add_ded.toFixed(2));
    }
</script>

