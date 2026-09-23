<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> My Profile</h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="name" required class="form-control" value="<?php echo $data['name'];?>" readonly >
                                                <label class="form-label">Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text"  name="user_name" required class="form-control" value="<?php echo $data['username'];?>" readonly >
                                                <label class="form-label">User Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="password" required minlenght="6" class="form-control" value="<?php echo $data['password'];?>" readonly >
                                                <label class="form-label">Password <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                            <label class="form-label" style="display: contents;">Role <span style="color: red;">*</span></label>
                                            <input type="text" name="password" required minlenght="6" class="form-control" value="<?php echo $role['name'];?>" readonly >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="mailid" id="email" class="form-control" value="<?php echo $data['email'];?>" readonly >
                                                <label class="form-label">E-Mail</label>
                                            </div>
                                        </div>
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
            url: "<?php echo base_url(); ?>/user/validation",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                console.log(obj);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    $("form").submit();
                }
            }
        })
            
    }
</script>