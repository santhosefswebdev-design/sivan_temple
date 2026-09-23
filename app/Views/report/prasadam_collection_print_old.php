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
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>

<tr><td colspan="2" style="width: 100%;">
<h3 style="text-align:center;"> PRASADAM Collection <?php echo date("d/m/Y", strtotime($collection_date)); ?></h3>
</td></tr>
</table>

<table border="1" width="100%" align="center">
    <thead><tr>
	<th width="5%">S.No</th>
	<th align="right" width="9%">Customer Name</th>
    <th align="left" width="10%">Name</th>
    <th align="right" width="9%">Collection Date</th>
    </tr>
    </thead>
    <tbody>
     
    <?php 
		$total = 0; 
		$fdt= date('Y-m-d',strtotime($collection_date));
		$fltername_fil= $fltername;
		$data = [];
		$dat = $db->table('prasadam')
        		->select('prasadam.*')
        		->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d")',$fdt);
		if($fltername_fil)
		{
		    $dat = $dat->where('prasadam.prasadam_master_id',$fltername_fil);
		}
		$dat = $dat->get()->getResultArray();
              $sn=1;
              foreach($dat as $row){
				$collect_name =  $this->db->table('prasadam_master')->where('id',$row['prasadam_master_id'])->get()->getRowArray();
	?>
	<tr>
		<td><?php echo $sn++; ?></td>
		<td><?php echo $row['customer_name']; ?></td>
		<td><?php echo $collect_name['name']; ?></td>
		<td><?php echo date('d-m-Y', strtotime($row['collection_date'])); ?></td>
	</tr>
	<?php } ?>   

    </tbody>
</table>
<script>
window.print();
</script>


