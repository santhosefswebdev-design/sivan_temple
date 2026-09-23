<?php global $lang;?>
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
            <div class="block-header">
                <h2><?php echo $lang->cemetery; ?><small><?php echo $lang->cemetery; ?> / <b><?php echo $lang->cemetery; ?> <?php echo $lang->booking; ?> <?php echo $lang->slot; ?></b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
					<?php //if($permission['create_p'] == 1) { ?>
                        <div class="header">
                            
                        </div>
					<?php //} ?>
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
                            
                            <form action="<?php echo base_url(); ?>/cemetery/save_slot" method="POST">
								<input type="hidden" name="id" value="<?php echo $data['id'];?>">
								<div class="container-fluid">
									<div class="row clearfix">
										<div class="col-sm-4">
											<div class="form-group form-float">
												<div class="form-line">
													<input type="text" required class="form-control" name="name" value="">
													<label class="form-label"><?php echo $lang->name; ?> <span style="color: red;"> *</span></label>
												</div>
											</div>
										</div>
										<div class="col-sm-2" align="center" style="background-color: white;padding-bottom: 1%;">
											<button type="submit" class="btn btn-success btn-lg waves-effect"><?php echo $lang->save; ?></button>
											<button type="button" id="clear" class="btn btn-primary btn-lg waves-effect"><?php echo $lang->clear; ?></button>
										</div>
										
									</div>
								</div>
							</form>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable" id="datatables">
                                    <thead>
                                        <tr>
                                            <th><?php echo $lang->sno; ?></th>
                                            <th><?php echo $lang->name; ?></th>
                                            <th><?php echo $lang->time; ?> <?php echo $lang->from; ?></th>
                                            <th><?php echo $lang->time; ?> <?php echo $lang->to; ?></th>
                                            <th><?php echo $lang->action; ?></th>
										</tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['from_time']; ?></td>
                                            <td><?php echo $row['to_time']; ?></td>
                                            <td style="width: 5%;">
                                                <?php if($row['id']==4) { } else { ?>
                                                <a class="btn btn-success btn-rad" href="<?= base_url()?>/cemetery/edit_slot/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                                <?php } ?>
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
         <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->donation; ?></h4>
                            <table>
        
                            <tr><span id="spndeddelid"><b></b></span></tr>
                          </table>
                            
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
    </section>
<script>


<script>
$("document").ready(function () {
    $("#datatables").dataTable({
        "searching": true
    });
    var table = $('#datatables').DataTable();
    $("#customFilter").on('change', function() {
        //filter by selected value on second column
        table.column(6).search($(this).val()).draw();
    }); 
    
    $("form").on("submit", function(){
        $('input[type=submit]').prop('disabled', true);
        $("#loader").show();
    });
});
</script>