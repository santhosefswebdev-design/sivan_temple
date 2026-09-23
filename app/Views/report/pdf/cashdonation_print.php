<?php        
$db = db_connect();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
.tbor, th{
    border: 1px solid #444242;
}
table th
{
    background-color: #444242 !important;
    color: #fff;

}
@media print {
    .vendorListHeading th {
        color: black !important;
    }
}
table { border-collapse:collapse; }
table td, table th { padding:5px; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
</style>

<table align="center" style="width: 100%;max-width: 800px;">
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

<tr><td colspan="2" style="width: 100%;">
<?php 
 $payfor = $pdfdata['payfor'];
 $fdate = $pdfdata['fdate'];
 $tdate = $pdfdata['tdate'];
 $fltername = $pdfdata['fltername']; 
 ?>
<h3 style="text-align:center;"> CASH DONATION <?php echo date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
<?php 
 if($payfor){
    $res = $db->query("select * from donation_setting where id = $payfor")->getRowArray();
    $targetamt = number_format($res['amount'], 2,'.',',');
    $targetamts = $res['amount'];
    $result1 = $db->query("select sum(amount) as collectedamt from donation where pay_for = $payfor")->getRowArray();
    if($result1['collectedamt']) $collectedamt = $result1['collectedamt'];
    else $collectedamt = 0;

?>
<h4 style="text-align: center;"><?php echo $res['name'].' Target Amount '.$targetamt?></h4>
<?php
$res_don_set = $db->table('donation_setting ds')->join('donation d', 'ds.id = d.pay_for', 'left')->select('max(ds.amount) as total_amount')->select('COALESCE(sum(d.amount), 0) as collected_amount')->where(['ds.id' => $payfor])->get()->getRowArray();
?>
</tr>
<tr><td colspan="2" style="width: 100%;">
<table >
	<tr>
		<td><b>Target Amount : </b></td>
		<td><?php echo $res_don_set['total_amount']; ?></td>
		<td><b>Collected Amount : </b></td>
		<td><?php echo $res_don_set['collected_amount']; ?></td>
		<td><b>Balance Amount : </b></td>
		<td>
		<?php 
		$balance_amount = $res_don_set['total_amount'] - $res_don_set['collected_amount'];
		if($balance_amount >= 0){
			echo $balance_amount;
		}
		else 
		{	
			echo "0";
		}	
		?></td>
	</tr>
</table>
</td></tr>
<?php
 }
 ?>
</table>
<table border="1" width="100%" align="center">
    <thead><tr>
    <th width="5%">S.No</th>
    <th align="left" width="25%">Pay For</th>
    <th align="left" width="18%">Date</th>
    <th align="left" width="38%">Name</th>
    <th align="right" width="19%">Amount</th>
    </tr>
    </thead>
    <tbody style="background:#c0c0c0;">
        <?php 
		$total = 0; 
		$fdt= date('Y-m-d',strtotime($fdate));
		$tdt= date('Y-m-d',strtotime($tdate));
		$data = [];
		$dat = $db->table('donation', 'donation_setting.name as pname')
		->join('donation_setting', 'donation_setting.id = donation.pay_for')
		->select('donation_setting.name as pname')
		->select('donation.*')
		->where('donation.date>=',$fdt);
		$dat = $dat->where('donation.date<=',$tdt);
		if($payfor)
		{
		    $dat = $dat->where('donation_setting.id',$payfor);
		}
		if($fltername)
		{
		    $dat = $dat->where('donation.name',$fltername);
		}
		$dat = $dat->get()->getResultArray();
              $sn=1;
              foreach($dat as $row){
        ?>
    <tr>
        <td><?= $sn++; ?></td>
        <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
        <td><?php echo $row ['pname']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo number_format($row['amount'], '2','.',','); ?></td>
	</tr>
    <?php } ?>
	</tbody>
</table>



