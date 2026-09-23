<?php        
$db = db_connect();
?>
<style>
    .table-responsive{
        overflow-x: hidden;
    }
    .cancelled-row {
        /* background-color: red; */
        color: red;
    }
</style>
<section class="content">
        <div class="container-fluid">
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
					<?php if($permission['create_p'] == 1) { ?>
                        <div class="header">
                            <div class="row">
                                <div class="col-md-3 col-xs-6"><h2>Temple Hall Booking List</h2></div>
                                <div class="col-md-3 col-xs-6"><h2>Date: <?= date("d-m-Y",strtotime($date)); ?></h2></div>
                                <div class="col-md-3 col-xs-6"><h2>Venue: <?php echo $venue; ?></h2></div>
                                <div class="col-md-3" align="right"><a href="<?php echo base_url(); ?>/templehallbooking/add_booking/<?= $date; ?>?venue=<?= urlencode($venue_id); ?>"><button type="button" class="btn bg-deep-purple waves-effect">New Booking</button></a></div>
                            </div>
                        </div>
					<?php } ?>
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
                                            <th>S.No</th>
                                            <th>Ref No</th>
                                            <th>Name</th>
                                            <th>Mobile Number</th>
                                            <th>Amount</th>
                                            <th>Paid Amount</th>
                                            <?php if($permission['view'] == 1 || $permission['edit'] == 1 ||  $permission['print'] == 1) { ?>
											<th>Actions</th>
											<?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $j=1; 
                                            foreach($list as $row) { 
                                                $amt=$row['amount'];
                                                $paid_amt=$row['paid_amount'];
                                                $bal_amt = $amt - $paid_amt;
                                                $rowClass = $row['booking_status'] == 3 ? 'cancelled-row' : '';
                                                ?>
                                        <tr class="<?php echo $rowClass; ?>">
                                            <td><?php echo $j++; ?></td>
                                            <td><?php echo $row['ref_no']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['mobile_no']; ?></td>
                                            <td><?php echo $row['amount']; ?></td>
                                            <td><?php echo $row['paid_amount']; ?></td> 
                                            <?php if($permission['view'] == 1 || $permission['edit'] == 1 ||  $permission['print'] == 1) { ?>                                            
												<td> 
													<?php if($permission['view'] == 1) { ?>
													    <!-- <a class="btn btn-success btn-rad" href="<?= base_url()?>/hallbooking/view/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a> -->
													<?php }
                                                     if ($row['booking_status']!=3) { 
                                                        if($permission['print'] == 1) {?>
                                                            <a class="btn btn-warning btn-rad" title="Print" href="<?= base_url()?>/templehallbooking/print_page/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>													
                                                        <?php } ?>
                                                        <!-- <a href="<?php // echo $whatsapp_url; ?>" target="_blank" class="text-success"><img src="<?php // echo base_url(); ?>/assets/images/whatsapp.png" style="width:25px;"></a> -->
                                                        <!-- <a class="btn btn-danger btn-rad" href="<?= base_url()?>/hallbooking/assignchecklist/<?php // echo $row['id'];?>"><i class="material-icons dp48">playlist_add_check</i></a> -->
                                                        <?php if($bal_amt && ($row['payment_type'] == "partial" || $row['payment_type'] == "only_booking") ) { ?>
                                                            <a class="btn btn-warning btn-payment btn-rad" title="Pay" href="<?= base_url()?>/templehallbooking/payment/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">payment</i> </a>	
                                                        <?php } ?>
                                                         <a class="btn btn-danger btn-cancel btn-rad" title="Cancel" href="<?= base_url()?>/templehallbooking/cancel/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">cancel</i> </a>	
                                                   <?php } else {
                                                        echo "Cancelled";
                                                   } ?>
												</td>
											<?php } ?>
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
                        <h5 class="modal-title" style="text-align: center;" id="repaymentModalLabel">Hall Booking Repayment</h5>
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

        <!--Delete Form-->
        <div id=delete-form>
            
        </div>
        <!--End Delete Form-->
    </section>
<script>
    $(document).ready(function(){
    $(".btn-payment").click(function(e){
        e.preventDefault();
        var bookingId = $(this).attr('href').split('/').pop();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/templehallbooking/gtpaymentdata",
            data: {
                id: bookingId
            },
            success: function(response){
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
            $('#alert-modal').modal('show', { backdrop: 'static' });
            $("#spndeddelid").css("color", "red").text('Pay amount cannot be greater than balance amount.');
            return;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/templehallbooking/save_repayment", 
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
                    $('#alert-modal').modal('show', { backdrop: 'static' });
					$("#spndeddelid").css("color", "green");
                    
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
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "  Donation?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/donation/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
    $('.btn-cancel').click(function(e) {
        e.preventDefault(); // Prevent default action

        var bookingId = $(this).attr('href').split('/').pop();

        if (confirm('Are you sure you want to cancel this booking?')) {
            // If "Yes" is clicked, send an AJAX request to update the booking status
            $.ajax({
                url: "<?php echo base_url(); ?>/templehallbooking/update_booking_status", 
                type: 'POST',
                data: {
                    id: bookingId,
                    status: 3
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res.success) {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                       $("#spndeddelid").css("color", "green").text('Successfully cancelled. Thank you.');
                    } else {
                        $('#alert-modal').modal('show', { backdrop: 'static' });
                       $("#spndeddelid").css("color", "red").text('Error while updating booking status.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });
</script>