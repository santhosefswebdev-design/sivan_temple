<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--> 
<style>
.table-responsive{
        overflow-x: hidden;
    }
.heading { text-align:center; background:#000; color:#FFF; padding:10px; }
/*.products { 
	background:#FFF;
	display: flex;
    flex-wrap: wrap;
    align-items: center; }*/
.prod { background:#CCCCCC; padding:10px 3px; margin-top:10px; margin-bottom:10px; cursor:pointer; }
.prod img { width:30%; float:left; border-right:1px dashed #999999; }
.prod .detail { width:60%; position:relative; margin-left:40%; }
.prod .detail h4,.prod .detail h5 { font-weight:bold; }
.vl { border-left: 2px dashed #999999; height: 82%; position: absolute; left: 38%; margin-left: -3px; top: 0; bottom:0; margin-top:10px; }
.cart-table { width:100%; } 
.cart-table tr th { font-weight:normal; padding:10px;  }
.cart-table tr td { padding:10px; font-size:12px; border :none;}
.row_amt {border :none;width: 40%;}
.row_qty{border :none;width: 40%;}
.row_tot {border :none;width: 60%;}
.detail h5 { font-size:12px; }
form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 90%;
  background: #f1f1f1;
}

form.example button {
  float: left;
  width: 10%;
  padding: 10px;
  background: #000;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.example button:hover {
  background:#333333;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}
.form-group{
    margin-bottom: 0;
}
.btn-rad{
    padding: 6px !important;
    border-radius: 13% !important;
    width: 23%;
    color: #fff !important;
}
.products .smal_marg{
	padding-right: 4px;
    padding-left: 4px;
}


.time tr td, .time tr th {
    padding: 3px 7px !important;
    border: 1px solid #eee;
}
.card .body .col-xs-12, .card .body .col-sm-12, .card .body .col-md-12, .card .body .col-lg-12 {
    margin-bottom: 10px !important;
}
.card .body .col-xs-8, .card .body .col-sm-8, .card .body .col-md-8, .card .body .col-lg-8 {
    margin-bottom: 10px !important;
}
.sub tr th { padding:1px 5px !important; }
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
.scroll::-webkit-scrollbar {
  width: 3px;
}
.scroll::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
.scroll::-webkit-scrollbar-thumb {
  background: #f44336; 
}
.scroll::-webkit-scrollbar-thumb:hover {
  background: #f7847c; 
}
h3.heading{
    font-weight: 700;
    background: #fa6742;
    color: white;
    padding: 5px 10px;
    font-size: 20px;
    margin-top:5px;
    margin-bottom:5px;
}
.area{
    background: #fa6742;  
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);  
    width: 100%;
	border-radius:15px;
	color:#FFFFFF;
	padding:30px;
}
</style>
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Hall Booking</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">New Hall Booking</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div> 
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                            <div class="row"><div class="col-md-8 col-xs-6"><h2><a href="<?php echo base_url(); ?>/booking"><button type="button" class="btn bg-blue waves-effect">Back</button></a></h2></div>
                            <div class="col-md-4" align="right"></div></div>
                        </div>
                        <div class="body">
                             <?php if($_SESSION['succ'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="suc-alert">
                                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['succ']; ?></p> 
                                    </div>
                                </div> 
                             <?php } ?>
                             <?php if($_SESSION['fail'] != '') { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                        <p><?php echo $_SESSION['fail']; ?></p>
                                    </div>
                                </div>
                             <?php } ?>
                        <div class="container-fluid">
                            <form>
                            <div class="row">
                                
                                  <div class="col-md-8 col-lg-8 det"> 
									<div class="row">
										<div class="col-sm-12">
											<h3 class="heading">Slot Details</h3>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-2 col-form-label" for="animals">Slot Time</label>
										<div class="col-10">
										  <select name="timing[]" id="timing" multiple style="width: 100%!important;">
											<?php foreach($time_list as $row) { 
												?>
												<option value="<?php echo $row['id']; ?>"><?php echo date("g:i A", strtotime($row['name'])) .' - '.date("g:i A", strtotime($row['description'])); ?></option>
												<?php 
												} ?>
										</select>
										</div>
									</div>
                                    <div class="row" style="margin-top:20px;">
                                    <div class="col-md-12">
                                    <div class="scroll  row">
                                        <div class="col-sm-12">
                                            <h3 class="heading">Package Details</h3>
                                        </div>
                                        <div class="col-sm-6 smal_marg">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label class="form-label">Select</label>
                                                    <select class="form-control" id="add_one">
                                                        <option value="">Select From</option> 
                                                        <?php foreach($package as $row) { ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 smal_marg">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label class="form-label">RM</label>
                                                    <input type="hidden" id="pack_name">
                                                    <input type="number" class="form-control" id="get_pack_amt" value="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 smal_marg">
                                            <div class="form-group form-float">
                                                <div class="form-line" style="border: none;">
													<label class="form-label">&nbsp;</label>
                                                    <p><label id="pack_add" class="btn btn-success" style="padding: 5px 12px !important;">Add</label></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px; margin-top:15px;">
                                        <div class="table-responsive">
                                        <table class="table table-bordered" style="width:100%" id="package_table" style="height: 220px;">
                                            <thead>
                                                <tr>
                                                    <th width="60%">Name</th>
                                                    <th width="25%">Total RM</th>
                                                    <th width="15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table> 
                                        <input type="hidden" id="pack_row_count" value="0">
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row" style=" margin-top:15px;    float: right;">
                                        <div class="col-sm-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label class="form-label">Total Amount</label>
                                                    <input type="text" id="total_amt" class="form-control" readonly  name="total_amt" value=0>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 det"> 
                                    
                                    <div class="cart area"> 
                                        <h3 class="heading">Register Details</h3>
                                        <!--<form action="" method="post"></form>-->
                                            <div class="row" style="margin-top: 25px;">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">Event Date <span style="color: red;">*</span></label>
                                                            <input type="date" class="form-control reg_det" id="event_date" name="event_date" value="<?= $date; ?>" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">Event Details <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control reg_det" name="event_name" id="event_name" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">Register By <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control reg_det" name="register" id="register" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control reg_det" name="name" id="name" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">Address <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control reg_det" name="address" id="address" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">City <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" name="city" id="city" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">Mobile Number <span style="color: red;">*</span></label>
                                                            <input type="text" class="form-control reg_det" name="mobile" id="mobile" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">Email ID [optional]</label>
                                                            <input type="text" class="form-control reg_det" name="email" id="email" value="" > 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <label class="form-label">IC Number [optional]</label>
                                                            <input type="text" class="form-control reg_det" name="ic_num" id="ic_num" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:30px;">
                                                <div class="col-sm-3 col-md-3 col-xs-3">
                                                    <div class="form-group">
                                                        <div class="form-line" style="border: none;">
                                                            <a class="btn btn-info" onclick="history.go(-1)" style="color: #fff;" >Back</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--div class="col-sm-3 col-md-3 col-xs-3">
                                                    <div class="form-group">
                                                        <div class="form-line" style="border: none;">
                                                            <a class="btn btn-danger" id="clear" style="color: #fff;"  >Clear</a>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-sm-3 col-md-3 col-xs-3">
                                                    <div class="form-group">
                                                        <div class="form-line" style="border: none;">
                                                            <input  type="checkbox" checked="checked" id="print" name="print" value="Print">
															<label for ='print'> Print &nbsp;&nbsp; </label>
                                                        </div>
                                                    </div>
                                                </div-->
                                                <div class="col-sm-3 col-md-3 col-xs-3">
                                                    <div class="form-group">
                                                        <div class="form-line" style="border: none; text-align: right;">															
															<label class="btn btn-success" id="submit">Save</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        <!--</form>-->
                                    </div>
                                </div>
                            
                            </div>
                            </form>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 127%;">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
        $("#clear").click(function() {
        //alert(0);
        //$("input:text").val("");
		$(".reg_det").val("");
        });

        
    $("#add_one").change(function(){
        var id = $("#add_one").val();
        if(id != ''){
            $.ajax({
                url: "<?php echo base_url();?>/booking/getpack_amt",
                type: "post",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    console.log(data)
                    ////Number(data['amt']).toFixed(2)
                    $("#get_pack_amt").val(Number(data['amt']).toFixed(2));
                    $("#pack_name").val(data['name']);
                }
            });
        }else{
            $("#get_pack_amt").val(0);
        }
    });
    
    $("#pack_add").click(function(){
        // alert(0);
        //var id = $("#add_one option:selected").val();
		var id = $("#add_one option:selected").val();
        var cnt = parseInt($("#pack_row_count").val());
		amt = $("#get_pack_amt").val();
		//alert(amt);
        if(id != '' && parseFloat(amt)>0){
            var name = $("#pack_name").val();
            
            var html = '<tr id="rmv_packrow'+cnt+'">';
                html += '<td style="width: 60%;"><input type="hidden" readonly name="package['+cnt+'][pack_id]" value="'+id+'"> '+name+'</td>';
                html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="package_amt" name="package['+cnt+'][pack_amt]" value="'+Number(amt).toFixed(2)+'"></td>';
                html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack('+ cnt +')" style="width:auto;padding: 0px 3px !important;"><i class="fa fa-trash"></i></a></td>';
                html += '</tr>';
            $("#package_table").append(html);
            var ct = parseInt(cnt + 1);
            $("#pack_row_count").val(ct);
            sum_amount();
			$("#get_pack_amt").val('');
        }
    });

    function rmv_pack(id){
        $("#rmv_packrow"+id).remove();
        sum_amount();
    }



    function sum_amount(){
        var total = 0;
        $(".package_amt").each(function(){
           total += parseFloat($(this).val());
        });
        $("#total_amt").val(Number(total).toFixed(2));
    }

$("#submit").click(function(){
        var total_amt       = parseFloat($("#total_amt").val());
        var timing    = $("#timing").val();
        var mobile    = $("#mobile").val();
        var event_name    = $("#event_name").val();
        var event_date    = $("#event_date").val();
        var name    = $("#name").val();
        var address    = $("#address").val();
        var city    = $("#city").val();
        var register_by    = $("#register").val();
        var pack_row_count    = $("#pack_row_count").val();
        if (pack_row_count > 0 && mobile != "" && event_name != "" && event_date != "" && name != "" && address != "" && city != "" && register_by != ""){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url();?>/booking/save_booking",
				data: $("form").serialize(),
				success:function(data)
				{
					obj = jQuery.parseJSON(data);
					if(obj.err != ''){
						$('#alert-modal').modal('show', {backdrop: 'static'});
						$("#spndeddelid").text(obj.err);
					}else{
						window.open("<?php echo base_url();?>/booking/payment_process/" + obj.id, "_blank", "width=680,height=500");
						window.location.reload(true);
					}
				}
			});
        }else{
			$('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text("please enter all fileds.");
        }
        
    });   

</script>