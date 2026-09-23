<?php        
$db = db_connect();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
.tbor, th{
    border: 1px solid;
}
table th
{
    background-color: #fff !important;
    color: #444242;

}
table { border-collapse:collapse; }
table td, table th { padding:5px; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.paid_text { color:green; font-weight:600; }
.unpaid_text { color:blue; font-weight:600; }
.cancel_text { color:red; font-weight:600; }
.capitalize{
	text-transform: capitalize;
}
</style>

<table align="center"style="width: 100%;max-width: 800px;">
<tr><td colspan="2">
	
    <!-- <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $pdfdata['temp_details']['image']; ?>" style="width:120px;" align="left"></td>
    <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $pdfdata['temp_details']['name']; ?></h2>
    <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1_frend']; ?>, <br><?php echo $_SESSION['address2_frend']; ?>,<br>
	<?php echo $_SESSION['city_frend']; ?> - <?php echo $_SESSION['postcode_frend']; ?><br>
    Tel : <?php echo $_SESSION['telephone_frend']; ?>
</p></td></tr>
    </table> -->

	<table border="1" align="center" style="border-collapse: collapse; width: 100%;">
										<tbody>
											<tr>
												<td width="15%" style="border: 1px solid #000; vertical-align: top;">
													<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $pdfdata['temp_details']['image']; ?>" style="width:95px;" align="left">
												</td>
												<td width="85%" style="padding: 0px; border: 1px solid #000;">
													<table style="width: 100%; border-collapse: collapse;">
														<tr>
															<td style="padding: 1px;">
																<h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
																	<?php echo $pdfdata['temp_details']['name']; ?>
																</h2>
																<p style="text-align:center; font-size:16px; margin:0;">
																	<?php echo $pdfdata['temp_details']['address1']; ?>, <?php echo $pdfdata['temp_details']['address2']; ?>
																</p>
																<p style="text-align:center; font-size:16px; margin:0;">
																	<?php echo $pdfdata['temp_details']['city'].'-'.$pdfdata['temp_details']['postcode']; ?>
																</p>
																<p style="text-align:center; font-size:16px; margin:0;">
																	Tel : <?= $pdfdata['temp_details']['telephone']; ?>
																</p>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table>

	
</td></tr>
<tr><td colspan="2"><hr></td></tr>
<?php 
//  $payfor = $pdfdata['payfor'];
 $fdate = $pdfdata['fdate'];
 $tdate = $pdfdata['tdate'];
 if (!empty($pdfdata['cdate'])) {

	 $cdate = $pdfdata['cdate'];
 }
 $group_filter = $pdfdata['group_filter']; 
//  $fltername = $pdfdata['fltername']; 
 $booking_type = $pdfdata['booking_type']; 
 $report_type = $pdfdata['report_type']; 
 $file_name = "KATTALAI ARCHANAI Report";
			
 ?>
<tr><td colspan="2" style="width: 100%;">
<h3 style="text-align:center;"> <?php echo strtoupper($file_name).' '. date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
</td></tr>
</table>

<table border="1" width="100%" align="center">
    <thead><tr>
    <th width="5%">S.No</th>
    <th align="center" width="15%">Date</th>
    <th align="center" width="25%">Devotee Name</th>
    <th align="center" width="10%">Types</th>
    <th align="center" width="10%">Payment Type</th>
    <th align="right" width="9%">Amount($)</th>
    <!-- <th align="right" width="9%">Paid</th>
    <th align="right" width="9%">Balance</th> -->
    <th align="right" width="8%">Paid Amount($)</th>
    </tr>
    </thead>
    <tbody>
     
    <?php 
		$total = 0; 
		$fdt= date('Y-m-d',strtotime($fdate));
		$tdt= date('Y-m-d',strtotime($tdate));
		// $cdt= date('Y-m-d',strtotime($cdate));
		if (!empty($cdate)) {
			$cdt= date('Y-m-d',strtotime($cdate));
		}
		// $payfor_fil= $payfor;
		// $fltername_fil= $fltername;
		$group_filter_fil= $group_filter;
		$booking_type = $booking_type;
		$data = [];
		
		$dat = $db->table('kattalai_archanai_booking as kab')
		->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
		->where('kab.date >=', $fdt)
		->where('kab.date <=', $tdt);
		
		if (!empty($group_filter_fil) && $group_filter_fil != "0") {
			$dat = $dat->where('kab.daytype', $group_filter_fil);
		}
		
		$dat = $dat->orderBy('kab.date', 'desc');
		$dat = $dat->get()->getResultArray();

              $sn=1;
			  $daytype = "";
              foreach($dat as $row){
				if ($row['daytype'] == 'daily'){
					$daytype = 'Daily';
				} elseif ($row['daytype'] == 'weekly'){
					$daytype = 'Weekly';
				} elseif ($row['daytype'] == 'days'){
					$daytype = 'Multiple Dates';
				} elseif ($row['daytype'] == 'years'){
					$daytype = 'Yearly';
				}
	?>
	<tr class="capitalize">
	<td><?php echo $sn++; ?></td>
		<td align="center"><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
		<!-- <td><?php echo date('d-m-Y', strtotime($row['booking_date'])); ?></td> -->
		<!-- <td id="pay<?= $row['id']; ?>" data-id="<?= $row['pname'];?>"><?php echo $row['pname']; ?></td> -->
		<td align="center"><?php echo $row['name']; ?></td>
		<td align="center"><?php echo $daytype; ?></td>
		<td align="center"><?php echo $row['payment_type']; ?></td>
		<td align="right"><?php echo $row['amount']; ?></td>
		<td align="right"><?php echo $row['paid_amount']; ?></td>
		
	</tr>
	<?php } ?>  

    </tbody>
</table>
