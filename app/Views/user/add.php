<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?><section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> USER SETTING<small>Finance / <b>Add User Setting</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Add User  Settings</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/user"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">

                        <form action="<?php echo base_url(); ?>/user/save" method="post">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="name" required class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text"  name="user_name" required class="form-control" value="<?php echo $data['username'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">User Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="password" required minlenght="6" class="form-control" value="<?php echo $data['password'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Password <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">Role <span style="color: red;">*</span></label>
												<select name="role" class="form-control" <?php echo $disable; ?>>
                                                    <option value="" >--Select Role--</option>
                                                    <?php foreach($role as $row) { ?>
                                                    <option <?php if($row['id'] == $data['role']) echo "selected"; ?> value="<?= $row['id']; ?>" ><?= $row['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="mailid" id="email" class="form-control" value="<?php echo $data['email'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">E-Mail</label>
                                            </div>
                                        </div>
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">User Portal <span style="color: red;">*</span></label>
												<select name="member_comes" class="form-control">
                                                    <option value="admin"<?php if($row['member_comes'] == 'admin') echo " selected"; ?>>DIRECT</option>
                                                    <option value="counter"<?php if($row['member_comes'] == 'counter') echo " selected"; ?>>COUNTER</option>
                                                    <option value="agent"<?php if($row['member_comes'] == 'agent') echo " selected"; ?>>CEMETERY</option>
                                                    <option value="customer"<?php if($row['member_comes'] == 'customer') echo " selected"; ?>>CUSTOMER</option>
                                                </select>
                                            </div>
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