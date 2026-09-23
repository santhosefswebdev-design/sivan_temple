<section class="content">
        <div class="container-fluid">
            <div class="block-header">
            <h2>UBAYAM GROUP<small>Ubayam / <b>Ubayam Group</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <?php /* if($permission['create_p'] == 1) { ?>
                        <div class="header">
                            <div class="row"><div class="col-md-8"><!--<h2>Ubayam Setting</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/add_ubayam_setting"><button type="button" class="btn bg-deep-purple waves-effect">Add</button></a></div></div>
                        </div>
                        <?php } */ ?>
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
							<form action="<?php echo base_url(); ?>/master/save_ubayam_group" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $data['id'];?>">
								<div class="container-fluid">
									<div class="row clearfix">
										<div class="col-sm-4">
											<div class="form-group form-float">
												<div class="form-line">
													<input type="text"  class="form-control" name="name" value="">
													<label class="form-label">Group Name <span style="color: red;"> *</span></label>
												</div>
											</div>
										</div>
										
                                        <div class="col-sm-2" align="center" style="background-color: white;padding-bottom: 1%;">
                                            <button type="submit" onclick="return validations();" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                            <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">No</th>
                                            <th style="width:35%;">Name</th>
                                            <?php if($permission['view'] == 1 ||  $permission['edit'] == 1 ||  $permission['delete_p'] == 1) { ?>
                                            <th>Actions</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; foreach($list as $row) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td id="pay<?= $row['id']; ?>" data-id="<?= $row['name'];?>"><?php echo $row['name']; ?></td>
                                        <?php if($permission['view'] == 1 ||  $permission['edit'] == 1 ||  $permission['delete_p'] == 1) { ?>
                                            <td>
                                                <?php if($permission['view'] == 1) { ?>
                                                    <a class="btn btn-success btn-rad" title="View" href="<?= base_url()?>/master/view_ubayam_group/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                <?php }
												if($permission['edit'] == 1) { ?> 
                                                    <a class="btn btn-primary btn-rad" title="Edit" href="<?= base_url()?>/master/edit_ubayam_group/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                                <?php }
												if($permission['delete_p'] == 1) { ?>
                                                    <a class="btn btn-danger btn-rad" title="Delete" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
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
        <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2">Delete Ubayam Group</h4>
                            <table>
        
                            <tr><span id="spndeddelid"><b></b></span></tr>
                          </table>
                            
                            <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">Yes</a> &nbsp;
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        
        <div id="del-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <table>
                                <tr><span id="delmol"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                            </table>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <div id="save-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body p-4">
						<div class="text-center">
							<i class="dripicons-information h1 text-info"></i>
							<table>
							<tr><span id="savedelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
							 </table>
							
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div>
		</div>
        <div id=delete-form>
            
        </div>
    </section>
    <script>
    function confirm_modal(id)
    {
        $.ajax({
            url: "<?php echo base_url();?>/master/del_uby_check",
            type: "post",
            data: {id: id},
            success:function(data){
                if(data == 0){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
                    $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "?" );
                }else{
                    $('#del-modal').modal('show', {backdrop: 'static'});
                    $("#delmol").text("We used for this Ubayam, So cant delete this Ubayam" );
                }
            }
        });
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/master/delete_ubayam_group/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
	
	function validations(){
        $.ajax
            ({
            type:"POST",
            url: "<?php echo base_url(); ?>/master/ubayam_g_validation",
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
</script>
