<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Profile<small>Vendor / <b>Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/vendor"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                    <form action="<?php echo base_url(); ?>/vendor/store" method="POST" id="form_validation">
						<input type="hidden" value="<?php echo isset($vendor['id']) ? $vendor['id'] : ""; ?>" name="id" id="updateid">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($vendor['name']) ? $vendor['name'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Name <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="contact_person" id="contact_person" class="form-control" value="<?php echo isset($vendor['contact_person']) ? $vendor['contact_person'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Contact Person <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="address1" id="address1" class="form-control" value="<?php echo isset($vendor['address1']) ? $vendor['address1'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Address 1 </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="address2" id="address2" class="form-control" value="<?php echo isset($vendor['address2']) ? $vendor['address2'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Address 2 </label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="phoneno" id="phoneno" class="form-control" value="<?php echo isset($vendor['phoneno']) ? $vendor['phoneno'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Phone No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="email" id="email" class="form-control" value="<?php echo isset($vendor['email']) ? $vendor['email'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Email ID</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="city" id="city" class="form-control" value="<?php echo isset($vendor['city']) ? $vendor['city'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">City </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="state" id="state" class="form-control" value="<?php echo isset($vendor['state']) ? $vendor['state'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">State </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="country" id="country" class="form-control" value="<?php echo isset($vendor['country']) ? $vendor['country'] : ""; ?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Country </label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="remarks" id="remarks" class="form-control" <?php echo $readonly; ?>><?php echo isset($vendor['remarks']) ? $vendor['remarks'] : ""; ?></textarea>
                                        <label class="form-label">Remarks</label>
                                    </div>
                                </div>
                            </div>
							<div style="clear:both"></div>
                        </div>
                        <?php if($view != true) { ?>
                        <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                            <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                        </div>
                        <?php } ?>
                    </div>
                    </form>
                    
                    </div>
             
            </div>
        </div>
    </div>
    </div>

</section>
<script>
$('#form_validation').validate({
	rules: {
		"name": {
			required: true,
		},
		"contact_person": {
			required: true,
			/*remote: {
				url: "<?php echo base_url(); ?>/paymentmodesetting/findledgernameExists",
				data: {
					update_id: function() {
						return $("#updateid").val();
					},
					ledger_name: $(this).data('ledger_name')
				},
				type: "post",
			},*/
		},
	},
	messages: {
		"name": {
			required: "name is required"
		},
        "contact_person": {
			required: "contact person is required"
		}
	},
	highlight: function (input) {
		$(input).parents('.form-line').addClass('error');
	},
	unhighlight: function (input) {
		$(input).parents('.form-line').removeClass('error');
	},
	errorPlacement: function (error, element) {
		$(element).parents('.form-group').append(error);
	}
});


</script>