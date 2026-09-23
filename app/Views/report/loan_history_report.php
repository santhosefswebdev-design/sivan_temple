<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Loan History Report<small>Finance / <b>Loan History Report</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form method="post">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control search_box" name="fltername" id="fltername" data-live-search="true">
                                                    <option value="">select staff name</option>
                                                    <?php
                                                    foreach($staff_list as $row)
                                                    {
                                                    ?>
                                                    <option value="<?php echo $row['staff_id']; ?>"><?php echo $row['name']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label class="form-label"></label>
                                            </div>
                                        </div>                                            
                                    </div>
                                    <div class="col-md-2 col-sm-3">
                                        <div class="form-group form-float">                                        
                                            <label class="btn btn-success btn-lg waves-effect" id="submit">
                                                Filter</label>                                          		
                                            </div>
                                        </div>
                                        <!--div class="col-md-12 col-sm-12" style="margin:0px;">                                    
                                            <button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
                                            <input name="pdf_archanaireport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_archanaireport" value="PDF">
                                            <input name="excel_archanaireport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_archanaireport" value="EXCEL">
                                        </div-->
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
								<table class="table table-bordered table-striped table-hover dataTable" id="datatables">
									<thead>
										<tr>
											<th>SNo</th>
											<th>Race</th>
											<th>Name</th>
											<th>Mobile No</th>
											<th>Email ID</th>
											<th>Address</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
                            </div>
						</div>
            
            </div>
        </div>
    </div>

</section>
<script>
    $(document).ready(function(){
        var report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/get_loan_history_report",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.fltername = $('#fltername').val();
                }
            },
        });

        $('#submit').click(function() {
            report.ajax.reload();
        });
    });
</script>