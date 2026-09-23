<title><?php echo $_SESSION['site_title']; ?></title>
<?php        
$db = db_connect();
?>
<style>
.tbor, th{
    border: 1px solid;
}
table th
{
    background-color: #edbf22 !important;
    color: #fff;

}
table th{
    background-color: #edbf22 !important;
    color: #fff !important;
}
table { border-collapse:collapse; }
table td, table th { padding:5px;text-align:center; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
</style>
<?php 
//echo '<pre>'; print_r($pdfdata['data']); 
//exit;
?>

<table align="center" width="100%">
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="left">
	<?php
	if(!empty($_SESSION['logo_img']))
	{
	?>
	<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left">
	<?php
	}
	else
	{
	?>
		<img src="<?php echo base_url(); ?>/assets/images/logo.png" style="width:120px;" align="left">
	<?php	
	}
	?>	
	</td>
    <td width="85%" align="center"><h2 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:center; font-size:12px; margin:5px;"><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>

    <table border="1" width="100%" align="center">
        <thead>
            <tr>
                <th>SNo.</th>
				<th>Property Name</th>
				<th>Month / Year</th>
				<th>Amount</th>
				<th>Payee Name</th>
            </tr>
        </thead>
		<tbody>
        <?php 
		$i = 1;
		foreach($data as $key => $row) {
		?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['month_year']; ?></td>
				<td><?php echo $row['amount']; ?></td>
				<td><?php echo $row['payee_name']; ?></td>
			</tr>
        <?php 
		$i++;
		} 
		?>
		</tbody>
    </table>
</br></br></br>


<script>
var css = '@page { size: landscape; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

style.type = 'text/css';
style.media = 'print';

if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}

head.appendChild(style);
window.print();
//window.onafterprint = window.close;
</script>
