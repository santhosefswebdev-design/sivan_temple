<?php global $lang;?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2><?php echo $lang->bom; ?><small><?php echo $lang->bom; ?> / <b><?php echo $lang->prasadam; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"></div></div>
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
                                        <th><?php echo $lang->sno; ?></th>
                                        <th><?php echo $lang->name_eng; ?></th>
                                        <th><?php echo $lang->name_tam; ?></th>
                                        <th><?php echo $lang->amount; ?></th>
										<th><?php echo $lang->action; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach($prasadam_boms as $row) { ?>
                                    <tr>
                                        <td align="center"><?php echo $i++; ?></td>
                                        <td ><?php echo $row['name_eng']; ?></td>
                                        <td><?php echo $row['name_tamil']; ?></td>
                                        <td><?php echo $row['amount']; ?></td>
											<td align="center">
													<a class="btn btn-success btn-rad" title="View" href="<?php echo base_url()?>/bom/view_prasadam/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                    <a class="btn btn-primary btn-rad" title="Edit" href="<?php echo base_url()?>/bom/edit_prasadam/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
										    </td>
										<?php } ?>   
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

