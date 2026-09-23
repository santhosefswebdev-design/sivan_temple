<?php global $lang;?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
.btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
    background: transparent !important;
}
.form-group { margin-bottom:0 !important; }
.col-sm-3 { margin-bottom:10px !important; }
.table tr th, .table tr td { text-align:center; }
</style>
  <section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2><?php echo $lang->archanai; ?><?php echo $lang->report; ?>  <small><?php echo $lang->archanai; ?> / <b><?php echo $lang->archanai; ?><?php echo $lang->booking; ?><?php echo $lang->report; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                        <div class="body">
                            
                        <form action="<?php echo base_url(); ?>/report/print_archanaireport" method="get" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="fdt" id="fdt" class="form-control" value="<?php echo date('Y-m-01'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->from; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
                                                <div class="form-line" id="bs_datepicker_container" >
                                                    <input type="date" name="tdt" id="tdt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label"><?php echo $lang->to; ?></label>
                                                </div>                                                        
                                            </div>                                            
                                        </div>
										
										<?php /* ?><div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="grp" id="grp">
													
													<option value="0">All</option>
													<?php foreach($grp as $row) { ?>
                                                                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name'];?></option>
                                                                    <?php } ?> 
													
													
														<!--<option value="0">All</option>
														<option value="1">Booked</option>
														<option value="2">Completed</option>
														<option value="3">Cancelled</option> -->
														
													</select>
													<label class="form-label">Group</label>
												</div>
											</div>                                            
                                        </div><?php */ ?>
										<div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="fltername" id="fltername">
                                                        <option value="0"><?php echo $lang->select; ?><?php echo $lang->name; ?></option>
                                                        <?php
                                                        foreach($arch as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name_eng']; ?></option>
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
                                                        <label type="submit" class="btn btn-success btn-lg waves-effect" id="submit"><?php echo $lang->submit; ?></label>                                          		</div>
                                            </div>
                                            <div class="col-md-12 col-sm-12" style="margin:0px;">                                    
    											<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
    											<input name="pdf_archanaireport" type="submit" class="btn btn-danger btn-lg waves-effect" id="pdf_archanaireport" value="PDF">
    											<input name="excel_archanaireport" type="submit" class="btn btn-success btn-lg waves-effect" id="excel_archanaireport" value="EXCEL">
    										</div>
                                        </div>
                                    </div>
                        </form>
<!-- 
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    
                                <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        
                                        <?php 
                                        //echo $qry;
                                        // $i = 1;
                                        // foreach($list as $row)
                                        // {
                                        //     ?> <tr> <td><?php echo $i++; ?></td> 
                                        //     <td><?php echo $row ['name_eng'] . ' ' .$row['name_tamil']; ?></td>
                                        //     <td><?php echo $row ['tQty']; ?></td>
                                        //     <td><?php echo $row ['tAmt']; ?></td>
                                        //     </tr>
                                        //     <?php 
                                        // }
                                         ?>

                                    </tbody>
                                </table>
                            </div>
 

                            <div class="table-responsive">
                                <table id="report" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    
                                <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // $i = 1;
                                        // foreach($list as $row)
                                        // {
                                        //     ?> <tr> <td><?php echo $i++; ?></td> 
                                        //     <td><?php echo $row ['name_eng'] . ' ' .$row['name_tamil']; ?></td>
                                        //     <td><?php echo $row ['tQty']; ?></td>
                                        //     <td><?php echo $row ['tAmt']; ?></td>
                                        //     </tr>
                                        //     <?php
                                        // }
                                         ?>

                                    </tbody>
                                </table>
                            </div>
-->

                            <!-- <div  class="table-responsive">
                                <table id="reporta" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    
                                <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTable" >                                    

                                    </tbody>
                                </table>
                            </div> -->


                            <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                                <table class="table table-striped dataTable" id="datatables">
                                    
                                <thead>
                                        <tr>
                                            <th style="width:5%;"><?php echo $lang->sno; ?></th>
                                            <th style="width:10%;"><?php echo $lang->date; ?></th>
                                            <th style="width:36%;"><?php echo $lang->prt_name_eng; ?></th>
                                            <th style="width:35%;"><?php echo $lang->prt_name_tam; ?></th>
                                            <th style="width:7%;"><?php echo $lang->quantity; ?></th>
                                            <th style="width:7%;"><?php echo $lang->amount; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody >                                    

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
        //alert(0);
        // member_details = $('#datatables').DataTable({
		// "ajax":{
        //     url: "<?php echo base_url(); ?>/report/arch_book_rep_ref",
        //     //url: "<?php echo site_url('report/arch_book_rep_ref'); ?>",
		//      dataType: "json",
		//      type: "POST",
		//      data: function ( data ) {
        //         //alert(0);
		// 		 	// data.type = $('#btn-filter').val();
		// 			// data.zone = $('#zone_id').val();
		// 			 console.log(data);
		// 		}
		// },
        //});
         //reloadTable();
        
        report = $('#datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            "ajax":{
                url: "<?php echo base_url(); ?>/report/arch_book_rep_ref",
                //url: "<?php echo base_url(); ?>/report/arch_book_rep_ref/"+($('#fdt').val()),
                //url: "<?php echo base_url(); ?>/report/arch_book_rep_ref/"+($('#fdt').val())+"/"+($('#tdt').val()),
                //url: "<?php echo base_url(); ?>/report/arch_book_rep_ref/"+(fdt:$('#fdt').val()),
                dataType: "json",
                type: "POST",
                //data:{fdt:$('#fdt').val(),tdt:$('#tdt').val()},
                
                data: function ( data ) {

                    //alert("<?php echo base_url(); ?>/report/arch_book_rep_ref/"+($('#fdt').val()));
                    data.fdt = $('#fdt').val();
                    data.tdt = $('#tdt').val();
                    data.grp = $('#grp').val();
                    data.fltername = $('#fltername').val();
                    }

                //     success:function(f)
                // {
                //     //alert(data);
                //    //$('#billno').val(data);
                //  }
            },
        });



        $('#submit').click(function() {
        //reloadTable();
        //alert($('#fdt').val());
        report.ajax.reload();
        });



    });
    
    function reloadTable() {
      $.ajax({
        url: "<?php echo site_url('report/arch_book_rep_refresh'); ?>",
        type:"POST",
        data:{fdt:$('#fdt').val(),tdt:$('#tdt').val()},
        beforeSend: function (f) {
          $('#userTable').html('Load Table ...');
        },
        success: function (data) {
         //$('#userTable').removeClass();
          $('#userTable').html(data);
        //$('#userTable').addClass("table table-bordered table-striped table-hover js-basic-example dataTable");
        }
      })
    }
</script>
