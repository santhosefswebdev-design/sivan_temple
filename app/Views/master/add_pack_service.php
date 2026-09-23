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
            <h2>Services<small>Booking / <b>Add Services </b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><!--<h2>Hall</h2>--></div>
                            <div class="col-md-4" align="right"><a
                                    href="<?php echo base_url(); ?>/master/pack_service"><button type="button"
                                        class="btn bg-deep-purple waves-effect">List</button></a></div>
                        </div>
                    </div>
                    
                    <form action="<?php echo base_url(); ?>/master/save_temple_service" method="POST">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="name" required value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Name <span style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="description" value="<?php echo $data['description'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Description </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="service_type" id="service_type" <?php echo $readonly; ?>>
                                            <option value="">-- Select Service Type --</option>
                                            <option value="1" <?php if($data['service_type'] == '1'){ echo "selected"; } ?>>Hallbooking</option>
                                            <option value="2" <?php if($data['service_type'] == '2'){ echo "selected"; } ?>>Ubayam</option>
                                            <option value="3" <?php if($data['service_type'] == '3'){ echo "selected"; } ?>>Sannathi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4" style="display:none">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="service_mode" <?php echo $readonly; ?>>
                                            <option value="">-- Select Service Mode --</option>
                                            <option value="1" <?php if($data['service_mode'] == '1'){ echo "selected"; } ?>>Single</option>
                                            <option value="2" <?php if($data['service_mode'] == '2'){ echo "selected"; } ?>>Multiple</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check" style="margin-top:15px;">
                                  <input class="form-check-input" id="add_on" name="add_on" <?php if($data['add_on'] == '1'){ echo "checked"; } ?> type="checkbox" value="1" id="add_on">
                                  <label class="form-check-label" for="add_on">
                                    Addon
                                  </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="amount" class="form-control" name="amount" value="<?php echo $data['amount'];?>" <?php echo $readonly; ?>>
                                        <label class="form-label">Amount <span id="req" style="color: red;"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control" name="status" id="status" <?php echo $readonly; ?>>
                                            <option value="">-- Select Status --</option>
                                            <option value="1" <?php if($data['status'] == '1'){ echo "selected"; } ?>>Active</option>
                                            <option value="2" <?php if($data['status'] == '2'){ echo "selected"; } ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="ledger_id" id="ledger_id">
                                        <option value="">Select Ledger</option>
                                        <?php
                                        if(!empty($ledgers))
                                        {
                                            foreach($ledgers as $ledger)
                                            {
                                        ?>
                                            <option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($data['ledger_id'])){ if($data['ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-sm-2">
                                <div class="form-check" style="margin-top:15px;">
                                  <input class="form-check-input" id="is_virtual" name="is_virtual" <?php if($data['is_virtual'] == '1'){ echo "checked"; } ?> type="checkbox" value="1" id="is_virtual">
                                  <label class="form-check-label" for="is_virtual">
                                  Is Virtual
                                  </label>
                                </div>
                            </div> -->
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
<script>
$("#clear").click(function(){
   $("input").val("");
    $('#service_type').prop('selectedIndex',0);
    $("#service_type").selectpicker("refresh");
    $('#status').prop('selectedIndex',0);
    $("#status").selectpicker("refresh");
    $('#ledger_id').prop('selectedIndex',0);
    $("#ledger_id").selectpicker("refresh");
    $("input[type=checkbox], input[type=radio]").prop('checked', false);
});
$(function () {
   $('#req').hide();
   $('#add_on').change(function () {
        if ($(this).is(':checked')) {
            $('#amount').attr('required', 'true');
            $('#req').show();
        }
        else {
            $('#amount').removeAttr('required'); 
            $('#req').hide();
        }
    });
});
</script>

<script>
    function validations(){
        $.ajax
            ({
            type:"POST",
            url: "<?php echo base_url(); ?>/master/validation2",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                console.log(obj);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    $('input[type=submit]').prop('disabled', true);
                    $("#loader").show();
                    $("form").submit();
                }
            }
        })
            
    }
</script>
