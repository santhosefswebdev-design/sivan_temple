<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?><section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2> Prasadam <small><b>Add Prasadam</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Ubayam</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/prasadam"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        
                        <form>
                            <input type="hidden" name="id" id="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                                <div class="row clearfix">
									<div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="prasadam_setting_id" id="prasadam_setting_id" <?php echo $readonly; ?>>
                                                    <option value="0">Select</option>
                                                    <?php foreach($prasadam_settings as $prasadam_setting) { ?>
                                                    <option value="<?php echo $prasadam_setting['id']; ?>" <?php if(!empty($data['prasadam_setting_id'])){ if($data['prasadam_setting_id'] == $prasadam_setting['id']){ echo "selected"; } } ?>><?php echo $prasadam_setting['name_eng'];?></option>
                                                    <?php } ?>
                                                </select>
                                                
                                                <label class="form-label">Prasadam Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container" >
                                                <label class="form-label">Date <span style="color: red;">*</span></label>
                                                <input type="date" name="date" id="date" class="form-control"  value="<?php echo isset($data['date']) ? $data['date'] : date("Y-m-d");  ?>" <?php echo $readonly; ?> >
                                            </div>
                                        </div>
                                    </div>
									<div class="clear:both"></div>
									<div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
												<textarea name="description" id="description" class="form-control" <?php echo $readonly; ?>><?php echo $data['desciption'];?></textarea>
                                                <label class="form-label">Description <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
									<div class="clear:both"></div>
									<div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="customer_name" id="customer_name" class="form-control" value="<?php echo $data['customer_name'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Customer Name <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="amount" id="amount" class="form-control" value="<?php echo $data['amount'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Amount <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear:both"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <div class="form-line focused" id="bs_datepicker_container" >
                                                <label class="form-label">Collection Date <span style="color: red;">*</span></label>
                                                <input type="date" name="collection_date" id="collection_date" class="form-control"  value="<?php echo $data['collection_date'];  ?>" <?php echo $readonly; ?> >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="" >
                                                <label class="form-label">Start Time <span style="color: red;">*</span></label>
                                                <input type="text" name="start_time" id="start_time" class="form-control bs-timepicker" value="<?php echo isset($data['start_time']) ? $data['start_time'] : date("H:i");  ?>" <?php echo $readonly; ?> >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="" >
                                                <label class="form-label">End Time <span style="color: red;">*</span></label>
                                                <input type="text" name="end_time" id="end_time" class="form-control bs-timepicker" value="<?php echo isset($data['end_time']) ? $data['end_time'] : date("H:i");  ?>" <?php echo $readonly; ?> >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="paymentmode" id="paymentmode" <?php echo $disable; ?>>
                                                    <option value="0">Select</option>
                                                    <?php foreach($payment_modes as $payment_mode) { ?>
                                                    <option value="<?php echo $payment_mode['id']; ?>" <?php if(!empty($data['payment_mode'])){ if($data['payment_mode'] == $payment_mode['id']){ echo "selected"; } } ?>><?php echo $payment_mode['name'];?></option>
                                                    <?php } ?>
                                                </select>
                                                <label class="form-label">Paymentmode <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" style="display:none">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select name="prasadam_master_id" id="prasadam_master_id" class="form-control" required>
                                                    
                                                </select>
                                                <label class="form-label">Prasadam Timing <span style="color: red;">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-sm-12" align="center">
                                        <?php if($view != true) { ?>
                                
										<input  type="checkbox" checked="checked" id="print" name="print" value="Print">
										<label for ='print'> Print &nbsp;&nbsp; </label>
										<label id="submit" class="btn btn-success btn-lg waves-effect">SAVE</label>
										<button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
									</div>
                                <?php } ?>
                                </div>
                            </div>
                        </form>                        
                    </div>
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
<script>
    $('#date').change(function() {
        var date= this.valueAsDate;
        date.setDate(date.getDate() + 3);
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var year = date.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        var newdate =  year + '-' + month + '-' + day;
        $('#collection_date').attr('min' , newdate);
    });
    $('#date').change();

    
    $('#date_old').change(function(){
        get_available_prasadam();
    });
    function get_available_prasadam(){
        var date = $("#date_old").val();
        if(date != ''){
            $.ajax({
                url: "<?php echo base_url();?>/prasadam/get_available_prasadam",
                type: "post",
                data: {prasadamdate: date},
                success: function(data){
                    $("#prasadam_master_id").html(data);
                    $('#prasadam_master_id').prop('selectedIndex',0);
                    $("#prasadam_master_id").selectpicker("refresh");
                }
            });
        }
    }
    $(document).ready(function () {
        //get_available_prasadam();
    });
	$("#clear").click(function(){
	   $("input").val("");
	});
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/prasadam/save",
            data: $("form").serialize(),
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
					{
						window.location.replace("<?php echo base_url();?>/prasadam");
					}
                }
            }
        });
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/prasadam/print_page/"+id,
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
        window.location.reload(true);
        //return true;
    }
    $("input[type='date']").keydown(false);
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/timepicker/css/timepicker.min.css">
<script src="<?php echo base_url(); ?>/assets/timepicker/js/timepicker.min.js"></script>
<script>
    $('.bs-timepicker').timepicker();
</script>