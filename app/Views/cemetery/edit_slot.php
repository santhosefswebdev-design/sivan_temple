<?php 
if($view == true){
    $readonly = 'readonly';
    $disabled = 'disabled';
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
            <h2>BOOKING SLOT SETTING<small>Cemetery / <a href="#" target="_blank">Edit Booking Slot Setting</a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Booking Slot Setting</h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/cemetery/booking_slot"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/cemetery/save_slot" method="POST">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
							<div class="row clearfix">
								<div class="col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="text"  class="form-control" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?>>
											<label class="form-label">Name <span style="color: red;"> *</span></label>
										</div>
									</div>
								</div>
								<?php if($view != true) { ?>
                                <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
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
<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
	$("form").on("submit", function(){
        $('input[type=submit]').prop('disabled', true);
        $("#loader").show();
    });
</script>

