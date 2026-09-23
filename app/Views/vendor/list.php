<?php $db = db_connect();?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Profile<small> Vendor / <b>List</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/vendor/add"><button type="button" class="btn bg-deep-purple waves-effect">Add</button></a></div></div>
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
								<table class="table table-bordered table-striped table-hover dataTable" id="datatables">
									<thead>
										<tr>
											<th>SNo.</th>
											<th>Name</th>
											<th>Phone No</th>
											<th>Email ID</th>
											<th>Contact Person</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
                                        if(!empty($vendors))
                                        {
										$i = 1; 
										foreach($vendors as $vendor) { ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $vendor['name']; ?></td>
											<td><?php echo $vendor['phoneno']; ?></td>
											<td><?php echo $vendor['email']; ?></td>
											<td><?php echo $vendor['contact_person']; ?></td>
											<td>
                                                <a class="btn btn-warning btn-rad" title="View" href="<?php echo base_url(); ?>/vendor/view/<?php echo $vendor['id']; ?>"><i class="material-icons">&#xE417;</i></a>&nbsp;
                                                <a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url(); ?>/vendor/edit/<?php echo $vendor['id']; ?>"><i class="material-icons">&#xE3C9;</i></a>
                                            </td>
										</tr>
										<?php }
                                        }
                                        ?>
									</tbody>
								</table>
                            </div>
						</div>
            
            </div>
        </div>
    </div>

</section>
<script>
    $("document").ready(function () {
      $("#datatables").dataTable({
        "searching": true
      });
      var table = $('#datatables').DataTable();
      // Apply the filter
        $("#categoryFilter").on( 'keyup change', function () {
        table
            .column( 1 )
            .search( this.value )
            .draw();
        });
    });
</script>