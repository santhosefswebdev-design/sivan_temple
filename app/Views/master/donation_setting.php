<?php global $lang;?>
<style>
 span.form-control {
     height: 0px;
   }
   .dropdown-menu.open {
     max-height: none !important;
   }
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
            <h2><?php echo $lang->donation; ?> <?php echo $lang->setting; ?><small><?php echo $lang->donation; ?> / <b><?php echo $lang->donation; ?> <?php echo $lang->setting; ?></b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <?php if($permission['create_p'] == 1) { ?>
                        <div class="header">
                            <div class="row"><div class="col-md-8"><!--<h2>Donation Setting</h2>--></div>
                            <!-- <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/add_donation_setting"><button type="button" class="btn bg-deep-purple waves-effect">Add</button></a></div></div> -->
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
                            <form id="donation" action="<?php echo base_url(); ?>/master/save_donation_setting" method="POST" enctype="multipart/form-data">
                            <div class="col-sm-3">
    <div class="form-group form-float">
        <div class="form-line">
            <select name="groupname" class="form-control">
                <option value="">-- Select Donation Group --</option>
                <?php foreach ($group as $row) { ?>
                                                <option value="<?php echo $row['name']; ?>" <?php echo ($row['name'] == $data['groupname']) ? 'selected' : ''; ?>>
                                                    <?php echo $row['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label"><?php echo $lang->name; ?> <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="description" value="<?php echo $data['description'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label"><?php echo $lang->description; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" step=".01" class="form-control" name="amount" value="<?php echo number_format($data['amount'], '2','.',','); ?>" <?php echo $readonly; ?>>
                                        <label class="form-label"><?php echo $lang->amount; ?> <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
    <div class="form-group form-float">
        <div class="form-line">
            <select name="donation_cat" id="donation_cat" class="form-control">
                <?php
                                            if (!empty($donation_category) && is_array($donation_category) && count($donation_category) > 0) {
                                                foreach ($donation_category as $dc) {
                                                    echo '<option value="' . $dc['id'] . '">' . $dc['name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">---Select Category---</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                           <?php if ($view != true) { ?>
                                <div class="col-sm-5">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <!--<label class="form-label" style="display: contents;"><?php echo $lang->image; ?></label>-->
                                            <input type="file" id="imgInp" name="donation_image" accept="image/png,image/jpeg,image/jpg"
                                                class="form-control" <?php echo $readonly; ?>>
                                            <!--<label class="form-label">Image</label>-->
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="ledger_id" id="ledger_id">
                                        <option value="">Select Ledger</option>
                                        <?php
                                        if(!empty($ledgers))
                                        {
                                            foreach($ledgers as $ledger)
                                            {
                                        ?>
                                            <option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($data['ledger_id'])){ if($data['ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <label type="submit" onclick="validations()" class="btn btn-success btn-lg waves-effect"><?php echo $lang->save; ?></label>
                                    <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect"><?php echo $lang->clear; ?></button>
                                </div>
                            </div>
                             </form>
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;"><?php echo $lang->no; ?></th>
                                            <th style="width:35%;"><?php echo $lang->name; ?></th>
                                            <th style="width:35%;"><?php echo $lang->description; ?></th>
                                            <th style="width:10%;"><?php echo $lang->amount; ?></th>
                                            <?php if($permission['view'] == 1 ||  $permission['edit'] == 1 ||  $permission['delete_p'] == 1) { ?>
                                            <th><?php echo $lang->action; ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	 <?php $i = 1; foreach($list as $row) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td id="pay<?= $row['id']; ?>" data-id="<?= $row['name'];?>"><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><?php echo number_format($row['amount'], '2','.',','); ?></td>
                                        <?php if($permission['view'] == 1 ||  $permission['edit'] == 1 ||  $permission['delete_p'] == 1) { ?>
                                        <td>
                                        	<?php if($permission['view'] == 1) { ?>
                                                    <a class="btn btn-success btn-rad" title="View" href="<?= base_url()?>/master/view_donation_setting/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                <?php } ?>
                                                <?php if($permission['edit'] == 1) { ?>    
                                                    <a class="btn btn-primary btn-rad" title="Edit" href="<?= base_url()?>/master/edit_donation_setting/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                                <?php } ?>
                                                <?php if($permission['delete_p'] == 1) { ?>    
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
                            <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->donation; ?> <?php echo $lang->setting; ?></h4>
                            <table>
        
                            <tr><span id="spndeddelid"><b></b></span></tr>
                          </table>
                            
                            <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal"><?php echo $lang->yes; ?></a> &nbsp;
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal"><?php echo $lang->no; ?></button>
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
        $("#clear").click(function(){
            $("input").val("");
        });
    </script>
    <script>
        function validations(){
            $.ajax({
                type:"POST",
                url: "<?php echo base_url(); ?>/master/donation_validation",
                data: $("#donation").serialize(),
                success:function(data)
                {
                    obj = jQuery.parseJSON(data);
                    console.log(obj);
                    if(obj.err != ''){
                        $('#save-modal').modal('show', {backdrop: 'static'});
                        $("#savemsg").text(obj.err);
                    }else{
                        $('input[type=submit]').prop('disabled', true);
                        $("#loader").show();
                        $("#donation").submit();
                    }
                }
            })        
        }
    </script>
    <script>
    function confirm_modal(id)
    {
        $.ajax({
            url: "<?php echo base_url();?>/master/del_don_check",
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
        var act = "<?php echo base_url(); ?>/master/delete_donation_setting/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
    
</script>