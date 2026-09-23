<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Funds</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <!-- Form -->
                        <form id="fundsForm" action="<?php echo base_url(); ?>/account/save_funds" method="POST">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="name" name="name"
                                                 required>
                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="description" name="description"
                                                >
                                            <label class="form-label">Description</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="code" name="code"
                                                >
                                            <label class="form-label">Code</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <button type="submit" class="btn btn-success btn-lg waves-effect"
                                            onclick="validations()">SAVE</button>
                                        <button type="button" id="clear"
                                            class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- End Form -->
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">No</th>
                                        <th style="width:35%;">Name</th>
                                        <th style="width:35%;">Description</th>
                                        <th style="width:10%;">Code</th>
                                        
                                            <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($list as $row) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $i++; ?>
                                            </td>
                                            <td id="pay<?= $row['id']; ?>" data-id="<?= $row['name']; ?>">
                                                <?php echo $row['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['description']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['code']; ?>
                                            </td>
                                            
                                                <td>
                                                    
                                                        <a class="btn btn-success btn-rad" title="View"
                                                            href="<?= base_url() ?>/account/view_funds/<?php echo $row['id']; ?>"><i
                                                                class="material-icons">&#xE417;</i></a>
                                                    
                                                   
                                                        <a class="btn btn-primary btn-rad" title="Edit"
                                                            href="<?= base_url() ?>/account/edit_funds/<?php echo $row['id']; ?>"><i
                                                                class="material-icons">&#xE3C9;</i></a>
                                                    
                                                    
                                                        <a class="btn btn-danger btn-rad" title="Delete"
                                                            onclick="confirm_modal(<?php echo $row['id']; ?>)"><i
                                                                class="material-icons">&#xE872;</i></a>
                                                   
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
                            <h4 class="mt-2">Delete Fund</h4>
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
        <div id="save-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <table>
                                <tr><span id="savemsg"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                            </table>          
                        </div>
                    </div>
                </div>
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
</section>

<script>
    function validations() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/account/funds_validation",
            data: $("#donation").serialize(),
            success: function (data) {
                obj = jQuery.parseJSON(data);
                console.log(obj);
                if (obj.err != '') {
                    $('#save-modal').modal('show', { backdrop: 'static' });
                    $("#savemsg").text(obj.err);
                } else {
                    $('input[type=submit]').prop('disabled', true);
                    $("#loader").show();
                    $("#donation").submit();
                }
            }
        })
    }


</script>
<script>
    $('#clear').click(function () {
        // Reset form fields
        $('#fundsForm')[0].reset();
    });


</script>
<script>
    function confirm_modal(id)
    {
        $.ajax({
            url: "<?php echo base_url();?>/account/del_funds_check",
            type: "post",
            data: {id: id},
            success:function(data){
                if(data == 0){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
                    $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "?" );
                }else{
                    $('#del-modal').modal('show', {backdrop: 'static'});
                    $("#delmol").text("We used for this Donation, So cant delete this Donation" );
                }
            }
        });
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/account/delete_funds/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
    
</script>