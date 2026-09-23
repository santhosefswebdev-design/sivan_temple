<?php 
if($view == true){
    $readonly = 'readonly';
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Prasadam Master Add<small>Prasadam / <b>Prasadam Master Add</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Prasadam</h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/master/prasadam"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/master/save_prasadam" method="POST" enctype="multipart/form-data">
                    <div class="body">
                        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text"  class="form-control" name="name" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> required>
                                        <label class="form-label">Prasadam Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line" id="bs_datepicker_container" >
                                        <label class="form-label">Date <span style="color: red;">*</span></label>
                                        <input type="date" name="date" id="date" class="form-control"  value="<?php echo isset($data['date']) ? $data['date'] : date("Y-m-d");  ?>" <?php echo $readonly; ?> required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line" id="" >
                                        <label class="form-label">Start Time <span style="color: red;">*</span></label>
                                        <input type="text" name="start_time" id="start_time" class="form-control bs-timepicker" value="<?php echo isset($data['start_time']) ? $data['start_time'] : date("H:i");  ?>" <?php echo $readonly; ?> >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <div class="form-line" id="" >
                                        <label class="form-label">End Time <span style="color: red;">*</span></label>
                                        <input type="text" name="end_time" id="end_time" class="form-control bs-timepicker" value="<?php echo isset($data['end_time']) ? $data['end_time'] : date("H:i");  ?>" <?php echo $readonly; ?> >
                                    </div>
                                </div>
                            </div>
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
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/timepicker/css/timepicker.min.css">
<script src="<?php echo base_url(); ?>/assets/timepicker/js/timepicker.min.js"></script>
<script>
    $('.bs-timepicker').timepicker();
</script>