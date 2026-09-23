<?php        
$db = db_connect();
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>Loan History<small>Finance / <b>Loan History</b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><!--<h2>Staff</h2>--></div>
                        <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/report/loan_history_report"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                    </div>
                    <div class="body">
                            <form action="<?php echo base_url(); ?>/report/print_loan_history" method="post" target="_blank">
                                <div class="container-fluid">
                                    <div class="row clearfix">
										<input type="hidden" value="<?php echo $loan['id']; ?>" name="loan_staff_id" id="loan_staff_id">
										<div class="col-md-2 col-sm-3">
                                            <div class="form-group form-float">
												<div class="form-line">
													<select class="form-control" name="ref_nooo" id="ref_nooo" required>
                                                        <option value="">Select ref no</option>
                                                        <?php
                                                        foreach($refdet_lists as $row)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $row['ref_no']; ?>"><?php echo $row['ref_no']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
													<label class="form-label"> </label>
												</div>
											</div>                                            
                                        </div>
										<div class="col-md-2 col-sm-3">
											<div class="form-group form-float">                                        
												<button type="submit" class="btn btn-primary btn-lg waves-effect" id="submit">Print</button>
                                            </div>
										</div>
                                        </div>
                                    </div>
                                </form>
                        <h3 class="col-md-12" style="font-size: 15px;text-transform: uppercase;">Staff Details</h3>
                        <div class="table-responsive col-md-12" style="background:#FFF; float:none;">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Name</td>
                                    <td><?php echo !empty($loan['name']) ? $loan['name'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Mobile No</td>
                                    <td>
                                        <?php 
                                            $phonecode = !empty($loan['mobile']) ? $loan['mobile'] : ""; 
                                            echo $phonecode;
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Email ID</td>
                                    <td><?php echo !empty($loan['email']) ? $loan['email'] : ""; ?></td>
                                </tr>
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Address</td>
                                    <td >
                                        <?php  
                                        $address1 = !empty($loan['address1']) ? $loan['address1'] : "";
                                        $address2 = !empty($loan['address2']) ? $loan['address2'] : "";
                                        $city = !empty($loan['city']) ? $loan['city'] : "";
                                        echo $address1." ".$address2." ".$city;
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Race</td>
                                    <td >
                                        <?php 
                                            if($loan['staff_type'] == 1){
                                               $emp_name = '<span style="background: #f44336;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">MALAYSIAN</span>';
                                            }
                                            else if($loan['staff_type'] == 2){
                                                $emp_name = '<span style="background: #2196f3;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">FOREIGNER</span>';
                                            }
                                            else{
                                                $emp_name = "";
                                            }
                                            echo $emp_name;
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">IC No</td>
                                    <td><?php echo !empty($loan['ic_number']) ? $loan['ic_number'] : ""; ?></td>
                                </tr>
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">Designation</td>
                                    <td><?php echo !empty($loan['designation']) ? $loan['designation'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">DOB</td>
                                    <td>
                                        <?php 
                                            echo !empty($loan['date_of_birth']) ? date('d/m/Y',strtotime($loan['date_of_birth'])) : ""; 
                                        ?>
                                    </td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">DOJ</td>
                                    <td><?php echo !empty($loan['date_of_join']) ? date('d/m/Y',strtotime($loan['date_of_join'])) : ""; ?></td>
                                </tr>
                                <?php
                                if($loan['staff_type'] == 1){
                                ?>
                                <tr>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">EPF No</td>
                                    <td><?php echo !empty($loan['epf_no']) ? $loan['epf_no'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">SOCSO No</td>
                                    <td><?php echo !empty($loan['socso_no']) ? $loan['socso_no'] : ""; ?></td>
                                    <td style="background: #9e9e9e0a;font-weight:bold;">EIS No</td>
                                    <td><?php echo !empty($loan['eis_no']) ? $loan['eis_no'] : ""; ?></td>
                                </tr>     
                                <?php
                                }
                                if($loan['staff_type'] == 2){
                                    ?>
                                    <tr>
                                        <td style="background: #9e9e9e0a;font-weight:bold;">Country</td>
                                        <td>
                                            <?php 
                                            $country_id = $loan['foreign_country_id'];
                                            $country_data = $db->query("SELECT * FROM countries WHERE id = $country_id ")->getRowArray();
                                            echo !empty($country_data['name']) ? $country_data['name'] : ""; ?>
                                        </td>
                                        <td style="background: #9e9e9e0a;font-weight:bold;">Passport No</td>
                                        <td><?php echo !empty($loan['foreign_passport_no']) ? $loan['foreign_passport_no'] : ""; ?></td>
                                        <td style="background: #9e9e9e0a;font-weight:bold;">Passport Expiry Date</td>
                                        <td><?php echo !empty($loan['foreign_passport_expiry_date']) ? date('d/m/Y',strtotime($loan['foreign_passport_expiry_date'])) : ""; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background: #9e9e9e0a;font-weight:bold;">VISA No</td>
                                        <td><?php echo !empty($loan['foreign_visa_no']) ? $loan['foreign_visa_no'] : ""; ?></td>
                                        <td style="background: #9e9e9e0a;font-weight:bold;">VISA Expiry Date</td>
                                        <td><?php echo !empty($loan['foreign_visa_expiry_date']) ? date('d/m/Y',strtotime($loan['foreign_visa_expiry_date'])) : ""; ?></td>
                                        <td style="background: #9e9e9e0a;font-weight:bold;">VISA Type</td>
                                        <td>
                                            <?php 
                                            if($loan['foreign_types_of_visa'] == 1){
                                                echo "SOCIAL VISA";
                                            }
                                            if($loan['foreign_types_of_visa'] == 2){
                                                echo "EMPLOYMENT PASS";
                                            }
                                            ?>
                                        </td>
                                    </tr>        
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <h3 class="col-md-12" style="font-size: 15px;text-transform: uppercase;margin-top: 0px;">Loan Details</h3>
                        <?php
                        $loan_emp_id = $loan['id'];
                        $loan_apply_details = $db->query("SELECT * FROM advancesalary WHERE advancesalary.staff_id = $loan_emp_id AND advancesalary.type = 2 ")->getResultArray();
                        if(count($loan_apply_details) > 0){
                            foreach($loan_apply_details as $lad){
                                $lon_emp_id = $lad['staff_id'];
                        ?>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                        <table>
                            <tr>
                                <th>Loan Date</th>
                                <td><?php echo !empty($lad['date']) ? date('d/m/Y', strtotime($lad['date'])) : ""; ?></td>
                                <th>Ref No</th>
                                <td><?php echo !empty($lad['ref_no']) ? $lad['ref_no'] : ""; ?></td>
                                <th>Start EMI Date</th>
                                <td><?php echo !empty($lad['emi_start_month']) ? date('m/Y', strtotime($lad['emi_start_month'])) : ""; ?></td>
                                <th>End EMI Date</th>
                                <td><?php echo !empty($lad['emi_end_month']) ? date('m/Y', strtotime($lad['emi_end_month'])) : ""; ?></td>
                                <th>Loan Amount</th>
                                <td><?php echo !empty($lad['total_amount']) ? $lad['total_amount'] : ""; ?></td>
                                <th>Processing Amount</th>
                                <td><?php echo !empty($lad['provision_amount']) ? $lad['provision_amount'] : ""; ?></td>
                                <th>Total EMI Tenure</th>
                                <td><?php echo !empty($lad['emi_count']) ? $lad['emi_count'] : ""; ?></td>
                            </tr>
                        </table>
                        </div>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;">
                            <table class="table table-bordered table-striped table-hover dataTable" id="datatables">
                                <thead>
                                    <tr>
                                        <th>SNo</th>
                                        <th>Due Month</th>
                                        <th>Ref No</th>
                                        <th>Remark</th>
                                        <th style="text-align:center;">Paid Amount</th>
                                        <th style="text-align:center;">Balance Amount</th>
                                        <th style="text-align:center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i=1;
                                    $balance_emi_amount = (float)$lad['total_amount'] + (float)$lad['provision_amount'];
                                    $loan_details = $db->query("SELECT pay_slip.date as due_month,pay_slip.ref_no,pay_slip_details.type_remark,pay_slip_details.deduction FROM pay_slip JOIN pay_slip_details ON pay_slip_details.pay_slip_id = pay_slip.id WHERE pay_slip_details.type = 'Loan' AND pay_slip.staff_id = $lon_emp_id ")->getResultArray();
                                    if(count($loan_details) > 0){
                                        foreach($loan_details as $row){
                                            $balance_emi_amount = $balance_emi_amount - (float)$row['deduction'];
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date('F, Y', strtotime($row['due_month'])); ?></td>
                                        <td><?php echo $row['ref_no']; ?></td>
                                        <td><?php echo $row['type_remark']; ?></td>
                                        <td style="text-align:center;"><?php echo $row['deduction']; ?></td>
                                        <td style="text-align:center;"><?php echo number_format($balance_emi_amount,2); ?></td>
                                        <td style="text-align:center;">
                                            <?php
                                            if(!empty($row['deduction']) && $row['deduction'] > 0 ){
                                                $paid_status = '<span style="background: #4CAF50;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">PAID</span>';
                                            }
                                            else{
                                                $paid_status = '<span style="background: #f44336d6;padding: 2px 5px;color: #fff;font-size: 12px;font-weight: bold;">UNPAID</span>';
                                            }
                                            echo $paid_status;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                        $i++;
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>


                        <?php
                            }
                        }
                        ?>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
				</div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('#datatables').DataTable({dom: 'Bfrtip'});
    });
</script>