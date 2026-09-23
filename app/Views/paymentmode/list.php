<?php global $lang;?>
<?php $db = db_connect();?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2><?php echo $lang->profile; ?><small><?php echo $lang->pay; ?> <?php echo $lang->mode; ?> <?php echo $lang->setting; ?> / <b><?php echo $lang->list; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/paymentmodesetting/add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div></div>
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
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
								<table class="table table-bordered table-striped table-hover dataTable" id="datatables">
									<thead>
										<tr>
											<th><?php echo $lang->no; ?>.</th>
											<th><?php echo $lang->name; ?></th>
											<th><?php echo $lang->ledger; ?> <?php echo $lang->name; ?></th>
											<th><?php echo $lang->group; ?></th>
											<th><?php echo $lang->display; ?> <?php echo $lang->order; ?></th>
											<th><?php echo $lang->action; ?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i = 1; 
										foreach($payment_modes as $payment_mode) { ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $payment_mode['name']; ?></td>
											<td>
												<?php 
                                                $ledger_name = $db->table('ledgers')->where('id', $payment_mode['ledger_id'])->get()->getRowArray();
                                                echo $ledger_name['name']; 
                                                ?>
											</td>
											<td><?php echo $payment_mode['paid_through']; ?></td>
                                            <td><?php echo $payment_mode['menu_order']; ?></td>
											<td><a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url(); ?>/paymentmodesetting/edit/<?php echo $payment_mode['id']; ?>"><i class="material-icons">&#xE3C9;</i></a> </td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
                            </div>
						</div>
            
            </div>
        </div>
    </div>

</section>
<script>
    $("document").ready(function () {
      $("#datatables").dataTable({
        "searching": true
      });
      var table = $('#datatables').DataTable();
      // Apply the filter
        $("#categoryFilter").on( 'keyup change', function () {
        table
            .column( 1 )
            .search( this.value )
            .draw();
        });
    });
</script>