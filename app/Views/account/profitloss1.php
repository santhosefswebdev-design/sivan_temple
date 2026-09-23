<style>
    .thead{
        color: #fff;
        background-color: #a1a09f;
    }
    a:hover { text-decoration: none; }
	.card .body .col-xs-3, .card .body .col-sm-3, .card .body .col-md-3, .card .body .col-lg-3 {
		 margin-bottom: 0px; 
	}
	.form-group { margin-bottom: 0; }
	.table1 tr th { padding:5px; background:#F3F3F3; text-align:right; min-width:100px !important; }
	.table1 tr td { padding:5px; border:1px solid #CCCCCC; }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> ACCOUNTS<small>Accounts / Profit Loss</small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Profit Loss</h2></div>
                        </div>
                    </div>
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
                        <!-- <div calss="row">
                            <form action="<?php echo base_url();?>/accountreport/profile_loss" method="post">
                                <div class="col-md-12">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="date" name="sdate" id="sdate" class="form-control" value="<?php echo date("Y-m-d", strtotime($sdate)); ?>" />
                                                <label class="form-label">From</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="date" name="edate" id="edate" class="form-control" value="<?php echo date("Y-m-d", strtotime($edate)); ?>" />
                                                <label class="form-label">To</label>
                                            </div>                                                        
                                        </div>                                            
                                    </div> 
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <button type="submit" id="submit" class="btn btn-success">Submit</button>
                                            <a target="_blank" class="btn btn-primary" href="<?php echo base_url(); ?>/accountreport/print_profit_loss">Print</a>
                                        </div>                                            
                                    </div>
                                </div>
                            </form>
                        </div> -->
                        <div calss="row">
                            <form id="dateform" method="post">
                                <div class="col-md-12">
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" id="bs_datepicker_container">
                                                <select class="form-control" id="type">
                                                    <option value="0">Daily</option> 
                                                    <option value="1">Monthly</option> 
                                                </select>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div id="daily">
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused" id="bs_datepicker_container">
                                                    <input type="date" name="sdate" id="sdate" class="form-control" value="<?php echo date("Y-m-d", strtotime($sdate)); ?>">
                                                    <label class="form-label">From</label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused" id="bs_datepicker_container">
                                                    <input type="date" name="edate" id="edate" class="form-control" value="<?php echo date("Y-m-d", strtotime($edate)); ?>">
                                                    <label class="form-label">To</label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                    </div>
                                    
                                    <div id="monthly" style="display:none;">
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused" id="bs_datepicker_container">
                                                    <input type="month" name="fromMonth" id="fromMonth" class="form-control">
                                                    <label class="form-label">From</label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line focused" id="bs_datepicker_container">
                                                    <input type="month" name="toMonth" id="toMonth" class="form-control">
                                                    <label class="form-label">To</label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                    </div>
									<!--<div class="col-md-3 col-sm-2">
                                        <div class="form-group form-float">
                                            <select class="form-control search_box" data-live-search="true" name="fund_id" id="fund_id">
												<option value="">Select Fund</option>
												<?php
												if(!empty($funds))
												{
													foreach($funds as $fund)
													{
												?>
													<option value="<?php echo $fund["id"]; ?>" <?php if($fund_id == $fund["id"]){ echo "selected"; } ?>><?php echo $fund['name'] . '(' . $fund['code'] . ")"; ?> </option>
												<?php
													}
												}
												?>
											</select>                                                   
                                        </div>                                            
                                    </div>-->
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <!--<button type="submit" id="submit" class="btn btn-success">Submit</button>-->
                                            <button type="button" class="btn btn-success" id="submit">Submit</button>
                                        </div>                                            
                                    </div>
                                </div>
                            </form>
							<form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url(); ?>/accountreport/print_profit_loss" method="post">
                               <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $edate; ?>">
                                <input type="hidden" name="fund_id_print" id="fund_id_print" class="form-control" value="<?= $fund_id; ?>">
                            </form>
                         </div>
                        <div class="row"><div class="table-responsive col-md-12">
                            <!--<table class="table table-striped" style="width:40%;">
                                <thead>
                                    <tr>
                                        <th style="width: 75%;" class="thead">Account Name</th>
                                        <th class="thead" style="text-align:right" align="right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($table as $row) { ?>
                                        <?php echo $row; ?>
                                    <?php } ?>
                                </tbody>
                            </table>-->
                            
                            <table border="1" class="table1" style="width:auto !important; overflow:auto">
                                <thead id="tableHeader"></thead>
                                <tbody>
                                	<?php foreach($table as $row) { ?>
                                        <?php echo $row; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            
                        </div><h1 align="center" style="margin-top: -19px;"><?php echo $profit; ?></h1></div>
                        <div class="row">
                            <div class="col-md-12" align="center">
                                <label id="print" class="btn btn-primary">Print</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $("#print").click(function(){
        $("#print_sheet").submit();
    });
	
	$('#monthly').hide();
	$('#type').on('change', function() {
	  var a = this.value;
	  if (a==0) { 
		  $('#daily').show(); 
		  $('#monthly').hide(); 
	  }
	  else if (a==1) { 
		  $('#monthly').show(); 
		  $('#daily').hide(); 
	  }
	});
</script>

<script>
    $(document).ready(function(){
        $("#submit").click(function(){
            var fromMonth = new Date($("#fromMonth").val() + "-01").getMonth();
            var fromYear = new Date($("#fromMonth").val() + "-01").getFullYear();
            var toMonth = new Date($("#toMonth").val() + "-01").getMonth();
            var toYear = new Date($("#toMonth").val() + "-01").getFullYear();
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            
            // Clear previous header
            $("#tableHeader").empty();
            
            // Generate new header based on selected range
            var headerRow = $("<tr></tr>");
			headerRow.append("<th style='width:300px;'>Account Name</th>");
            if (fromYear === toYear) {
                // Months in the same year
                for (var i = fromMonth; i <= toMonth; i++) {
					headerRow.append("<th style='width:100px;'>" + monthNames[i] + " " + fromYear + "</th>");
                }
            } else {
                // Months spanning different years
                for (var i = fromMonth; i < 12; i++) {
					headerRow.append("<th style='width:100px;'>" + monthNames[i] + " " + fromYear + "</th>");
                }
                for (var j = fromYear + 1; j < toYear; j++) {
                    for (var k = 0; k < 12; k++) {
						headerRow.append("<th style='width:100px;'>" + monthNames[k] + " " + j + "</th>");
                    }
                }
                for (var l = 0; l <= toMonth; l++) {
					headerRow.append("<th style='width:100px;'>" + monthNames[l] + " " + toYear + "</th>");
                }
            }
			headerRow.append("<th style='width:130px;'>Total</th>");
            $("#tableHeader").append(headerRow);
        });
    });
</script>