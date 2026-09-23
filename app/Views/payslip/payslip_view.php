<?php $db = db_connect();?>
<?php 
$readonly = 'readonly';
?>
<style>
#wamount { text-transform: capitalize; }
#pay_table { width:100%; border-collapse:collapse; }
#pay_table th { padding: 10px; background: #f44336; color: #fff; }
#pay_table td { padding:10px; }

.pay_desc {border :none}
.pay_earn {border :none; text-align: right;width:100%}
.pay_ded {border :none;text-align: right;width:100%}

</style>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>PAY SLIP<small>Finance / <b>View Pay Slip</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/payslip"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                        
                        <form  id="form_submit">

                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="bs_datepicker_container" >
                                                <input type="date" name="date" id="date"  class="form-control" value="<?php if($view == true){ echo $data['date']; } else { echo  date('Y-m-d'); } ?>" <?php echo $readonly; ?> >
                                                <!--<label class="form-label">Date</label>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?php foreach($staff as $st) { 
                                                     if($st['id'] == $data['staff_id']) $sname = $st['name'];
                                                 } ?>
                                                <input type="text" name="invno" id="invno" class="form-control" value="<?= $sname; ?>" readonly>
                                                <label class="form-label">Staff Name</label>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" name="invno" id="invno" class="form-control" value="<?= $data['ref_no']; ?>" readonly>
                                            <label class="form-label">Ref No</label>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped table-hover" id="pay_table" border="1 " style="width:100%;">
                                  <thead>
                                    <tr>
                                      <th style="width:40%;text-align: center;">Description</th>
                                      <th style="width:25%;text-align: center;">Earning</th>
                                      <th style="width:25%;text-align: center;">Deduction</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($data_pay as $row) { ?>
                                        <tr>
                                            <td><?= $row['description']; ?></td>
                                            <td><?= $row['earning']; ?></td>
                                            <td><?= $row['deduction']; ?></td>
                                        </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                                <br><br>
                                
                                
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Earning</label>
                                            <input type="number" id="tot_earn" name="tot_earn" class="form-control" value="<?= $data['earning']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Deduction</label>
                                            <input type="number" id="tot_ded" name="tot_ded" class="form-control" value="<?= $data['deduction']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="form-label">Netpay</label>
                                            <input type="number" id="net_pay" name="net_pay" class="form-control" value="<?= $data['net_pay']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <?php
                                            $payment_mode_check = $db->table("payment_mode")->where("id", $data['payment_mode'])->get()->getResultArray();
                                            if(count($payment_mode_check) > 0)
                                            {
                                                $payment_mode_row = $payment_mode_check[0]['name'];
                                            }
                                            else
                                            {
                                                $payment_mode_row = "";
                                            }
                                            ?>
                                            <input type="text" id="paymentmode" name="paymentmode" class="form-control" value="<?php echo $payment_mode_row; ?>" readonly>
                                            <label class="form-label">Paymentmode <span style="color: red;">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <label class="form-label">Amount in Words</label>
                                            <input type="text" readonly name="wamount" id="wamount" class="form-control" value="<?php //echo AmountInWords($data['total_amount']); ?>" <?php echo $readonly; ?> >
                                        </div>
                                    </div>
                                </div> -->
                                
                                
                                <?php if($view != true) { ?>
                                <div class="col-sm-12" align="center">
                                    <a id="submit" class="btn btn-success btn-lg waves-effect">SAVE</a>
                                    
                                    <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button>
                                </div>
                                <?php } ?>
                                </div>
                            </div>
                        </form>
						
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 127%;">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <table>
                            <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>