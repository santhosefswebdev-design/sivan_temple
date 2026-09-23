<?php        
$db = db_connect();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.tab tr th, .tab tr td { text-align:center; }
</style>
<table align="center"style="width: 100%;max-width:100%;">
    <tr><td colspan="2">
        <table style="width:100%">
            <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
            <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
            <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
            <?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
            Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
        </table>
    </td></tr>
    <tr><td colspan="2"><hr></td></tr>
<tr>
    <td colspan="2">
        <h3 style="text-align:center;"> STAFF DETAIL </h3>
    </td>
</tr>
<tr>
    <td colspan="2">
        <table class="tab" border="1" width="100%" align="center">
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
                            $emp_name = 'MALAYSIAN';
                        }
                        else if($loan['staff_type'] == 2){
                            $emp_name = 'FOREIGNER';
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
    </td>
</tr>
<tr>
    <td colspan="2">
        &nbsp;
    </td>
</tr>
<tr>
    <td colspan="2">
        <h3 style="text-align:center;"> LOAN DETAILS </h3>
    </td>
</tr>
<?php
$loan_emp_id = $loan['id'];
$loan_apply_details = $db->query("SELECT * FROM advancesalary WHERE advancesalary.staff_id = $loan_emp_id AND advancesalary.type = 2 AND advancesalary.ref_no = '$ref_no' ")->getResultArray();
if(count($loan_apply_details) > 0){
    foreach($loan_apply_details as $lad){
        $lon_emp_id = $lad['staff_id'];
?>
<tr>
    <td colspan="2">
        <table border="1" width="100%" >
            <tr>
                <th style="text-align:center;">Loan Date</th>
                <td style="text-align:center;"><?php echo !empty($lad['date']) ? date('d/m/Y', strtotime($lad['date'])) : ""; ?></td>
                <th style="text-align:center;">Ref No</th>
                <td style="text-align:center;"><?php echo !empty($lad['ref_no']) ? $lad['ref_no'] : ""; ?></td>
                <th style="text-align:center;">Start EMI Date</th>
                <td style="text-align:center;"><?php echo !empty($lad['emi_start_month']) ? date('m/Y', strtotime($lad['emi_start_month'])) : ""; ?></td>
                <th style="text-align:center;">End EMI Date</th>
                <td style="text-align:center;"><?php echo !empty($lad['emi_end_month']) ? date('m/Y', strtotime($lad['emi_end_month'])) : ""; ?></td>
            </tr>
            <tr>
                <th style="text-align:center;">Loan Amount</th>
                <td style="text-align:center;"><?php echo !empty($lad['total_amount']) ? $lad['total_amount'] : ""; ?></td>
                <th style="text-align:center;">Processing Amount</th>
                <td style="text-align:center;"><?php echo !empty($lad['provision_amount']) ? $lad['provision_amount'] : ""; ?></td>
                <th style="text-align:center;">Total EMI Tenure</th>
                <td style="text-align:center;"><?php echo !empty($lad['emi_count']) ? $lad['emi_count'] : ""; ?></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="2">
        &nbsp;
    </td>
</tr>
<tr>
    <td colspan="2">
        <table border="1" width="100%" >
            <tr>
                <th style="text-align:center;">SNo</th>
                <th style="text-align:center;">Due Month</th>
                <th style="text-align:center;">Ref No</th>
                <th style="text-align:center;">Remark</th>
                <th style="text-align:center;">Paid Amount</th>
                <th style="text-align:center;">Balance Amount</th>
                <th style="text-align:center;">Status</th>
            </tr>
            <?php
                $i=1;
                $balance_emi_amount = (float)$lad['total_amount'] + (float)$lad['provision_amount'];
                $loan_details = $db->query("SELECT pay_slip.date as due_month,pay_slip.ref_no,pay_slip_details.type_remark,pay_slip_details.deduction FROM pay_slip JOIN pay_slip_details ON pay_slip_details.pay_slip_id = pay_slip.id WHERE pay_slip_details.type = 'Loan' AND pay_slip.staff_id = $lon_emp_id ")->getResultArray();
                if(count($loan_details) > 0){
                    foreach($loan_details as $row){
                        $balance_emi_amount = $balance_emi_amount - (float)$row['deduction'];
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo $i; ?></td>
                    <td style="text-align:center;"><?php echo date('F, Y', strtotime($row['due_month'])); ?></td>
                    <td style="text-align:center;"><?php echo $row['ref_no']; ?></td>
                    <td style="text-align:center;"><?php echo $row['type_remark']; ?></td>
                    <td style="text-align:center;"><?php echo $row['deduction']; ?></td>
                    <td style="text-align:center;"><?php echo number_format($balance_emi_amount,2); ?></td>
                    <td style="text-align:center;">
                        <?php
                        if(!empty($row['deduction']) && $row['deduction'] > 0 ){
                            $paid_status = 'PAID';
                        }
                        else{
                            $paid_status = 'UNPAID';
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
        </table>
    </td>
</tr>   
<?php
    }
}
?>
</table>

<script>
window.print();
</script>