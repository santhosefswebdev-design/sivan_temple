<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Annathanam<small>Special / <b>Types</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                	<!--<div class="header">
                        <div class="row"><div class="col-md-8"><h2>Hall</h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/add_property_type"><button type="button" class="btn bg-deep-purple waves-effect">Add</button></a></div></div>
                    </div>-->
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
                        <form action="<?php echo base_url(); ?>/annathanam_new/save_special_types" method="POST">
							<input type="hidden" name="id" value="">
							<div class="container-fluid">
								<div class="row clearfix">
									<div class="col-sm-3">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="text"  class="form-control" name="name" required value="" >
												<label class="form-label">Name<span style="color: red;"> *</span></label>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="status" id="status" <?php echo $readonly; ?>>
                                                    <option value="">-- Select Status --</option>
                                                    <option value="1" <?php if($data['status'] == '1'){ echo "selected"; } ?>>Active</option>
                                                    <option value="2" <?php if($data['status'] == '2'){ echo "selected"; } ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									<div class="col-sm-3" align="center">
										<button type="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
										<button type="reset" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
									</div>
								</div>
							</div>
						</form><br><br>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th style="width:10%;">S.No</th>
                                        <th style="width:40%;">Name</th>
                                        <th style="width:30%;">Status</th>
                                        <!-- <th style="width:20%;">Action</th> -->
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($list as $row) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo strtoupper($row['name']); ?></td>
                                        <td>
                                            <select class="form-control status-dropdown" data-id="<?php echo $row['id']; ?>" style="color:<?php echo $row['status'] == 1 ? 'green' : 'red'; ?>">
                                                <option value="1" <?php echo $row['status'] == 1 ? 'selected' : ''; ?> style="color: green;">Active</option>
                                                <option value="2" <?php echo $row['status'] == 2 ? 'selected' : ''; ?> style="color: red;">Inactive</option>
                                            </select>
                                        </td>

                                        <!-- <td>
                                        	<a class="btn btn-success btn-rad" title="View" href="<?= base_url()?>/annathanam_new/view_special/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                            <a class="btn btn-primary btn-rad" title="Edit" href="<?= base_url()?>/annathanam_new/edit_special/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                            <a class="btn btn-danger btn-rad" title="Delete" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a>
                                        </td> -->
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
                            <h4 class="mt-2">Delete Group</h4>
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
        
        
        <div id=delete-form>
            
        </div>
        <!--End Delete Form-->
</section>

<script>
$(document).ready(function() {
    $('.status-dropdown').on('change', function() {
        var status = $(this).val();
        var id = $(this).data('id');
        var dropdown = $(this);

        // Update color based on selection
        dropdown.css('color', status == '1' ? 'green' : 'red');

        // Send AJAX request to server to update the status
        $.ajax({
            url: '<?= base_url()?>/annathanam_new/edit_status/' + id,
            type: 'POST',
            data: { status: status },
            success: function(response) {
                alert('Status updated successfully');
                // Optionally process response
            },
            error: function() {
                alert('Error updating status');
            }
        });
    });
});
</script>


<script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete" );
    
    }
    
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/archanai/delete_group/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
    
    $("form").on("submit", function(){
        $('input[type=submit]').prop('disabled', true);
        $("#loader").show();
    });
</script>