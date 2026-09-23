<?php $db = db_connect(); ?>
<title>
    <?php echo $_SESSION['site_title']; ?>
</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Barlow', sans-serif;
    }

    table {
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 7px;
    }

    h4 {
        color: #FFF;
        margin-bottom: 2px;
    }
</style>

<table align="center" width="100%">
    <tr>
        <td colspan="2">
            <table style="width:100%">
                <tr>
                    <td width="15%" align="left"><img
                            src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
                            style="width:120px;" align="left"></td>
                    <td width="85%" align="left">
                        <h2 style="text-align:left;margin-bottom: 0;">
                            <?php echo $_SESSION['site_title']; ?>
                        </h2>
                        <p style="text-align:left; font-size:16px; margin:5px;">
                            <?php echo $_SESSION['address1']; ?>, <br>
                            <?php echo $_SESSION['address2']; ?>,<br>
                            <?php echo $_SESSION['city']; ?> -
                            <?php echo $_SESSION['postcode']; ?><br>
                            Tel :
                            <?php echo $_SESSION['telephone']; ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <h3 style="text-align:center;">Application for Marriage Registration</h3>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="background:#152a55">
            <h4>Personal Details of Bride</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table style="width:100%;">
                <tr>
                    <td style="width:30%;">Full Name of Bride:</td>
                    <td style="width:20%;">
                        <?php echo $marriage['bri_name']; ?>
                    </td>
                    <td style="width:30%;">IC/Passport Number:</td>
                    <td style="width:20%;">
                        <?php echo $marriage['bri_ic']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Date of Birth:</td>
                    <td>
                        <?php echo $marriage['bri_dob']; ?>
                    </td>
                    <td>Nationality:</td>
                    <td>
                        <?php echo $marriage['bri_nationality']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Religion:</td>
                    <td>
                        <?php echo $marriage['bri_religion']; ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="background:#152a55">
            <h4>Personal Details of Groom</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table style="width:100%;">
                <tr>
                    <td style="width:30%;">Full Name of Groom:</td>
                    <td style="width:20%;">
                        <?php echo $marriage['gro_name']; ?>
                    </td>
                    <td style="width:30%;">IC/Passport Number:</td>
                    <td style="width:20%;">
                        <?php echo $marriage['gro_ic']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Date of Birth:</td>
                    <td>
                        <?php echo $marriage['gro_dob']; ?>
                    </td>
                    <td>Nationality:</td>
                    <td>
                        <?php echo $marriage['gro_nationality']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Religion:</td>
                    <td>
                        <?php echo $marriage['gro_religion']; ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="background:#152a55">
            <h4>Marriage Details</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table style="width:100%;">
                <tr>
                    <td style="width:30%;">Date of Intended Marriage:</td>
                    <td style="width:20%;">
                        <?php echo date('d/m/Y', strtotime($marriage['date_of_mrg'])); ?>
                    </td>
                    <td style="width:30%;">Time of Marriage:</td>
                    <td style="width:20%;">
                        <?php echo $marriage['time_of_mrg']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Place of Marriage (Venue):</td>
                    <td>
                        <?php echo $marriage['place_of_mrg']; ?>
                    </td>
                    <td>Phone No</td>
                    <td>
                    <?php
                        $phonecode = !empty($marriage['phonecode'])?$marriage['phonecode']:"";
                        $phoneno = !empty($marriage['phoneno'])?$marriage['phoneno']:"";
                        echo $phonecode.$phoneno;
                    ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="background:#152a55">
            <h4>Payment Details</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table border="1" style="width:100%" align="center">
                <tr>
                    <th width="40%" style="text-align:left">Payment Date</th>
                    <th width="30%" style="text-align:left">Amount</th>
                    <th width="30%" style="text-align:left">Payment Mode</th>
                </tr>
                <?php
                foreach ($payment as $pbd) {
                    $payment_mode_check = $db->table("payment_mode")->where("id", $pbd['payment_mode'])->get()->getResultArray();
                    if (count($payment_mode_check) > 0) {
                        $payment_mode_row = $payment_mode_check[0]['name'];
                    } else {
                        $payment_mode_row = "";
                    }
                    ?>
                    <tr>
                        <td>
                            <?php echo date("d/m/Y", strtotime($pbd['date'])); ?>
                        </td>
                        <td>
                            <?php $total_amount = $pbd['amount'];
                            echo number_format((float) $total_amount, 2, '.', ''); ?>
                        </td>
                        <td>
                            <?php echo $payment_mode_row ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="background:#152a55">
            <h4>Attach documents Details</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table border="1" style="width:100%" align="center">
                <tr>
                    <th width="40%">Description</th>
                    <th width="60%">Document</th>
                </tr>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($mrg_documents as $row) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['description']; ?>
                            </td>
                            <td><a href="<?php echo base_url(); ?>/uploads/marriage/<?php echo $row['document_name']; ?>"
                                    download>
                                    <?php echo $row['document_name']; ?>
                                </a></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <!-- <p class="dot_line" style="bottom:0;position:relative;margin-top: 100px;">
      <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---------------------------------</span>
    </p> -->
        </td>
    </tr>

</table>
<script>
    window.print();
</script>