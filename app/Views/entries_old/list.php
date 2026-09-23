<?php global $lang; ?>
<style>
    /*.thead{
        color: #fff;
        background-color: red;
    }
    a:hover { text-decoration: none; }
    body { background:#fff; }
    .content { max-width: 1009%; padding: 0 .2rem; }*/
</style>
<section class="content">
    <div class="container-fluid">
        <!--<div class="block-header">
            <h2> ENTRIES <small>Account / <a href="#" target="_blank">Entries</a></small></h2>
        </div>-->
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-4"><h2><?php echo $lang->list; ?> <?php echo $lang->of; ?> <?php echo $lang->entries; ?></h2></div>
                            <?php if($permission['create_p'] == 1) { ?>
                                <div class="col-md-8" align="right">
                                    <a href="<?php echo base_url(); ?>/entries/receipt_add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->receipt; ?></button></a>
                                    <a href="<?php echo base_url(); ?>/entries/payment_add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->pay; ?></button></a>
                                    <!-- <a href="<?php echo base_url(); ?>/entries/add_entries/3"><button type="button" class="btn bg-deep-purple waves-effect">Contra</button></a> -->
                                    <a href="<?php echo base_url(); ?>/entries/journal_add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->journal; ?></button></a>
                                </div>
                            <?php } ?>
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
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="custom_datatable">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;"><?php echo $lang->date; ?></th>
                                            
                                            <th style="width:42%;"><?php echo $lang->narration; ?></th>
                                            <th style="width:10%;"><?php echo $lang->type; ?></th>
                                            <th align="right" style="width:12%; text-align:right !important;"><?php echo $lang->debit; ?> <?php echo $lang->amount; ?></th>
                                            <th align="right" style="width:12%; text-align:right !important;"><?php echo $lang->credit; ?> <?php echo $lang->amount; ?></th>
                                            <?php if($permission['view'] == 1 ||  $permission['edit'] == 1 ||  $permission['delete_p'] == 1 || $permission['print_p'] == 1) { ?>
                                            <th style="width:12%;"><?php echo $lang->action; ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php //echo '<pre>';  //print_r($data); ?>
                                        <?php foreach($data as $row) { //$disable = ""; $edit_icon="&#xE3C9;";
                                            if($row['entrytype_id'] == 1) $type = 'Receipt';
                                            else if($row['entrytype_id'] == 2) $type = 'Payment';
                                            else if($row['entrytype_id'] == 3) $type = 'Contra';
                                            else if($row['entrytype_id'] == 4) $type = 'Journal';
                                            else $type = '';
                                            if(!empty($row['dr_total'])) $damt = $row['dr_total'];
                                            else $damt = 0;
                                            if(!empty($row['cr_total'])) $camt = $row['cr_total'];
                                            else $camt = 0;
                                            ?>
                                            <tr>
                                                <td ><?php echo $row['date']; ?></td>
                                                <td ><?php echo $row['narration']; ?></td>
                                                <td ><?php echo $type; ?></td>
                                                <td align="right"><?php echo ''.number_format($damt, '2','.',','); ?></td>
                                                <td align="right"><?php echo ''.number_format($camt, '2','.',','); ?></td>
                                                <?php if($permission['view'] == 1 ||  $permission['edit'] == 1 ||  $permission['delete_p'] == 1) { ?>
                                                    <td>
                                                        <?php if($permission['view'] == 1) { ?>
                                                                <a class="btn btn-success btn-rad" title="View" href="<?= base_url()?>/entries/view_page/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                            <?php } if($permission['delete_p'] == 1) { ?>
                                                                <a class="btn btn-info btn-rad" title="Print" href="<?= base_url()?>/entries/print_page/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i></a>
                                                            <?php } if(empty($row['inv_id'])) {	 if($permission['edit'] == 1) { 
																	
																	//$disable = 'pointer-events: none';
																		//$edit_icon="  ";
																		//echo $row['inv_id'];																	
																		?> 
																		<!--a class="btn btn-primary btn-rad"  title="Edit" href="<?= base_url()?>/entries/edit_page/<?= $row['id'] ?>"><i class="material-icons">&#xE3C9;</i></a--> 
																		<!--<a class="btn btn-primary btn-rad" style="<?= $disable ?>" title="Edit" href="<?= base_url()?>/entries/edit/<?= $row['id'] ?>"><i class="material-icons"><?= $edit_icon ?></i></a> -->
															<?php }   if($permission['delete_p'] == 1) { ?>
                                                                <a class="btn btn-danger btn-rad" title="Delete" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a>
                                                            <?php }}  ?>
															
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
                            <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->entries; ?></h4>
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
        <div id=delete-form style="display: none">
            
        </div>
</section>
<script>

    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'dedDel('+id+')');
        $("#spndeddelid").text("Are you sure to Delete  Entrie?" );
    
    }
    
    function dedDel(id)
    {
        var act = "<?php echo base_url(); ?>/entries/delete_page/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"' >submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
    $(function () {
        $('#custom_datatable').DataTable({
            //dom: 'Bfrtip',
            responsive: true,
            order: [[0, 'desc']]
            /*buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]*/
        });
    });
</script>
