<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
if($edit == true){
    $readonly_edit = 'readonly';
    $disable_edit = "disabled";
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
                <h2>Annathanam<small>Annathanam / <b>Add Annathanam</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/annathanam"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form action="<?php echo base_url(); ?>/annathanam/save_annathanam" method="post">
                        <div class="body">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line" id="bs_datepicker_component_container">
                                            <input type="date" name="date" class="form-control" value="<?php if($view == true) echo date("Y-m-d",strtotime($data['date'])); else echo date("Y-m-d");?>" <?php echo $readonly; ?> <?php echo $disable_edit; ?> required>
                                            <label class="form-label">Date <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" style="margin: 0px;">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="billno"  id="billno" class="form-control" value="<?php echo !empty($data['ref_no']) ? $data['ref_no'] : $bill_no; ?>" readonly>
                                            <label class="form-label">Bill No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $data['name'];?>" <?php echo $readonly; ?> required>
                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <?php if($edit != true) { ?>                        
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-md-3" style="margin: 0px;">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control" name="phonecode" id="phonecode">
                                                            <?php
                                                            if (!empty($phone_codes)) {
                                                                foreach ($phone_codes as $phone_code) {
                                                                    ?>
                                                            <option value="<?php echo $phone_code['dailing_code']; ?>" <?php if ($phone_code['dailing_code'] == "+60") {
                                                                echo "selected";
                                                            } ?>><?php echo $phone_code['dailing_code']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9" style="margin: 0px;">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input class="form-control reg_det" type="number" min="0" name="phone_no" id="phone_no" required pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" autocomplete="off">
                                                        <label class="form-label">Mobile Number</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                    else{
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="hidden" name="edit_status" value="1">
                                                <input type="text" name="phone_no" id="phone_no" class="form-control" value="<?php echo $data['phone_no'];?>" <?php echo $readonly; ?> >
                                                <label class="form-label">Mobile Number</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-1">
                                            Time : 
                                        </div>
                                        <div class="col-md-10">
                                            <input  type="checkbox" id="breakfast" name="time" value="Breakfast" class="check_time" <?php if($data['slot_time'] == "Breakfast"){ echo "checked"; } ?> <?php echo $disable; ?>>
									        <label for ='breakfast'> Breakfast &nbsp;&nbsp; </label>
                                            <input  type="checkbox" id="tiffin" name="time" value="Tiffin" class="check_time" <?php if($data['slot_time'] == "Tiffin"){ echo "checked"; } ?> <?php echo $disable; ?>>
									        <label for ='tiffin'> Tiffin &nbsp;&nbsp; </label>
                                            <input  type="checkbox" id="lunch" name="time" value="Lunch" class="check_time" <?php if($data['slot_time'] == "Lunch"){ echo "checked"; } ?> <?php echo $disable; ?>>
									        <label for ='lunch'> Lunch &nbsp;&nbsp; </label>
                                            <input  type="checkbox" id="dinner" name="time" value="Dinner" class="check_time" <?php if($data['slot_time'] == "Dinner"){ echo "checked"; } ?> <?php echo $disable; ?>>
									        <label for ='dinner'> Dinner &nbsp;&nbsp; </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="rice_category" id="rice_category" <?php echo $disable; ?> <?php echo $disable_edit; ?> required>
                                                <option value="">--select rice category --</option>
                                                <?php
                                                if(count($annathanam_rice_category) > 0)
                                                {
                                                    foreach($annathanam_rice_category as $arc)
                                                    {
                                                ?>
                                                <option value="<?php echo $arc['id']; ?>" <?php if($data['rice_category_id'] == $arc['id']){ echo "selected"; } ?> ><?php echo $arc['name_eng']." - ".$arc['name_tamil']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="hidden" name="kuruma_count_id" id="kuruma_count_id" value="<?php echo $kuruma_count_id; ?>">
                                            <select class="form-control" name="kuruma_id" id="kuruma_id" <?php echo $disable; ?> <?php echo $disable_edit; ?> required>
                                                <option value="">--select kuruma --</option>
                                                <?php
                                                if(count($annathanam_kuruma_type) > 0)
                                                {
                                                    foreach($annathanam_kuruma_type as $akt)
                                                    {
                                                ?>
                                                <option value="<?php echo $akt['id']; ?>" <?php if($data['kuruma_id'] == $akt['id']){ echo "selected"; } ?> ><?php echo $akt['name_eng']." - ".$akt['name_tamil']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="rice_type_id" id="rice_type_id" <?php echo $disable; ?> <?php echo $disable_edit; ?> required>
                                                <option value="">--select rice type --</option>
                                                <?php
                                                if(count($annathanam_rice_type) > 0)
                                                {
                                                    foreach($annathanam_rice_type as $art)
                                                    {
                                                ?>
                                                <option value="<?php echo $art['id']; ?>" <?php if($data['rice_type_id'] == $art['id']){ echo "selected"; } ?> ><?php echo $art['name']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" id="amount" min="0" step=".01" name="amount" class="form-control amount" readonly placeholder="Amount" value="<?php echo !empty($data['amount']) ? $data['amount'] : "0.00"; ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" id="no_of_pax" min="0" name="no_of_pax" class="form-control" value="<?php echo !empty($data['no_of_pax']) ? $data['no_of_pax'] : 0; ?>" <?php echo $readonly; ?> <?php echo $disable_edit; ?> required>
                                            <label class="form-label">No of Pax</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h4>காய்கறி வகைகள் / TYPE OF VEGETABLES</h4>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                        <div class="col-sm-12">
                                            <div class="table-responsive" style="background: #9e9e9e17;">
                                                <table style="width:100%" class="table table-bordered" id="pay_table" style="height: 150px;">
                                                    <?php 
                                                    $i = 1;
                                                    foreach($annathanam_vegetables as $row) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $row['name_tamil']; ?></td>
                                                        <td><?php echo $row['name_eng']; ?></td>
                                                        <td>
                                                            <?php
                                                            if(in_array($row['id'], $a_vegetables))
                                                            {
                                                                $checked = "checked";
                                                            }
                                                            else
                                                            {
                                                                $checked = "";
                                                            }
                                                            ?>
                                                            <input id="vegetables_id_<?php echo $row['id']; ?>" name="vegetables[<?php echo $row['id']; ?>][vegetble_id]" type="checkbox" value="<?php echo $row['id']; ?>" class="vegetables_id" onclick="vegatables_click(<?php echo $row['id']; ?>)" <?php echo $checked; ?> <?php echo $disable; ?>>
                                                            <label for ='vegetables_id_<?php echo $row['id']; ?>' ></label>
                                                        </td>
                                                    </tr>
                                            <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>                          
                                </div>                          
                                <div class="col-md-12">&nbsp;</div>                             
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" step="0.1" id="total_amount" name="total_amount" class="form-control" step=".01"  value="<?php echo !empty($data['total_amount']) ? $data['total_amount'] : "0.00"; ?>" readonly>
                                            <label class="form-label">Total Amount </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" name="payment_mode" id="payment_mode" <?php echo $disable; ?> <?php echo $disable_edit; ?> required>
                                                <option value="0">Select</option>
                                                <?php foreach($payment_modes as $payment_mode) { ?>
                                                <option value="<?php echo $payment_mode['id']; ?>" <?php if(!empty($data['payment_mode'])){ if($data['payment_mode'] == $payment_mode['id']){ echo "selected"; } } ?>><?php echo $payment_mode['name'];?></option>
                                                <?php } ?>
                                            </select>
                                            <label class="form-label">Paymentmode <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
                                    <!--input  type="checkbox" checked="checked" id="print" name="print" value="Print">
									<label for ='print'> Print &nbsp;&nbsp; </label-->
									<input type="submit" class="btn btn-success btn-lg waves-effect" value="SAVE">
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
<style>
.bal_amnt_div{
	display: none;
}
</style>
<script>
    $("#clear").click(function(){
        $("input").val("");
    });
    $(document).ready(function(){
        $('.check_time').click(function() {
            $('.check_time').not(this).prop('checked', false);
        });
    });
</script>
<script>
    $(document).ready(function(){
        vegatables_click();
    });
    $("#rice_category, #rice_type_id").change(function(){
        getriceAmount();
    });
    $("#kuruma_id").change(function(){
        $(".vegetables_id").prop("checked",false);
        $(".vegetables_id").prop("disabled",false);
        var krm_id = $(this).val();
        $.ajax({
            url: "<?php echo base_url(); ?>/annathanam/getkurumaCount",
            type: 'POST',
            data: {kurm_id:krm_id},
            success: function (data) {
                $("#kuruma_count_id").val(data);
                getriceAmount();
            }
        });
    });
    $("#no_of_pax").on("keyup", function() {
        sum_amount();
    });
    function vegatables_click()
    {
        //var total_vegetables = $(".vegetables_id").each(function(){ }).length;
        var total_kuruma_count = $("#kuruma_count_id").val();
        var array = [];
        $('.vegetables_id').each(function () {
           if (this.checked) {
            array.push($(this).val());
            //total_veg_checked++;
           }
        });
        var total_veg_checked = array.length;
        if(total_kuruma_count > total_veg_checked)
        {
            $(".vegetables_id").prop("disabled",false);
        }
        else
        {
            $('.vegetables_id').each(function () {
                if (this.checked) {
                    var chj_tr = $(this).val();
                    $("#vegetables_id_"+chj_tr).prop("disabled",false);
                }
                else
                {
                    var chj_tre = $(this).val();
                    $("#vegetables_id_"+chj_tre).prop("disabled",true);
                }
            });
        }
    }
    function getriceAmount()
    {
        var rice_category = $("#rice_category").val();
        var kuruma_id = $("#kuruma_id").val();
        var rice_type_id = $("#rice_type_id").val();
        $.ajax({
            url: "<?php echo base_url(); ?>/annathanam/getriceAmount",
            type: 'POST',
            data: {rice_cat:rice_category,kurm_id:kuruma_id,ricetype_id:rice_type_id},
            success: function (data) {
                $("#amount").val(data);
                sum_amount();
            }
        });
    }
    function sum_amount(){
        var nooffax = $("#no_of_pax").val();
        var amount = $("#amount").val();
        var total_amount = nooffax * amount;
        $("#total_amount").val(Number(total_amount).toFixed(2));
    }
    $("#submit").click(function(){
        return;
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/donation/save",
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
            }
        });
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/donation/print_page/"+id,
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
        frame1.remove();
        //window.location.replace("<?php echo base_url();?>/donation");
		window.location.reload(true);
        //return true;
    }

</script>