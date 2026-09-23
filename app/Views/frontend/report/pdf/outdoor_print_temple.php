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
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $pdfdata['temp_details']['image']; ?>" style="width:120px;" align="left">
			</td>
			<td width="85%" style="padding: 0px; border: 1px solid #000;">
				<table style="width: 100%; border-collapse: collapse;">
					<tr>
						<td>
							<h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
								<?php echo $pdfdata['temp_details']['name']; ?>
							</h2>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $pdfdata['temp_details']['address1']; ?>, <?php echo $pdfdata['temp_details']['address2']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $pdfdata['temp_details']['city'].'-'.$pdfdata['temp_details']['postcode']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								Tel : <?= $pdfdata['temp_details']['telephone']; ?>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php 
		$fdate = $pdfdata['fdate'];
		$tdate = $pdfdata['tdate'];
		if (!empty($pdfdata['cdate'])) {
			$cdate = $pdfdata['cdate'];
		}
		$group_filter = $pdfdata['group_filter'];  
		$file_name = "OUTDOOR SERVICE VOUCHER";	
		?>
		<tr>
			<td colspan="2" style="width: 100%;">
				<h3 style="text-align:center;"> OUTDOOR SERVICE REPORT <?php echo date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
			</td>
		</tr>
	</tbody>
</table>

</td></tr>
<tr><td colspan="2"><hr></td></tr>

<!-- <tr><td colspan="2" style="width: 100%;">
<h3 style="text-align:center;"> <?php //echo strtoupper($file_name).' '. date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
</td></tr> -->
</table>

<table border="1" width="100%" align="center">
    <thead><tr>
    <th width="5%">S.No</th>
    <th align="left" width="20%">Booking Date</th>
    <th align="left" width="20%">EventDate</th>
    <th align="left" width="15%">Event Name</th>
    <th align="left" width="15%">Name</th>
    <th align="right" width="9%">Amount</th>
    <!-- <th align="right" width="9%">Paid</th>
    <th align="right" width="9%">Balance</th> -->
    <th align="right" width="8%">Status</th>
    </tr>
    </thead>
    <tbody>
     
    <?php 
		$total = 0; 
		$fdt= date('Y-m-d',strtotime($fdate));
		$tdt= date('Y-m-d',strtotime($tdate));
		if (!empty($cdate)) {
			$cdt= date('Y-m-d',strtotime($cdate));
		}
		
		$group_filter_fil= $group_filter;
		$data = [];
		
		$dat = $db->table('outdoor_booking')
			->join('temple_packages', 'temple_packages.id = outdoor_booking.package_id')
			->select('temple_packages.name as pname')
			->select('outdoor_booking.*')
			->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") <=', $tdt);
		
		if (!empty($cdt)) {
			$dat = $dat->where('outdoor_booking.event_date =', $cdt);
		}

		if (!empty($group_filter_fill) && $group_filter_fill != "0") {
			$dat = $dat->where('outdoor_booking.payment_type', $group_filter_fill);
		}
		$dat = $dat->orderBy('outdoor_booking.date', 'desc');
		$dat = $dat->get()->getResultArray();


              $sn=1;
              foreach($dat as $row){
			  $balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			  if($balance_amount < 0) $balance_amount = 0;
	?>
	<tr>
		<td><?php echo $sn++; ?></td>
		<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
		<td><?php echo date('d-m-Y', strtotime($row['event_date'])); ?></td>
		<td id="pay<?= $row['id']; ?>" data-id="<?= $row['pname'];?>"><?php echo $row['pname']; ?></td>
		<td><?php echo $row['name']; ?></td>
		<td align="right"><?php if($row['amount'] =='') 
		{ echo $row['amount']; } 
		else { echo number_format($row['amount'], '2','.',','); } ?></td>
		<!-- <td><?php // if($row['paid_amount'] =='') 		{ echo $row['paid_amount']; } 		else { echo number_format($row['paid_amount'], '2','.',','); } ?></td> -->
		<!-- <td><?php //echo number_format($balance_amount, '2','.',','); ?></td> -->
		<td align="center"><?php if($row['booking_status'] == 3) {
				echo '<span class="cancel_text">Cancelled</span>';
			}	else {

				if (empty($balance_amount)) {
					echo '<span class="paid_text">Paid</span>';
				} else {
					echo '<span class="unpaid_text">Partially Paid</span>';
				}
			}  ?></td>
	</tr>
	<?php } ?>  

    </tbody>
</table>
