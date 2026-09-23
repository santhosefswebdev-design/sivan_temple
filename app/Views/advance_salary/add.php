<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
#wamount {
  text-transform: capitalize;
}
#pay_table { width:100%; border-collapse:collapse; }
#pay_table th { padding: 10px; background: #f44336; color: #fff; }
#pay_table td { padding:10px; }

.pay_desc {border :none}
.pay_earn {border :none; text-align: right;width:100%}
.pay_ded {border :none;text-align: right;width:100%}

</style>

<section class="content">
    <div class="container-fluid">
        <div class="block-header"> 
            <h2>ADVANCE SALARY<small>Finance / <b>Add Advance Salary</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/payslip/advance_salary"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        
                        <form  id="form_submit">

                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container" >
                                                <input type="date" name="date" id="date"  class="form-control" value="<?php if(!empty($data['date'])){ echo $data['date']; } else { echo  date('Y-m-d'); } ?>" <?php echo $readonly; ?> max="<?php echo date('Y-m-d'); ?>" >
                                                <!--<label class="form-label">Date</label>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <!--<label class="form-label" style="display: contents;">Staff Name</label>-->
                                                <select class="form-control show-tick search_box" name="staffname" id="staffname" data-live-search="true" required <?php echo $disable; ?>>
                                                <option value="">-- Select Staff Name --</option>
                                                <?php foreach($staff as $st) { ?>
                                                <option value="<?php echo $st['id']; ?>" <?php if(!empty($data['staff_id'])){ if($data['staff_id'] == $st['id']){ echo "selected"; } } ?>><?php echo $st['name']; ?></option>
                                                <?php } ?>
                                        		</select>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" name="invno" id="invno" class="form-control" value="<?php if(!empty($data['ref_no'])){ echo $data['ref_no']; } else { echo $ref_no; } ?>" readonly>
                                            <label class="form-label">Ref No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <?php
                                            if($view != true){
                                            ?>
                                            <select class="form-control show-tick" name="pay_type" id="pay_type">
                                                <option value="">-- Select Type --</option>
                                            </select>
                                            <?php
                                            }
                                            else{
                                            ?>
                                            <select class="form-control show-tick" <?php echo $disable; ?>>
                                                <option value='1' <?php if(!empty($data['type'])){ if($data['type'] == 1){ echo "selected"; } } ?>>Month</option>
                                                <option value='2' <?php if(!empty($data['type'])){ if($data['type'] == 2){ echo "selected"; } } ?>>EMI</option>
                                            </select>
                                            <?php
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" id="type_category_month_hide_show" style="display:<?php if(!empty($data['type'])){ if($data['type'] == 1){ echo "block"; }else{ echo "none"; } }else{ echo "none"; } ?>;">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="month" class="form-control" id="month_type" name="month_type" 
                                            value="<?php if(!empty($data['deduction_month'])){ echo $data['deduction_month']; } else { echo  date('Y-m'); } ?>" min="" <?php echo $readonly; ?> max="<?php echo date('Y-m', strtotime($booking_calendar_range_year)); ?>">
                                            <label class="form-label">Month</label>
                                        </div>
                                    </div>
                                </div>                 
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="hidden" class="form-control" id="max_amount" name="max_amount">
                                            <input type="number" class="form-control amount_change" id="amount" name="amount" min="0" placeholder="0.00" value="<?php if(!empty($data['total_amount'])){ echo $data['total_amount']; } ?>" readonly>
                                            <label class="form-label">Amount</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="provision_amount_emi_hide_show" style="display:<?php if($data['type'] == 2){ echo 'block'; }else{ echo 'none'; } ?>;">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="number" class="form-control" id="provision_amount" name="provision_amount" min="0" placeholder="0.00" value="<?php if(!empty($data['provision_amount'])){ echo $data['provision_amount']; } ?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Processing fee</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="type_category_emi_hide_show" style="display:<?php if($data['type'] == 2){ echo 'block'; }else{ echo 'none'; } ?>;">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="number" class="form-control" id="emi_type" name="emi_type" min="1" value="<?php if(!empty($data['emi_count'])){ echo $data['emi_count']; } ?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Total EMI Tenure</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="type_category_emi_start_month_hide_show" style="display:<?php if(!empty($data['type'])){ if($data['type'] == 2){ echo "block"; }else{ echo "none"; } }else{ echo "none"; } ?>;">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="month" class="form-control" id="emi_start_month" name="emi_start_month" 
                                            value="<?php if(!empty($data['emi_start_month'])){ echo date('Y-m', strtotime($data['emi_start_month'])); } ?>" <?php echo $readonly; ?> max="<?php echo date('Y-m', strtotime($booking_calendar_range_year)); ?>">
                                            <label class="form-label">EMI Start Month</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="type_category_emi_amount_hide_show" style="display:<?php if(!empty($data['type'])){ if($data['type'] == 2){ echo "block"; }else{ echo "none"; } }else{ echo "none"; } ?>;">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" id="emi_amount" class="form-control" value="<?php if(!empty($data['amount'])){ echo $data['amount']; } ?>" disabled style='background: #eee;'>
                                            <label class="form-label">EMI Amount</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="paymentmode" id="paymentmode" <?php echo $disable; ?>>
                                                <!--option value="0">Select</option-->
                                                <?php foreach($payment_modes as $payment_mode) { ?>
                                                <option value="<?php echo $payment_mode['id']; ?>" <?php if(!empty($data['payment_mode'])){ if($data['payment_mode'] == $payment_mode['id']){ echo "selected"; } } ?>><?php echo $payment_mode['name'];?></option>
                                                <?php } ?>
                                            </select>
                                            <label class="form-label">Payment Mode <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <label class="form-label">Narration</label>
                                            <textarea name="narration" id="narration" class="form-control" row="10" <?php echo $readonly; ?>><?php if(!empty($data['narration'])){ echo $data['narration']; } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if($view != true){
                                ?>
                                <div class="col-sm-12" align="center">
                                    <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
									<label for ='print'> Print &nbsp;&nbsp; </label>
									<a id="submit" class="btn btn-success btn-lg waves-effect">SAVE</a>
                                    
                                </div>
                                <?php
                                }
                                ?>
                                </div>
                            </div>
                        </form>
						
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>

<script>
$('document').ready(function() {
   // $('#type_category_month_hide_show').hide(); 
   // $('#type_category_emi_hide_show').hide();
   // $('#provision_amount_emi_hide_show').hide(); 
    $('#pay_type').change(function(){
        if($('#pay_type').val() == '1') {
            $('#type_category_month_hide_show').show();
            $('#type_category_emi_hide_show').hide();
            $('#type_category_emi_start_month_hide_show').hide();
            $('#type_category_emi_amount_hide_show').hide();
            $('#provision_amount_emi_hide_show').hide();
        }
        else if($('#pay_type').val() == '2') {
            $('#type_category_emi_hide_show').show();
            $('#type_category_emi_start_month_hide_show').show();
            $('#type_category_emi_amount_hide_show').show();
            $('#provision_amount_emi_hide_show').show();
            $('#type_category_month_hide_show').hide();
        }
        else {
            $('#type_category_month_hide_show').hide(); 
            $('#type_category_emi_hide_show').hide(); 
            $('#type_category_emi_start_month_hide_show').hide(); 
            $('#type_category_emi_amount_hide_show').hide(); 
            $('#provision_amount_emi_hide_show').hide();
        } 
    });
    $("#pay_type").empty();
});

$("#amount").on("keyup", function(e) {
    emi_calculation();
});
$("#provision_amount").on("keyup", function(e) {
    emi_calculation();
});
$("#emi_type").on("keyup", function(e) {
    emi_calculation();
});

function emi_calculation(){
    var amount = $('#amount').val();
    var provision_amount = $('#provision_amount').val();
    var emi_type = $('#emi_type').val();
    if(amount != '' && amount != 0 && emi_type != '' && emi_type != 0){
        $.ajax({
            url: "<?php echo base_url();?>/payslip/emi_calculation",
            type: "post",
            data: {loanamount:amount,provisionamount:provision_amount,emitype:emi_type},
            success:function(data){
                $('#emi_amount').val(data);
            }
        });
    }
}

$("#staffname").change(function(){
	var staffid = $(this).val();
    if(staffid != ""){
        $("#amount").val("");
        $("#provision_amount").val("");
        $("#emi_type").val("");
        $('#type_category_month_hide_show').hide(); 
        $('#type_category_emi_hide_show').hide();     
        $('#provision_amount_emi_hide_show').hide();      
        $('#type_category_emi_start_month_hide_show').hide();      
        $('#type_category_emi_amount_hide_show').hide();
        var date = $("#date").val();
        loadsalarytype(staffid,date);
    }
    else{
        $('#type_category_month_hide_show').hide(); 
        $('#type_category_emi_hide_show').hide();     
        $('#type_category_emi_start_month_hide_show').hide();      
        $('#type_category_emi_amount_hide_show').hide();
        $('#provision_amount_emi_hide_show').hide(); 
        $('#emi_type').val("");     
        $('#emi_amount').val("0.00");     
        $('#max_amount').val("");      
        $('.amount_change').attr("max",0);  
        $("#emi_start_month").val("").prop("min","");    
    }

	/*var pay_type = $("#pay_type").val();
    if(pay_type == 1){
        var ded_month = $("#month_type").val();
        loadstaffsalary(staffid,pay_type,ded_month);
    }
    if(pay_type == 2){
        var ded_month = $("#date").val();
        loadstaffsalary(staffid,pay_type,ded_month);
    }*/
});
$("#date").change(function(){
    $("#amount").val("");
    $("#provision_amount").val("");
    $("#emi_type").val("");
    $('#type_category_month_hide_show').hide(); 
    $('#type_category_emi_hide_show').hide();     
    $('#provision_amount_emi_hide_show').hide();      
    $('#type_category_emi_start_month_hide_show').hide();      
    $('#type_category_emi_amount_hide_show').hide();
    var staffid = $("#staffname").val();
    var date = $("#date").val();
    loadsalarytype(staffid,date);
});
function loadsalarytype(staffid,date)
{
    $.ajax({
        type:"POST",
        url: "<?php echo base_url(); ?>/payslip/loadsalarytype",
        data: {staff_id:staffid,choosed_date:date},
        success:function(data)
        {
            $("#pay_type").empty();
            $("#pay_type").html(data);
            $("#pay_type").selectpicker('refresh');
        }
    });
}

$("#pay_type").change(function(){
    $(".amount_change").attr("max",0);
    $("#amount").prop("readonly", true);
    $("#max_amount").val("");
    $('#emi_amount').val("0.00");
    $("#emi_start_month").val("").prop("min","");
	var pay_type = $(this).val();
	var staffid = $("#staffname").val();
    if(pay_type == 1){
        var ded_month = $("#month_type").val();
        loadstaffsalary(staffid,pay_type,ded_month);
    }
    if(pay_type == 2){
        var ded_month = $("#date").val();
        loadstaffsalary(staffid,pay_type,ded_month);
    }
});
function loadstaffsalary(staffid,paytypeid,dedmonth)
{
    $.ajax({
        type:"POST",
        url: "<?php echo base_url(); ?>/payslip/loadstaffsalary",
        data: {staff_id:staffid,paytype_id:paytypeid,ded_month:dedmonth},
        success:function(response)
        {
           // $("#amount").attr("max", response);
            $("#amount").prop("readonly", false);
            //$("#max_amount").val(response);
            $("#emi_start_month").prop("min",response);
            $("#emi_start_month").val(response);
        }
    });
}


$('document').ready(function() {    
    $("#submit").click(function(){
        var staff       = $("#staffname").val();
        var amount     = $("#amount").val();
        if(amount > 0 && amount != ''){
            if(staff != '' && staff != 0){
                $.ajax({
                    url: "<?php echo base_url();?>/payslip/save_advancesalary",
                    type: "post",
                    data: $("form").serialize(),
                    success:function(data){
                        //return data;
                        obj = jQuery.parseJSON(data);
                        if(obj.err != ''){
                            $('#alert-modal').modal('show', {backdrop: 'static'});
                            $("#spndeddelid").text(obj.err);
                        }else{					
							if($("#print").prop('checked')==true) {
                               // printData(obj.id);
                                window.open("<?php echo base_url(); ?>/payslip/print_advance_salary/"+obj.id);
					            window.location.replace("<?php echo base_url();?>/payslip/advance_salary");
                            }
							else {
                                window.location.reload(true);
                            }
						}
                    }
                });
            }else{
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text('Please Choose Staff');
            }
        }else{
            $('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text('Advance Salary Amount Not Zero or Minus');
        }
    });

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/payslip/print_advance_salary/"+id,
            type: 'POST',
            success: function (result) {
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
		//window.location.reload(true);
        window.location.replace("<?php echo base_url();?>/payslip/advance_salary");
        //return true;
    }
});
</script>