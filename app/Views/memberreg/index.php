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
            <div class="row clearfix">
            <div class="block-header">
                <h2> MEMBER <small>Member / <b>Member Registration</b></small></h2>
            </div>
            <!-- Basic Examples -->
            
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                         <div class="header">
                        <div class="row">
                            <div class="col-md-12" align="center"><h2>Member Registration</h2></div>
                        </div>
                    </div>
                        <form id="reset_member_reg">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">
                                        <div class="form-line">-->
                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                            <input type="text" name="name" class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> >
                                        <!--</div>
                                    </div>-->
                                </div>
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">
                                        <div class="form-line">-->
                                            <label class="form-label">Member Number</label>
                                            <input type="text" class="form-control" value="<?php echo $data['member_no'];?>" readonly>
                                        <!--</div>
                                    </div>-->
                                </div>
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">
                                        <div class="form-line">-->
                                        <label class="form-label" style="display: contents;">Member Type <span style="color: red;">*</span></label>
                                            <select class="form-control" id="member_type" name="member_type" <?php echo $disable; ?>>
                                                <option value="">-- Select Type --</option>
												<?php 
												if(count($member_type_list) > 0){
													foreach($member_type_list as $mtl){
													?>
													<option value="<?php echo $mtl['id']; ?>" <?php echo ($data['member_type'] == $mtl['id']) ? "selected": ""; ?> ><?php echo $mtl['name']; ?></option>
													<?php 
													}
												}
												?>
                                            </select>
                                        <!--</div>
                                    </div>-->
                                </div>
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">
                                        <div class="form-line">-->
                                        <label class="form-label" style="display: contents;">Status <span style="color: red;">*</span></label>
                                            <select class="form-control" name="status" <?php echo $disable; ?>>
                                                <option value="">-- Select Status --</option>
                                                <option value="1" <?php echo ($data['status'] == 1) ? "selected": ""; ?> >Active</option>
                                                <option value="2" <?php echo ($data['status'] == 2) ? "selected": ""; ?>>Deactive</option>
                                            </select>
                                        <!--</div>
                                    </div>-->
                                </div>
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">
                                        <div class="form-line">-->
                                            <label class="form-label">Ic Number</label>
                                            <input type="text" name="ic_number" class="form-control" value="<?php echo $data['ic_no'];?>" <?php echo $readonly; ?> >
                                        <!--</div>
                                    </div>-->
                                </div>
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">
                                        <div class="form-line">-->
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" name="mobile" class="form-control" value="<?php echo $data['mobile'];?>" <?php echo $readonly; ?> >
                                        <!--</div>
                                    </div>-->
                                </div>
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">
                                        <div class="form-line">-->
                                            <label class="form-label">Address</label>
                                            <input type="text"  name="address" class="form-control" value="<?php echo $data['address'];?>" <?php echo $readonly; ?> >
                                        <!--</div>
                                    </div>-->
                                </div>
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">-->
                                        <div id="bs_datepicker_component_container">
                                            <label class="form-label">Start Date <span style="color: red;">*</span></label>
                                            <input type="date" name="start_date" class="form-control" value="<?php echo ($data['start_date']) ? date("Y-m-d",strtotime($data['start_date'])) : date("Y-m-d");?>" <?php echo $readonly; ?> >
                                        </div>
                                    <!--</div>-->
                                </div>
                                <div class="col-sm-6">
                                    <!--<div class="form-group form-float">
                                        <div class="form-line focused">-->
                                            <label class="form-label">Payment <span style="color: red;">*</span></label>
                                            <input type="number" step="0.1" id="payment" name="payment" class="form-control" step=".01"  value="<?= $data['payment'] ?>" <?php echo $readonly; ?>>
                                        <!--</div>
                                    </div>-->
                                </div>
                                <?php if($view != true) { ?>
                                <div class="col-sm-12" align="center"> 
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
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button id="hide_remove_button" type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
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
    $("#member_type").change(function(){
        var type = $(this).val();
        $.ajax({
            type: "post",
            url: "<?php echo base_url();?>/memberreg/get_member_amount",
            data: {id: type},
            success: function(data){
                obj = jQuery.parseJSON(data);
                $("#payment").val(obj.amount);
            }
        });
    });

    $("#clear").click(function(){
        $("input").val("");
    });
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/memberreg/save",
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
							$('#alert-modal').modal('show', {backdrop: 'static'});
							$("#spndeddelid").text(obj.succ);
							$("#hide_remove_button").hide();
							//$("#reset_member_reg")[0].reset();
							setTimeout(function() {
								location.reload();
							}, 2000);
							//window.location.reload(true);
						}
                }
            }
        });
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/memberreg/print_page/"+id,
            type: 'POST',
            success: function (result) {
                //console.log(result)
                popup(result);
            }
        });
    }

    //setTimeout(popup(data), 500000);
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
		
			frameDoc.onload(function() { 
				frameDoc.focus();
				frameDoc.print();
				frameDoc.close();
			});

        frame1.remove();
        //window.location.replace("<?php echo base_url();?>/donation");
		window.location.reload(true);
        //return true;
    }

</script>