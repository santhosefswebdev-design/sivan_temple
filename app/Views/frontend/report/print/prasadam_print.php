<title><?php echo $_SESSION['site_title']; ?></title>
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
    background-color: #ffffff !important;
    color: #000000;

}
table { border-collapse:collapse; }
table td, table th { padding:5px; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.paid_text { color:green; font-weight:600; }
.unpaid_text { color:red; font-weight:600; }
</style>

<table border="1" align="center" style="border-collapse: collapse; width: 100%;">
	<tbody>
		<tr>
			<td width="15%" style="border: 1px solid #000; vertical-align: top;">
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left">
			</td>
			<td width="85%" style="padding: 0px; border: 1px solid #000;">
				<table style="width: 100%; border-collapse: collapse;">
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
								<?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								Tel : <?= $temp_details['telephone']; ?>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="width: 100%;">
				<h3 style="text-align:center;"> PRASADAM VOUCHER <?php echo date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
			</td>
		</tr>
	</tbody>
</table>


<table border="1" width="100%" align="center">
    <thead>
		<tr>
			<th style="width:5%;text-align: center;">S.No</th>
			<th style="width:8%;text-align: center;">Date</th>
			<th style="width:9%;text-align: center;">Customer Name</th>
			<!-- <th style="width:12%;text-align: center;">Collection Date</th> -->
			<th style="width:15%;text-align:left;">Payfor</th>
			<th style="width:10%;text-align: center;">Amount</th>
    	</tr>
    </thead>
    <tbody>
     
    <?php 
		$total = 0; 
		$fdt= date('Y-m-d',strtotime($fdate));
		$tdt= date('Y-m-d',strtotime($tdate));
		$fltername_fil= $fltername;
		// $collection_date = !empty($collection_date) ? date('Y-m-d', strtotime($collection_date)) : null;
		// echo ($fdt." - ".$tdt . " - " . $fltername_fil);
		$data = [];
		// $dat = $db->table('prasadam')
        // 		->select('prasadam.id,prasadam.date,prasadam.customer_name,prasadam.amount')
        // 		->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") >=',$fdt);
        // 		$dat = $dat->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") <=',$tdt);
		$dat = $db->table('prasadam p')
			->select('p.`id`, `p`.`date`, p.`customer_name`, pg.group_name, p.`amount`')
			->join('prasadam_booking_details pbd', 'p.id = pbd.prasadam_booking_id', 'left')
			->join('prasadam_setting ps', 'ps.id = pbd.prasadam_id', 'left')
			->join('prasadam_setting_group psp', 'psp.prasadam_id = ps.id', 'left')
			->join('prasadam_group pg', 'pg.id = psp.prasadam_group_id', 'left')
			->where('DATE_FORMAT(p.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(p.date, "%Y-%m-%d") <=', $tdt);
				// if(!empty($collection_date)){
        		// 	$dat = $dat->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d")=',$collection_date);
				// }
				if($fltername_fil)
        		{
        		    // $dat = $dat->where('prasadam.prasadam_group_id',$fltername_fil);
					$dat = $dat->where('psp.prasadam_group_id', $fltername_fil);
        		}
				$dat = $dat->orderBy('p.date', 'asc');
        		$dat = $dat->get()->getResultArray();
              $sn=1;
        foreach($dat as $row){
			// $payfors = $db->table('prasadam_booking_details as pbd')
			// ->join('prasadam_setting','prasadam_setting.id = pbd.prasadam_id')
			// ->select('prasadam_setting.name_eng,prasadam_setting.name_tamil, pbd.quantity')
			// ->where('pbd.prasadam_booking_id',$row['id'])
			// ->get()->getResultArray();
			$payfors = $db->table('prasadam_booking_details')->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')->select('prasadam_setting.name_eng,prasadam_setting.name_tamil')->where('prasadam_booking_details.prasadam_booking_id', $row['id'])->get()->getResultArray();
			$html = "";
			foreach($payfors as $payfor)
			{
				$html.= "&#x2022; ".$payfor['name_eng']. ' - '. $payfor['quantity']."<br>";
			}
	?>
	<tr>
		<td style='text-align: center;'><?php echo $sn++; ?></td>
		<td style='text-align: center;'><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
		<td style='text-align: center;'> <?php echo $row ['customer_name']; ?></td>
		<!-- <td style='text-align: center;'><?php echo date('d-m-Y', strtotime($row['collection_date'])); ?></td> -->
		<td style='text-align: left;'><?php echo $html; ?></td>
		<td style='text-align: right;'><?php if($row['amount'] =='') 
		{ echo $row['amount']; } 
		else { echo number_format($row['amount'], '2','.',','); } ?></td>
	</tr>
	<?php } ?>   

    </tbody>
</table>
<script>
window.print();
</script>


