<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
<style>
[type="checkbox"] + label {
	display:none;
}
[type="checkbox"] + label.s_print {
	display:block;
}
.heading { text-align:center; background:#000; color:#FFF; padding:10px; }
.products { 
	background:#fff;
	display: flex;
    flex-wrap: wrap;
    align-items: center; 
	max-height: 875px;
    overflow-y: scroll;
}

.products .col-md-3{ 
	margin-bottom: 0px;
}
.prod {  padding:5px 3px; margin-top:1px;border:2px solid #fa6742; margin-bottom:1px; cursor:pointer;display: flex; align-items: center; border-radius:15px; position:relative; overflow:hidden; z-index:1;}
.prod img { width:30%; float:left; border-right:1px dashed #999999; border-radius:15px; }
.prod .detail { /*width:60%;margin-left:40%;*/ position:relative; margin-left:10px; width:100%; }
.prod .detail h4,.prod .detail h5 { font-weight:bold; }
.vl { border-left: 2px dashed #999999; height: 82%; position: absolute; left: 38%; margin-left: -3px; top: 0; bottom:0; margin-top:10px; }
.cart-table { width:100%; } 
.cart-table tr th { font-weight:600; padding:4px;  }
.cart-table tr td { padding:2px; font-size:12px; border :none;}
.row_amt,.row_qty,.row_tot,.tot  {border :none;width: 100%;}
.detail h5 { font-size:11px; }
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
.all_close{
	height: 39px;
}
.cart-body{
    overflow-y: scroll;
    overflow-x: hidden;
    /*height: 220px;*/
	height:150px;
	display: block;
}
.cart-table thead, tbody.cart-body tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.rasi-body{
    overflow-y: scroll;
    overflow-x: hidden;
    /*height: 220px;*/
	height:70px;
	display: block;
}
.rasi-table thead, tbody.rasi-body tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.arch_total { background:#CCC; color:#000; font-weight:bold; text-align:center; font-size:38px; padding:0px; line-height:40px; } 

.card .body .col-xs-12, .card .body .col-sm-12, .card .body .col-md-12, .card .body .col-lg-12 {
    margin-bottom: 0px !important;
}
.detail h4 { font-size:21px; }
.prod { min-height:125px; }
@media (min-width: 992px) and (max-width: 1285px) {
.detail h4 { font-size:19px; }
}
.cart-table p { line-height: 15px; margin: 0 0 5px; color:#FFFFFF; font-size:12px !important; }
.rasi-table p { line-height: 15px; margin: 0 0 5px; color:#FFFFFF; }
.cart-table .btn { padding: 0.33rem 0.533rem; }
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
.archheading{
    text-transform: uppercase;
    background: #fa6742;
    color: white;
    text-align: center;
    padding: 10px;
    margin-top: 15px;
}
</style> 
<div id="banner-area" class="banner-area" style="background-image:url(<?php echo base_url(); ?>/assets/frontend/images/banner/banner5.jpg)">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="banner-heading">
              <h1 class="banner-title">Archanai Booking</h1>
              <ol class="breadcrumb">
                 <li>Home</li>
                 <li><a href="#">New Archanai Booking</a></li>
              </ol>
           </div>
        </div>
     </div>
  </div>
</div> 
<section class="content">
    <div class="container my-5">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
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
                            <div class="row">
                                  <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12 search-container" style="padding:0;">
                                          <input type="text" class="form-control" placeholder="Search.." name="search" id="search">
                                          <!--<button type="submit"><i class="fa fa-search"></i></button>-->
                                        </div>
                                    </div>
                                    <div id="products" class="products row scroll">

                                        <?php foreach($archanai as $key => $value){ 
                                            if(!empty($value)) {
                                            ?>
                                            <div class="col-md-12" style="width:100%; padding:0;"><h4 class="archheading"><?php if(!empty($key)) { echo $key; } else{  echo '';} ?></h4></div>
                                            <?php foreach($value as $row) { ?>
                                                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" style="padding-left: 0px; padding-right:3px;">
                                                    <div class="prod gradient-background" id="<?php echo $row['id']; ?>" data-id="prod<?php echo $row['id']; ?>" onclick="addtocart(<?php echo $row['id']; ?>)"><img src="<?php echo base_url(); ?>/uploads/archanai/<?php echo $row['image']; ?>" width="200" height="80" alt="image" />
                                                        <!--<div class="vl"></div>-->
                                                        <div class="detail">
                                                            <h5 id="nm_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>"><?php echo $row['name_tamil'].' <br>'.$row['name_eng']; ?></h5><h4 id="amt_<?php echo $row['id'];?>" data-id="<?php echo $row['amount']; ?>" >RM <?php echo number_format((float)($row['amount']), 2);?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } }?>
                                        <?php /* foreach($data as $row) { ?>
                                            <div class="col-md-3" style="padding-left: 0px;">
                                                <div class="prod" id="<?php echo $row['id']; ?>" data-id="prod<?php echo $row['id']; ?>" onclick="addtocart(<?php echo $row['id']; ?>)"><img src="<?php echo base_url(); ?>/uploads/archanai/<?php echo $row['image']; ?>" width="200" height="80" alt="image" />
                                                    <!--<div class="vl"></div>-->
                                                    <div class="detail">
                                                        <h5 id="nm_<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>"><?php echo $row['name_tamil'].' <br>'.$row['name_eng']; ?></h5><h4 id="amt_<?php echo $row['id'];?>" data-id="<?php echo $row['amount'] + $row['commission']; ?>" >RM <?php echo number_format((float)($row['amount'] + $row['commission']), 2);?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } */ ?>
                                        
                                    </div> 
                                </div>
                                        <div class="col-md-4 det">
                                            <div class="cart area">
                                                
                                                <div class="row">
                                                <h3 style="margin-top:0px; margin-bottom: 15px; text-align:center; color:#FFFFFF;">Archanai Items</h3>
                                                <form action="" method="post">
                                                <div class="row" style="margin-top:20px;">
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line" id="bs_datepicker_container" >
																<label class="form-label">Date</label>
                                                                <input type="date" name="dt" id="dt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  >
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line">
																<label class="form-label">Bill No</label>
                                                                <input type="text"  name="billno"  id="billno" class="form-control" value="<?php echo $bill_no; ?>" readonly>
															</div>
														</div>
													</div>
                                                </div>
                                                <div class="row">
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line" id="ar_name_cont" >
                                                                  <label class="form-label">Name</label>
                                                                  <input type="text"  name="ar_name"  id="ar_name" class="form-control" value="" />
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line" id="bs_datepicker_container" >
																<label class="form-label">Rasi</label>
                                                                <select class="form-control" name="rasi_id" id="rasi_id">
                                                                    <option>Select Rasi</option>
                                                                    <?php foreach($rasi as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng'];?></option>
                                                                    <?php } ?>
                                                                </select>
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin: 0px;">
														<div class="form-group form-float">
															<div class="form-line">
																<label class="form-label">Natchathiram</label>
                                                                <select class="form-control" name="natchathra_id" id="natchathra_id">
                                                                    <option>Select Natchathiram</option>
                                                                    <?php foreach($nat as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng'];?></option>
                                                                    <?php } ?>
                                                                </select>
															</div>
														</div>
													</div>
													<div class="col-sm-6" style="margin-top: 40px;">
														<div class="form-group form-float">
															<div class="" id="ar_name_cont" >
                                                                  <button type="button"  name="ar_add_btn"  id="ar_add_btn" class="btn btn-info" style="width:100%;">Add</button>
															</div>
														</div>
													</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label class="form-label">Comission To</label>
                                                                <select class="form-control" name="comission_to">
                                                                    <option value="0">Select Staff</option>
                                                                    <?php foreach($staff as $row) { ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name'];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <input type="hidden" value="0" name="cnt" id="count">
													<div class="cart_tab_outer">
														<table class="cart-table">
															<thead>
																<th style="width: 40%; text-align: left;">Archanai Name</th>
																<th style="width: 16%; text-align: center;">RM</th>
																<th style="width: 12%; text-align: center;">Qty</th>
																<th style="width: 20%; text-align: center;">Total</th>
																<th style="width: 12%; text-align: center;">&nbsp;</th>
															</thead>
															<tbody class="cart-body scroll">
															</tbody>
														</table>
													</div>
                                                    <input type="hidden" value="0" name="cnt1" id="count1">
													<div class="cart_tab_outer">
														<table class="rasi-table">
															<thead>
																<th style="width: 38%; text-align: left;">Name</th>
																<th style="width: 32%; text-align: center;">Rasi</th>
																<th style="width: 30%; text-align: center;">Natchathiram</th>
															</thead>
															<tbody class="rasi-body scroll">
															</tbody>
														</table>
													</div>
                                                    <hr>
													<div class="arch_total">
														<input type="hidden" class="tot" id="tot_amt" name="tot_amt" value="0.00">
														<strong>Total RM</strong> <span class="tot_amt_txt">0.00</span>
													</div>
                                                    <div class="row" style="margin-top:10px;">
                                                        <!--<div class="col-md-12" style="background:#FFFFFF;margin-top:5px;">  -->                                                      
														<?php if($permission['create_p'] == 1) {?>														
														<div class="col-md-3" align="left">
                                                            <input  type="checkbox" checked="checked" id="print" name="print" value="Print" style="display:inline;">
                                                            <!--<label for ='print'> &nbsp;&nbsp; </label>-->
                                                            <label id="submit" class="btn btn-success waves-effect" style="display:inline; position:absolute;">PRINT</label>
                                                        </div>
                                                        <div class="col-md-5"></div>
                                                        <!--div class="col-md-5" align="center" style="padding: 6px 12px">
                                                            <input  type="checkbox" id="s_print" name="s_print" value="Separate" style="display:inline;">
                                                            <label class="s_print" for ='s_print' style="display:inline;"> Separate </label>
                                                        </div-->
                                                        <?php } ?>
														<div class="col-md-4" align="right">
                                                        <a style="float:right;"><button type="submit" class="btn btn-danger waves-effect" id="clear">Clear All</button></a>
                                                        </div>
                                                        <!--</div>-->
                                                    </div>
                                                    </form>
                                                </div>
                                                 
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
<style>
/*.gradient-background {
   background: linear-gradient(62deg, #EE7752, #E73C7E, #23A6D5, #23D5AB);
     animation: gradient 15s ease infinite; 
      background-size: 400% 400%;
  
}*/
.prod:before {
    position: absolute;
    top: 35%;
    left: -20%;
    width: 180%;
    height: 35px;
    content: "";
    background: rgba(0, 0, 0, 0.541);
    -webkit-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transition: all 0.6s linear;
    -o-transition: all 0.6s linear;
    transition: all 0.6s linear;
    opacity: 0;
    visibility: hidden;
}
.prod:after {
    position: absolute;
    top: 30%;
    left: -50%;
    width: 180%;
    height: 35px;
    content: "";
    background: rgba(0, 0, 0, 0.541);
    -webkit-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transition: all 0.6s linear;
    -o-transition: all 0.6s linear;
    transition: all 0.6s linear;
    opacity: 0;
    visibility: hidden;
    left: auto;
    right: -50%;
}
.prod:hover:before {
  left: 100%;
  visibility: visible;
  opacity: 1;
}

.prod:hover:after {
  right: 100%;
  visibility: visible;
  opacity: 1;
}
.gradient-background {
    background: linear-gradient(62deg, #ea4816, #ffffff, #23A6D5, #23D5AB);
    /* animation: gradient 15s ease infinite; */
    background-size: 290% 326%;
}
@-webkit-keyframes gradient{
  0% {
    background-position: 0 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
     background-position: 0% 50%;
  }
}
@keyframes gradient{
  0% {
    background-position: 0 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
     background-position: 0% 50%;
  }
}

.area{
    background: #fa6742;  
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);  
    width: 100%;
	border-radius:15px;
	color:#FFFFFF;
	padding:30px;
}
#print { opacity:0; }
</style>
<script src="http://templeganesh.graspsoftwaresolutions.com/assets/plugins/jquery/jquery.min.js"></script> 
<script>
$(document).ready(function() {

    $('#dt').change(function() {
        $.ajax
            ({
                type:"POST",
                url: "<?php echo base_url();?>/archanaibooking/getbillno",
                data:{dt:$('#dt').val()},
                success:function(data)
                {
                    //alert(data);
                   $('#billno').val(data);
                }
            })
    });

    $('#search').keyup(function() {

    //alert($('#search').val());
    $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url();?>/archanaibooking/show_product",
            data:{prod:$('#search').val()},
            success: function (response) {
                //alert($('#search').val());
        		var obj=jQuery.parseJSON(response);
                console.log(obj.row)
                $('#products').empty();
                $('#products').append(obj.row);
                //alert(data);
            //$('#billno').val(data);
            }
        })
    });
	
	$("#clear").click(function() {
       $(".cart-table .all_close").empty();
       $("#count").val(0);
        sum_total();
    });
	
	$('tr td #remove').click(function() {
    	$(this).css({"display":"block"});
	});
	
	$('#ar_add_btn').on('click', function(){
		var ar_name = $('#ar_name').val();
		var rasi_id = $('#rasi_id').val();
		var rasi_text = $( "#rasi_id option:selected" ).text();
		var natchathra_id = $('#natchathra_id').val();
		var natchathra_text = $( "#natchathra_id option:selected" ).text();
		$('#ar_name').val('');
		$('#rasi_id').prop('selectedIndex',0);
		//$("#rasi_id").selectpicker("refresh");
		//$('#rasi_id').val(0);
		$('#natchathra_id').prop('selectedIndex',0);
		//$("#natchathra_id").selectpicker("refresh");
		//$('#natchathra_id').val(0);
		//alert(ar_name);
		var count1 = $('#count1').val(); 
		var html = '';
		html += '<tr>';
		html += '<td><input type="hidden" name="rasi['+count1+'][arc_name]" value="' + ar_name + '" /><label>' + ar_name + '</label></td>';
		html += '<td><input type="hidden" name="rasi['+count1+'][rasi_ids]" value="' + rasi_id + '" /><label>' + rasi_text + '</label></td>';
		html += '<td><input type="hidden" name="rasi['+count1+'][natchathra_ids]" value="' + natchathra_id + '" /><label>' + natchathra_text + '</label></td>';
		html += '</tr>';
		$('.rasi-table').append(html);
		count1++;
		$("#count1").val(count1);
		console.log(ar_name);
		console.log(rasi_id);
		console.log(rasi_text);
		console.log(natchathra_id);
		console.log(natchathra_text);
	});
	
});
    function sum_total(){
        var total_qty = 0;
        $( ".row_qty" ).each(function() {
            total_qty += parseFloat($( this ).val());
        });
        /* $("#tot_qty").text(total_qty); */

        var total_amt = 0;
        $( ".row_tot" ).each(function() {
            total_amt += parseFloat($( this ).val());
        });
        $("#tot_amt").val(Number(total_amt).toFixed(2));
        $(".tot_amt_txt").text(Number(total_amt).toFixed(2));

        
    }
    function remove(id){
        $(".cart-table #remov"+id).remove();

        $("#count").val(  parseInt($("#count").val())-1);
         sum_total();
    }

    function addtocart(ids){

		//if(!this.form.checkbox.checked){alert('You must agree to the terms first.');return false}
		//alert ($("#print").prop('checked')); 
        
        var text = $("#nm_"+ids).text();
        var amt = Number($("#amt_"+ids).attr("data-id")).toFixed(2);
        
        // let num = amt;
        // let n = num.toFixed(2);
         //alert (amt); exit;
        
        let exist_id=$("#remov"+ids).attr("data-id");
        exist_id = exist_id || 0;

        let exist_qty=$("#qty_"+ids).val();
        exist_qty = exist_qty || 0;
        
        
        if (exist_id==0 || exist_qty==0)
        {
            var count = $('#count').val();        
		
            var text1 = '<tr class="all_close" data-id="'+ids+'" id="remov'+ids +'"><td style="width: 40%;"><input type="hidden" id="id_'+ids+'" name="arch['+count+'][id]" value="'+ids+'" ><p>'+text+'</p></td>';
            text1 += '<td style="width: 20%;"><input type="text" style="text-align: center;" class="row_amt" readonly name="arch['+count+'][amt]" value="'+amt+'"></td>';
            text1 += '<td style="width: 8%;"><input type="text" style="text-align: center;" class="row_qty" name="arch['+count+'][qty]" onkeyup="man_qun('+ids+')" id="qty_'+ids+'" value="1"></td>';
            text1 += '<td style="width: 20%;"><input type="text" style="text-align: center;" class="row_tot"readonly  name="tot" id="tot_'+ids+'" value="'+amt+'"></td>';
            text1 += '<td style="width: 12%;"><button class="btn btn-danger" style="font-size:10px;" onclick="remove('+ids+')" id="remove">X</button></td></tr>';
            $(".cart-table").append(text1);
            count++;
		
        $("#count").val(count);
		
        }
       
        else
        {
                $("#qty_"+ids).val(parseInt($("#qty_"+ids).val())+1);
                $("#tot_"+ids).val(Number(parseInt($("#qty_"+ids).val())*amt).toFixed(2));

        }
        sum_total();
        
    }

    function man_qun(ids){
        //alert(ids)
        sum_total();
        var amt = Number($("#amt_"+ids).attr("data-id")).toFixed(2);
        var cnt = $("#qty_"+ids).val();
        var tot = amt * cnt;
        $("#tot_"+ids).val(tot.toFixed(2));
        sum_total();
    }
</script>
<script>
    $("#submit").click(function(){
        $.ajax
        ({
            type:"POST",
            url: "<?php echo base_url(); ?>/archanai_booking/save",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{					
					if ($("#print").prop('checked')==true && $("#s_print").prop('checked')==false)	
						{
							printData(obj.id);
						}
					else if ($("#print").prop('checked')==true && $("#s_print").prop('checked')==true)
						{
							printData_sep(obj.id);
						}	
					else
							window.location.reload(true);
                }
            }
        });
    });  

    function printData(id) {
		
		// if ($("#print").prop('checked')==true)	
		// {
			$.ajax({
				url: "<?php echo base_url(); ?>/archanai_booking/print_booking/"+id,
				type: 'POST',
				success: function (result) {
					//console.log(result)
					popup(result);
				}
			});
		// }
		// else window.location.reload(true);
    }
	
	function printData_sep(id) {
		
			$.ajax({
				url: "<?php echo base_url(); ?>/archanai_booking/print_booking_sep/"+id,
				type: 'POST',
				success: function (result) {
					//console.log(result)
					popup_sep(result);
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
		window.frameDoc = frameDoc;
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
			
            window.frameDoc.focus();
            window.frameDoc.print();
            frame1.remove();
            window.location.reload(true);
        }, 500);
    }
	
	function popup_sep(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        
		frameDoc.document.open();
		window.frameDoc = frameDoc;
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
			
            window.frameDoc.focus();
            window.frameDoc.print();
            frame1.remove();
            window.location.reload(true);
        }, 500);
    }

</script>
 
