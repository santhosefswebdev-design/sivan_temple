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
              <h1 class="banner-title">Donation</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">Cash Donation List</a></li>
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
                            <div class="row"><div class="col-md-8 col-xs-6"><h2>Cash Donation List</h2></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/donation_online/add"><button type="button" class="btn btn-dark">Add</button></a></div></div>
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
                                            <th>Date</th>
                                            <th>Paid For</th>
                                            <th>Name</th>
                                            <th>Amount</th>
											<th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['pname']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo number_format($row['amount'], '2','.',','); ?></td>
                                            <td style="width: 16%;">
                                                <a class="btn btn-success" href="<?= base_url()?>/donation_online/view/<?php echo $row['id'];?>"><i class="fa fa-eye"></i></a>
												<!--<a class="btn btn-primary" href="<?= base_url()?>/donation/print_page/<?php echo $row['id'];?>" target="_blank"><i class="fa fa-print"></i></a>
												<a class="btn btn-primary btn-rad" href="<?= base_url()?>/donation/edit/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                                <a class="btn btn-danger btn-rad" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a>-->                                                
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