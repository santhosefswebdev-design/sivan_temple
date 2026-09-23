<script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>PROPERTIES<small>Properties / <b>Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/properties"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                    <form action="<?php echo base_url(); ?>/properties/store" method="POST" id="form_validation" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo isset($property['id']) ? $property['id'] : ""; ?>" name="id" id="updateid">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="property_name" id="property_name" class="form-control" value="<?php echo isset($property['name']) ? $property['name'] : ""; ?>" required>
                                        <label class="form-label">Property Name<span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="lotno" id="lotno" class="form-control" value="<?php echo isset($property['lot_no']) ? $property['lot_no'] : ""; ?>" required>
                                        <label class="form-label">Lot No. <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="area" id="area" class="form-control" value="<?php echo isset($property['area']) ? $property['area'] : ""; ?>" required>
                                        <label class="form-label">Area <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" step=".01" name="square_feet" id="square_feet" class="form-control" value="<?php echo isset($property['square_feet']) ? $property['square_feet'] : ""; ?>" required>
                                        <label class="form-label">Square Feet <span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" min="0" step="any" name="amount" id="amount" class="form-control" value="<?php echo isset($property['amount']) ? $property['amount'] : ""; ?>" required>
                                        <label class="form-label">Property Value</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 hide">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  name="type" id="type" class="form-control" value="<?php echo isset($property['type']) ? $property['type'] : ""; ?>" required>
                                        <label class="form-label">Type</label>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select name="property_category" id="property_category" class="form-control" required>
											<option value="">select property type</option>
											<?php
											foreach($property_category as $property_category_row)
											{
											?>
											<option value="<?php echo $property_category_row['id']; ?>" <?php if(isset($property['property_category_id'])){ if($property['property_category_id'] == $property_category_row['id']){ echo "selected"; } }?>><?php echo $property_category_row['name']; ?></option>
											<?php
											}
											?>
										</select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select name="purchased_year" id="purchased_year" class="form-control" required>
											<option value="">select purchased year</option>
											<?php
                                            $cur_year = date('Y');
											for($year = ($cur_year-5); $year <= ($cur_year+10); $year++)
											{
											?>
											<option value="<?php echo $year; ?>" <?php if(isset($property['purchased_year'])){ if($property['purchased_year'] == $year){ echo "selected"; } }?>><?php echo $year; ?></option>
											<?php
											}
											?>
										</select>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select name="title_type" id="title_type" class="form-control" required>
											<option value="">select title type</option>
											<?php
											foreach($property_titles as $property_title)
											{
											?>
											<option value="<?php echo $property_title['id']; ?>" <?php if(isset($property['title_type'])){ if($property['title_type'] == $property_title['id']){ echo "selected"; } }?>><?php echo $property_title['name']; ?></option>
											<?php
											}
											?>
										</select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" name="rental_value" id="rental_value" class="form-control" value="<?php echo isset($property['rental_value']) ? $property['rental_value'] : ""; ?>" required>
                                        <label class="form-label">Rental Value<span style="color: red;">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                          <div class="form-group form-float">
                             <div class="form-line">
                             <select name="due_date" id="due_date" class="form-control" required>
                          <option value="">Select Due Date</option>
                             <?php
                              for ($day = 1; $day <= 31; $day++) {
                              echo "<option value='$day'>$day</option>";
                           }
                             ?>
                          </select>
                            </div>
                          </div>
                       </div>
                        </div>
                        
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 style="margin-bottom:5px; margin-top:5px;">Document Details</h3>
                            </div>
                            <div class="col-sm-12" style="text-align:right">
                                <div class="form-group form-float">
                                    <div class="form-line" style="border: none;">
                                        <label id="document_upload" class="btn btn-success" style="padding: 5px 12px !important;">Add</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="pay_row_count" value="1">
                            <div class="col-sm-12">
                                <div class="">
                                    <table style="width:100%" class="table table-bordered" id="pay_table">
                                        <thead>
                                            <tr>
                                                <th width="20%">Date</th>
                                                <th width="60%">Document</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            foreach($property_documents as $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo date("d/m/Y", strtotime($row['date'])); ?></td>
                                                <td><a href="<?php echo base_url(); ?>/uploads/properties/<?php echo $row['document_name']; ?>" download><?php echo $row['document_name']; ?></a></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                            <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                        </div>
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
		"property_category": {
			required: true,
		}
	},
	messages: {
		"property_category": {
			required: "property name is required"
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

<script type="text/javascript">
    $("#document_upload").click(function(){
        var cnt = parseInt($("#pay_row_count").val());
        var html = '<tr id="rmv_payrow'+cnt+'">';
        html += '<td style="width: 20%;"><input type="date" value="<?php echo date("Y-m-d"); ?>" style="border: none;" name="date[]"></td>';
        html += '<td style="width: 60%;"><input type="file" style="border: none;" name="file[]"></td>';
        html += '<td style="width: 20%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay('+ cnt +')" style="width:auto;"><i class="material-icons"></i></a></td>';
        html += '</tr>';
        $("#pay_table").append(html);
        var ct = parseInt(cnt + 1);
        $("#pay_row_count").val(ct);
    });
    function rmv_pay(id){
        $("#rmv_payrow"+id).remove();
    }
    $("form").on("submit", function(){
        $('input[type=submit]').prop('disabled', true);
        $("#loader").show();
    });
</script>