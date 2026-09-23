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

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

    <?php if(empty($data['image'])) {?>
        #img_pre {
            display : none;
        }
    <?php }
	if($view == true) { ?>
        label.form-label span { display:none !important; color:transporant; }
    <?php } ?>
        
</style>

<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> Archanai Setting<small>Archanai / <b> Add Rasi Setting</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Add Archanai Settings</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/archanai/rasi"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/archanai/rasi_save" method="POST" enctype='multipart/form-data'>
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="name_eng"  class="form-control" value="<?php echo $data['name_eng'];?>" <?php echo $readonly; ?> >
                                        <label class="form-label">Rasi Name in English <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="name_tamil"  class="form-control" value="<?php echo $data['name_tamil'];?>" <?php echo $readonly; ?> >
                                        <label class="form-label">Rasi Name in Tamil <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="natchathra_id[]" multiple="multiple">
                                        <option value="">--Select--</option>
                                        <?php foreach($nat as $row) { 
										$nat = explode(',', trim($data['natchathra_id'], ','));
										?>
                                        <option <?php foreach($nat as $res) { if($res == $row['id']) echo 'selected'; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name_eng']; ?></option>
                                        <?php } ?>
                                        </select>
                                        <label class="form-label">Natchathiram</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </form>
                    <?php if($view != true) { ?>
                    <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                        <button type="submit" onclick="validations()" class="btn btn-success btn-lg waves-effect">SAVE</button>
                        <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                    </div>
                    <?php } ?>
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
                </div>
            </div>
        </div>
    </div>
</section> 
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<?php //if($data['view_archanai'] != 0) {?>
<script>
    $('#alpha').prop('checked', false);
</script>
<?php //} ?>
<script>
    $("#clear").click(function(){
		
       $("input").val("");
    });
function validations(){
    $.ajax
        ({
        type:"POST",
        url: "<?php echo base_url(); ?>/archanai/rasi_validation",
        data: $("form").serialize(),
        success:function(data)
        {
            obj = jQuery.parseJSON(data);
            console.log(obj);
            if(obj.err != ''){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text(obj.err);
            }else{
                $("form").submit();
            }
        }
    })
        
}
</script>
