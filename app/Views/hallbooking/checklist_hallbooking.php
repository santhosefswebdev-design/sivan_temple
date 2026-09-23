<?php $db = db_connect();?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/demo.css">
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

table tr td .btn {
    padding: 9px 5px !important;
}
</style>
<section class="content">
    <div class="container-fluid">
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
                                <div class="col-md-12 det">
                                        <h3 style="margin-top:0px;">Register Details</h3>
                                            <div class="row" style="margin-top:10px;">
                                                <div class="col-sm-12">
                                                    <table class="table table-bordered" style="width:100%">
                                                        <tr>
                                                            <td style="width: 25%;"><b>Event Date</b></td>
                                                            <td style="width: 25%;"><?= $data['booking_date']; ?></td>
                                                            <td style="width: 25%;"><b>Event Details</b></td>
                                                            <td style="width: 25%;"><?= $data['event_name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 25%;"><b>Register By</b></td>
                                                            <td style="width: 25%;"><?= $data['register_by']; ?></td>
                                                            <td style="width: 25%;"><b>Name</b></td>
                                                            <td style="width: 25%;"><?= $data['name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 25%;"><b>Address</b></td>
                                                            <td style="width: 25%;"><?= $data['address']; ?></td>
                                                            <td style="width: 25%;"><b>Mobile Number</b></td>
                                                            <td style="width: 25%;"><?= $data['mobile_number']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 25%;"><b>Email ID</b></td>
                                                            <td style="width: 25%;"><?= $data['email']; ?></td>
                                                            <td style="width: 25%;"><b>IC Number</b></td>
                                                            <td style="width: 25%;"><?= $data['ic_no']; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                            <form method="post" action="<?php echo base_url();?>/hallbooking/assignchecklist_update">
                                <input type="hidden" name="hall_id" value="<?php echo $data['id'];?>">
                                  <div class="col-md-12">
                                    <div class="col-md-12">
                                    <div class="products row">
                                        <div class="col-sm-12" style="padding:0; width:100%;">
                                            <h3 style="margin-bottom:5px; margin-top:5px;">Package Details</h3>
                                        </div>
                                    </div>
                                    <div class="row scroll">
                                        <table class="table table-bordered sub" id="package_table">
                                            <thead>
                                                <tr>
                                                    <th>Service Name</th>
                                                    <th>Service Description</th>
                                                    <th>Service Amount</th>
                                                    <th>Checklist</th>
                                                    <th>Checklist Amount</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; foreach($package_list as $row) { 
                                                    
                                                    ?>
                                                    <tr >
                                                        <td><?=  $row['service_name'];?> </td>
                                                        <td><?=  $row['service_description'];?></td>
                                                        <td><?=  $row['service_amount'];?></td>
                                                        <td>
                                                            <select class="form-control" name="checklist[<?php echo $row['id']; ?>][checklist_id]" id="checklist_service" style="border:none;" onchange="getchecklistamt(this.value,<?php echo $row['id']; ?>);">
                                                                <option value="">choose checklist</option>
                                                                <?php
                                                                $checlists = get_checklist_availablity($data['booking_date'],$row['service_id']);
                                                                foreach($checlists['checklists'] as $checlist)
                                                                {
                                                                    if (in_array($checlist['id'], $checlists['availabilty'])) {
                                                                        $disabled = "readonly";
                                                                        $label_style = 'cursor: no-drop;';
                                                                    }
                                                                    else {
                                                                        $disabled = "";
                                                                        $label_style ="";
                                                                    }
                                                                ?>
                                                                <option value="<?php echo $checlist['id']; ?>" <?php echo $disabled; ?> <?php if($checlist['id'] == $row['checklist_id']){ echo "selected"; }?> style="<?php echo $label_style; ?>"><?php echo $checlist['name']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="form-control"name="checklist[<?php echo $row['id']; ?>][hallbook_service_id]" value="<?php echo $row['id']; ?>">
                                                            <input type="number" class="form-control" min="0" step="any" name="checklist[<?php echo $row['id']; ?>][checklist_amount]" id="checklist_amount_<?php echo $row['id'];?>" placeholder="0.00" style="border:none;" value="<?=  $row['checklist_amount'];?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="checklist[<?php echo $row['id']; ?>][checklist_remarks]" id="checklist_remarks" style="border:none;" placeholder="Remarks" value="<?=  $row['remarks'];?>">
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line" style="border: none; text-align: right;">
                                            <button class="btn btn-success btn-lg" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
function getchecklistamt(id,checklistid)
{
    if(id != "")
    {
        $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>/hallbooking/getchecklistamt",
            data: {check_id : id},
            success:function(response)
            {
                $("#checklist_amount_"+checklistid).val(response);
            }
        });
    }
    else
    {
        $("#checklist_amount_"+checklistid).val("");
    }
}
</script>

<script>
    $("#save").click(function(){
        $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>/hallbooking/assignchecklist_update",
            data: $("form").serialize(),
            success:function(data)
            {
                
            }
        });
    });  
</script>