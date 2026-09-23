<?php global $lang;?>
<style>
    .table-responsive{
        overflow-x: hidden;
    }
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Templebooking <small>Temple Event / <b>Session block</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/sessionblock/add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div>
                            <!-- <div class="col-md-2" align="left"><a href="<?php echo base_url(); ?>/commission/add"><button type="button" class="btn bg-deep-purple waves-effect">Edit</button></a></div> -->
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
                                            <th><?php echo $lang->sno; ?></th>
                                            <th>Date</th>
                                            <th>Event</th>
                                            <th>Session</th>
                                            <th>Description</th>
											<th><?php echo $lang->action; ?></th>
				
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; // Initialize counter for row numbers ?>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td id="<?= $booking['id']; ?>" data-id="<?= $booking['date']; ?>">
                                                    <?= date('d-m-Y', strtotime($booking['date'])); ?>
                                                </td>
                                                <td><?= esc($booking['event']) == '1' ? 'Hall Booking' : 'Ubayam'; ?></td>
                                                <td><?= esc($booking['session']); ?></td>
                                                <td><?= esc($booking['description']); ?></td>
                                                <td style="width: 16%;">
                                                    <a class="btn btn-success btn-rad" href="<?= base_url() ?>/sessionblock/view/<?= $booking['id']; ?>"><i class="material-icons">&#xE417;</i></a>                                              
                                                    <a class="btn btn-warning btn-rad" href="<?= base_url() ?>/sessionblock/edit/<?= $booking['id']; ?>"><i class="material-icons">&#xE3C9;</i></a>                        
                                                    <a class="btn btn-danger btn-rad" onclick="confirm_modal(<?= $booking['id']; ?>)"><i class="material-icons">&#xE872;</i></a>                                                
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="alert-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm Deletion</h4>
                    </div>
                    <div class="modal-body">
                        <p id="spndeddelid"></p>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form" method="post">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
        <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2">Confirm Deletion</h4>
                            <table>
                                <tr><span id="spndeddelid"><b></b></span></tr>
                            </table>
                            <form id="delete-form" method="post">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                <button type="submit" class="btn btn-danger"><?php echo $lang->yes; ?></button> &nbsp;
                                <button type="button" class="btn btn-info my-3" data-dismiss="modal"><?php echo $lang->no; ?></button>
                            </form>

                            <!-- <form id="delete-form" method="post">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form> -->
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <!--Delete Form-->
        <!-- <div id=delete-form> -->
            
        </div>
        <!--End Delete Form-->
    </section>

    <script>
    function confirm_modal(id) {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        var dateText = $("#pay"+id).attr("data-id");
        $("#spndeddelid").text("Are you sure to Delete this session block?");
        $('#delete-form').attr('action', '<?php echo base_url(); ?>/sessionblock/delete/' + id);
    }
</script>

<!-- <script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "  sessionblock?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/sessionblock/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script> -->