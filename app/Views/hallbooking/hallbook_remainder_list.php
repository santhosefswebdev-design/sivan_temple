<?php global $lang;?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .table-responsive{
        overflow-x: hidden;
    }
</style>
<section class="content">
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
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8 col-xs-6"><h2><?php echo $lang->hall; ?> <?php echo $lang->booking; ?> <?php echo $lang->reminder; ?> <?php echo $lang->list; ?></h2></div>
                            <div class="col-md-4" align="right"></div></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th><?php echo $lang->sno; ?></th>
                                            <th><?php echo $lang->hall; ?></th>
                                            <th><?php echo $lang->booking; ?> <?php echo $lang->date; ?></th>
                                            <th><?php echo $lang->reg_by; ?></th>
                                            <th><?php echo $lang->event; ?> <?php echo $lang->details; ?></th>
                                            <th><?php echo $lang->status; ?></th>
                                            <th><?php echo $lang->total; ?> <?php echo $lang->amount; ?></th>
                                            <th><?php echo $lang->paid; ?> <?php echo $lang->amount; ?></th>
                                            <th><?php echo $lang->balance; ?> <?php echo $lang->amount; ?></th>
											<th style="text-align:center"><?php echo $lang->action; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($list as $row) { 
                                            if($row['status'] == 1) $status = "Booked";
                                            else if($row['status'] == 2) $status = "Completed";
                                            else $status = "Cancelled";
											$interval_date = $row['interval_date'];
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['booking_date']; ?></td>
                                            <td><?php echo $row['register_by']; ?></td>
                                            <td><?php echo $row['event_name']; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><?php echo $row['total_amount']; ?></td>
                                            <td><?php echo $row['paid_amount']; ?></td> 
                                            <td><?php echo $row['balance_amount']; ?></td>                                        
											<td style="text-align:center"> 
												<div class="row">
													<div class="col-md-3" style="margin-bottom: 0px;">&nbsp;</div>
													<div class="col-md-3" style="margin-bottom: 0px;">
														<?php
														$whatsapp_msg = <<<RAJKUMAR
Hi,
	Your booking has remaining $interval_date days to schedule, You need to pay the remaining amount.
RAJKUMAR;
														$whatsapp_url = 'https://wa.me/+60' . $row['mobile_number'] . '?text='.urlencode($whatsapp_msg);
														?>
														<a href="<?php echo $whatsapp_url; ?>" target="_blank" class="text-success" style="color: #0fc713;"><i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 19px;"></i></a>
														<a href="<?php echo base_url(); ?>/hallbooking/send_whatsapp_msg/<?php echo $row['id']; ?>" target="_blank" class="text-success" style="color: #0fc713;"><i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 19px;"></i></a>
													</div>
													<div class="col-md-3" style="margin-bottom: 0px;">
														<form action="<?php echo base_url(); ?>/hallbooking/hallbook_reminder_sendmail" method="post">
															<input type="hidden" name="hallbook_id" id="hallbook_id" value="<?php echo $row['id']; ?>">
															<button type="submit" class="text-primary" style="border: none;"><i class="fa fa-envelope" aria-hidden="true" style="font-size: 18px;"></i></button>
														</form>
													</div>
													<div class="col-md-3" style="margin-bottom: 0px;">&nbsp;</div>
												</div>
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
    </section>
