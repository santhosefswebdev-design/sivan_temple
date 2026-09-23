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
            <h2><?php echo $lang->sallary; ?><small><?php echo $lang->finance; ?> / <b><?php echo $lang->sallary; ?></b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
				<?php if($permission['create_p'] == 1) { ?>
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/payslip/advancesalary_add"><button type="button" class="btn bg-deep-purple waves-effect"><?php echo $lang->add; ?></button></a></div></div>
                    </div>
				<?php } ?>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th style="text-align:center;">STAFF NAME</th>
                                        <th style="text-align:center;">DATE</th>
                                        <th style="text-align:center;">REF.NO</th>
                                        <th style="text-align:center;">ADVANCE<br> AMOUNT</th>
                                        <th style="text-align:center;">LOAN<br> AMOUNT</th>
                                        <th style="text-align:center;">PROCESSING<br> FEE</th>
                                        <th style="text-align:center;">EMI<br> AMOUNT</th>
                                        <th style="text-align:center;">TOTAL EMI<br> TENURE</th>
                                        <th style="text-align:center;">PAYMENT<br> MODE</th>
                                        <?php if($permission['view'] == 1 ||  $permission['print'] == 1) { ?>
										<th style="width:8%;"><?php echo $lang->action; ?></th>
										<?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($data as $row) { ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $i++; ?></td>
                                        <td style="text-align:center;"><?php echo $row['name']; ?></td>
                                        <td style="text-align:center;"><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>
                                        <td style="text-align:center;"><?php echo $row['ref_no']; ?></td>
                                        <td style="text-align:center;">
                                            <?php 
                                            if($row['type'] == 1){
                                                echo $row['amount'];
                                            }
                                            else{
                                                echo "0.00";
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php 
                                            if($row['type'] == 2){
                                                echo $row['total_amount'];
                                            }
                                            else{
                                                echo "0.00";
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align:center;"><?php echo $row['provision_amount']; ?></td>
                                        <td style="text-align:center;">
                                            <?php 
                                            if($row['type'] == 2){
                                                echo $row['amount'];
                                            }
                                            else{
                                                echo "0.00";
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php 
                                            if($row['type'] == 2){
                                                echo $row['emi_count'];
                                            }
                                            else{
                                                echo 0;
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php 
                                            $payment_mode_data = $db->table('payment_mode')->where('id',$row['payment_mode'])->get()->getResultArray();
                                            if(count($payment_mode_data) > 0){
                                                $payment_mode_name = $payment_mode_data[0]['name'];
                                            }
                                            else{
                                                $payment_mode_name = "";
                                            }
                                            echo $payment_mode_name; 
                                            ?>
                                        </td>
										<?php if($permission['view'] == 1 || $permission['print'] == 1) { ?>
                                            <td>
												<?php if($permission['view'] == 1) { ?>
													<a class="btn btn-success btn-rad" href="<?= base_url()?>/payslip/advance_salary_view/<?php echo $row['id'];?>"><i class="material-icons">&#xE417;</i></a>
                                                <?php } if($permission['print'] == 1) {?>
													<a class="btn btn-primary btn-rad" href="<?= base_url()?>/payslip/print_advance_salary/<?php echo $row['id'];?>" target="_blank"><i class="material-icons">print</i> </a>
												<?php } ?>
                                                <?php /*<a class="btn btn-primary btn-rad" href="<?= base_url()?>/payslip/edit/<?php echo $row['id'];?>"><i class="material-icons">&#xE3C9;</i></a>
                                                <a class="btn btn-danger btn-rad" onclick="confirm_modal(<?php echo $row['id'];?>)"><i class="material-icons">&#xE872;</i></a> */?>
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
                    <h4 class="mt-2"><?php echo $lang->delete; ?> <?php echo $lang->staff; ?> <?php echo $lang->in; ?></h4>
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
