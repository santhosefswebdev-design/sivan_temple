<?php 
if($view == true){
    $readonly = 'readonly';
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Setting<small>Annathanam / <b>Setting</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                            <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/annathanam/setting"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form method="POST">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="rice_category_id" id="rice_category_id" <?php echo $readonly; ?> required>
                                            <option value="">select rice category</option>
                                            <?php
                                            if(count($rice_categories) > 0)
                                            {
                                                foreach($rice_categories as $rice_category)
                                                {
                                            ?>
                                            <option value="<?php echo $rice_category['id']; ?>" <?php if($data['rice_category_id'] == $rice_category['id']){ echo "selected"; } ?>><?php echo $rice_category['name_eng']." - ".$rice_category['name_tamil']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="kuruma_id" id="kuruma_id" <?php echo $readonly; ?> required>
                                            <option value="">select kuruma type</option>
                                            <?php
                                            if(count($kuruma_types) > 0)
                                            {
                                                foreach($kuruma_types as $kuruma_type)
                                                {
                                            ?>
                                            <option value="<?php echo $kuruma_type['id']; ?>" <?php if($data['kuruma_id'] == $kuruma_type['id']){ echo "selected"; } ?>><?php echo $kuruma_type['name_eng']." - ".$kuruma_type['name_tamil']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="rice_type_id" id="rice_type_id" <?php echo $readonly; ?> required>
                                            <option value="">select rice type</option>
                                            <?php
                                            if(count($rice_types) > 0)
                                            {
                                                foreach($rice_types as $rice_type)
                                                {
                                            ?>
                                            <option value="<?php echo $rice_type['id']; ?>" <?php if($data['rice_type_id'] == $rice_type['id']){ echo "selected"; } ?>><?php echo $rice_type['name']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" min="0" step="any" name="amount" id="amount" class="form-control" value="<?php echo $data['amount']; ?>" required>
                                        <label class="form-label">Amount</label>
                                    </div>
                                </div>
                            </div>                
                            <?php if($view != true) { ?>
                            <div class="col-sm-12" align="center">
                                <label id="submit" class="btn btn-success btn-lg waves-effect">SAVE</label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
<script>
	$("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/annathanam/save_setting",
            data: $("form").serialize(),
            beforeSend: function() {    
                $('input[type=submit]').prop('disabled', true);
                $("#loader").show();
			},
            success:function(data)
            {
				//console.log(data);
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    window.location.reload(true);
                }
            },
            complete:function(data){
                // Hide image container
                $('input[type=submit]').prop('disabled', false);
                $("#loader").hide();
            }
        });
    }); 
</script>