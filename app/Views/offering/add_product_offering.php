<?php 
if($view == true){
    $readonly = 'readonly';
}
?>
<style>
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

<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>

</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Offering<small>Offering / <b>Add Product Offering</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Donation Setting</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/offering/product_offering"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <input type="hidden" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <?php if($view != true) { ?>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select id="offering_id" name="offering_id" class="form-control">
										    <option value="">-- Select Offering Category --</option>
										    <?php foreach($offer as $row) { ?>
										    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
										    <?php } ?>
										</select> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select id="product_id" name="product_id" class="form-control">
										    <option value="">-- Select Product Category --</option>
										</select> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number"  class="form-control" id="grams" name="grams" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Grams <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number"  class="form-control" id="value" name="value" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Value <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1" align="right">
                                <div class="form-group form-float">
                                    <button class="btn btn-success" onclick="appen()" type="button">Add</button>
                                </div>
                            </div>
                            <?php } ?>
                            <br>
                            <?php if($view != true) { ?>
                            <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped table-hover" id="table" border="1 ">
                              <thead>
                                <tr>
                                  <th style="width:25%;">Offering Category</th>
                                  <th style="width:25%;">Product Category</th>
                                  <th style="width:10%;">Grams</th>
                                  <th style="width:10%;">Value</th>
                                  <th style="width:10%;">Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                            </div>
                            <input type="hidden" id="tot_count" value="0">
                            <?php } ?>
                            <br>
                            <?php if($view == true) { ?>
                            <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped table-hover" id="table" border="1 ">
                              <thead>
                                <tr>
                                  <th style="width:25%;">Offering Category</th>
                                  <th style="width:25%;">Product Category</th>
                                  <th style="width:10%;">Grams</th>
                                  <th style="width:10%;">Value</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php foreach($pro as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['offering_id']; ?></td>
                                        <td><?php echo $row['product_id']; ?></td>
                                        <td><?php echo $row['grams']; ?></td>
                                        <td><?php echo $row['value']; ?></td>
                                    </tr>
                                  <?php } ?>
                              </tbody>
                            </table>
                            </div>
                            <?php } ?>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" id="name" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Name <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" id="phone" name="phone" value="<?php echo $data['phone'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Phone <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" id="address" name="address" value="<?php echo $data['address'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Address <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </form>
                    <?php if($view != true) { ?>
                    <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                        <button type="submit"id="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
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
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
</script>
<script>
$("#offering_id").change(function(){
var id = $("#offering_id").val();
if(id != "")
	{
        $.ajax({
			url: '<?php echo base_url();?>/offering/get_category',
			type: 'post',
			data: {id:id},
			dataType: 'json',
			success:function(data)
			{
				console.log(data.data);
                $('#product_id').empty();
                $('#product_id').append('<option value="">Select Product Category</option>');
                data.data.forEach(function(item) {
                    $('#product_id').append(
                        $('<option></option>').val(item.id).text(item.name)
                    );
                });
                $('#product_id').selectpicker('refresh');
				//$('#product_id').append('<option value="' + data.data.pid + '">' + data.data.pname + '</option>');
		    }
		});
	}
});

$("#submit").click(function(){
    $.ajax
    ({
        type:"POST",
        url: "<?php echo base_url(); ?>/offering/pro_offering_save",
        data: $("form").serialize(),
        beforeSend: function() {    
            $('input[type=submit]').prop('disabled', true);
            $("#loader").show();
        },
        success:function(data)
        {
            obj = jQuery.parseJSON(data);
            if(obj.err != ''){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text(obj.err);
            }else{					
				window.open("<?php echo base_url(); ?>/offering/print_offering/" + obj.id);
                window.location.replace("<?php echo base_url(); ?>/offering/product_offering");
            }
        },
        complete:function(data){
            // Hide image container
            $('input[type=submit]').prop('disabled', false);
            $("#loader").hide();
        }
    });
});


function appen() {
var count = parseInt($("#tot_count").val());
var offering_id = $("#offering_id").val();
var offering_text = $("#offering_id option:selected").text();
var product_id = $("#product_id").val();
var product_text = $("#product_id option:selected").text();
var grams = $("#grams").val();
var value = $("#value").val();
if(offering_id!="" && product_id!="" && grams!=0 && value >0  )
{
    var html = "<tr id='row_"+count+"'>";
        html += "<td><input type='hidden' name='sout["+count+"][offering_id]' class='typeidclass' value='"+offering_id+"' >" + offering_text + "</td>";
        html += "<td><input type='hidden' class='rawidclass' name='sout["+count+"][product_id]' value='"+product_id+"' >" + product_text + "</td>";
        html += "<td><input type='hidden' name='sout["+count+"][grams]' value='"+grams+"' >" + grams + "</td>";
        html += "<td><input type='hidden' name='sout["+count+"][value]' value='"+value+"' >" + value + "</td>";
        html += "<td><button class='btn btn-danger remove' onclick='remove_row("+count+")' type='button'><i class='glyphicon glyphicon-remove'></i></button></td></tr>";
        $("#table tbody").append(html);
        
        $("#grams").val('');
        $("#value").val('');
        $('#offering_id').prop('selectedIndex',0);
        $("#offering_id").selectpicker("refresh");
        $('#product_id').prop('selectedIndex',0);
        $("#product_id").selectpicker("refresh");
        var cnt = count + 1;
        $("#tot_count").val(cnt);
    }
}
function remove_row(id){
    $('#row_'+id).remove();
}
</script>