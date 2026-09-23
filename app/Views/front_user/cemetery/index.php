<section class="content">
    <div class="container-fluid">
			<?php if($_SESSION['succ'] != '') { ?>
                <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                    <div class="suc-alert">
                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p><?php echo $_SESSION['succ']; ?></p> 
                    </div>
                </div>
            <?php } ?>
            <?php if($_SESSION['fail'] != '') { ?>
                <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p><?php echo $_SESSION['fail']; ?></p>
                    </div>
                </div>
            <?php } ?>
            <div class="block-header">
            <h2>CEMETERY<small>Cemetery / <a href="#" target="_blank">Cemetery Setting</a></small></h2>
        </div>
		
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><h2>Cemetery</h2></div>
                            <div class="col-md-4" style="text-align:right"><button class="btn btn-warning" type="button" onclick="appen()">+</button></div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>/cemetery/save" method="POST">
                    <div class="body"> 
                        <div class="container-fluid">
                        <div class="row clearfix">
                        <div class="add_box">
							<?php
							$db = \Config\Database::connect();
							$check_cemetery_settings = $db->table('cemetery_settings')->get()->getResultArray();
							if(count($check_cemetery_settings) > 0)
							{
								$i = 1;
								foreach($check_cemetery_settings as $cemesett_row)
								{
							?>
							<div id='cemetery_row_<?php echo $i; ?>' class='row'>
								<div class='col-sm-6'>
									<div class='form-group form-float'>
										<div class='form-line'>
										<input type="text" class="form-control" name="cemetery_setting_name[]" id="cemetery_setting_name<?php echo $i; ?>" value="<?php echo $cemesett_row['meta_key']; ?>">
										<label class='form-label'>Name <span style='color: red;'> *</span></label>
										</div>
									</div>
								</div>
								<div class='col-sm-5'>
									<div class='form-group form-float'>
										<div class='form-line'>
											<input type="text" class="form-control" name="cemetery_setting_amount[]" id="cemetery_setting_amount<?php echo $i; ?>" value="<?php echo $cemesett_row['meta_value']; ?>">
											<label class='form-label'>Amount <span style='color: red;'> *</span></label>
										</div>
									</div>
								</div>
								<div class='col-sm-1' style="text-align:right">
									<button class='btn btn-warning' type='button' onclick='remove_row(<?php echo $i; ?>)' id='remove_new'>-</button>
								</div>
							</div>
							<?php
								$i++;
								}
								$total_count = count($check_cemetery_settings);
							}
							else
							{
								$total_count = 0;
							}
							?>
                            <input type="hidden" id="tot_count" value="<?php echo $total_count; ?>">
                        </div>
                        </div>
                        <div class="row">
							<button class="btn btn-success" type="submit" name="cemetery_submit" id="cemetery_submit" style="<?php if(count($check_cemetery_settings) > 0)
							{ echo "display:block;"; } else { echo "display:none;"; } ?>">SAVE</button>
						</div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.4.js"></script>
<script>
function appen() {
	var count = parseInt($("#tot_count").val()) + 1;
	var html = "<div id='cemetery_row_"+count+"' class='row'><div class='col-sm-6'><div class='form-group form-float'><div class='form-line'><input type='text' class='form-control' required name='cemetery_setting_name[]' id='cemetery_setting_name"+count+"'><label class='form-label'>Name <span style='color: red;'> *</span></label></div></div></div><div class='col-sm-5'><div class='form-group form-float'><div class='form-line'><input type='text' class='form-control' name='cemetery_setting_amount[]' id='cemetery_setting_amount"+count+"'><label class='form-label'>Amount <span style='color: red;'> *</span></label></div></div></div><div class='col-sm-1' style='text-align:right'><button class='btn btn-warning' type='button' onclick='remove_row("+count+")' id='remove_new'>-</button></div></div>";
	$(".add_box").append(html);
	//var cnt = count + 1;
	if(count > 0)
	{
		$("#cemetery_submit").css("display","block");
	}
	else
	{
		$("#cemetery_submit").css("display","none");
	}
	$("#tot_count").val(count);
}
function remove_row(id){
    $('#cemetery_row_'+id).remove();
	var t_count = $("#tot_count").val();
	var cnt = t_count - 1;
	$("#tot_count").val(cnt);
	if(cnt > 0)
	{
		$("#cemetery_submit").css("display","block");
	}
	else
	{
		$("#cemetery_submit").css("display","none");
	}
}
</script>
