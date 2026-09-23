<?php 
if($view == true){
    $readonly = 'readonly';
}
?>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2> PRODUCT DONATION <small>Donation / <a href="#" target="_blank">Product Donation</a></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"><h2>Product Donation</h2></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/productdonation"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form action="<?php echo base_url(); ?>/productdonation/save" method="POST">
                        <div class="body">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
										<div class="form-line" id="bs_datepicker_component_container">
                                            <input type="date" name="date" class="form-control" value="<?php if($view == true) echo date("Y-m-d",strtotime($data['date'])); else echo date("Y-m-d");?>" <?php echo $readonly; ?> >
                                            <label class="form-label">Date <span style="color: red;">*</span></label>
                                        </div>                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="name" class="form-control" <?php echo $readonly; ?>  value="<?php echo isset($data['name']) ? $data['name'] : "";?>">
                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text"  name="address" class="form-control" <?php echo $readonly; ?> value="<?php echo isset($data['address']) ? $data['address'] : "";?>" >
                                            <label class="form-label">Address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="ic_num" class="form-control" <?php echo $readonly; ?> value="<?php echo isset($data['ic_num']) ? $data['ic_num'] : "";?>" >
                                            <label class="form-label">Ic Number</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="mobile" class="form-control" <?php echo $readonly; ?> value="<?php echo isset($data['mobile']) ? $data['mobile'] : "";?>" >
                                            <label class="form-label">Mobile Number</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea name="description" rows="1" class="form-control" <?php echo $readonly; ?>><?php echo isset($data['description']) ? $data['description'] : "";?></textarea>
                                            <label class="form-label">Description</label>
                                        </div>
                                    </div>
                                </div>
								<div style="clear:both"></div>
								<?php if($view != true) { ?>
								<div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" id="producttype">
                                            <option value="">-- Select type --</option>
                                            <option value="1">Product</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="hidden" class="add_list" id="pname">
                                            <select class="form-control show-tick calc_amt add_list" name="product_id" id="product_id">
                                            <option value="">-- Select Item Name --</option>
                                            <?php foreach($product as $p) { ?>
                                            <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="product_id" id="product_id">
                                            <option value="">-- Select Product --</option>
                                            <?php //foreach($pro as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>" name="<?php echo $row['name']; ?>" ><?php echo $row['name']; ?></option>
                                            <?php //} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div-->
                                <div class="col-sm-1">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" id="qty" name="quantity" class="form-control">
                                            <label class="form-label">Quantity</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" id="range" name="range" step="any" min="0" class="form-control">
                                            <label class="form-label">Range</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group form-float">
                                        <div class="form-line" style="border-bottom:none">
                                            <label class="form-label" id="uom_type"></label>
                                            <input type="hidden" id="uom_type_input" name="uom_type_input">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" id="amt" name="amount" class="form-control">
                                            <label class="form-label">Value of Amount</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line" id="tot">
                                            <input type="number" id="total" name="total_amount" class="form-control" >
                                            <label class="form-label">Total Amount</label>
                                        </div>
                                    </div>
                                </div>
								<div class="col-sm-1">
                                	<div class="form-group form-float">
                                    	<button class="btn btn-success" onclick="appen()" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                                    </div>
                                </div>
								
								
                                <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-hover" id="table" border="1 ">
                                  <thead>
                                    <tr>
                                        <th style="width:25%;">Type</th>
                                        <th style="width:25%%;">Product Name</th>
                                        <th style="width:10%;">Quantity</th>
                                        <th style="width:10%;">Range</th>
                                        <th style="width:10%;">UOM</th>
                                        <th style="width:10%;">Value of Amount</th>
                                        <th style="width:10%;">Total Amount</th>
									    <th style="width:10%;">Delete</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                                </div>
                                <input type="hidden" id="tot_count" value="0">
                                <br><br>
                                <?php 
								} 
								 if($view == true) { ?>
								<div class="table-responsive col-md-12">
                                <table class="table table-bordered table-hover" border="1 ">
                                  <thead>
                                    <tr>
                                        <th style="width:25%;">Type</th>
                                        <th style="width:25%%;">Product Name</th>
                                        <th style="width:10%;">Quantity</th>
                                        <th style="width:10%;">Range</th>
                                        <th style="width:10%;">UOM</th>
                                        <th style="width:10%;">Value of Amount</th>
                                        <th style="width:10%;">Total Amount</th>
                                    </tr>
                                  </thead>
                                  <tbody>
									<?php 
									if(!empty($product_item))
									{
									foreach($product_item as $row) { 
										?>
										<tr>
                                            <td>
                                            <?php 
                                                if($row['item_type'] == 1) { echo "Product"; }
                                                else if($row['item_type'] == 2) { echo "Raw Material"; }
                                                else { echo ""; }
                                            ?>
                                            </td>
                                            <td><?php echo $row['pname']; ?></td>
										    <td><?php echo $row['quantity']; ?></td>
										    <td><?php echo $row['uom_range']; ?></td>
										    <td><?php echo $row['uom']; ?></td>
										    <td><?php echo number_format($row['amount'], '2','.',','); ?></td>
										    <td><?php echo number_format($row['total_amount'], '2','.',','); ?></td>
										</tr>
									  
									<?php
									}
									}
									?>
									</tbody>
									</table>
									</div>
									<?php 
								}
								if($view != true) { 
								?>
                                <div class="col-sm-12" align="center">
                                    <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
									<label for ='print'> Print &nbsp;&nbsp; </label>
									
                                    <label id="submit" class="btn btn-success btn-lg waves-effect">SAVE</label>
									<label id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
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
    </section>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
$(document).ready(function() {
    $('#producttype').on('change', function() {
        $("#product_id").empty();
        var product_type = this.value;
        $.ajax({
            url: "<?php echo base_url(); ?>/stock/get_productcategory",
            type: "POST",
            data: {
                producttype: product_type
            },
            cache: false,
            success: function(result){
                $("#product_id").html(result);
                $('#product_id').prop('selectedIndex',0);
    		    $("#product_id").selectpicker("refresh");
                $("#uom").val("");
                $("#rate").val("");
                $("#qty").val("");
                $("#amount").val("");
            }
        });
    });    
});

$( "#product_id" ).change(function() {
        var id =  $("#product_id").val();
        var producttype =  $("#producttype").val();
        $.ajax({
            url: "<?php echo base_url();?>/stock/getuom",
            type: "post",
            data: {type:producttype,name: id},
            dataType: "json",
            success: function(data){
                //var obj = jQuery.parseJSON(data);
                console.log(data.uom_name);
                $("#pname").val(data.name);
            }
        });
    });
</script>

<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
$(document).ready(function() {
	$('#amt').blur(function() {
	 var val1 = parseFloat($('#qty').val());
	 var val2 = parseFloat($('#amt').val());
	 var result = (val1 * val2);
	 //alert(result);  
	 $("#total").val(result);
	 $('#tot').addClass("focused");
	});
});

function appen() {
  var count = parseInt($("#tot_count").val());
  var producttype = $("#producttype").val();
  var producttype_text = $("#producttype option:selected").text();
  var product_id = $("#product_id").val();
  //var pname = $("#product_id").find('option:selected').attr("name");
  var pname = $("#pname").val();
  var qty = parseInt($("#qty").val()); 
  var range = $("#range").val();
  var amt = $("#amt").val();
  var total = $("#total").val();
  var uom_type_input = $("#uom_type_input").val();
  if(product_id >0 && qty>0 && amt>0  && total>0  ){
      var html = "<tr id='row_"+count+"'>";
          html += "<td><input type='hidden' name='pdon["+count+"][ptype]' value='"+producttype+"' >" + producttype_text + "</td>";
          html += "<td><input type='hidden' name='pdon["+count+"][pid]' value='"+product_id+"' >" + pname + "</td>";
          html += "<td><input type='hidden' name='pdon["+count+"][qty]' value='"+qty+"' >" + qty + "</td>";
          html += "<td><input type='hidden' name='pdon["+count+"][range]' value='"+range+"' >" + range + "</td>";
          html += "<td><input type='hidden' name='pdon["+count+"][uom]' value='"+uom_type_input+"' >" + uom_type_input + "</td>";
          html += "<td><input type='hidden' name='pdon["+count+"][amt]' value='"+amt+"' >" + amt + "</td>";
          html += "<td><input type='hidden' name='pdon["+count+"][total]' value='"+total+"' >" + total + "</td>";
          html += "<td><button class='btn btn-danger remove' onclick='remove_row("+count+")' type='button'><i class='glyphicon glyphicon-remove'></i></button></td></tr>";
      $("#table tbody").append(html);
      $(".add_list").val('');
	  $('#product_id').prop('selectedIndex',0);
	  $("#product_id").trigger("change");
      var cnt = count + 1;
      $("#tot_count").val(cnt);
	  
	  $("#qty").val("");
	  $("#amt").val("");
	  $("#total").val("");
	  $("#range").val("");
	  $("#uom_type_input").val("");
  }
}






function remove_row(id){
    $('#row_'+id).remove();
}
$("#product_id").change(function() {
    var prod_id = $(this).val();
	if(prod_id !="")
	{
		$.ajax({
			url: '<?php echo base_url(); ?>/productdonation/get_uom_name',
			type: 'POST',
			datatype: 'JSON',
			data: {prod_id : prod_id},
			success: function(response) {
				$("#uom_type").html(response);
                $("#uom_type_input").val(response);
			}
		});
	}
	else
	{
		$("#uom_type").html("");
        $("#uom_type_input").val("");
	}
    
});

$("#submit").click(function(){
		//alert("haii");
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/productdonation/save",
            data: $("form").serialize(),
            beforeSend: function() {    
                $('input[type=submit]').prop('disabled', true);
                $("#loader").show();
                $("#submit").attr("disabled", true);
            },
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
					if ($("#print").prop('checked')==true)	
						{
							printData(obj.id);
						}
						else 
							window.location.reload(true);
                }
            },
            complete:function(data){
                // Hide image container
                $('input[type=submit]').prop('disabled', false);
                $("#loader").hide();
                $("#submit").attr("disabled", false);
            }
        });
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/productdonation/print_page/"+id,
            type: 'POST',
            success: function (result) {
                //console.log(result)
                popup(result);
            }
        });
    }

    function popup(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body >');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            window.location.reload(true);
        }, 500);

        frame1.remove();
        //window.location.replace("<?php echo base_url();?>/donation");
		window.location.reload(true);
        //return true;
    }
</script>
