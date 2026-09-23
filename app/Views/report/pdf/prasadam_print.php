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
    background-color: #444242 !important;
    color: #fff;

}
table { border-collapse:collapse; }
table td, table th { padding:5px; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.paid_text { color:green; font-weight:600; }
.unpaid_text { color:red; font-weight:600; }
</style>

<table align="center"style="width: 100%;max-width: 800px;">
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
    <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td>
</tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>
<?php 
 $fdate = $pdfdata['fdate'];
 $tdate = $pdfdata['tdate'];
 $fltername = $pdfdata['fltername']; 
 $collection_date = $pdfdata['collection_date']; 
 ?>
<tr><td colspan="2" style="width: 100%;">
<h3 style="text-align:center;"> PRASADAM VOUCHER <?php echo date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
</td></tr>
</table>

<table border="1" width="100%" align="center">
    <thead>
		<tr>
			<th style="width:5%;text-align: center;">S.No</th>
			<th style="width:8%;text-align: center;">Date</th>
			<th style="width:9%;text-align: center;">Customer Name</th>
			<th style="width:12%;text-align: center;">Collection Date</th>
			<th style="width:15%;text-align:left;">Payfor</th>
			<th style="width:10%;text-align: center;">Amount</th>
    	</tr>
    </thead>
    <tbody>
     
    <?php 
		$total = 0; 
		$fdt= date('Y-m-d',strtotime($fdate));
		$tdt= date('Y-m-d',strtotime($tdate));
		$collection_date= date('Y-m-d',strtotime($collection_date));
		$fltername_fil= $fltername;
		$data = [];
		$dat = $db->table('prasadam')
        		->select('prasadam.id,prasadam.date,prasadam.customer_name,prasadam.collection_date,prasadam.amount')
        		->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") >=',$fdt);
        		$dat = $dat->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") <=',$tdt);
        		$dat = $dat->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d")',$collection_date);
				if($fltername_fil)
        		{
        		    $dat = $dat->where('prasadam.customer_name',$fltername_fil);
        		}
				$dat = $dat->orderBy('prasadam.date', 'asc');
        		$dat = $dat->get()->getResultArray();
              $sn=1;
        foreach($dat as $row){
	?>
	<tr>
		<td style='text-align: center;'><?php echo $sn++; ?></td>
		<td style='text-align: center;'><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
		<td style='text-align: center;'> <?php echo $row ['customer_name']; ?></td>
		<td style='text-align: center;'><?php echo date('d-m-Y', strtotime($row['collection_date'])); ?></td>
		<td style='text-align: left;'><?php echo $html; ?></td>
		<td style='text-align: center;'><?php if($row['amount'] =='') 
		{ echo $row['amount']; } 
		else { echo number_format($row['amount'], '2','.',','); } ?></td>
	</tr>
	<?php } ?>   

    </tbody>
</table>
