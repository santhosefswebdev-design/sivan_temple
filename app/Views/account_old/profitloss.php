<?php global $lang; ?>
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
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->account; ?> <small><?php echo $lang->account; ?> /<?php echo $lang->profit_loss; ?> </small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2><?php echo $lang->profit_loss; ?></h2></div>
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
                                                <input type="date" name="sdate" id="sdate" class="form-control" value="<?php echo date("Y-m-d", strtotime($sdate)); ?>">
                                                <label class="form-label"><?php echo $lang->from; ?></label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" id="bs_datepicker_container">
                                                <input type="date" name="edate" id="edate" class="form-control" value="<?php echo date("Y-m-d", strtotime($edate)); ?>">
                                                <label class="form-label"><?php echo $lang->to; ?></label>
                                            </div>                                                        
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">
                                            <button type="submit" id="submit" class="btn btn-success"><?php echo $lang->submit; ?></button>
                                        </div>                                            
                                    </div>
                                </div>
                            </form>
							<form style="display: none;" target="_blank" id="print_sheet" action="<?php echo base_url(); ?>/accountreport/print_profit_loss" method="post">
                               <input type="hidden" name="fdate" id="fdate" class="form-control" value="<?= $sdate; ?>">
                                <input type="hidden" name="tdate" id="tdate" class="form-control" value="<?= $edate; ?>">
                            </form>
                         </div>
                        <div class="row"><div class="table-responsive col-md-12">
                            <table class="table table-striped" style="width:40%;">
                                <thead>
                                    <tr>
                                        <th style="width: 75%;" class="thead"><?php echo $lang->account; ?> <?php echo $lang->name; ?></th>
                                        <th class="thead" style="text-align:right" align="right"><?php echo $lang->amount; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($table as $row) { ?>
                                        <?php echo $row; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><h1 align="center" style="margin-top: -19px;"><?php echo $profit; ?></h1></div>
                        <div class="row">
                            <div class="col-md-12" align="center">
                                <label id="print" class="btn btn-primary"><?php echo $lang->print; ?></label>
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
        $("#print_sheet").submit();
    });
</script>