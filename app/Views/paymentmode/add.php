<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>PROFILE<small>Payment Mode Setting / <b>Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/paymentmodesetting"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                    <form action="<?php echo base_url(); ?>/paymentmodesetting/store" method="POST" id="form_validation">
						<input type="hidden" value="<?php echo isset($payment_mode['id']) ? $payment_mode['id'] : ""; ?>" name="id" id="updateid">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($payment_mode['name']) ? $payment_mode['name'] : ""; ?>" required>
                                        <label class="form-label">Name <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="description" id="description" class="form-control" required><?php echo isset($payment_mode['description']) ? $payment_mode['description'] : ""; ?></textarea>
                                        <label class="form-label">Description</label>
                                    </div>
                                </div>
                            </div>
							<div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select name="ledger_name" id="ledger_name" class="form-control" required>
											<option value="">select ledger</option>
											<?php
											foreach($ledgers as $ledger)
											{
											?>
											<option value="<?php echo $ledger['id']; ?>" <?php if(isset($payment_mode['ledger_id'])){ if($payment_mode['ledger_id'] == $ledger['id']){ echo "selected"; } }?>><?php echo $ledger['name']; ?></option>
											<?php
											}
											?>
										</select>
                                        <!--label class="form-label">Ledger<span style="color: red;">*</span></label-->
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" min="0" name="order" id="order" class="form-control" value="<?php echo isset($payment_mode['menu_order']) ? $payment_mode['menu_order'] : ""; ?>">
                                        <label class="form-label">Order</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                            <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                        </div>
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
		"ledger_name": {
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
		"ledger_name": {
			required: "ledger name is required"
			//remote: "already ledger name exist"
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