<style>
    .table-responsive{
        overflow-x: hidden;
    }
	.paid_text { color:green; font-weight:600; }
	.unpaid_text { color:red; font-weight:600; }
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2> Prasadam <small><b>Entry</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2">Delete Prasadam</h4>
                            <table>
        
                            <tr><span id="spndelid"><b></b></span></tr><br>
                          </table>
                            <br>
                            <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">Yes</a> &nbsp;
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <!--Delete Form-->
        <div id=delete-form>
            
        </div>
        <!--End Delete Form-->
							<div class="header">
								<div class="row"><div class="col-md-8"><!--<h2>prasadam</h2>--></div>
								<div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/prasadam/add"><button type="button" class="btn bg-deep-purple waves-effect">Add Prasadam</button></a></div></div>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">S.No</th>
                                            <th style="width:7%;">Date</th>
                                            <th style="width:22%;">Devotee Name</th>
                                            <th style="width:7%;">Collection Date</th>
                                            <th style="width:7%;">Amount</th>
                                            <th style="width:7%;">PAid Amount</th>
											<th style="width:12% !important;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) {
                                            $amt=$row['amount'];
                                            $paid_amt=$row['paid_amount'];
                                            $bal_amt = $amt - $paid_amt;
                                            $rowClass = $row['booking_status'] == 3 ? 'cancelled-row' : '';
										?>
                                        <tr>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['customer_name']; ?></td>
                                            <td><?php echo $row['collection_date']; ?></td>
                                            <td><?php echo $row['amount']; ?></td>
                                            <td><?php echo $row['paid_amount']; ?></td>
                                            <!-- <td><?php if($row['amount'] =='') 
											{ echo $row['amount']; } 
											else { echo number_format($row['amount'], '2','.',','); } ?></td> -->
											
                                            <td style="width: 12%;">
                                                <!-- <a class="btn btn-warning btn-rad" href="<?= base_url()?>/prasadam/view/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a> -->
												<a class="btn btn-primary btn-rad" href="<?= base_url()?>/prasadam/print_booking/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>
                                                <!-- <a class="btn btn-primary btn-rad" href="<?= base_url()?>/prasadam/edit/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a> -->
                                                <!--<a class="btn btn-danger btn-rad" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a>-->
                                                <?php if($bal_amt && $row['payment_type'] == "partial") { ?>
                                                            <a class="btn btn-warning btn-payment btn-rad" title="Pay" href="<?= base_url()?>/annathanam_new/payment/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">payment</i> </a>	
                                                        <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="alert-modal_payment" tabindex="-1" role="dialog" aria-labelledby="repaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align: center;" id="repaymentModalLabel">Prasadam Repayment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <table>
                        <tr>
                            <td><b>Total Amount (RM): <span id="totalAmount"></span></b></td>
                            <td><b>Paid Amount (RM): <span id="paidAmount"></span></b></td>
                            <td><b>Balance Amount (RM): <span id="balAmount"></span></b></td>
                        </tr>
                    </table>
                    <div class="modal-body">
                        <form id="repaymentForm">
                            <div class="form-group">
                                <label for="repaymentDate">Date</label>
                                <input type="date" class="form-control" id="repaymentDate" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group form-float">
                                <label for="payAmount">Amount</label>
                                <input type="number" id="payAmount" min="0" class="form-control" step=".01" placeholder="0.00" required>
                            </div>
                            <div class="form-group">
                                <label for="paymentMode">Payment Mode</label>
                                <select class="form-control" id="paymentMode" name="payment_mode" required>
                                    <?php foreach($payment_modes as $payment_mode) { ?>
                                        <option value="<?php echo $payment_mode['id']; ?>"><?php echo $payment_mode['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="hidden" id="bookingId" name="booking_id">
                            <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal">Cancel</a>
                            <button type="button" class="btn btn-primary" id="saveRepayment">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="alert-modal1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
    <script>
        $(document).ready(function(){
    $(".btn-payment").click(function(e){
        e.preventDefault();
        var bookingId = $(this).attr('href').split('/').pop();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/prasadam/gtpaymentdata",
            data: {
                id: bookingId
            },
            success: function(response){
                console.log(response);
                var obj = JSON.parse(response);
                var totalAmount = formatAmount(obj.amt);
                var paidAmount = formatAmount(obj.paid_amount);
                var balAmount = formatAmount(obj.amt - obj.paid_amount);

                $("#bookingId").val(bookingId);
                $("#totalAmount").text(totalAmount);
                $("#paidAmount").text(paidAmount);
                $("#balAmount").text(balAmount);
                $("#alert-modal_payment").modal('show');
            },
            error: function(){
                $("#spndeddelid").css("color", "red").text('Error while fetching repayment data.');
            }
        });
        
    });

    function formatAmount(amount){
        amount = parseFloat(amount);
        return isNaN(amount) ? '0.00' : amount.toFixed(2);
    }

    $("#saveRepayment").click(function(){
        var date = $("#repaymentDate").val();
        var payAmount = parseFloat($("#payAmount").val());
        var paymentMode = $("#paymentMode").val();
        var bookingId = $("#bookingId").val();
        var balAmount = parseFloat($("#balAmount").text());

        if (payAmount > balAmount) {
            $("#alert-modal_payment").modal('hide');
            $('#alert-modal1').modal('show', { backdrop: 'static' });
            $("#spndeddelid").css("color", "red").text('Pay amount cannot be greater than balance amount.');
            return;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/prasadam/save_repayment", 
            data: {
                date: date,
                pay_amount: payAmount,
                payment_mode: paymentMode,
                booking_id: bookingId
            },
            success: function(response){
                var obj = JSON.parse(response);
                if(obj.status){
                    $("#payAmount").val("");
                    $("#alert-modal_payment").modal('hide');
                    $("#spndeddelid").css("color", "green").text(obj.message);
                    $('#alert-modal1').modal('show', { backdrop: 'static' });
					$("#spndeddelid").css("color", "green");

                    setTimeout(function(){
                        location.reload(); // Reloads the page
                    }, 2000);
                    
                } else {
                    $("#spndeddelid").css("color", "red").text(obj.message);
                }
            },
            error: function(){
                $("#spndeddelid").css("color", "red").text('Error while saving repayment.');
            }
        });
    });
});

    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'Del('+id+')');
        $("#spndelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " prasadam?" );    
    }    
    function Del(id)
    {
        var act = "<?php echo base_url(); ?>/prasadam/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"'>submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>
    <script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'Del('+id+')');
        $("#spndelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " prasadam?" );    
    }    
    function Del(id)
    {
        var act = "<?php echo base_url(); ?>/prasadam/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"'>submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>