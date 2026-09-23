<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>TIMING<small>Master / <b>Timing</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
				<?php if($permission['create_p'] == 1) { ?>
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/add_timing"><button type="button" class="btn bg-deep-purple waves-effect">Add</button></a></div></div>
                    </div>
				<?php } ?>
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
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Start</th>
                                        <th>End</th>
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
                                        <td id="pay2_<?= $row['id']; ?>" data-id="<?= $row['description'];?>"><?php echo $row['description']; ?></td>
										<?php if($permission['view'] == 1 ||  $permission['edit'] == 1 ||  $permission['delete_p'] == 1) { ?>
											<td>
											<?php if($permission['view'] == 1) { ?>
											   	<a class="btn btn-success btn-rad" title="View" href="<?php base_url()?>/master/view_timing/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
											<?php }
											if($permission['edit'] == 1) { ?> 
                                            	<a class="btn btn-primary btn-rad" title="Edit" href="<?php base_url()?>/master/edit_timing/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
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
                            <h4 class="mt-2">Delete Timing</h4>
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
        <div id=delete-form>
            
        </div>
        <!--End Delete Form-->
</section>
<script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " to "+$("#pay2_"+id).attr("data-id") + " Timing?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/master/delete_timing/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>
