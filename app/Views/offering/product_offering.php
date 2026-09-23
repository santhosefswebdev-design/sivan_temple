<style>
    .table-responsive{
        overflow-x: hidden;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Offering<small>Offering / <b>Product Offering</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
				    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Product Offering</h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/offering/add_product_offering"><button type="button" class="btn bg-deep-purple waves-effect">Add</button></a></div></div>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th style="width:10%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['phone']; ?></td>
                                            <td><?= $row['address']; ?></td>
                                            <td style="width: 10%;">
												<a class="btn btn-success btn-rad" title="View" href="<?= base_url()?>/offering/view_prod_offering/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                <!-- <a class="btn btn-danger btn-rad" title="Delete" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a> -->
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
                    <h4 class="mt-2">Delete Stock In</h4>
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
        $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "  Stock In?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/stock/delete_prod_offering/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>
