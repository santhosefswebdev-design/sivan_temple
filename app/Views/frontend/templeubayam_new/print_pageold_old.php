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
	}

	table td {
		padding: 5px;
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

		<table border="1" align="center" style="border-collapse: collapse; width: 100%;">
            <tbody>
                <tr>
                    <td width="15%" style="border: 1px solid #000; vertical-align: top;">
                        <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left">
                    </td>
                    <td width="85%" style="padding: 0px; border: 1px solid #000;">
                        <table class="table1" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td><h2 style="text-align:center; margin-bottom: 0; font-size: 18px;"><?php echo $temp_details['name']; ?></h2></td>  
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
									<p style="text-align:center; font-size:16px; margin:0;">GST Reg.No: <?php echo $temp_details['regno']; ?></p>
								</td> 
                            </tr>
                            <tr>
                                <td><p style="text-align:center; font-size:16px; margin:0;">
                                        Tel: <?php echo $temp_details['telephone']; ?>  Fax: <?php echo $temp_details['fax_no']; ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">
                        Ubayam Receipt
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
                        Invoice No: <?php echo $data['ref_no']; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <?php echo $data['name']; ?> - <?php echo $data['mobile_code']; ?><?php echo $data['mobile_no']; ?>
                    </td>
                    <td style="text-align: center;">
                        Date: <?php echo date('d-m-Y'); ?>
                    </td>
                </tr>
				<tr>
                    <!-- <td style="text-align: center;">
                        Ubayam Date: <?php echo date('d-m-Y', strtotime($data['booking_date'])); ?>
                    </td> -->
                    <td style="text-align: center;">
                        Event Date: <?php echo date('d-m-Y', strtotime($data['booking_date'])); ?> - Slot: <?php echo $booked_slot['slot_name']; ?>
                    </td>
                    <td style="text-align: center;">
                        Ubayam Name: <?php echo $packages['name']; ?>
                    </td>
                </tr>
				<!-- <tr>
                    <td style="text-align: center;">
						&nbsp;
                    </td>
                    <td style="text-align: center;">
                        
                    </td>
                </tr> -->
            </table>
        </div>

		<div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">
            <table class="table table-bordered table-striped table-hover">
                <tbody>
                    <tr>
                        <td style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">Description</td>
                        <td style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">Quantity</td> 
                        <td style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">Unit Price(RM)</td> 
                        <td style="text-align: center; font-weight: bold; padding: 10px; border: 1px solid #000;">Amount(RM)</td> 
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td class="right-align"><?php echo $packages['name']; ?></td>
                        <td style="text-align: center;"><?php echo $packages['quantity']; ?></td>
                        <td style="text-align: right;"><?php echo $packages['amount']; ?></td>
                        <?php $amount1 = $packages['quantity'] * $packages['amount']; ?>
                        <td style="text-align: right;"><?php echo number_format($amount1, 2); ?></td>
                    </tr>

					<?php if(!empty($services)){ ?>
						<?php foreach($services as $service){ ?>
							<tr>
								<td class="right-align"><?php echo $service['name']; ?></td>
								<td style="text-align: center;"><?php echo $service['quantity']; ?></td>
								<td style="text-align: right;">-</td>
								<td style="text-align: right;">-</td>
							</tr>
                    	<?php } ?>
					<?php } ?>
				 

                    <?php if(!empty($booked_addon)){ ?>
						<?php foreach($booked_addon as $addon){ ?>
                        <tr>
                            <td class="right-align"><?php echo $addon['name']; ?></td>
                            <td style="text-align: center;"><?php echo $addon['quantity']; ?></td>
                            <td style="text-align: right;"><?php echo $addon['amount']; ?></td>
                            <?php $amount2 = $addon['quantity'] * $addon['amount']; ?>
                            <td style="text-align: right;"><?php echo number_format($amount2, 2); ?></td>
                        </tr>
						<?php } ?>
					<?php } ?>

                    <tr>
                        <td style="text-align: right;" colspan="3"><strong>Sub Total(RM)</strong></td>
                        <?php $sub_total = $amount1 + $amount2; ?>
                        <td style="text-align: right;"><strong><?php echo number_format($sub_total, 2); ?></strong></td>
				    </tr>
                    <tr>
                        <td style="text-align: right;" colspan="3"><strong>Discount(RM)</strong></td>
                        <td style="text-align: right;">-<?php echo $data['discount_amount']; ?></td>
				    </tr>
                    <tr>
                        
                        <td style="text-align: right;" colspan="3"><strong>Total(RM)</strong></td>
                        <td style="text-align: right;"><strong><?php echo $data['amount']; ?></strong></td>
				    </tr>
                    <!-- <tr>
                        <td class="right-align" colspan="4">(GST has been absorbed by the Temple)</td>
                    </tr> -->
                    <!-- <tr>
                        <td colspan="3">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr> -->
                    <!-- <tr>
                        <td class="right-align" colspan="5">Note: All cheques should be crossed and made payable to "Muneeswaran Temple Society"</td>
                    </tr>
                    <tr>
                        <td class="right-align" colspan="4">PAYNOW - S67SS0012K (Please Quote Tax Invoice Number As Reference)</td>
                    </tr> -->
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
                        <td style="text-align: right;"><?php echo number_format($data['amount'], 2); ?></td>
                    </tr>
                     <tr>
                        <td class="right-align" width="30%">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr> 
                    <tr>
                        <td class="right-align" width="30%"><strong>Balance Payable(RM)</strong></td>
                        <td colspan="2">&nbsp;</td>
                        <td style="text-align: right;"><?php echo number_format(($data['amount'] - $data['paid_amount']), 2); ?></td>
                    </tr> -->
                    <tr>
		<td colspan="2">
			<table border="1" style="width:100%" align="center">
				<tr>
					<th width="18%" style="text-align:left">Payment Date</th>
					<th width="18%">Payment Mode</th>
					<th width="32%" style="text-align:left">Paid Amount</th>
					<th width="32%" style="text-align:left">Balance Amount</th>

				</tr>
			<?php
// Assuming $data['balance_amount'] contains the initial balance amount
$balance_amount = $data['amount'] ; // Starting balance
$paid_amount = 0;
foreach ($pay_details as $row) {
    // Fetch the payment mode
    $payment_mode = $db->table("payment_mode")->where('id', $row['payment_mode_id'])->get()->getRowArray();
    $payment_mode_name = !empty($payment_mode['name']) ? $payment_mode['name'] : "";

    // Calculate the new balance by subtracting the paid amount from the previous balance
    // $balance_amount -= $row['amount']; // Deduct the paid amount from the balance
    if($balance_amount > 0) {

        $balance_amount = $balance_amount - $row['amount'];
    } else {
        $balance_amount = 0;
    }
    $paid_amount = $paid_amount + $row['amount'];
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

?>
<tr>
        <td>
            
        </td>
        <td >
            
        </td>
        <td style="font-weight: bold;">
            <?php echo "Total Paid: " . number_format($paid_amount, '2', '.', ','); ?>
        </td>
        
        <!-- Display the remaining balance -->
        <td style="font-weight: bold;"><?php echo "Balance Payable: " . number_format($balance_amount, 2, '.', ','); ?></td>
    </tr>
        </table>
    </td>
</tr>
                </tbody>
            </table>
        </div>

<script>
	window.print();
</script>