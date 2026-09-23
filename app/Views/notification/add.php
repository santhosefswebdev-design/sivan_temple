<?php        
$db = db_connect();
?>
<style>
.ui-autocomplete{
            padding: 0px !important;
    }
    .ui-autocomplete ul{
        background-color: #5d8dff; font-size:14px;
    }
    li a{
        color: #fff;
    }
</style>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2> NOTIFICATION <smallMember / <b>Member Notification</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"><!--<h2>Cash Donation</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/notification"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form method="post" id="form_submit" enctype="multipart/form-data">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                            <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                        <label class="form-label" style="display: contents;">Type <span style="color: red;">*</span></label>
                                            <select class="form-control" id="type" name="type" >
                                                <option value="">-- Select Type --</option>
                                                <option value="All" <?php if(!empty($data['type'])){ if($data['type'] == "All"){ echo "selected";} }?>>ALL</option>
												<option value="Individual" <?php if(!empty($data['type'])){ if($data['type'] == "Individual"){ echo "selected";} }?>>INDIVIDUAL</option>
												<option value="Group" <?php if(!empty($data['type'])){ if($data['type'] == "Group"){ echo "selected";} }?>>GROUP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="col-sm-12" id="indi_member" style="display:<?php if(!empty($data['type'])){ if($data['type'] == "Individual"){ echo "block";} else {echo "none";} }else {echo "none";}?>">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <?php
                                            if(!empty($data['type'])){ 
                                                if($data['type'] == "Individual"){ 
                                                    $memb_det = $db->table('member')->where('id', $data['member_id'])->get()->getRowArray();
                                                    $mem_name = $memb_det['member_no']." - ".$memb_det['name'];
                                                } 
                                                else {
                                                    $mem_name = "";
                                                }
                                            }
                                            else {
                                                $mem_name = "";
                                            }
                                            ?>
                                            <input type="text" id='member_no' name="member_no" class="form-control" value="<?php echo $mem_name; ?>" <?php echo $readonly; ?>>
                                            <input type="hidden" id='member_id' name="member_id" value="<?php if(!empty($data['member_id'])){ echo $data['member_id']; }?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Member Number</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="group_member" style="display:<?php if(!empty($data['type'])){ if($data['type'] == "Group"){ echo "block";} else {echo "none";} }else {echo "none";}?>">
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="group_name" name="group_name" value="<?php if(!empty($data['group_name'])){ echo $data['group_name']; }?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Group Name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" id="group_member_no" name="group_member_no[]" multiple="multiple" style="width:100%" >
                                                    <option value="">-- Select member name --</option>
                                                    <?php 
                                                    if(count($members_list) > 0){
                                                        if(!empty($data['type'])){ 
                                                            if($data['type'] == "Group"){ 
                                                                $selectedservices = explode(",", $data['member_id']);
                                                            } 
                                                            else {
                                                                $selectedservices = array();
                                                            }
                                                        }
                                                        else {
                                                            $selectedservices = array();
                                                        }
                                                        foreach($members_list as $member){
                                                            if(in_array($member['id'],$selectedservices)){
                                                                $selected = "selected";
                                                            }
                                                            else
                                                            {
                                                                $selected ="";
                                                            }
                                                        ?>
                                                        <option value="<?php echo $member['id']; ?>" <?php echo $selected; ?>><?php echo $member['name']; ?></option>
                                                        <?php 
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="indi_all_tdf">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="title" id="title" class="form-control" value="<?php if(!empty($data['title'])){ echo $data['title']; }?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Title</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="description" id="description" class="form-control" value="<?php if(!empty($data['description'])){ echo $data['description']; }?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Description</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="file" id="file_up" name="file_up" class="form-control" <?php echo $disable; ?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <?php 
                                        if(!empty($data['file_upload']))
                                        {
                                        ?>
                                        <a href="<?php echo base_url(); ?>/uploads/notification/<?php echo $data['file_upload']; ?>" download><?php echo $data['file_upload']; ?></a>
                                        <?php
                                        }
                                        ?>
                                    </div>               
                                </div>
                                
                                <div style="clear:both"></div>
                                <?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
									<input type="submit" class="btn btn-success btn-lg waves-effect" value="SAVE">
                                    <!--label id="submit" class="btn btn-success">Save</label-->
                                </div>
                                <?php } ?>
                            </div>
                            </div>
                            <div class="col-md-3"></div>
                            </div>
                        </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Image loader -->                                                        
<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<link href="<?php echo base_url(); ?>/assets/jquery-ui.css" rel="Stylesheet"></link>
<script src="<?php echo base_url(); ?>/assets/jquery-ui.js" ></script>
<script>
$(document).ready(function(){
  $("#type").change(function(){
   if($("#type").val() == 'All'){
      //Show text box here
      $("#indi_all_tdf").show();
      $("#indi_member").hide();
	  $("#group_member").hide();
   }
   if($("#type").val() == 'Individual'){
     //Hide text box here
     $("#indi_all_tdf").show();
     $("#indi_member").show();
     $("#group_member").hide();
   }
   if($("#type").val() == 'Group'){
     //Hide text box here
     $("#indi_all_tdf").show();
     $("#group_member").show();
     $("#indi_member").hide();
   }
   if($("#type").val() == ''){
     //Hide text box here
     $("#indi_all_tdf").hide();
     $("#indi_member").hide();
     $("#group_member").hide();
   }
   
    });
});

$(document).ready(function(e){
    // Submit form data via Ajax
    $("#form_submit").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url: "<?php echo base_url(); ?>/notification/save",
            data: new FormData(this),
            //dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {
                $("#loader").show();
            },
            success: function(data){
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    window.location.reload(true);
                }
            },
            complete:function(data){
                $("#loader").hide();
            }
        });
    });
});

</script>

<script type="text/javascript">

$("#member_no").autocomplete({
	source: function( request, response ) {
		$.ajax({
			url: "<?php echo base_url(); ?>/notification/searchmemberno",
			type: 'post',
			data: { search: request.term},
			dataType: 'json',
			success: function(data){
				response(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				console.log("error handler!");
			}
		});
	},
	minLength: 3,
	select: function( event, ui ) {
		//console.log("Selected: "+ui.item.name);
        $('#member_no').val(ui.item.label); // display the selected text
        $('#member_id').val(ui.item.value); // save selected id to input
        return false;
	}
}); 

  </script>