<?php 
if($view == true){
    $readonly = 'readonly';
}
if($edit == true)
{
    $edit_readonly = 'readonly';
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Raw Material<small>Product / <a href="#" target="_blank">Raw Material</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Raw Material</h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/rawmaterial"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/rawmaterial/save_product" method="POST" enctype="multipart/form-data">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" id="price" name="price" value="<?php echo number_format($data['price'], '2','.',',');?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Product Per Price</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="opening_stock" value="<?php echo $data['opening_stock'];?>" <?php echo $readonly; ?> <?php echo $edit_readonly; ?>>
                                        <label class="form-label">Opening Stock</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="minimum_stock" id="minimum_stock" value="<?php echo $data['minimum_stock'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Minimum Stock</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select required class="form-control show-tick" name="uom_id">
                                        <option value="">-- Select UOM --</option>
                                        <?php foreach($uom as $row) { ?>
										<option value="<?php echo $row['id']; ?>" <?php if($data['uom_id'] == $row['id']){ echo "selected"; } ?>><?php echo $row['symbol']; ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-12">
                                <input type="checkbox" id="expire" name="expire_type" class="filled-in date_type date_type1" value="1" <?php if(!empty($data['expire_type'])){ if($data['expire_type'] == 1){ echo "checked"; } } ?> <?php echo $disabled; ?>>
                                <label for="expire" style="text-transform: uppercase;">Expire</label> 
                                <input type="checkbox" id="non_expire" name="expire_type" class="filled-in date_type date_type2" value="2"  <?php if(!empty($data['expire_type'])){ if($data['expire_type'] == 2){ echo "checked"; } } ?> <?php echo $disabled; ?>>
                                <label for="non_expire" style="text-transform: uppercase;">Non-Expire</label>
                            </div>
                            <div style="clear:both"></div>
                            <div class="answer_date" style="display:<?php if(!empty($data['expire_type'])){ if($data['expire_type'] == 1){ echo "block;"; } { echo "none"; } } else { echo "none"; } ?>" >
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="date" class="form-control" name="mfg_date" id="mfg_date" value="<?php echo $data['mfg_date'];?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Mfg.Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="date" class="form-control" name="exp_date" id="exp_date" value="<?php echo $data['exp_date'];?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Exp.Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="answer_date2" style="display: <?php if(!empty($data['expire_type'])){ if($data['expire_type'] == 2){ echo "block;"; } { echo "none"; } } else { echo "none"; } ?>">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="date" class="form-control" name="service_date" id="service_date" value="<?php echo $data['service_date'];?>" <?php echo $readonly; ?>>
                                            <label class="form-label">Service Check Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <textarea class="form-control" name="product_description" id="product_description" maxlength="300" rows="2" <?php echo $readonly; ?>><?php echo $data['product_description'];?></textarea>
                                        <label class="form-label"> Description</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>       
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="supplier_id" id="supplier_id" required <?php echo $disabled; ?>>
                                        <option value="">-- Select supplier --</option>
                                        <?php 
                                        if(!empty($suppliers)) {
                                        foreach($suppliers as $supplier) { ?>
										<option value="<?php echo $supplier['id']; ?>" <?php if(!empty($data['supplier_id'])){ if($data['supplier_id'] == $supplier['id']){ echo "selected"; } } ?>><?php echo $supplier['name']; ?></option>
                                        <?php } 
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <?php if($view != true) { ?>
                            <div class="col-sm-12" align="center">
                                <button type="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
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
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
    $('#price').click(
    function(){
        $(this).val('');
    });

    $('input.date_type').on('change', function() {
        $('input.date_type').not(this).prop('checked', false);  
    });

    $(".date_type1").click(function() {
        if($(this).is(":checked")) {
            $(".answer_date").show(300);
            $(".answer_date2").hide(200);
        } else {
            $(".answer_date").hide(200);
        }
    });

    $(".date_type2").click(function() {
        if($(this).is(":checked")) {
            $(".answer_date2").show(300);
            $(".answer_date").hide(200);
        } else {
            $(".answer_date2").hide(200);
        }
    });
</script>