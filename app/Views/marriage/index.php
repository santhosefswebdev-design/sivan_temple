<?php global $lang;?>
<?php $db = db_connect();?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2><?php echo $lang->member; ?><small><?php echo $lang->marriage; ?> <?php echo $lang->reg; ?>  / <b><?php echo $lang->list; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/marriage/add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div></div>
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
											<th><?php echo $lang->sno; ?></th>
											<th><?php echo $lang->name; ?> <?php echo $lang->of; ?> <?php echo $lang->bride; ?></th>
											<th><?php echo $lang->name; ?> <?php echo $lang->of; ?> <?php echo $lang->groom; ?></th>
											<th><?php echo $lang->date; ?> <?php echo $lang->of; ?> <?php echo $lang->intended; ?> <?php echo $lang->marriage; ?></th>
											<th><?php echo $lang->place; ?> <?php echo $lang->of; ?> <?php echo $lang->marriage; ?></th>
											<th><?php echo $lang->action; ?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
                                        $i = 1; 
										foreach($list as $row) { ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['bri_name']; ?></td>
											<td><?php echo $row['gro_name']; ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['date_of_mrg'])); ?></td>
											<td><?php echo $row['place_of_mrg']; ?></td>
											<td>
                                                <a class="btn btn-warning btn-rad" title="View" href="<?php echo base_url(); ?>/marriage/view/<?php echo $row['id']; ?>"><i class="material-icons">&#xE417;</i></a>&nbsp;
                                                <a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url(); ?>/marriage/edit/<?php echo $row['id']; ?>"><i class="material-icons">&#xE3C9;</i></a>&nbsp;
                                                <a class="btn btn-info btn-rad" title="Print" target="_blank" href="<?php echo base_url(); ?>/marriage/print/<?php echo $row['id']; ?>"><i class="material-icons">print</i></a>
                                            </td>
										</tr>
										<?php 
                                        }
                                        ?>
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