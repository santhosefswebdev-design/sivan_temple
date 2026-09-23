<?php global $lang;?>
<style>
    .table-responsive{
        overflow-x: hidden;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->stock; ?><small><?php echo $lang->inventory; ?> / <b><?php echo $lang->stock; ?> <?php echo $lang->in; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
				<?php if($permission['create_p'] == 1) { ?>
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2><?php echo $lang->stock; ?> <?php echo $lang->in; ?></h2></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/stock/stock_in_add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div></div>
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
                                        <th><?php echo $lang->sno; ?></th>
                                        <th><?php echo $lang->staff; ?> <?php echo $lang->name; ?></th>
                                        <th><?php echo $lang->date; ?></th>
                                        <th><?php echo $lang->invoice; ?> <?php echo $lang->no; ?></th>
                                        <th><?php echo $lang->amount; ?></th>
                                        <?php if($permission['view'] == 1 ||  $permission['print'] == 1) { ?>
										<th style="width:10%;"><?php echo $lang->action; ?></th>
										<?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($list as $row) { ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['staffname']; ?></td>
                                            <td><?= $row['date']; ?></td>
                                            <td id="pay<?= $row['id']; ?>" data-id="<?= $row['invoice_no'];?>"><?= $row['invoice_no']; ?></td>
                                            <td><?php if($row['total_amount'] =='') 
											{ echo '0.00'; } 
											else { echo number_format($row['total_amount'], '2','.',','); } ?></td>
                                            <!--<td><?= $row['total_amount']; ?></td>-->
											<?php if($permission['view'] == 1 ||  $permission['print'] == 1) { ?>
                                            <td style="width: 10%;">
												<?php if($permission['view'] == 1) { ?>
                                                <a class="btn btn-success btn-rad" href="<?= base_url()?>/stock/view_stock_in/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                <?php } if($permission['print'] == 1) {?>
												<a class="btn btn-primary btn-rad" href="<?= base_url()?>/stock/print_page_stock_in/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>
												<?php } ?>
                                                <!--<a class="btn btn-primary btn-rad" href="<?= base_url()?>/stock/edit_stock_in/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
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
<div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-information h1 text-info"></i>
                    <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->stock; ?> <?php echo $lang->in; ?></h4>
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
<div id=delete-form>
    
</div>
        <!--End Delete Form-->
</section>
<script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + "  Stock In?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/stock/delete_stock_in/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>
