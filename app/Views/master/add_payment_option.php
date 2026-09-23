<?php global $lang; ?>
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
            <h2> Master<small>Payment Option / <b> Add Payment Option</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Add Archanai Settings</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/payment_option"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/master/save_payment_option" method="POST" enctype='multipart/form-data'>
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="pay_name"  class="form-control" value="<?php echo $data['pay_name']; ?>" <?php echo $readonly; ?> >
                                        <label class="form-label">Payment Name <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="pay_id"  class="form-control" value="<?php echo $data['pay_id']; ?>" <?php echo $readonly; ?> >
                                        <label class="form-label">Payment Id <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label">Select status</label>
                                        <select class="form-control" name="status" <?php echo $disable; ?> required>
                                            <option value="">-- Select Status --</option>
                                            <option value="1" <?php echo ($data['status'] == 1) ? "selected": ""; ?> >Active</option>
                                            <option value="0" <?php echo ($data['status'] == 0) ? "selected": ""; ?>>Inactive</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            
                            </div>
                            <div class="row">
                            <?php if($view != true) { ?>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label class="form-label" style="display: contents;">Image</label>
                                        <input type="file" id="imgInp" name="image" accept="image/png,image/jpeg,image/jpg" class="form-control" <?php echo $readonly; ?> >
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="">
    								<?php if(!empty($data['image'])) {?>
                                        <a target="_blank" href="/uploads/payment/<?php echo $data['image']; ?>">
                                            <img id="img_pre" src="/uploads/payment/<?php echo $data['image']; ?>" width="200">
                                        </a>
    								<?php } else { ?> 
    									<img id="img_pre" src="#" width="200"></img>
                                    <?php }?>												
                                    </div>
                                </div>
                            </div> 

                        </div>
                    </div>
                    </div>
                    
                    <?php if($view != true) { ?>
                    <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                        <button type="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
                        <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                    </div>
                    <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 

<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
    $("#clear").click(function(){
		
       $("input").val("");
    });
    
    function addCategory() 
	{
		$('.custom-category-modal').modal();
	}
		
		$("#imgInp").change(function(){
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
