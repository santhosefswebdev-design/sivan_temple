<?php 
if($view == true){
    $readonly = 'readonly';
    $disabled = 'disabled';
}
if($edit == true)
{
    $edit_readonly = 'readonly';
}
?>
<style>
  .multiselect-dropdown {width: 100%!important;}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Add Product<small>Product / <a href="#" target="_blank">Add Product</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Add Product</h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/product"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/product/save_product" method="POST" enctype="multipart/form-data">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> required>
                                        <label class="form-label">Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="product_code" id="product_code" value="<?php echo $data['product_code'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Product Code</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" min="0" step="any" class="form-control" name="product_qty" id="product_qty" value="<?php echo $data['opening_stock'];?>" <?php echo $readonly; ?> <?php echo $edit_readonly; ?> required>
                                        <label class="form-label">Quantity</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="minimum_stock" id="minimum_stock" value="<?php echo $data['minimum_stock'];?>" <?php echo $readonly; ?> required>
                                        <label class="form-label">Minimum Stock</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="uom_id" id="uom_id" required>
                                        <option value="">-- Select UOM --</option>
                                        <?php foreach($uom as $row) { ?>
										<option value="<?php echo $row['id']; ?>" <?php if($data['uom_id'] == $row['id']){ echo "selected"; } ?>><?php echo $row['symbol']; ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="price" value="<?php echo number_format($data['price'], '2','.',',');?>" <?php echo $readonly; ?> required>
                                        <label class="form-label">Product Per Price</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <textarea class="form-control" name="product_description" id="product_description" maxlength="300" rows="2" <?php echo $readonly; ?>><?php echo $data['description'];?></textarea>
                                        <label class="form-label"> Description</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="file" name="product_image"  class="form-control" accept="image/png, image/jpeg, image/jpg" <?php echo $disabled; ?> />
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($data['image'])) {?>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <a target="_blank" href="/uploads/product/<?php echo $data['image']; ?>">
                                            <img src="/uploads/product/<?php echo $data['image']; ?>" width="200" height="160"></img>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="col-md-12"> 
                                <?php if($view != true) { ?>
                                <div class="products row">
                                    <div class="col-sm-12">
                                        <h3 style="margin-bottom:5px; margin-top:5px;">Raw Material Details</h3>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" id="raw_id">
                                                    <option value="0">Select</option>
                                                    <?php foreach($products as $product) { ?>
                                                    <option value="<?php echo $product['id']; ?>"><?php echo $product['name'];?></option>
                                                    <?php } ?>
                                                </select>
                                                <label class="form-label">Raw Material</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <input type="number" id="raw_qty" min="0" step="any" class="form-control" placeholder="0">
                                                <label class="form-label">Quantity</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <div class="form-line" style="border: none;">
                                                <label id="rawmaterial_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                <div class="col-sm-12">
                                    <div class="table-responsive"><table style="width:100%" class="table table-bordered" id="pay_table" style="height: 150px;">
                                        <thead>
                                            <tr>
                                                <th width="60%">Raw Material</th>
                                                <th width="25%">For Per Product Quantity</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($product_raw_material_items as $row) {
                                                $db = \Config\Database::connect();
                                                $raw_matrial_group = $db->table("raw_matrial_groups")->where('id', $row['raw_id'])->get()->getRowArray();
                                                $raw_matrial_group_name = !empty($raw_matrial_group['name']) ? $raw_matrial_group['name'] : "";
                                                ?>
                                                <tr>
                                                    <td><input type="hidden" style="border: none;" class="rawidclass" value="<?php echo $row['raw_id']; ?>"><?php echo $raw_matrial_group_name; ?></td>
                                                    <td><?php echo $row['qty']; ?></td>
                                                    <td>
                                                        <a class="btn btn-primary btn-rad" onClick="editRawmaterial(<?php echo $row['id']; ?>,<?php echo $row['qty']; ?>);" style="cursor: pointer;"><i class="material-icons dp48">edit</i></a>
                                                    </td>
                                                </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                    <input type="hidden" id="pay_row_count" value="1">
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
<div id="editrawmaterial_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header p-4" style="padding: 10px 15px 10px 15px;">
                <div class="row">
                    <div class="col-sm-8"><h3 style="font-size: 16px;line-height: 0;">Edit Raw Material</h3></div>
                    <div class="col-sm-4" style="text-align: right;">
                        <button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button>
                    </div>
                </div>
            </div>
            <hr style="margin: 0px;">
            <div class="modal-body p-4">
                <form action="<?php echo base_url(); ?>/product/update_raw_qty" method="POST">
                <input type="hidden" name="edit_rawid" id="edit_rawid">
                <input type="hidden" name="edit_id" value="<?php echo $data['id'];?>">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="number" class="form-control" name="edit_rawqty" id="edit_rawqty" min="0" step="any" required>
                                <label class="form-label">Quantity</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" align="center">
                        <button type="submit" class="btn btn-warning btn-lg waves-effect">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
	$("#rawmaterial_add").click(function(){
        var raw_qty = $("#raw_qty").val();
        var raw_id = $("#raw_id").val();
        var raw_name_text = $( "#raw_id option:selected" ).text();   
        var cnt = parseInt($("#pay_row_count").val());
        if(raw_qty != 0 && raw_id != 0){
            var isExists=false;
            $(".rawidclass").each(function(){
              var val=$(this).val();
              if(val==raw_id)
                isExists=true;
            }).val();
            //alert(isExists);
            if (isExists) {
                alert('already exists this raw material.');
            } else {
                $.ajax({
                    type:"POST",
                    url: "<?php echo base_url();?>/product/checkavailablity_productcount",
                    data: {rawmat_id:raw_id,rawmat_qty:raw_qty},
                    success:function(data)
                    {
                        if(data > 0)
                        {
                            alert("Available only less than quantity. please increase product quantity. ");
                        }
                        else
                        {
                            var html = '<tr id="rmv_payrow'+cnt+'">';
                            html += '<td style="width: 60%;"><input type="hidden" style="border: none;" class="rawidclass" readonly name="rawmaterial['+cnt+'][raw_id]" value="'+raw_id+'">'+raw_name_text+'</td>';
                            html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly name="rawmaterial['+cnt+'][raw_qty]" value="'+raw_qty+'"></td>';
                            html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_rawmaterial('+ cnt +')" style="width:auto;"><i class="material-icons"></i></a></td>';
                            html += '</tr>';
                            $("#pay_table").append(html);
                            var ct = parseInt(cnt + 1);
                            $("#pay_row_count").val(ct);
                            $("#raw_qty").val('');
                            $('#raw_id').prop('selectedIndex',0);
                            $("#raw_id").selectpicker("refresh");
                        }
                    }
                });
            }
            
        }
    });

    function rmv_rawmaterial(id){
        $("#rmv_payrow"+id).remove();
    }
    function editRawmaterial(id,qty)
    {
        $('#editrawmaterial_modal').modal('show', {backdrop: 'static'});
        $("#edit_rawid").val(id);
        $("#edit_rawqty").val(qty);
    }
    $("form").on("submit", function(){
        $('input[type=submit]').prop('disabled', true);
        $("#loader").show();
    });
</script>