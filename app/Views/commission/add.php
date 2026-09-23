<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2> Commission <small>Finance / <b>Commission</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"><!--<h2>Cash Donation</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/commission"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form action="<?php echo base_url(); ?>/commission/save" method="post">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="date" name="commission_date" id="commission_date" class="form-control" value="<?php echo $data['date'];?>" <?php echo $readonly; ?> required max="<?php echo $booking_calendar_range_year; ?>">
                                            <label class="form-label">Commission Date <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="commission_type" id="commission_type" required>
                                                <option value="">select type</option>
                                                <option value="Hall Booking" <?php if($data['type']=='Hall Booking') { echo 'selected'; } ?> >Hall Booking</option>
                                                <option value="Ubayam" <?php if($data['type']=='Ubayam') { echo 'selected'; } ?> >Ubayam</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control search_box" name="commission_staff" id="commission_staff" required data-live-search="true">
                                                <option value="0">select staff</option>
                                                <?php
                                                foreach($staff_list as $row){
                                                ?>
                                                <option value="<?php echo $row['id']; ?>" <?php if($data['staff_id'] == $row['id']) { echo 'selected'; } ?> ><?php echo $row['name']; ?></option>
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
                                            <input type="number" step="any" min="0" class="form-control" name="commission_amount" id="commission_amount" value="<?php echo $data['amount'];?>" <?php echo $readonly; ?> required>
                                            <label class="form-label">Amount <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control" name="commission_remarks" id="commission_remarks"><?php echo $data['remarks'];?></textarea>
                                            <label class="form-label">Remarks</label>
                                        </div>
                                    </div>
                                </div>                
								<?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
									<button type="submit" class="btn btn-success btn-lg waves-effect">SAVE</button>
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
    $("#clear").click(function(){
        $("input").val("");
    });
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/commission/save",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
					window.location.reload(true);
                }
            }
        });
    }); 
    
    $("form").on("submit", function(){
        //$('input[type=submit]').prop('disabled', true);
        //$("#loader").show();
    });

</script>