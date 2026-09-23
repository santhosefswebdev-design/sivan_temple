<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2> USER ROLE SETTING<small>Finance / <b>User Role</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-information h1 text-info"></i>
                                        <h4 class="mt-2">Delete User</h4>
                                        <table>
                    
                                        <tr><span id="spndelid"><b></b></span></tr><br>
                                      </table>
                                        <br>
                                        <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">Yes</a> &nbsp;
                                        <button type="button" class="btn btn-info my-3" data-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div>
                </div>
                <!--Delete Form-->
                <div id=delete-form>
                    
                </div>					
                <!--End Delete Form-->
                        <div class="header">
                            <div class="row">
								<div class="col-md-10"><!--<h2>User  Settings</h2>--></div>
									<!--<div class="col-md-1" align="right"><a href="<?php echo base_url(); ?>/user/add">			<button type="button" class="btn bg-deep-purple waves-effect">Add User</button></a></div>-->
									<div class="col-md-2" align="right"><a href="<?php echo base_url(); ?>/user/add_user_role">	<button type="button" class="btn bg-deep-purple waves-effect">Add User Role</button></a></div>
								</div>
                        </div>
                        <div class="body">

                        <?php if($_SESSION['succ'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="suc-alert">
                                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['succ']; ?></p> 
                                    </div>
                                </div>
                            <?php } ?>
                             <?php if($_SESSION['fail'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['fail']; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>User Type</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($data as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td style="width: 16%;">
                                                <a class="btn btn-success btn-rad" title="View" href="<?php base_url()?>/userpermission/view/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                <a class="btn btn-primary btn-rad" title="Edit" href="<?php base_url()?>/userpermission/edit/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'Del('+id+')');
        $("#spndelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " User Role?" );    
    }    
    function Del(id)
    {
        var act = "<?php echo base_url(); ?>/user_role/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"'>submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>