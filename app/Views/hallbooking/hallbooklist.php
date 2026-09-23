<?php        
$db = db_connect();
?>
<style>
    .table-responsive{
        overflow-x: hidden;
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
                            <div class="row"><div class="col-md-4 col-xs-6"><h2>Hall Booking List</h2></div>
                            <div class="col-md-4 col-xs-6"><h2><?= date("d-m-Y",strtotime($date)); ?></h2></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/hallbooking/add_booking/<?= $date; ?>"><button type="button" class="btn bg-deep-purple waves-effect">New Booking</button></a></div></div>
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
                                            <th>Name</th>
                                            <th>Register By</th>
                                            <th>Event Details</th>
                                            <th>Status</th>
                                            <th>Total Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Balance Amount</th>
                                            <?php if($permission['view'] == 1 || $permission['edit'] == 1 ||  $permission['print'] == 1) { ?>
											<th>Actions</th>
											<?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $j=1; 
                                            foreach($list as $row) { 
                                            if($row['status'] == 1) $status = "Booked";
                                            else if($row['status'] == 2) $status = "Completed";
                                            else $status = "Cancelled";
											$event_name = $row['event_name'];
											$register_by = $row['register_by'];
											$total_amount = $row['total_amount'];
											$paid_amount = $row['paid_amount'];
											$slot_details = $row['slot_details'];
											$balance_amount = $row['total_amount']-$row['paid_amount'];
											$bal_amount = number_format($balance_amount, 2,'.',',');
											$book_date = date("d-m-Y",strtotime($date));
                                            $name = $row['name'];
											$address = $row['address'];
											$mobile_number = $row['mobile_number'];
											$email = $row['email'];
											$ic_no = $row['ic_no'];
											$slot_txt = '';
											$i = 0;
											foreach($slot_details as $slot_detail){
												if($i > 0) $slot_txt .= ', ';
												$slot_txt .= $slot_detail['name'] . ' - ' . $slot_detail['description'];
												$i++;
											}
											$wmsett = $db->table('whatsapp_message_setting')->get()->getRowArray();
											if(!empty($wmsett['hall']))
											{
												$find = ['{registered_by}','{event_detail}','{event_date}','{slot_details}','{total}','{paid}','{balance}','{customer_name}','{address}','mobile_no','email_id','icno'];
												$replacement = [$register_by,$event_name,$book_date,$slot_txt,$total_amount,$paid_amount,$bal_amount,$name,$address,$mobile_number,$email,$ic_no];
												$hall_message = str_replace($find, $replacement, $wmsett['hall']);
												if(preg_match_all('/{+(.*?)}/', $hall_message, $wmsett['hall'])) {
													$array1 = $wmsett['hall'][0];
													$find2 = [$array1[0],$array1[1],$array1[2],$array1[3],$array1[4],$array1[5],$array1[6],$array1[7],$array1[8],$array1[9],$array1[10],$array1[11]];
													$replacement2 = ["","","","","","","","","","","",""];
													$hall_message2 = str_replace($find2, $replacement2, $hall_message);
												}
												else
												{
													$hall_message2 = $hall_message;
												}
												$whatsapp_msg = <<<PRITHIVI
												$hall_message2
PRITHIVI;
											}
											else
											{
												$whatsapp_msg = <<<PRITHIVI
Dear $register_by,   
	You registered the $event_name in $book_date at the slot time($slot_txt)
	The Total amount for the event is RM $total_amount
	You paid RM $paid_amount
	Your balance RM $bal_amount
PRITHIVI;
											}
                                            $whatsapp_url = 'https://wa.me/+60' . $row['mobile_number'] . '?text=' . urlencode($whatsapp_msg);
                                        ?>
                                        <tr>
                                            <td><?php echo $j++; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['register_by']; ?></td>
                                            <td><?php echo $row['event_name']; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><?php echo $row['total_amount']; ?></td>
                                            <td><?php echo $row['paid_amount']; ?></td> 
                                            <td><?php echo $row['balance_amount']; ?></td>
                                            <?php if($permission['view'] == 1 || $permission['edit'] == 1 ||  $permission['print'] == 1) { ?>                                            
												<td> 
													<?php if($permission['view'] == 1) { ?>
													    <a class="btn btn-success btn-rad" href="<?= base_url()?>/hallbooking/view/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
													<?php } if ($row['status']!=3) { 
                                                                if($permission['edit'] == 1 ){ ?>
													                <?php if($row['status'] == 1) { ?> <a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url();?>/hallbooking/edit_booking/<?= $row['id']; ?>"><i class="material-icons">&#xE3C9;</i></a> <?php } ?>
													            <?php } if($permission['print'] == 1) {?>
													                <a class="btn btn-warning btn-rad" title="Print" href="<?= base_url()?>/hallbooking/print_page/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>													
                                                                <?php } ?>
															<a href="<?php echo $whatsapp_url; ?>" target="_blank" class="text-success"><img src="<?php echo base_url(); ?>/assets/images/whatsapp.png" style="width:25px;"></a>
                                                            <a class="btn btn-danger btn-rad" href="<?= base_url()?>/hallbooking/assignchecklist/<?php echo $row['id'];?>"><i class="material-icons dp48">playlist_add_check</i></a>
                                                   <?php } ?>
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
         <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2">Delete Donation</h4>
                            <table>
        
                            <tr><span id="spndeddelid"><b></b></span></tr>
                          </table>
                            
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
    </section>
<script>
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
</script>