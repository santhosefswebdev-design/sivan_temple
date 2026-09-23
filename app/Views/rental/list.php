<?php global $lang;?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2><?php echo $lang->rental; ?><small><?php echo $lang->rental; ?> / <b><?php echo $lang->list; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
							<div class="col-md-12">
									<form action="<?php echo base_url();?>/rental/print_rental" method="get" target="_blank" >
										<div class="row">
											<div class="col-md-12" align="right">
												<button type="submit" name="excel_data" class="btn btn-success waves-effect btn-sm" value="EXCEL">Excel</button>
												<button type="submit" name="pdf_data" class="btn btn-danger waves-effect btn-sm" value="PDF">Pdf</button>
												<button type="submit" class="btn btn-info waves-effect btn-sm" value="PRINT">Print</button> 
												<a href="<?php echo base_url(); ?>/rental/add"><button type="button" class="btn bg-deep-purple waves-effect">Pay</button></a>
											</div>
										</div>
									</form>
								</div>
						</div>
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
							
							<div class="row">
								
							</div>
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
								<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
									<thead>
										<tr>
											<th><?php echo $lang->sno; ?>.</th>
											<th><?php echo $lang->property; ?> <?php echo $lang->name; ?></th>
											<th><?php echo $lang->month; ?> / <?php echo $lang->year; ?></th>
											<th><?php echo $lang->pay; ?> <?php echo $lang->amount; ?></th>
											<th><?php echo $lang->payee; ?> <?php echo $lang->name; ?></th>
											<th><?php echo $lang->action; ?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i = 1; 
										foreach($rentals as $rental) { ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $rental['propertyname']; ?></td>
											<td><?php echo $rental['month_year']; ?></td>
											<td><?php echo $rental['amount']; ?></td>
											<td><?php echo $rental['payee_name']; ?></td>
											<td><a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url(); ?>/rental/edit/<?php echo $rental['id']; ?>"><i class="material-icons">&#xE3C9;</i></a>
											<a class="btn btn-warning btn-rad" target="_blank" title="Print" href="<?php echo base_url(); ?>/rental/print/<?php echo $rental['id']; ?>"><i class="material-icons">print</i></a></td>
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
