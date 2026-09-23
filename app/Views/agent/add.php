<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
if($edit == true){
    $readonly_edit = 'readonly';
    $disable_edit = "disabled";
}
?>
<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2> Agent Registration <small>CEMETERY / <b>Agent Registration</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"><!--<h2>Cash Donation</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/agent_reg"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form action="<?php echo base_url(); ?>/agent_reg/save" method="POST" id="form_validation">
                        <div class="body">
                            <input type="hidden" name="id" id="updateid" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="name" class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email" value="<?php echo $data['email'];?>" <?php echo $readonly; ?> required>
                                            <label class="form-label">Email <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" name="username" class="form-control" value="<?php echo $data['username'];?>" <?php echo $readonly; ?> <?php echo $disable_edit; ?>>
                                            <label class="form-label">Username <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <!--<input type="text" class="form-control" name="password" value="<?php echo $data['password'];?>" <?php echo $readonly; ?> <?php echo $disable_edit; ?>>
                                            <label class="form-label">Password <span style="color: red;">*</span></label>-->
                                            <input id="password" type="password" class="form-control" name="password" value="<?php echo $data['password'];?>" <?php echo $readonly; ?> <?php echo $disable_edit; ?>>
                                            <i class="material-icons psw" id="on" onClick="switchpasswordicon()">visibility</i>
                                            <i class="material-icons psw" id="off" onClick="switchpasswordicon()">visibility_off</i>
                                            <label class="form-label">Password <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="address" id="address" class="form-control" value="<?php echo isset($data['address']) ? $data['address'] : ""; ?>" required <?php echo $readonly; ?>>
                                            <label class="form-label">Address </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="phoneno" id="phoneno" class="form-control" value="<?php echo isset($data['phoneno']) ? $data['phoneno'] : ""; ?>" required <?php echo $readonly; ?>>
                                            <label class="form-label">Phone No </label>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="city" id="city" class="form-control" value="<?php echo isset($data['city']) ? $data['city'] : ""; ?>" <?php echo $readonly; ?>>
                                            <label class="form-label">City </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="state" id="state" class="form-control" value="<?php echo isset($data['state']) ? $data['state'] : ""; ?>" <?php echo $readonly; ?>>
                                            <label class="form-label">State </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="country" id="country" class="form-control" value="<?php echo isset($data['country']) ? $data['country'] : ""; ?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Country </label>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea name="description" class="form-control" <?php echo $readonly; ?>><?php echo $data['description'];?></textarea>
                                            <label class="form-label">Description</label>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
								<?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
									<input type="submit" class="btn btn-success btn-lg waves-effect" value="SAVE">
                                    <button type="reset" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
    </section>
<style>
.psw { right:0; cursor:pointer; float:right; font-size:18px; margin-top:-25px; color:#666666; }
</style>

<script>
$('#form_validation').validate({
	rules: {
		"name": {
			required: true,
		},
        "password": {
			required: true,
		},
		"username": {
			required: true,
			remote: {
				url: "<?php echo base_url(); ?>/agent_reg/findusernameExists",
				data: {
					update_id: function() {
						return $("#updateid").val();
					},
					username: $(this).data('username')
				},
				type: "post",
			},
		},
        "email": {
			required: true,
			remote: {
				url: "<?php echo base_url(); ?>/agent_reg/findemailExists",
				data: {
					update_id: function() {
						return $("#updateid").val();
					},
					email: $(this).data('email')
				},
				type: "post",
			},
		},
	},
	messages: {
		"name": {
			required: "name is required"
		},
		"username": {
			required: "username is required",
			remote: "already username exist"
		},
        "email": {
			required: "email is required",
			remote: "already email exist"
		},
		"password": {
			required: "password is required"
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
	},
    submitHandler: function (form) {
        //console.log('test');
        $('input[type=submit]').prop('disabled', true);
        form.submit();
    }
});
</script>

<script>
function switchpasswordicon()
{
  var input = $("#password");
   if (input.attr("type") === "password") {
    input.attr("type", "text");
    $("#off").hide();
    $("#on").show();
  } else {              
    input.attr("type", "password");
    $("#off").show();
    $("#on").hide();
  }   
}

$("form").on("submit", function(){
        //$('input[type=submit]').prop('disabled', true);
       // $("#loader").show();
    });
</script>