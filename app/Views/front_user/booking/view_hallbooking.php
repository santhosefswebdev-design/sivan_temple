<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
<style>
.heading { text-align:center; background:#000; color:#FFF; padding:10px; }
.products { 
	background:#FFF;
	display: flex;
    flex-wrap: wrap;
    align-items: center; }
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

</style>
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Hall Booking</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">View Hall Booking</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div> 
<section class="content">
    <div class="container my-5">
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
                                <input type="hidden" name="hall_id" value="<?php echo $data['id'];?>">
                                  <div class="col-md-8 col-lg-8">
                                  <div class="products row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 250px;">
                                        <table class="table table-bordered time">
                                            <thead>
                                                <tr>
                                                    
                                                    <th style="width: 40%;">Slot Time</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; foreach($time_list as $row) { 
                                                    // if (in_array($row['id'], $data_time)) { $disabled = "disabled"; $t_name = $time_name[$row['id']];}
                                                    // else  { $disabled = ""; $t_name = ''; };

                                                    // if (in_array($row['id'], $own_time)) { $checked = "checked"; $disabled = ""; }
                                                    // else  { $checked = "";};
                                                    
                                                ?>
                                                <tr>
                                                    
                                                    <td><?php echo date("g:i A", strtotime($row['name'])) .' - '.date("g:i A", strtotime($row['description'])); ?></td>
                                                    
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                    <div class="products row">
                                        <div class="col-sm-12" style="padding:0; width:100%;">
                                            <h3 style="margin-bottom:5px; margin-top:5px;">Package Details</h3>
                                        </div>
                                    </div>
                                    <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                        <table class="table table-bordered sub" id="package_table" style="height: 150px;">
                                            <thead>
                                                <tr>
                                                    <th width="60%">Name</th>
                                                    <th width="25%">Total RM</th>
                                                    <!--<th width="15%">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; foreach($package_list as $row) { 
                                                    
                                                    ?>
                                                    <tr id="rmv_packrow<?= $i; ?>">
                                                        <td style="width: 60%;"><input type="hidden" readonly name="package[<?= $i; ?>][pack_id]" value="<?= $row['booking_addon_id']?>"><?= $row['name'];?></td>
                                                        <td style="width: 25%;"><input type="text" style="border: none;" readonly class="package_amt" name="package[<?= $i;?>][pack_amt]" value="<?=  $row['tot'];?>"></td>
                                                        <!--<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack(<?= $i++; ?>)"  style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a></td> -->
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="pack_row_count" value="<?= $i; ?>">
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                    <div class="products row">
                                        <div class="col-sm-12" style="padding:0; width:100%;">
                                            <h3 style="margin-bottom:5px; margin-top:5px;">Pay Details</h3>
                                        </div>
                                    </div>
                                    <div class="row scroll" style="overflow-y:scroll; overflow-x:hidden; height: 200px;">
                                        <table class="table table-bordered sub" id="pay_table" style="height: 150px;">
                                            <thead>
                                                <tr>
                                                    <th width="60%">Date</th>
                                                    <th width="25%">Total RM</th>
                                                    <!--<th width="15%">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; foreach($pay_details as $row) {?>
                                                    <tr id="rmv_payrow<?= $i; ?>">
                                                        <td style="width: 60%;"><input type="date" style="border: none;" readonly name="pay[<?= $i; ?>][date]" value="<?= $row['date'];?>"></td>
                                                        <td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="pay[<?= $i; ?>][pay_amt]" value="<?= $row['amount'];?>"></td>
                                                        <!--<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay(<?= $i++;?>)"  style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a></td> -->
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="pay_row_count" value="<?= $i;?>">
                                    </div>
                                    </div>
                                    </div>
                                    
                                    <div class="row products" style=" margin-top:15px;">
                                        <div class="col-sm-4 col-lg-4 col-xs-12 det">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="text" readonly="readonly" id="total_amt" class="form-control" readonly  name="total_amt" value="<?= $data['total_amount'];?>">
                                                    <label class="form-label">Total Amount</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-4 col-xs-12 det">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="text" readonly="readonly" id="deposite_amt" class="form-control" readonly name="deposie_amt" value="<?= $data['paid_amount'];?>">
                                                    <label class="form-label">Deposite RM</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-4 col-xs-12 det">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="text" readonly="readonly" id="balance" class="form-control" readonly name="balance" value="<?= $data['balance_amount'];?>">
                                                    <label class="form-label">Balance RM</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 det"> 
                                    <div class="cart"> 
                                        <h3 style="margin-top:0px;">Register Details</h3>
                                        <!--<form action="" method="post"></form>-->
                                            <div class="row" style="margin-top:10px;">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label">Event Date <span style="color: red;">*</span></label>
                                                            <input type="date" readonly="readonly" class="form-control reg_det" id="event_date" name="event_date" readonly value="<?= $data['booking_date']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label">Event Details <span style="color: red;">*</span></label>
                                                            <input type="text" readonly="readonly" class="form-control  reg_det" name="event_name" value="<?= $data['event_name']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label">Register By <span style="color: red;">*</span></label>
                                                            <input type="text" readonly="readonly" class="form-control reg_det" name="register" value="<?= $data['register_by']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label">Name <span style="color: red;">*</span></label>
                                                            <input type="text" readonly="readonly" class="form-control reg_det" name="name" value="<?= $data['name']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label" style="display: contents; font-size: 14px;">Status</label>
                                                            <select disabled="disabled" class="form-control" name="status" id="status" >
                                                                <option <?php if($data['status'] == 1) echo 'selected'; ?> value="1">Booked</option>
                                                                <option <?php if($data['status'] == 2) echo 'selected'; ?> value="2">Completed</option>
                                                                <option <?php if($data['status'] == 3) echo 'selected'; ?> value="3">Cancelled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label">Address</label>
                                                            <input readonly="readonly" type="text" class="form-control reg_det" name="address" value="<?= $data['address']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label">Mobile Number <span style="color: red;">*</span></label>
                                                            <input readonly="readonly" type="text" class="form-control reg_det" name="mobile" value="<?= $data['mobile_number']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label">Email ID [optional]</label>
                                                            <input readonly="readonly" type="text" class="form-control reg_det" name="email" value="<?= $data['email']; ?>" > 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                            <label class="form-label">IC Number [optional]</label>
                                                            <input readonly="readonly" type="text" class="form-control reg_det" name="ic_num" value="<?= $data['ic_no']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-float">
                                                        <div class="form-line focused">
                                                        <label class="form-label" style="display: contents; font-size: 14px;">Commission To</label>
                                                            <select class="form-control" disabled="disabled" name="commission_to" required>
                                                                <option value="">Select Staff</option>
                                                                <?php foreach($staff as $row) { ?>
                                                                    <option <?php if($data['commision_to'] == $row['id']) echo 'selected'; ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                        <!--</form>-->
                                    </div>
                                
                            </form></div>
                            <div id="del-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body p-4">
                                        <div class="text-center">
                                            <i class="dripicons-information h1 text-info"></i>
                                            <table>
                                                <tr><span id="delmol"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
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
    // $(document).ready(function() {
        $("#clear").click(function() {
        //alert(0);
        //$("input:text").val("");
		$(".reg_det").val("");
		
		//sum_amount();
        });
    // )};
    $("#status ").change(function() {
            var pre_sts = $("#status option:selected").val();
            var balance = parseFloat($("#balance").val());
            if ($("#status option:selected").val()==3 && parseFloat($("#deposite_amt").val())>0){
                $('#del-modal').modal('show', {backdrop: 'static'});
                $("#delmol").text("Unable to cancel Please sure remove the Pay Amount" );
            }else if($("#status option:selected").val()== 2 && balance != 0){
                $('#del-modal').modal('show', {backdrop: 'static'});
                $("#delmol").text("Unable to Completed Please sure Balance Amount Zero" );
            }else{}
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
                    $("#get_pack_amt").val(Number(data['amt']).toFixed(2));
                    $("#pack_name").val(data['name']);
                }
            });
        }else{
            $("#get_pack_amt").val("0.00");
        }
    });
    
    $("#pack_add").click(function(){
        var id = $("#add_one").val();  
        var cnt = parseInt($("#pack_row_count").val());
        if(id != ''){
            var name = $("#pack_name").val();
            var amt = $("#get_pack_amt").val();
            var html = '<tr id="rmv_packrow'+cnt+'">';
                html += '<td style="width: 60%;"><input type="hidden" readonly name="package['+cnt+'][pack_id]" value="'+id+'"> '+name+'</td>';
                html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="package_amt" name="package['+cnt+'][pack_amt]" value="'+Number(amt).toFixed(2)+'"></td>';
                html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pack('+ cnt +')" style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a></td>';
                html += '</tr>';
            $("#package_table").append(html);
            var ct = parseInt(cnt + 1);
            $("#pack_row_count").val(ct);
            sum_amount();
        }
    });

    function rmv_pack(id){
        $("#rmv_packrow"+id).remove();
        sum_amount();
    }

    $("#pay_add").click(function(){
        var date = $("#pay_date").val();
        var amt = $("#pay_amt").val();  
        var cnt = parseInt($("#pay_row_count").val());
        if(date != '' && amt != 0){
            var html = '<tr id="rmv_payrow'+cnt+'">';
                html += '<td style="width: 60%;"><input type="date" style="border: none;" readonly name="pay['+cnt+'][date]" value="'+date+'"></td>';
                html += '<td style="width: 25%;"><input type="text" style="border: none;" readonly class="pay_amt" name="pay['+cnt+'][pay_amt]" value="'+Number(amt).toFixed(2)+'"></td>';
                html += '<td style="width: 15%;"><a class="btn btn-danger btn-rad" onclick="rmv_pay('+ cnt +')"  style="width:auto;padding: 0px 3px !important;"><i class="material-icons"></i></a></td>';
                html += '</tr>';
            $("#pay_table").append(html);
            var ct = parseInt(cnt + 1);
            $("#pay_row_count").val(ct);
            sum_amount();
        }
    });

    function rmv_pay(id){
        $("#rmv_payrow"+id).remove();
        sum_amount();
    }

    function sum_amount(){
        var total = 0;
        var pay_tot = 0;
        $(".package_amt").each(function(){
           total += parseFloat($(this).val());
        });

        $(".pay_amt").each(function(){
            pay_tot += parseFloat($(this).val());
        });

        $("#total_amt").val(Number(total).toFixed(2));
        $("#deposite_amt").val(Number(pay_tot).toFixed(2));
        var sts = $("#status").val();
        if(pay_tot == 0 && sts == 3){
            $("#save").show();
        }
        var balance = total - pay_tot;
        $("#balance").val(Number(balance).toFixed(2));
    }

</script>

<script>
    $("#save").click(function(){
        var pre_sts = $("#status option:selected").val();
        var total_amt       = parseFloat($("#total_amt").val());
        var deposite_amt    = parseFloat($("#deposite_amt").val());
        var balance         = parseFloat($("#balance").val());
        var check_dep       = parseFloat((total_amt / 100) * 30).toFixed(2);
        console.log(check_dep);
        if (pre_sts == 3 && deposite_amt > 0){
            $('#alert-modal').modal('show', {backdrop: 'static'});
            $("#spndeddelid").text("Unable to cancel Please sure remove the Pay Amount");
        }else{
            if(pre_sts != 3 && deposite_amt < check_dep){
                $('#alert-modal').modal('show', {backdrop: 'static'});
                $("#spndeddelid").text("Minimum Deposit Amount RM "+check_dep);
            }else{
                 $.ajax({
                    type:"POST",
                    url: "<?php echo base_url();?>/booking/update",
                    data: $("form").serialize(),
                    success:function(data)
                    {
                        obj = jQuery.parseJSON(data);
                        if(obj.err != ''){
                            $('#alert-modal').modal('show', {backdrop: 'static'});
                            $("#spndeddelid").text(obj.err);
                        }else{
                            printData(obj.id);
                        }
                    }
                });
            }
        }
        
    });  

    function printData(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>/booking/print_page/"+id,
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
        var dt = $('#event_date').val();
        window.location.replace("<?php echo base_url();?>/booking/hallbook_list?date="+dt);
        //return true;
    }

</script>