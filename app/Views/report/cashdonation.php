<?php global $lang;?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-3 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:center; }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->cash; ?> <?php echo $lang->donation; ?> <?php echo $lang->report; ?><small><?php echo $lang->donation; ?> / <b><?php echo $lang->cash; ?> <?php echo $lang->donation; ?> <?php echo $lang->booking; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            
                        <form action="<?php echo base_url(); ?>/report/print_cashreport" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
										<div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="payfor" id="payfor">
                                                        <option value="0"><?php echo $lang->select; ?> <?php echo $lang->paid_for; ?></option>
                                                        <?php
                                                        foreach($dons_set as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
													<label class="form-label"></label>
												</div>
											</div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="fltername" id="fltername">
                                                        <option value="0"><?php echo $lang->select; ?> <?php echo $lang->name; ?></option>
                                                        <?php
                                                        foreach($dons_name as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
													<label class="form-label"></label>
												</div>
											</div>                                            
                                        </div>
                                            <div class="col-md-2 col-sm-4">
                                                <div class="form-group form-float">                                        
                                                    <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>
                                                </div>
                                            </div>
                                            
                                            
                                        <div class="col-md-12 col-sm-12" style="margin:0px;">                                    
											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
											<input name="pdf_cashdonationreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_cashdonationreport" value="PDF">
											<input name="excel_cashdonationreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_cashdonationreport" value="EXCEL">
										</div>
                                        </div>
                                    </div>
                                    <div class="row" id="cash_donation_setting" style="display:none;">
										<p>&nbsp;</p>
										<div class="col-sm-4">
											<div class="form-group form-float">
												<div class="form-line focused">
													<input type="text" id="targetamt" name="targetamt" class="form-control" value="0" readonly="">
													<label class="form-label"><?php echo $lang->target; ?> <?php echo $lang->amount; ?></label>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group form-float">
												<div class="form-line focused">
													<input type="text" id="collectedamt" name="collectedamt" class="form-control" value="0" readonly="">
													<label class="form-label"><?php echo $lang->collected; ?> <?php echo $lang->amount; ?>  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-4 bal_amnt_div">
											<div class="form-group form-float">
												<div class="form-line focused">
													<input type="text" id="balanceamt" name="balanceamt" class="form-control" value="0" readonly="">
													<label class="form-label"><?php echo $lang->balance; ?> <?php echo $lang->amount; ?></label>
												</div>
											</div>
										</div>
									</div>	
                                </div>
                                </form>
                                <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables">        
                                <thead>
                                        <tr>
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:10%;"><?php echo $lang->date; ?></th>
                                            <th style="width:40%;"><?php echo $lang->paid_for; ?></th>
                                            <th style="width:35%;"><?php echo $lang->name; ?></th>
                                            <th style="width:10%;"><?php echo $lang->amount; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    

                                    </tbody>
                                </table>
                            </div>
           
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    
$(document).ready
(
    function()
    {        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/cash_don_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.payfor = $('#payfor').val();
                    data.fltername = $('#fltername').val();
                    }
            },
        });

        $('#submit').click(function() {
			report.ajax.reload();
			
			if($("#payfor").val() != "0")
			{
				$("#cash_donation_setting").css("display", "block");
				var setting_id = $("#payfor").val();
				$.ajax({
					type:"POST",
					url: "<?php echo base_url(); ?>/donation/get_donation_amount",
					data: {setting_id, setting_id},
					dataType: 'json',
					success:function(data){
						console.log(data.data);
						if(typeof data.data != 'undefined'){
							$('#targetamt').val(data.data.total_amount);
							$('#collectedamt').val(data.data.collected_amount);
							var balance_amount = parseFloat(data.data.total_amount) - parseFloat(data.data.collected_amount);
							if(balance_amount >= 0){
								$('.bal_amnt_div').show();
								$('#balanceamt').val(balance_amount);
							}
							else 
							{	
								$('#balanceamt').val(0);
								$('.bal_amnt_div').show();
							}
						}else{
							$('#targetamt').val(0);
							$('#collectedamt').val(0);
							$('#balanceamt').val(0);
							$('.bal_amnt_div').hide();
						}
					},
					error:function(err){
						console.log('err');
						console.log(err);
						$('#targetamt').val(0);
						$('#collectedamt').val(0);
						$('#balanceamt').val(0);
						$('.bal_amnt_div').hide();
					}
				});
			}
			else
			{
				$("#cash_donation_setting").css("display", "none");
			}
			
        });
    });
    
    
</script>