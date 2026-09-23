<?php global $lang;?>
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
                <h2><?php echo $lang->annathanam; ?>  <small><b><?php echo $lang->list; ?></b></small></h2>
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
                            <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->annathanam; ?></h4>
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
							<div class="header">
								<div class="row"><div class="col-md-8"></div>
								<div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/annathanam/add_annathanam"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?> <?php echo $lang->annathanam; ?></button></a></div></div>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:10%;"><?php echo $lang->date; ?></th>
                                            <th style="width:10%;"><?php echo $lang->invoice; ?> <?php echo $lang->no; ?></th>
                                            <th style="width:22%;"><?php echo $lang->name; ?></th>
                                            <th style="width:15%;"><?php echo $lang->phone; ?> <?php echo $lang->no; ?></th>
                                            <th style="width:10%;"><?php echo $lang->no_pax; ?></th>
											<th style="width:12% !important;"><?php echo $lang->action; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach($list as $row) {
										?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
											<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                            <td><?php echo $row['ref_no']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
											<td><?php echo $row['phone_no']; ?></td>
											<td><?php echo $row['no_of_pax']; ?></td>
                                            <td style="width: 12%;">
                                                <a class="btn btn-warning btn-rad" href="<?= base_url()?>/annathanam/view_annathanam/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                <a class="btn btn-primary btn-rad" title="Edit" href="<?= base_url()?>/annathanam/edit_annathanam/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
												<a class="btn btn-primary btn-rad" href="<?= base_url()?>/annathanam/print_annathanam/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>
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
    </section>
    <script>
    function confirm_modal(id)
    {
        $('#alert-modal').modal('show', {backdrop: 'static'});
        document.getElementById('del').setAttribute('onclick' , 'Del('+id+')');
        $("#spndelid").text("Are you sure to Delete "+$("#pay"+id).attr("data-id") + " prasadam?" );    
    }    
    function Del(id)
    {
        var act = "<?php echo base_url(); ?>/prasadam/delete/"+id;
        $( "#delete-form" ).append( "<form action='"+act+"'><button type='submit' id='delete"+id+"'>submit</button></form>");
        $( "#delete"+id).trigger( "click" );
    }
</script>