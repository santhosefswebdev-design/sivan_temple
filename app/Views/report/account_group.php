<?php global $lang; ?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->account; ?> <?php echo $lang->group; ?> <?php echo $lang->report; ?> <small><?php echo $lang->account; ?> / <a href="#" target="_blank"><?php echo $lang->account; ?> <?php echo $lang->group; ?> <?php echo $lang->report; ?></a></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2><?php echo $lang->account; ?> <?php echo $lang->group; ?> <?php echo $lang->report; ?></h2></div>
                        
						</div>
                        <div class="body">
                            
                            <form action="<?php echo base_url(); ?>/report/print_accountgroupreport" method="post" target="_blank">    
                                <div class="container-fluid">
                                    <div class="row clearfix">
										<div class="col-md-12 col-sm-12" style="margin-bottom:0px;">                                    
											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
											<input name="pdf_accountgroupreport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_accountgroupreport" value="PDF">
											<input name="excel_accountgroupreport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_accountgroupreport" value="EXCEL">
										</div>
                                    </div>
                                </div>
							</form>
                                </div>
                                <div class="table-responsive">
									<table class="table table-striped dataTable" id="datatables"> 
										<thead>
											<tr>
												<th><?php echo $lang->sno; ?></th>
												<th><?php echo $lang->order; ?> <?php echo $lang->code; ?></th>
												<th><?php echo $lang->group; ?> <?php echo $lang->name; ?></th>
												<th><?php echo $lang->category; ?></th>
											</tr>
										</thead>
										<tbody id="userTable" >                                    

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
$(document).ready
(
    function()
    {        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/accountgroup_rep_ref",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    //data.group_name = $('#group_name').val();
                }
            },
        });

        $('#submit').click(function() {
			report.ajax.reload();
        });
    });
</script>
