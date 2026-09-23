<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Prasadam Master<small>Prasadam / <b>Prasadam Master</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
				<?php if($permission['create_p'] == 1) { ?>
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/add_prasadam"><button type="button" class="btn bg-deep-purple waves-effect">Add Prasadam</button></a></div></div>
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
                                        <th>SNo</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <?php if($permission['view'] == 1 ||  $permission['edit'] == 1) { ?>
										<th>Actions</th>
										<?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($list as $row) { ?>
                                    <tr>
                                        <td align="center"><?php echo $i++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td align="center"><?php echo $row['start_time']; ?></td>
                                        <td align="center"><?php echo $row['end_time']; ?></td>
										<?php if($permission['view'] == 1 ||  $permission['edit'] == 1) { ?>
											<td align="center">
												<?php if($permission['view'] == 1) { ?>
													<a class="btn btn-success btn-rad" title="View" href="<?php echo base_url()?>/master/view_prasadam/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
												<?php }
												if($permission['edit'] == 1) { ?> 
                                                    <a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url()?>/master/edit_prasadam/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
												<?php }
                                                ?>
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
                    <h4 class="mt-2">Delete Product</h4>
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
</section>
<script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "  Product?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/master/delete_product/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>
