<?php global $lang;?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2><?php echo $lang->rental; ?><small><?php echo $lang->tennant; ?> / <b><?php echo $lang->list; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/tennant/add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div></div>
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
								<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
									<thead>
										<tr>
											<th><?php echo $lang->no; ?>.</th>
											<th><?php echo $lang->tennant; ?> <?php echo $lang->name; ?></th>
											<th><?php echo $lang->phone; ?> <?php echo $lang->no; ?></th>
											<th><?php echo $lang->email_id; ?></th>
											<th><?php echo $lang->address; ?></th>
											<th><?php echo $lang->action; ?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i = 1; 
										foreach($tennants as $tennant) {
                                            $phonecode = !empty($tennant['phonecode'])?$tennant['phonecode']:"";
                                            $phoneno = !empty($tennant['phone'])?$tennant['phone']:"";    
                                        ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $tennant['name']; ?></td>
											<td><?php echo $phonecode.$phoneno; ?></td>
											<td><?php echo $tennant['email']; ?></td>
											<td><?php echo $tennant['address']; ?></td>
											<td><a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url(); ?>/tennant/edit/<?php echo $tennant['id']; ?>"><i class="material-icons">&#xE3C9;</i></a> </td>
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
