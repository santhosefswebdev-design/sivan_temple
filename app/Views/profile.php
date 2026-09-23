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
            <h2>PROFILE<small>Dashboard / <a href="#" target="_blank">Profile</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Profile</h2></div>
                        <div class="col-md-4" align="right"></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/profile/save" method="POST" enctype="multipart/form-data">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $profile['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" required name="name" value="<?php echo $profile['name'];?>">
                                        <label class="form-label">Name <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="address1" value="<?php echo $profile['address1'];?>">
                                        <label class="form-label">Address 1</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="address2" value="<?php echo $profile['address2'];?>">
                                        <label class="form-label">Address 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="city" value="<?php echo $profile['city'];?>">
                                        <label class="form-label">City</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="postcode" value="<?php echo $profile['postcode'];?>">
                                        <label class="form-label">Postcode</label>
                                    </div>
                                </div>
                            </div><div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="telephone" value="<?php echo $profile['telephone'];?>">
                                        <label class="form-label">Telephone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="mobile" value="<?php echo $profile['mobile'];?>">
                                        <label class="form-label">Mobile</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" class="form-control" name="email" value="<?php echo $profile['email'];?>">
                                        <label class="form-label">Email <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="gstno" value="<?php echo $profile['gstno'];?>">
                                        <label class="form-label">GST No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="fax_no" value="<?php echo $profile['fax_no'];?>">
                                        <label class="form-label">Fax No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="website" value="<?php echo $profile['website'];?>">
                                        <label class="form-label">Website</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="bankid" value="<?php echo $profile['bankid'];?>">
                                        <label class="form-label">Bank Id</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input name="logo_img" id="logo_img" class="form-control" type="file" accept="image/png, image/gif, image/jpeg">
                                        <!-- <label class="form-label">Logo Image</label>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
								<?php 
                                if(!empty($profile['image']))
                                {
                                ?>
                                <img id="img_pre" src="<?php echo base_url(); ?>/uploads/main/<?php echo $profile['image']; ?>" class="img-responsive" style="width:100px;">
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-sm-12" align="center">
                                <button type="submit" class="btn btn-success btn-lg waves-effect">UPDATE</button>
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
$("#logo_img").change(function(){
			// alert (0);
        readURL(this);		
		});
		
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				
				reader.onload = function (e) {
					//alert (URL.createObjectURL(e.target.files[0]))
					$('#img_pre').attr('src', e.target.result);
					$('#img_pre').show();
					//$('#img_anchor').attr("href", e.target.result)				
				}            
				reader.readAsDataURL(input.files[0]);
			}
		}
</script>