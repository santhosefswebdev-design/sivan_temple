<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<style>
.table-responsive{
        overflow-x: hidden;
    }
.table td, .table th {
    padding: 0.5rem;
}
.table thead th {
    background: #fa6742;
    color: white;
}
</style>
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Hall Booking</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">Hall Booking List</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div>
<section class="content">
        <div class="container">
          <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8 col-xs-6"><h2>Hall Booking List - <?= date("d-m-Y",strtotime($date)); ?></h2></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/booking/add_booking/<?= $date; ?>"><button type="button" class="btn btn-dark">New Booking</button></a></div></div>
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
                            <div class="table-responsive" style="margin-top:20px;">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Register By</th>
                                            <th>Event Details</th>
                                            <th>Status</th>
                                            <th>Total Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Balance Amount</th>
                                            <?php if($permission['view'] == 1 || $permission['edit'] == 1 ||  $permission['print'] == 1) { ?>
											<th>Actions</th>
											<?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($list as $row) { 
                                            if($row['status'] == 1) $status = "Booked";
                                            else if($row['status'] == 2) $status = "Completed";
                                            else $status = "Cancelled";
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['register_by']; ?></td>
                                            <td><?php echo $row['event_name']; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><?php echo $row['total_amount']; ?></td>
                                            <td><?php echo $row['paid_amount']; ?></td> 
                                            <td><?php echo $row['balance_amount']; ?></td>
                                            <?php if($permission['view'] == 1 || $permission['edit'] == 1 ||  $permission['print'] == 1) { ?>                                            
												<td> 
													<?php if($permission['view'] == 1) { ?>
													    <a class="btn btn-success btn-rad" href="<?= base_url()?>/booking/view/<?php echo $row['id'];?>"><i class="fa fa-eye"></i></a>
													<?php } if ($row['status']!=3) { 
                                                                if($permission['edit'] == 1 ){ ?>
													                <?php if($row['status'] == 1) { ?> <a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url();?>/booking/edit_booking/<?= $row['id']; ?>"><i class="fa fa-edit"></i></a> <?php } ?>
													            <?php } if($permission['print'] == 1) {?>
													                <a class="btn btn-warning btn-rad" title="Print" href="<?= base_url()?>/booking/print_page/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>													
                                                                <?php } ?>
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
                            <h4 class="mt-2">Delete Donation</h4>
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
        <!--Delete Form-->
        <div id=delete-form>
            
        </div>
        <!--End Delete Form-->
    </section>
<script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "  Donation?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/donation/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>