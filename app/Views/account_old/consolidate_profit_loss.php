<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }

    .thead{
        color: #fff;
        background-color: #a1a09f;
    }
    a:hover { text-decoration: none; }*/
	.card .body .col-xs-3, .card .body .col-sm-3, .card .body .col-md-3, .card .body .col-lg-3 {
		 margin-bottom: 0px; 
	}
	.card .body .col-xs-12, .card .body .col-sm-12, .card .body .col-md-12, .card .body .col-lg-12 {
        margin-bottom: 0;
    }
	.form-group { margin-bottom: 0; }
</style>
<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>
<section class="content">
    <div class="container-fluid">
        <!--<div class="block-header">
            <h2> ACCOUNTS<small>Accounts / Profit Loss</small></h2>
        </div>
         Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Consolidate Profit Loss</h2></div>
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
                        <div calss="row" style="margin-top:15px;">
                            <form id="dateform" method="post">
                                <div class="col-md-12">
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
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <button type="submit" id="submit" class="btn btn-success">Submit</button>
                                            <label id="print" class="btn btn-primary">Print</label>
                                        </div>                                            
                                    </div>
                                </div>
                            </form>
							<form style="display: none;" target="_blank" action="<?php echo base_url();?>/accountreport/print_consolidate_profit_loss" method="POST" id="print_profit">
								<input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $tdate; ?>">
                                <button type="submit" id="print_sub" class="btn btn-success">Submit</button>
                            </form>
                         </div>
                        <div class="row"><div class="table-responsive col-md-12" style="margin-top:15px;">
                            <table class="table table-striped table_wrapper" style="width:40%;">
                                <thead>
                                    <tr>
                                        <th style="width: 75%;" class="thead">Account Name</th>
                                        <?php
                                        if(count($job_codes) > 0){
                                            foreach($job_codes as $job_code){
                                        ?>
                                        <th class="thead"><?php echo $job_code['job_code']; ?></th>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($table as $row) { ?>
                                        <?php echo $row; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><h1 align="center" style="margin-top: -19px;"><?php echo $profit; ?></h1></div>
                        <div calss="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#print").click(function(){
        $("#print_sub").trigger('click');
    });
</script>