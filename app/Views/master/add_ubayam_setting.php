<?php 
if($view == true){
    $readonly = 'readonly';
    $disabled = 'disabled';
}
?>
<style>
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

<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>

</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>UBAYAM SETTING<small>Ubayam / <a href="#" target="_blank">Add Ubayam Setting</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Ubayam Setting</h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/ubayam_setting"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/master/save_ubayam_setting" method="POST"  enctype="multipart/form-data">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
							<div class="row clearfix">
                                  <div class="col-sm-3">
    <div class="form-group form-float">
        <div class="form-line">
            <select name="groupname" class="form-control">
                <option value="">-- Select Ubayam Group --</option>
                <?php foreach ($group as $row) { ?>
                                                            <option value="<?php echo $row['name']; ?>" <?php echo ($row['name'] == $data['groupname']) ? 'selected' : ''; ?>>
                                                                <?php echo $row['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
								<div class="col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="text"  class="form-control" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
											<label class="form-label">Name <span style="color: red;"> *</span></label>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="text"  class="form-control" name="description" value="<?php echo $data['description'];?>" <?php echo $readonly; ?>>
											<label class="form-label">Description</label>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="date" step=".01" class="form-control" name="ubayam_date" value="<?php echo $data['ubayam_date']; ?>" <?php echo $readonly; ?>>
											<label class="form-label">Ubayam Date</label>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="number" step=".01" class="form-control" name="amount" value="<?php echo number_format($data['amount'], '2','.',''); ?>" <?php echo $readonly; ?>>
											<label class="form-label">Amount <span style="color: red;"> *</span></label>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="event_type" id="event_type" <?php echo $disabled; ?>>
                                                <option value="">select event type</option>
                                                <option value="1" <?php if(!empty($data['event_type'])){ if($data['event_type'] == 1){ echo "selected"; } }?>>Single</option>
                                                <option value="2" <?php if(!empty($data['event_type'])){ if($data['event_type'] == 2){ echo "selected"; } }?>>Multiple</option>
                                            </select>
                                            <label class="form-label">Event Type <span style="color: red;"> *</span></label>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($view != true) { ?>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">Image</label>
                                                <input type="file" id="imgInp" name="ubayam_image" accept="image/png,image/jpeg,image/jpg"
                                                    class="form-control" <?php echo $readonly; ?>>
                                                <!--<label class="form-label">Image</label>-->
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="">
                                            <?php if (!empty($data['image'])) { ?>
                                                <a target="_blank" href="<?php echo base_url(); ?>/uploads/ubayam/<?php echo $data['image']; ?>">
                                                    <img id="img_pre" src="<?php echo base_url(); ?>/uploads/ubayam/<?php echo $data['image']; ?>" width="200" height="160"></img>
                                                </a>
                                            <?php } else { ?>
                                
                                                <!--<a id="img_anchor" target="_blank" href="#"> -->
                                                <img id="img_pre" src="#" width="200" height="160"></img>
                                                <!--</a>  -->
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control search_box" data-live-search="true" name="ledger_id" id="ledger_id">
                                                    <option value="">Select Ledger</option>
                                                    <?php
                                                    if(!empty($ledgers))
                                                    {
                                                        foreach($ledgers as $ledger)
                                                        {
                                                    ?>
                                                        <option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($data['ledger_id'])){ if($data['ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo '(' . $ledger['left_code'] . '/' . $ledger['right_code'] . ") - ".$ledger["name"]; ?> </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

							</div>
						</div>
                    </div>
                    </form>
                    <?php if($view != true) { ?>
                    <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                        <button type="submit" onclick="validations()" class="btn btn-success btn-lg waves-effect">SAVE</button>
                        <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                    </div>
                    <?php } ?>
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
</script>
<script>
    function validations(){
        $.ajax
            ({
            type:"POST",
            url: "<?php echo base_url(); ?>/master/ubayam_validation",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                console.log(obj);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    $('input[type=submit]').prop('disabled', true);
                    $("#loader").show();
                    $("form").submit();
                }
            }
        })
            
    }
</script>
