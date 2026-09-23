<?php global $lang; ?>
<style>

.ui-autocomplete{
            padding: 0px !important;
    }
    .ui-autocomplete ul{
        background-color: #5d8dff; font-size:14px;
    }
    li a{
        color: #fff;
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
            <h2><?php echo $lang->account; ?> <?php echo $lang->setting; ?> <small><?php echo $lang->account; ?> / <b><?php echo $lang->add; ?> <?php echo $lang->account; ?> <?php echo $lang->setting; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/accountsetting/save" method="POST" enctype='multipart/form-data'>
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
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
										<label class="form-label"  style="display: contents;"><?php echo $lang->start; ?> <?php echo $lang->month; ?> <span style="color: red;">*</span></label>
										<select class="form-control" id='start_month' name="start_month" required>
											<option value='4'>April</option>
										</select> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
										<label class="form-label"  style="display: contents;"><?php echo $lang->end; ?> <?php echo $lang->month; ?> <span style="color: red;">*</span></label>
										<select class="form-control" id='end_month' name="end_month" required>
											<option value='3'>March</option>
										</select> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
					<div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                        <button type="submit" class="btn btn-success btn-lg waves-effect"><?php echo $lang->save; ?></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
    $("#clear").click(function(){
       $("select").val("");
    });
</script>