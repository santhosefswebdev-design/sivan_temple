<section class="content">
    <div class="container-fluid">
			<?php if($_SESSION['succ'] != '') { ?>
                <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                    <div class="suc-alert">
                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p><?php echo $_SESSION['succ']; ?></p> 
                    </div>
                </div>
            <?php } ?>
            <?php if($_SESSION['fail'] != '') { ?>
                <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p><?php echo $_SESSION['fail']; ?></p>
                    </div>
                </div>
            <?php } ?>
            <div class="block-header">
            <h2>PROFILE<small>Whatsapp Message / <a href="#" target="_blank">Whatsapp Message Setting</a></small></h2>
        </div>
		
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Whatsapp Message Setting</h2></div>
                        <div class="col-md-4" align="right"></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/whatsappmessage/save" method="POST" enctype="multipart/form-data">
                    <div class="body">
                        <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-sm-8" style="margin: 0px;">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Hall</h3>
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="hall_editor" id="hall_editor" class="form-control" cols="3" rows="5" required><?php echo $whatsappmessage['hall'];?></textarea>
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-4" style="margin: 0px;background: #eee;overflow-y: scroll;height: 150px;padding: 10px 10px;">
								<p>Event Date : {event_date}</p>
								<p>Event Detail : {event_detail}</p>
								<p>Registered By : {registered_by}</p>
								<p>Customer Name : {customer_name}</p>
								<p>Address : {address}</p>
								<p>Mobile No : {mobile_no}</p>
								<p>Email ID : {email_id}</p>
								<p>IC No : {icno}</p>
								<p>Slot Details : {slot_details}</p>
								<p>Total : {total}</p>
								<p>Paid : {paid}</p>
								<p>Balance : {balance}</p>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-sm-12" style="margin: 0px;display:none">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Cash Donation</h3>
							</div>
                            <div class="col-sm-12" style="margin: 0px;display:none">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="cash_donation_editor" id="cash_donation_editor" class="form-control" cols="3" rows="3" required><?php echo $whatsappmessage['cash_donation'];?></textarea>
                                    </div>
                                </div>
                            </div>
						</div>
						<div class="row clearfix">	
							<div class="col-sm-12" style="margin: 0px;display:none">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Product Donation</h3>
							</div>
                            <div class="col-sm-12" style="margin: 0px;display:none">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="product_donation_editor" id="product_donation_editor" class="form-control" cols="3" rows="3" required><?php echo $whatsappmessage['product_donation'];?></textarea>
                                    </div>
                                </div>
                            </div>
						</div>
						<div class="row clearfix">	
                            <div class="col-sm-8" style="margin: 0px;">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Ubayam</h3>
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="ubayam_editor" id="ubayam_editor" class="form-control" cols="3" rows="5" required><?php echo $whatsappmessage['ubayam'];?></textarea>
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-4" style="margin: 0px;background: #eee;overflow-y: scroll;height: 150px;padding: 10px 10px;">
								<p>Customer Name : {customer_name}</p>
								<p>Ubayam Name : {ubayam_name}</p>
								<p>Ubayam Date : {ubayam_date}</p>
								<p>Address : {address}</p>
								<p>Mobile No : {mobile_no}</p>
								<p>IC No : {icno}</p>
								<p>Total : {total}</p>
								<p>Paid : {paid}</p>
								<p>Balance : {balance}</p>
							</div>
						</div>
						<div class="row clearfix">	
							<div class="col-sm-12" style="margin: 0px;display:none">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Common</h3>
							</div>
                            <div class="col-sm-12" style="margin: 0px;display:none">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="common_editor" id="common_editor" class="form-control" cols="3" rows="3" required><?php echo $whatsappmessage['common'];?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12" align="center">
                                <button type="submit" class="btn btn-success btn-lg waves-effect">UPDATE</button>
                            </div>
                        </div>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>