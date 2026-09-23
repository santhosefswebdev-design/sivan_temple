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
            <h2>PAY SLIP<small>Finance / <b>Add Pay Slip</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/payslip"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        
                        <form  id="form_submit">

                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container" >
                                                <input type="date" name="date" id="date"  class="form-control" value="<?php if($view == true){ echo $data['date']; } else { echo  date('Y-m-d'); } ?>" <?php echo $readonly; ?> max="<?php echo date('Y-m-d'); ?>">
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
                                                <option value="<?php echo $st['id']; ?>"><?php echo $st['name']; ?></option>
                                                <?php } ?>
                                        		</select>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" name="invno" id="invno" class="form-control" value="<?= $ref_no ?>" readonly>
                                            <label class="form-label">Ref No</label>
                                        </div>
                                    </div>
                                </div>
								
								<!--<div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <!--<input type="text" name="description" id="description" class="form-control" value="">
                                            <label class="form-label">Description</label> -->
											<!--<select class="form-control show-tick" name="description" id="description" required <?php echo $disable; ?>>
                                                <option value="">-- Select Description --</option>
                                                <option value="1">Salary</option>
                                                <option value="2">Commission</option>
                                                <option value="3">Service Fees</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>-->
								<div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="description" id="description" class="form-control" value="<?php echo $data['groupname'];?>" <?php echo $readonly; ?> >
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line ">
                                            <input type="number" min="0" step=".01"  name="earning" id="earning" class="form-control" value="0.00" >
                                            <label class="form-label">Earning</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" min="0" step=".01"  name="deduction" id="deduction" class="form-control" value="0.00" >
                                            <label class="form-label">Deduction</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                	<div class="form-group form-float">
                                    	<!-- <button class="btn btn-success" onclick="appen()" type="button"><i class="glyphicon glyphicon-plus"></i></button> -->
										<label id="pay_add" class="btn btn-success" style="padding: 5px 12px !important;"><i class="glyphicon glyphicon-plus"></i></label>
                                    </div>
                                </div>
                                <br><br>
                                <table class="table table-bordered table-striped table-hover" id="pay_table" border="1 " style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th style="width:40%;text-align: center;">Description</th>
                                      <th style="width:25%;text-align: center;">Earning</th>
                                      <th style="width:25%;text-align: center;">Deduction</th>
                                      <th style="width:10%;text-align: center;">Delete</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                                <input type="hidden" id="pay_row_count" value="0">
                                <br>
                                <div class="col-sm-12" id="display_emi_dedection_show_hide" style="display:none;">
                                    <input  type="checkbox" id="emi_deduction" name="emi_deduction" value="1">
									<label for ='emi_deduction'> Except EMI deduction to this month </label>
                                    <br>
                                    <br>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Earning</label>
                                            <input type="number" id="tot_earn" name="tot_earn" class="form-control" value="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Deduction</label>
                                            <input type="number" id="tot_ded" name="tot_ded" class="form-control" value="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Netpay</label>
                                            <input type="number" id="net_pay" name="net_pay" class="form-control" value="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="paymentmode" id="paymentmode">
                                                <option value="0">Select</option>
                                                <?php foreach($payment_modes as $payment_mode) { ?>
                                                <option value="<?php echo $payment_mode['id']; ?>"><?php echo $payment_mode['name'];?></option>
                                                <?php } ?>
                                            </select>
                                            <label class="form-label">Payment Mode <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <label class="form-label">Amount in Words</label>
                                            <input type="text" readonly name="wamount" id="wamount" class="form-control" value="<?php //echo AmountInWords($data['total_amount']); ?>" <?php echo $readonly; ?> >
                                        </div>
                                    </div>
                                </div> -->
                                
                                
                                <?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
                                    <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
									<label for ='print'> Print &nbsp;&nbsp; </label>
									<a id="submit" class="btn btn-success btn-lg waves-effect">SAVE</a>
                                    
                                    <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                </div>
                                <?php } ?>
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
	
    $('#emi_deduction').change(function() {
        sum_net_pay();
    });
    
	$('#date').change(function() {
		
        $.ajax
            ({
                type:"POST",
                url: "<?php echo base_url();?>/payslip/getrefno",
                data:{date:$('#date').val()},
                success:function(data)
                {
                    //alert(data);
                   $('#invno').val(data);
                   $("#staffname").val("");
                   $("#staffname").selectpicker('refresh');
                   $("#tot_earn").val('0.00');
                    $("#tot_ded").val('0.00');
                    $("#net_pay").val('0.00');
                    $(".all_close").empty();
                    $("#display_emi_dedection_show_hide").hide();
                }
            })
    });
	$("#deduction").keyup(function(){
		
		// alert($("#deduction").val())
		if (parseFloat($("#deduction").val())>0)
		{
			if (parseFloat($("#earning").val())>0)
			{
				// alert('Earning Should be ZERO')
				$('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text('Earning Should be ZERO');
				$("#deduction").val('0.00');				
			}
		}
	});
	
	$("#earning").keyup(function(){
		
		// alert($("#deduction").val())
		if (parseFloat($("#earning").val())>0)
		{
			if (parseFloat($("#deduction").val())>0)
			{
				// alert('Deduction Should be ZERO')
				$('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text('Deduction Should be ZERO');
				$("#earning").val('0.00');				
			}
		}
	});
	
	$("#staffname").change(function(){
		// $('#deduction').val('0.00');
		// $('#earning').val('0.00');
            
			$("#tot_earn").val('0.00');
			$("#tot_ded").val('0.00');
			$("#net_pay").val('0.00');
			$(".all_close").empty();
            $("#display_emi_dedection_show_hide").hide();
			if ($("#staffname").val() !='')
			{
				$.ajax({
						url: "<?php echo base_url();?>/payslip/get_earn",
						type: "post",
						data: {staff_id:$("#staffname").val(), date: $("#date").val()},
						dataType: "json",
						success: function(data){
							console.log(data)
							//alert(data['sal_amt']) 
							//alert(data['com_amt'])
							var cnt_ft = parseInt($("#pay_row_count").val());
							var epf = data['epf_amt'].split('_');	
							var socso = data['socso_amt'].split('_');	
							var eis = data['eis_amt'].split('_');	
							//var name = $("#description").text();
								
							if (parseFloat(data['sal_amt'])>0)
							{
								html = '<tr class="all_close" id="rmv_pay_row'+cnt_ft+'">';
								html += '<td ><input style="width: 100%;" type="text" readonly class="pay_desc pay_row" name="pay['+cnt_ft+'][pay_name]" value="' + data['sal_txt'] + '"></td>';
								html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt_ft+'][pay_earn]" value="'+ Number(data['sal_amt']).toFixed(2) +'"></td>';
								html += '<td ><input type="text" readonly class="pay_ded pay_row" name="pay['+cnt_ft+'][pay_ded]" value="0.00"></td>';
								html += '<td ></td>';
								html += '</tr>';
								$("#pay_table").append(html);
                                cnt_ft++;
                                $("#pay_row_count").val(cnt_ft);
							}
                            if (parseFloat(data['allowance_amt'])>0)
							{
								html = '<tr class="all_close" id="rmv_pay_row'+cnt_ft+'">';
								html += '<td ><input style="width: 100%;" type="hidden" readonly class="pay_type pay_row" name="pay['+cnt_ft+'][pay_type]" value="Earnings"><input style="width: 100%;" type="text" readonly class="pay_desc pay_row" name="pay['+cnt_ft+'][pay_name]" value="Allowance"></td>';
								html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt_ft+'][pay_earn]" value="'+ Number(data['allowance_amt']).toFixed(2) +'"></td>';
								html += '<td ><input type="text" readonly class="pay_ded pay_row" name="pay['+cnt_ft+'][pay_ded]" value="0.00"></td>';
								html += '<td ></td>';
								html += '</tr>';
								$("#pay_table").append(html);
                                cnt_ft++;
                                $("#pay_row_count").val(cnt_ft);
							}
							if (parseFloat(data['com_amt'])>0)
							{
								html = '<tr class="all_close" id="rmv_pay_row'+cnt_ft+'">';
								html += '<td ><input style="width: 100%;" type="text" readonly class="pay_desc pay_row" name="pay['+cnt_ft+'][pay_name]" value="Commission"></td>';
								html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt_ft+'][pay_earn]" value="'+ Number(data['com_amt']).toFixed(2) +'"></td>';
								html += '<td ><input type="text" readonly class="pay_ded pay_row" name="pay['+cnt_ft+'][pay_ded]" value="0.00"></td>';
								html += '<td ></td>';
								html += '</tr>';	
								$("#pay_table").append(html);
                                cnt_ft++;
                                $("#pay_row_count").val(cnt_ft);
							}
                            if (parseFloat(epf[1])>0 && epf[0] == 1){
								html = '<tr class="all_close" id="rmv_pay_row'+cnt_ft+'">';
								html += '<td ><input style="width: 100%;" type="hidden" readonly class="pay_type pay_row" name="pay['+cnt_ft+'][pay_type]" value="Deductions"><input style="width: 100%;" type="text" readonly class="pay_desc pay_row" name="pay['+cnt_ft+'][pay_name]" value="EPF"></td>';
								html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt_ft+'][pay_earn]" value="0.00"></td>';
								html += '<td ><input type="text" readonly class="pay_ded pay_row" name="pay['+cnt_ft+'][pay_ded]" value="'+ Number(epf[1]).toFixed(2) +'"></td>';
								html += '<td ></td>';
								html += '</tr>';
							    $("#pay_table").append(html);
                                cnt_ft++;
                                $("#pay_row_count").val(cnt_ft);
							}
                            if (parseFloat(socso[1])>0 && socso[0] == 1){
								html = '<tr class="all_close" id="rmv_pay_row'+cnt_ft+'">';
								html += '<td ><input style="width: 100%;" type="hidden" readonly class="pay_type pay_row" name="pay['+cnt_ft+'][pay_type]" value="Deductions"><input style="width: 100%;" type="text" readonly class="pay_desc pay_row" name="pay['+cnt_ft+'][pay_name]" value="SOCSO"></td>';
								html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt_ft+'][pay_earn]" value="0.00"></td>';
								html += '<td ><input type="text" readonly class="pay_ded pay_row" name="pay['+cnt_ft+'][pay_ded]" value="'+ Number(socso[1]).toFixed(2) +'"></td>';
								html += '<td ></td>';
								html += '</tr>';
							    $("#pay_table").append(html);
                                cnt_ft++;
                                $("#pay_row_count").val(cnt_ft);
							}
                            if (parseFloat(eis[1])>0 && eis[0] == 1){
								html = '<tr class="all_close" id="rmv_pay_row'+cnt_ft+'">';
								html += '<td ><input style="width: 100%;" type="hidden" readonly class="pay_type pay_row" name="pay['+cnt_ft+'][pay_type]" value="Deductions"><input style="width: 100%;" type="text" readonly class="pay_desc pay_row" name="pay['+cnt_ft+'][pay_name]" value="EIS"></td>';
								html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt_ft+'][pay_earn]" value="0.00"></td>';
								html += '<td ><input type="text" readonly class="pay_ded pay_row" name="pay['+cnt_ft+'][pay_ded]" value="'+ Number(eis[1]).toFixed(2) +'"></td>';
								html += '<td ></td>';
								html += '</tr>';
							    $("#pay_table").append(html);
                                cnt_ft++;
                                $("#pay_row_count").val(cnt_ft);
							}
							if (parseFloat(data['adv_amt'])>0){
								html = '<tr class="all_close" id="rmv_pay_row'+cnt_ft+'">';
								html += '<td ><input style="width: 100%;" type="text" readonly class="pay_desc pay_row" name="pay['+cnt_ft+'][pay_name]" value="Advance Salary"></td>';
								html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt_ft+'][pay_earn]" value="0.00"></td>';
								html += '<td ><input type="text" readonly class="pay_ded pay_row" name="pay['+cnt_ft+'][pay_ded]" value="'+ Number(data['adv_amt']).toFixed(2) +'"></td>';
								html += '<td ></td>';
								html += '</tr>';	
							    $("#pay_table").append(html);
                                cnt_ft++;
                                $("#pay_row_count").val(cnt_ft);
							}
                            if (parseFloat(data['emi_dedection_option'])>0){
                                $("#display_emi_dedection_show_hide").show();
                                html = '<tr class="all_close" id="rmv_pay_row'+cnt_ft+'">';
								html += '<td ><input style="width: 100%;" type="text" readonly class="pay_desc pay_row" name="pay['+cnt_ft+'][pay_name]" value="Monthly Loan EMI"></td>';
								html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt_ft+'][pay_earn]" value="0.00"></td>';
								html += '<td ><input type="text" readonly class="pay_ded pay_row loan_deduction_amt" name="pay['+cnt_ft+'][pay_ded]" value="'+ Number(data['emi_dedection_option']).toFixed(2) +'"></td>';
								html += '<td ></td>';
								html += '</tr>';	
							    $("#pay_table").append(html);
                                cnt_ft++;
                                $("#pay_row_count").val(cnt_ft);
                            }
							//cnt_ft++;
							
							sum_net_pay();
							//<a class="btn btn-danger btn-rad" onclick="rmv_pay('+ cnt++ +')" ><i class="material-icons"></i></a>
							//$("#earning").val(data['amt']);
						}
					});
			}
		
		
		// $("#description").trigger("change");
		});
	$("#description").change(function(){
	//var descr= 
	
	//alert(0)
	
		if ( $("#description").val().toLowerCase() == "salary" || $("#description").val().toLowerCase() == "commission") 
		{
			//alert($("#staffname").val());
			
			$('#earning').prop('readonly', true);
			$('#deduction').prop('readonly', true);
			$('#deduction').val('0.00');
			$.ajax({
                url: "<?php echo base_url();?>/payslip/get_earn",
                type: "post",
                data: {staff_id:$("#staffname").val()},
                dataType: "json",
                success: function(data){
                    console.log(data)
					//alert (data['amt']);
                    //$("#get_pack_amt").val(Number(data['amt']).toFixed(2));
                    //$("#earning").val(data['amt']);
					
					if ($("#description").val().toLowerCase() == "salary") 
					$("#earning").val(data['sal_amt']);
					if ($("#description").val().toLowerCase() == "commission") 
					$("#earning").val(data['com_amt']);
				
					$("#deduction").val('0.00');
					$('#earning').prop('readonly', false);
					$('#deduction').prop('readonly', false);
                }
            });
		}
		else 
		{
			//alert('ser');
			$('#earning').val('0.00');
			$('#deduction').val('0.00');
			$('#earning').prop('readonly', false);
			$('#deduction').prop('readonly', false);
		}		
	});
	
	$("#pay_add").click(function(){		
		$(".pay_desc").each(function(){
			
			   if ( $(this).val().toLowerCase() == "salary" || $(this).val().toLowerCase() == "commission") 
				{
					if ( $(this).val().toLowerCase() == $("#description").val().toLowerCase()) 
					{
						exit;
					}
				}
			});
		// var staffname = $("#staffname").val();
		// var desc = $("#description").text();
		// let desca = $("#description").text();
		// let descb = desca.toLowerCase();
		
		// alert($("#description").val().toLowerCase())
        cnt = parseInt($("#pay_row_count").val());
		earn = parseFloat($("#earning").val());
		ded = parseFloat($("#deduction").val());
		
		
         if( $("#staffname").val() != '' && $("#description").val() != "" && (earn>0 || ded>0) ){
		
			var desc = $("#description").val().toLowerCase();
			 
             var html = '<tr class="all_close" id="rmv_pay_row'+cnt+'">';
                html += '<td ><input type="text" readonly class="pay_desc pay_row" name="pay['+cnt+'][pay_name]" value="'+ $("#description").val() +'"></td>';
                html += '<td ><input type="text" readonly class="pay_earn pay_row" name="pay['+cnt+'][pay_earn]" value="'+ Number(earn).toFixed(2) +'"></td>';
                html += '<td ><input type="text" readonly class="pay_ded pay_row" name="pay['+cnt+'][pay_ded]" value="'+ Number(ded).toFixed(2) +'"></td>';
                html += '<td ><a class="btn btn-danger btn-rad" onclick="rmv_pay('+ cnt +')" ><i class="material-icons"></i></a></td>';
                html += '</tr>';
            $("#pay_table").append(html);
            cnt++;
            $("#pay_row_count").val(cnt);
            sum_net_pay();
			$("#description").val('');
			$("#earning").val('0.00');
			$("#deduction").val('0.00');
         }		
		});
		
});

		function data_check(){
		// alert (0)       
		
		}
		function rmv_pay(id){
		// alert (0)
        $("#rmv_pay_row"+id).remove();
		
        sum_net_pay();
		}
		
		function sum_net_pay(){
			var earn = 0;
			var ded = 0;
			$(".pay_earn").each(function(){
			   earn += parseFloat($(this).val());
			});

			$(".pay_ded").each(function(){
				ded += parseFloat($(this).val());
			});

            if( $('#emi_deduction').is(':checked') ){
                var chec_emi_ded = $(".loan_deduction_amt").val();
                var new_ded = ded - parseFloat(chec_emi_ded);
            }
            else{
                var new_ded = ded;
            }

			$("#tot_earn").val(Number(earn).toFixed(2));
			$("#tot_ded").val(Number(new_ded).toFixed(2));

			var net_pay = earn - new_ded;
			$("#net_pay").val(Number(net_pay).toFixed(2));
			// $("#submit").removeClass('disabled');
			// if ( parseFloat(net_pay) <= 0)
			// {
				// $("#submit").addClass('disabled'); 
				// // alert(0)
				// // $("#submit").prop('disabled', true);
			// }
			// // else
			// // {
				// // $("#submit").prop('disabled', false);
			// // }				

			
		}
    
    $("#submit").click(function(){
        var staff       = $("#staffname").val();
        var net_pay     = $("#net_pay").val();
        var tot_ded     = $("#tot_ded").val();
        var tot_earn    = $("#tot_earn").val();
        if(net_pay >= 0){
            if(staff != '' && staff != 0){
                $.ajax({
                    url: "<?php echo base_url();?>/payslip/save_slip",
                    type: "post",
                    data: $("form").serialize(),
                    success:function(data){
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
									window.location.reload(true);
						}
                    }
                });
            }else{
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text('Please Choose Staff');
            }
        }else{
            $('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text('Net pay amount not zero or minus');
        }
    });

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/payslip/print_page/"+id,
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
		window.location.reload(true);
        //window.location.replace("<?php echo base_url();?>/payslip/payslip_add");
        //return true;
    }
	
	
</script>
<script type="text/javascript">

$("#description").autocomplete({
	source: function( request, response ) {
		$.ajax({
			url: "<?php echo base_url(); ?>/payslip/get_desc",
			type: 'post',
			data: { search: request.term},
			dataType: 'json',
			success: function(data){
				response(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				console.log("error handler!");
			}
		});
	},
	minLength: 1,
	select: function( event, ui ) {
		console.log("Selected: "+ui.item.name);
	}
}); 

  </script>