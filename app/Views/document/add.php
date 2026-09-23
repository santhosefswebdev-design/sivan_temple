<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Profile<small>Document Store / <b>Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/document"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                    <form action="<?php echo base_url(); ?>/document/store" method="POST" id="form_validation" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo isset($document['id']) ? $document['id'] : ""; ?>" name="id" id="updateid">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($document['name']) ? $document['name'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Name <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="datetime-local" name="datetime" id="datetime" class="form-control" value="<?php echo isset($document['datetime']) ? $document['datetime'] : ""; ?>" required <?php echo $readonly; ?>>
                                        <label class="form-label">Datetime <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input name="document_file[]" id="document_file" class="form-control" type="file" multiple="multiple" <?php echo $disable; ?>>
                                        <!--<label class="form-label">Logo Image</label>-->
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <?php
                            if($view == true || $edit == true)
                            {
                            ?>
                            <div class="col-sm-12">
                                <div class="table-responsive" style="background:#FFF; float:none;">
                                    <table class="table table-bordered table-striped table-hover">
                                        <tr>
                                            <th>Sno</th>
                                            <th>File Name</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php 
                                        if(!empty($document_items))
                                        {
                                            $i = 1;
                                            foreach($document_items as $document_item)
                                            {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $document_item['file']; ?></td>
                                            <td>
                                                <a class="btn btn-warning btn-rad" title="Download" href="<?php echo base_url(); ?>/uploads/documents/<?php echo $document_item['file']; ?>" download><i class="material-icons">file_download</i></a>&nbsp;
                                                <?php
                                                if($view != true)
                                                {
                                                ?>
                                                <a href="javascript:void(0);" title="Delete" onclick="delete_file(<?php echo $document_item['id']; ?>,<?php echo $document['id']; ?>);" class="btn btn-danger btn-rad"><i class="material-icons">delete</i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            $i++;
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
							<div style="clear:both"></div>
                        <?php
                        }
                        ?>
                        </div>
                        <?php if($view != true) { ?>
                        <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                            <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                        </div>
                        <?php } ?>
                    </div>
                    </form>
                    
                    </div>
             
            </div>
        </div>
    </div>
    </div>

</section>
<script>
$('#form_validation').validate({
	rules: {
		"name": {
			required: true,
		},
		"document_file": {
			required: true,
			/*remote: {
				url: "<?php echo base_url(); ?>/paymentmodesetting/findledgernameExists",
				data: {
					update_id: function() {
						return $("#updateid").val();
					},
					ledger_name: $(this).data('ledger_name')
				},
				type: "post",
			},*/
		},
	},
	messages: {
		"name": {
			required: "name is required"
		},
        "document_file": {
			required: "file required"
		}
	},
	highlight: function (input) {
		$(input).parents('.form-line').addClass('error');
	},
	unhighlight: function (input) {
		$(input).parents('.form-line').removeClass('error');
	},
	errorPlacement: function (error, element) {
		$(element).parents('.form-group').append(error);
	}
});


</script>
<script>
$("#document_file").change(function(){
			// alert (0);
        readURL(this);		
		});
		
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				
				reader.onload = function (e) {
					//alert (URL.createObjectURL(e.target.files[0]))
					$('#img_pre').attr('src', e.target.result);
					$('#img_pre').show();
					//$('#img_anchor').attr("href", e.target.result)				
				}            
				reader.readAsDataURL(input.files[0]);
			}
		}
</script>

<script type="text/javascript">
    var url="<?php echo base_url();?>";
    function delete_file(id,docid){
        var r=confirm("Do you want to delete this?")
        if (r==true)
          window.location = url+"/document/deletedocument/"+id+"/"+docid;
        else
          return false;
    } 
</script>