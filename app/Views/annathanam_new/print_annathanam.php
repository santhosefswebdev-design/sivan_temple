<?php $db = db_connect(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
	body {
		font-family: 'Barlow', sans-serif;
	}

	table {
		border-collapse: collapse;
        text-align: center;
	}

	table td {
		padding: 5px 10px!important;
	}
    table th {
		padding: 5px 10px!important;
        /* text-align: center; */
        font-weight: bold;
	}
    .table tr th {
        font-size: 14px;
        background: #f7ebbb;
        color: #333232;
    }
    table tr td, table tr th{
        border-collapse: collapse;
        border: 1px solid;
    }

    .table1{
        border-collapse: collapse;
        border: 0px !important;
    }

.body_head table tr td, .body_head table tr th{
	border: 0;
}
table{
	width: 100%;
	border-collapse: collapse;
}
</style>
<style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header, .footer {
            text-align: center;
        }
        .header h1, .header p {
            margin: 0;
        }
        .details, .items, .payment-details, .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details th, .details td, .items th, .items td, .payment-details th, .payment-details td, .footer-table th, .footer-table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .details th {
            background-color: #f4f4f4;
        }
        .items th {
            background-color: #f0f0f0;
        }
        .right-align {
            text-align: left !important;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer-table th, .footer-table td {
            border: none;
        }
    </style>


<!-- <table align="center" width="100%" border="1" style="border-collapse: collapse;">
    <tr>
        <td width="15%" align="left" style="border:1px solid black; vertical-align:top;">
            <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left">
        </td>
        <td style="vertical-align:top;">
            <table width="100%" border="1" style="border-collapse: collapse;">
                <tr>
                    <td style="text-align:center;">
                        <h2 style="text-align:center;margin-bottom: 0; margin-top:8px;"><?php echo $temp_details['name']; ?></h2>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-size:16px;">
                        <?php echo $temp_details['address1']; ?>, <?php echo $temp_details['city']; ?> <?php echo $temp_details['postcode']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-size:16px;">
                        GST Reg.No: <?php echo $temp_details['gstno']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-size:16px;">
                        Tel: <?php echo $temp_details['telephone']; ?>  Fax: <?php echo $temp_details['fax_no']; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center;"><strong> Annathanam Voucher </strong></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td class="right-align"> Date: <?php echo date('Y-m-d'); ?> </td>
    </tr>

</table> -->

        <table border="1" align="center" style="border-collapse: collapse; width: 100%;">
            <tbody>
                <tr>
                    <td width="15%" style="border: 1px solid #000; vertical-align: top;">
                        <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left">
                    </td>
                    <td width="85%" style="padding: 0px; border: 1px solid #000;">
                        <table class="table1" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td>
                                    <h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
                                        <?php echo $temp_details['name']; ?>
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="text-align:center; font-size:16px; margin:0;">
                                        <?php echo $temp_details['address1']; ?>, <?php echo $temp_details['city']; ?> - <?php echo $temp_details['postcode']; ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="text-align:center; font-size:16px; margin:0;">
                                        GST Reg.No: <?php echo $temp_details['gstno']; ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="text-align:center; font-size:16px; margin:0;">
                                        Tel: <?php echo $temp_details['telephone']; ?>  Fax: <?php echo $temp_details['fax_no']; ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">
                        Annathanam Voucher
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <td style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">
                        Devotee Name and Details
                    </td>
                    <td style="text-align: center;">
                        Tax Invoice No: <?php echo $data['ref_no']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <?php echo $data['name']; ?> 
                    </td>
                    <td style="text-align: center;">
                        Date: <?php echo date('d-m-Y'); ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        Phone Number: <?php echo $data['phone_no']; ?>
                    </td>
                    <td style="text-align: center;">
                        Event Date: <?php echo date('d-m-Y', strtotime($data['event_date'])); ?>
                    </td>
                </tr>
            </table>
        </div>

            

        <div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">
            <table class="table table-bordered table-striped table-hover">
              
               <tbody>
            <tr>
                <td style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">Description</td>
                <td style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">Quantity</td> 
                <td style="text-align: right; font-weight: bold; padding: 10px; border: 1px solid #000;">Unit Price</td> 
                <td style="text-align: right; font-weight: bold; padding: 10px; border: 1px solid #000;">Amount</td> 
            </tr>
            <?php
                $subtotal = 0;
                if ($data['is_special'] == 0) {
                    $subtotal += $data['no_of_pax'] * $data['amount'];
                    ?>
                    <tr>
                        <td class="right-align"><?php echo $data['name_eng'] . ' / ' . $data['name_tamil']; ?></td>
                        <td><?php echo $data['no_of_pax']; ?></td>
                        <td style="text-align: right;">$<?php echo $data['amount']; ?></td>
                        <td style="text-align: right;">$<?php echo number_format($data['no_of_pax'] * $data['amount'], 2); ?></td>
                    </tr>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td class="right-align">&nbsp;&nbsp; -<?php echo $item['name_eng'] . ' / ' . $item['name_tamil']; ?></td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: right;">-</td>
                            <td style="text-align: right;">-</td>
                        </tr>
                    <?php }
                } else {
                    foreach ($special_items as $item) {
                        $subtotal += $item['quantity'] * $item['amount']; ?>
                        <tr>
                            <td class="right-align">Special - <?php echo $item['name_eng'] . ' / ' . $item['name_tamil']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td style="text-align: right;">$<?php echo $item['amount']; ?></td>
                            <td style="text-align: right;">$<?php echo number_format($item['quantity'] * $item['amount'], 2); ?></td>
                        </tr>
                    <?php }
                }
                foreach ($addon_items as $addon) {
                    $subtotal += $addon['quantity'] * $addon['amount']; ?>
                    <tr>
                        <td class="right-align"><?php echo $addon['name_eng'] . ' / ' . $addon['name_tamil']; ?></td>
                        <td><?php echo $addon['quantity']; ?></td>
                        <td style="text-align: right;">$<?php echo $addon['amount']; ?></td>
                        <td style="text-align: right;">$<?php echo number_format($addon['quantity'] * $addon['amount'], 2); ?></td>
                    </tr>
                <?php } ?>
            
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><strong>Sub total</strong></td>
                    <td style="text-align: right;">$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: right;" colspan="3"><strong>Discount (RM)</strong></td>
                    <td style="text-align: right;">-<?php echo $data['discount_amount']; ?></td>
                </tr>
                <tr>
                    <td style="text-align: right;" colspan="3"><strong>Total (RM)</strong></td>
                    <?php $total = $subtotal - $data['discount_amount']; ?>
                    <td style="text-align: right;"><strong><?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">
            <table class="table table-bordered table-striped table-hover">
                <tbody>
                    <!-- <tr>
                        <td class="right-align" width="30%"><strong>Payment Details(RM)</strong></td>
                        <td colspan="2">&nbsp;</td>
                        <td style="text-align: right;"><?php echo number_format($data['paid_amount'], 2); ?></td>
                    </tr>
                    <tr>
                        <td class="right-align" width="30%"><strong>Total Invoice Value(RM)</strong></td>
                        <td colspan="2" style="text-align: center"><?php echo $data['ref_no'] . '/' . date('d-m-Y', strtotime($data['entry_date'])); ?></td>
                        <?php $amount = $data['deposit_amount'] + $data['amount']; ?>
                        <td style="text-align: right;"><?php echo number_format($amount, 2); ?></td>
                    </tr>
                  <tr>
                        <td class="right-align" width="30%">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr> 
                    <tr>
                        <td class="right-align" width="30%"><strong>Balance Payable(RM)</strong></td>
                        <td colspan="2">&nbsp;</td>
                        <td style="text-align: right;"> <?php echo number_format(($amount - $data['paid_amount']), 2); ?></td>
                    </tr> -->
                                  <tr>
		<td colspan="2">
			<table border="1" style="width:100%" align="center">
				<tr>
                    <th width="25%" style="text-align:center">Payment Date</th>
					<th width="25%" style="text-align:center">Payment Mode</th>
					<th width="25%" style="text-align:right">Paid Amount</th>
					<th width="25%" style="text-align:right">Balance Amount</th>
				</tr>
                <?php
                $balance_amount = $total - $tempdata['paid_amount'];
                foreach ($pay_details as $row) {
                    $payment_mode = $db->table("payment_mode")->where('id', $row['payment_mode_id'])->get()->getRowArray();
                    $payment_mode_name = !empty($payment_mode['name']) ? $payment_mode['name'] : "";

                    $balance_amount -= $row['amount']; ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($row['paid_date'])); ?></td>
                        <td><?php echo $payment_mode_name; ?></td>
                        <td style="text-align:right"><?php echo number_format($row['amount'], 2); ?></td>
                        <td style="text-align:right"><?php echo number_format($balance_amount, 2); ?></td>
                    </tr>
                <?php } ?>
			<?php /*
                                            // Assuming $data['balance_amount'] contains the initial balance amount
                                            $balance_amount = $tempdata['total_amount'] - $tempdata['paid_amount'];  // Starting balance
                                            
                                            foreach ($pay_details as $row) {
                                                // Fetch the payment mode
                                                $payment_mode = $db->table("payment_mode")->where('id', $row['payment_mode_id'])->get()->getRowArray();
                                                $payment_mode_name = !empty($payment_mode['name']) ? $payment_mode['name'] : "";

                                                // Calculate the new balance by subtracting the paid amount from the previous balance
                                                $balance_amount -= $row['total_amount']; // Deduct the paid amount from the balance
                                            
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo date("d/m/Y", strtotime($row['paid_date'])); ?>
                                                    </td>
                                                    <td align="center">
                                            <?php echo $payment_mode_name; ?>
                                        </td>
                                                    <td>
                                                        <?php echo number_format($row['amount'] + $qry1['deposit_amount'], '2', '.', ','); ?>
                                                    </td>
                                
                                                    <!-- Display the remaining balance -->
                                                    <td><?php echo number_format($balance_amount, 2, '.', ','); ?></td>
                                                </tr>
                                                <?php
                                            }
                                          */  ?>
                                
                                        </table>
                                    </td>
                                </tr>
                </tbody>
            </table>
        </div>
        

	
<!-- <p class="dot_line" style="bottom:0;position:relative;margin-top: 100px;">
	  <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---------------------------------</span>
	</p> -->
<script>
	window.print();
</script>