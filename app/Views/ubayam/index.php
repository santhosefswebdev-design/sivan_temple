<?php global $lang;?>
<?php        
$db = db_connect();
?>
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
                <h2><?php echo $lang->ubayam; ?> <small><?php echo $lang->ubayam; ?> / <b><?php echo $lang->ubayam; ?> <?php echo $lang->entry; ?></b></small></h2>
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
                            <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->ubayam; ?></h4>
                            <table>
        
                            <tr><span id="spndelid"><b></b></span></tr><br>
                          </table>
                            <br>
                            <a href="#" id="del" class="btn btn-danger my-3" data-dismiss="modal"><?php echo $lang->yes; ?></a> &nbsp;
                            <button type="button" class="btn btn-info my-3" data-dismiss="modal"><?php echo $lang->no; ?></button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <!--Delete Form-->
        <div id=delete-form>
            
        </div>
        <!--End Delete Form-->
                        <?php if($permission['create_p'] == 1) { ?>
							<div class="header">
								<div class="row"><div class="col-md-8"><!--<h2>Ubayam</h2>--></div>
								<div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/ubayam/add<?php echo (!empty($date) ? '?date=' . $date : ''); ?>"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?> <?php echo $lang->ubayam; ?></button></a></div></div>
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
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:8%;"><?php echo $lang->date; ?></th>
                                            <th style="width:25%;"><?php echo $lang->pay_for; ?></th>
                                            <th style="width:22%;"><?php echo $lang->name; ?></th>
                                            <th style="width:7%;"><?php echo $lang->amount; ?></th>
                                            <th style="width:7%;"><?php echo $lang->paid; ?></th>
                                            <th style="width:7%;"><?php echo $lang->balance; ?></th>
                                            <th style="width:7%;"><?php echo $lang->status; ?></th>
                                            <?php if($permission['view'] == 1 ||  $permission['print'] == 1) { ?>
											<th style="width:12% !important;"><?php echo $lang->action; ?></th>
											<?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) {
										$balance_amount = (float) $row['amount'] - (float) $row['paidamount'];
										if($balance_amount < 0) $balance_amount = 0; 
										$name = $row['name'];
										$date = date("d-m-Y", strtotime($row['dt']));
										$payfor = $row['pname'];
										$amount = number_format($row['amount'], '2','.',',');
										$paid = number_format($row['paidamount'], '2','.',',');
										$balance = number_format($balance_amount, '2','.',',');
										$address = $row['address']; 
										$ic_number = $row['ic_number']; 
										$mobile = $row['mobile']; 
										$wmsett = $db->table('whatsapp_message_setting')->get()->getRowArray();
										
										if(!empty($wmsett['ubayam']))
										{
											$find = ['{customer_name}','{ubayam_name}','{ubayam_date}','{total}','{paid}','{balance}','{address}','{mobile_no}' ,'{icno}'];
											$replacement = [$name,$payfor,$date,$amount,$paid,$balance,$address,$mobile,$ic_number];
											$ubayam_message = str_replace($find, $replacement, $wmsett['ubayam']);
											if(preg_match_all('/{+(.*?)}/', $ubayam_message, $wmsett['ubayam'])) {
												$array1 = $wmsett['ubayam'][0];
												$find2 = [$array1[0],$array1[1],$array1[2],$array1[3],$array1[4],$array1[5],$array1[6],$array1[7],$array1[8]];
												$replacement2 = ["","","","","","","","",""];
												$ubayam_message2 = str_replace($find2, $replacement2, $ubayam_message);
											}
											else
											{
												$ubayam_message2 = $ubayam_message;
											}
											$whatsapp_msg = <<<PRITHIVI
											$ubayam_message2
											PRITHIVI; 
										}
										else
										{
											$whatsapp_msg = <<<PRITHIVI
											Dear $name,   
												You registered the Ubayam - $payfor in $date
												The Total amount for the ubayam is RM $amount
												You paid RM $paid and
												Your balance is RM $balance
											PRITHIVI; 
										}
										
										$whatsapp_url = 'https://wa.me/+91' . $row['mobile'] . '?text=' . urlencode($whatsapp_msg);
										?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['dt'])); ?></td>
                                            <td id="pay<?= $row['id']; ?>" data-id="<?= $row['pname'];?>"><?php echo $row['pname']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php if($row['amount'] =='') 
											{ echo $row['amount']; } 
											else { echo number_format($row['amount'], '2','.',','); } ?></td>
                                            <td><?php if($row['paidamount'] =='') 
											{ echo $row['paidamount']; } 
											else { echo number_format($row['paidamount'], '2','.',','); } ?></td>
											<td><?php echo number_format($balance_amount, '2','.',','); ?></td>
											<td><?php if(empty($balance_amount)) echo '<span class="paid_text">Paid</span>'; else echo '<span class="unpaid_text">Not Paid</span>'; ?></td>
                                            <?php if($permission['view'] == 1 ||  $permission['print'] == 1) { ?>
                                            <td style="width: 12%;">
												<?php if($permission['view'] == 1) { ?>
                                                    <a class="btn btn-warning btn-rad" href="<?= base_url()?>/ubayam/view/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                <?php } ?>
                                                <?php 
													if($permission['create_p'] == 1) {
													if(empty($balance_amount)) {
												?>
												    <a class="btn btn-success" style="cursor:default;">Paid </a>
                                                <?php } else { ?>
                                                	<a class="btn btn-danger" href="<?= base_url()?>/ubayam/edit/<?php echo $row['id'];?>">Pay </a>
                                                    <a href="<?php echo $whatsapp_url; ?>" target="_blank" class="text-success"><img src="<?php echo base_url(); ?>/assets/images/whatsapp.png" style="width:25px;"></a>
												<?php } } ?>
                                                <?php if($permission['print'] == 1) {?>
												    <a class="btn btn-primary btn-rad" href="<?= base_url()?>/ubayam/print_page/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>
												<?php } ?>
                                                <!--<a class="btn btn-primary btn-rad" href="<?= base_url()?>/ubayam/edit/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                                <a class="btn btn-danger btn-rad" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a>-->
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
    </section>
    <script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'Del('+id+')');
        $("#spndelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " Ubayam?" );    
    }    
    function Del(id)
    {
        var act = "<?php echo base_url(); ?>/ubayam/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"'>submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>