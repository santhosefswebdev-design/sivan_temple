<?php
if ($view == true) {
    $readonly = 'readonly';
    $disable = "disabled";
}
?>

<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Profile<small>Festival Message</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="body">
						<?php if(!empty($_SESSION['succ'])){ ?> 
							<div class="row" style="padding: 0 30%;" id="content_alert">
								<div class="suc-alert">
									<span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
									<p><?php echo $_SESSION['succ']; ?></p> 
								</div>
							</div>
						 <?php } ?>
						 <?php if(!empty($_SESSION['fail'])){ ?>
							<div class="row" style="padding: 0 30%;" id="content_alert">
								<div class="alert">
									<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
									<p><?php echo $_SESSION['fail']; ?></p>
								</div>
							</div>
						 <?php } ?>
                        <form action="<?php echo base_url(); ?>/festival_message/store" method="POST"
                            id="form_validation" enctype="multipart/form-data">
                            <input type="hidden" value="id" name="id" id="updateid">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="name" id="nameInput" class="form-control"
                                                    value="" required>
                                                <label class="form-label">Enter Festival Name <span
                                                        style="color: red;">*</span></label>
                                            </div>
                                        </div>
									</div>
									<div class="col-sm-4">
										<div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">Member Type<span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" id="member_type" name="member_type" required>
                                                    <option value="">-- Select Type --</option>
                                                    <?php
                                                    if (count($member_type_list) > 0) {
                                                        foreach ($member_type_list as $mtl) {
                                                            ?>
                                                            <option value="<?php echo $mtl['id']; ?>" <?php echo ($data['member_type'] == $mtl['id']) ? "selected" : ""; ?>>
                                                                <?php echo $mtl['name']; ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
									</div>
									<div class="col-sm-4 members_col" style="display :none;">
										<div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">Members</label>
                                                <select class="form-control" id="members" name="members[]" multiple>
                                                    <option value="">-- Select Members --</option>
                                                </select>
                                            </div>
                                        </div>
									</div>
                                </div> 
								<div class="row clearfix">
									<div class="col-sm-6">
										<div id="displayText" style="margin-top: 20px; font-size:18px;">
                                        </div>
									</div> 	
                                </div>
								<div class="row clearfix">
									<?php if ($view != true) { ?>
										<div class="col-sm-12 mt-5" align="center"
											style="background-color: white;padding-bottom: 1%;margin-top: 2rem">
											<button type="submit"
												class="btn btn-success btn-lg waves-effect  ">SUBMIT</button>
										</div>
									<?php } ?> 	
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
    $(document).ready(function () {
        $('#nameInput').on('input', function () {
            var enteredText = $(this).val();
            var boldEnteredText = '<strong>' + enteredText + '</strong>';

            var message = "Dear [Member Name]<br><br>Warm greetings on your special day! May this " + boldEnteredText + " be filled with joy, blessings, and prosperity.<br><br>As you celebrate another year of life/devotion, may the divine light guide your path, bringing you happiness, peace, and fulfillment.<br><br>On behalf of the community, we extend our heartfelt wishes for a wonderful and joyous celebration. May your day be surrounded by loved ones, laughter, and the divine grace that our temple offers.<br><br>Wishing you a year ahead filled with auspicious moments and spiritual growth. May your journey be illuminated by the divine presence, and may you continue to inspire those around you with your devotion.<br><br> Happy " + boldEnteredText + "!<br><br>Best regards,<br>Temple Management";

            $('#displayText').html(message);
        });
		$(document).on('change', '#member_type', function(){
			var member_type = this.value;
			var elm = $(this);
			$.ajax({
				url: '<?php echo base_url(); ?>/festival_message/get_members_by_type',
				data:{member_type: member_type},
				dataType: 'json',
				type: 'POST',
				success: function (result) {
					console.log(result);
					var html = '';
					if(result.members.length > 0){
						html += '<option value="all_members">All Members</option>';
						for(var i=0; i<result.members.length; i++){
							html += '<option value="' + result.members[i].id + '">' + result.members[i].name + '</option>';
						}
					}else html += '<option value="">-- Select Members --</option>';
					$('.members_col').show();
					$('#members').html(html);
					$("#members").selectpicker("refresh");
                },
                error: function (err) {
                   console.log('err');
                   console.log(err);
                }
			});
		});
    });

    $('#form_validation').validate({
        rules: {
            "name": {
                required: true,
            },

        },
        messages: {
            "name": {
                required: "Name is required"
            },

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