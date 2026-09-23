<style>
    .thead{
        color: #fff;
        background-color: red;
    }
    a:hover { text-decoration: none; }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> ACCOUNTS</h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Chart Of Accounts</h2></div>
                        <?php if($add_group['create_p'] == 1) { ?>						
						<div class="col-md-2" align="right"><a href="<?php echo base_url(); ?>/account/add_group"><button type="button" class="btn bg-deep-purple waves-effect">Add Group</button></a></div>
                        <?php } if($add_ledger['create_p'] == 1) { ?>
						<div class="col-md-2" align="right"><a href="<?php echo base_url(); ?>/account/add_ledger"><button type="button" class="btn bg-deep-purple waves-effect">Add Ledger</button></a></div>
						<?php } ?>
                        </div>
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
                        <table class="table table-striped" style="width:100%;">
                        <tr>
                            <th style="width: 40%;" class="thead">Account Name</th>
                            <th class="thead">Type</th>
                            <th class="thead">O/P Balance</th>
                            <th class="thead">C/L Balance</th>
							<?php if($add_group['edit'] == 1 ||  $add_group['delete_p'] == 1 || $add_ledger['edit'] == 1 ||  $add_ledger['delete_p'] == 1) { ?>
							<th class="thead">Actions</th>
							<?php } ?>
                        </tr>
                        <?php foreach($list as $row) { ?>
                            <?php print_r($row);?>
                        <?php } ?>
                        </table>
                        
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
                            <h4 class="mt-2 heading">Delete Entries</h4>
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
        <div id="alert-okay" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <table>
        
                            <tr><span id="spndeddelids"><b></b></span></tr>
                          </table>
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal">Okay</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <div id=delete-form >
            
        </div>
</section>
<script>
    function confirm_modal(id, type){
        if(type == 1) var url = "<?php echo base_url(); ?>/account/check_group/"+id;
        else var url = "<?php echo base_url(); ?>/account/check_ledger/"+id;
        $.ajax({
            type: "POST",
            url: url,
            data: {id: id},
            success:function(data){
                console.log(data)
                if(data == 'true'){
                    var name = $("#name_"+id+'_'+type).text();
                    if(type == 1){ var head_title = 'Delete Group'; var title ="Group"; }
                    else { var head_title = 'Delete Ledger'; var title ="Ledger"; }
                    $(".heading").text(head_title);
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+','+type+')');
                    $("#spndeddelid").text("Are you sure to Delete "+name+" "+title+"?" );
                }else{
                    $('#alert-okay').modal('show', {backdrop: 'static'});
                    $("#spndeddelids").text("We used for this, So cant Delete" );
                }
            }
        });
        
    }
    function dedDel(id, type){
        if(type == 1) var url = "<?php echo base_url(); ?>/account/delete_group/"+id;
        else var url = "<?php echo base_url(); ?>/account/delete_ledger/"+id;
        $( "#delete-form" ).append( "<form action='"+url+"'><button type='submit' id='delete_"+id+"_"+type+"' >submit</button></form>");
        $( "#delete_"+id+"_"+type).trigger( "click");
    }
</script>
