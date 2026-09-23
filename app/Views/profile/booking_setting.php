<?php global $lang; ?>
<section class="content">
    <div class="container-fluid">
        <?php if ($_SESSION['succ'] != '') { ?>
            <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                <div class="suc-alert">
                    <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <p>
                        <?php echo $_SESSION['succ']; ?>
                    </p>
                </div>
            </div>
        <?php } ?>
        <?php if ($_SESSION['fail'] != '') { ?>
            <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <p>
                        <?php echo $_SESSION['fail']; ?>
                    </p>
                </div>
            </div>
        <?php } ?>
        <div class="block-header">
            <h2>
                <?php echo $lang->booking; ?><small>
                    <?php echo $lang->booking; ?> / <a href="#" target="_blank">
                        <?php echo $lang->booking; ?>
                        <?php echo $lang->setting; ?>
                    </a>
                </small>
            </h2>
        </div>

        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8">
                                <h2>
                                    <?php echo $lang->booking; ?>  <?php echo $lang->setting; ?>
                                </h2>
                            </div>
                            <div class="col-md-4" align="right"></div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>/profile/save_booking_setting" method="POST" enctype="multipart/form-data">
                        <div class="body">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <input type="checkbox" class="form-control" name="setting[archanai_discount]" id="archanai_discount"<?php echo !empty($setting['archanai_discount']) ? ' checked="checked"' : ''; ?>" value="1">
                                                <label class="form-label" for="archanai_discount"><?php echo $lang->archanai; ?> <?php echo $lang->discount; ?> <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 archanai_discount">
										<div class="form-group">
											<select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="setting[discount_archanai_ledger_id]" id="discount_archanai_ledger_id">
												<option value="">Discount Ledger</option>
												<?php
												if(!empty($discount_ledgers))
												{
													foreach($discount_ledgers as $ledger)
													{
												?>
													<option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($setting['discount_archanai_ledger_id'])){ if($setting['discount_archanai_ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <input type="checkbox" class="form-control" name="setting[hall_discount]" id="hall_discount"<?php echo !empty($setting['hall_discount']) ? ' checked="checked"' : ''; ?>" value="1">
                                                <label class="form-label" for="hall_discount"><?php echo $lang->hall; ?> <?php echo $lang->discount; ?> <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 hall_discount">
										<div class="form-group">
											<select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="setting[discount_hall_ledger_id]" id="discount_hall_ledger_id">
												<option value="">Discount Ledger</option>
												<?php
												if(!empty($discount_ledgers))
												{
													foreach($discount_ledgers as $ledger)
													{
												?>
													<option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($setting['discount_hall_ledger_id'])){ if($setting['discount_hall_ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <input type="checkbox" class="form-control" name="setting[ubayam_discount]" id="ubayam_discount"<?php echo !empty($setting['ubayam_discount']) ? ' checked="checked"' : ''; ?>" value="1">
                                                <label class="form-label" for="ubayam_discount"><?php echo $lang->ubayam; ?> <?php echo $lang->discount; ?> <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 ubayam_discount">
										<div class="form-group">
											<select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="setting[discount_ubayam_ledger_id]" id="discount_ubayam_ledger_id">
												<option value="">Discount Ledger</option>
												<?php
												if(!empty($discount_ledgers))
												{
													foreach($discount_ledgers as $ledger)
													{
												?>
													<option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($setting['discount_ubayam_ledger_id'])){ if($setting['discount_ubayam_ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <input type="checkbox" class="form-control" name="setting[prasadam_discount]" id="prasadam_discount"<?php echo !empty($setting['prasadam_discount']) ? ' checked="checked"' : ''; ?>" value="1">
                                                <label class="form-label" for="prasadam_discount"><?php echo $lang->prasadam; ?> <?php echo $lang->discount; ?> <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 prasadam_discount">
										<div class="form-group">
											<select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="setting[discount_prasadam_ledger_id]" id="discount_prasadam_ledger_id">
												<option value="">Discount Ledger</option>
												<?php
												if(!empty($discount_ledgers))
												{
													foreach($discount_ledgers as $ledger)
													{
												?>
													<option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($setting['discount_prasadam_ledger_id'])){ if($setting['discount_prasadam_ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<!-- <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <input type="checkbox" class="form-control" name="setting[annathanam_discount]" id="annathanam_discount"<?php echo !empty($setting['annathanam_discount']) ? ' checked="checked"' : ''; ?>" value="1">
                                                <label class="form-label" for="annathanam_discount"><?php echo $lang->annathanam; ?> <?php echo $lang->discount; ?> <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 annathanam_discount">
										<div class="form-group">
											<select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="setting[discount_annathanam_ledger_id]" id="discount_annathanam_ledger_id">
												<option value="">Discount Ledger</option>
												<?php
												if(!empty($discount_ledgers))
												{
													foreach($discount_ledgers as $ledger)
													{
												?>
													<option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($setting['discount_annathanam_ledger_id'])){ if($setting['discount_annathanam_ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
								</div> -->
                                <div class="row clearfix">
                                    <div class="col-sm-12" align="center">
                                        <button type="submit" class="btn btn-success btn-lg waves-effect">
                                            <?php echo $lang->update; ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
	$('#archanai_discount').on('change', function(){
		if($(this).is(":checked")) $('.archanai_discount').show();
		else  $('.archanai_discount').hide();
	});
	$('#hall_discount').on('change', function(){
		if($(this).is(":checked")) $('.hall_discount').show();
		else  $('.hall_discount').hide();
	});
	$('#ubayam_discount').on('change', function(){
		if($(this).is(":checked")) $('.ubayam_discount').show();
		else  $('.ubayam_discount').hide();
	});
	$('#prasadam_discount').on('change', function(){
		if($(this).is(":checked")) $('.prasadam_discount').show();
		else  $('.prasadam_discount').hide();
	});
	$('#annathanam_discount').on('change', function(){
		if($(this).is(":checked")) $('.annathanam_discount').show();
		else  $('.annathanam_discount').hide();
	});
	$('#archanai_discount').trigger("change");
	$('#hall_discount').trigger("change");
	$('#ubayam_discount').trigger("change");
	$('#prasadam_discount').trigger("change");
	$('#annathanam_discount').trigger("change");
});
</script>