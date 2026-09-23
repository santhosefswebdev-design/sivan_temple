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
<table style="width:100%;">
	<tr>
		<td style="width:15%;">&nbsp;</td>
		<td style="width:10%">
			<img src="<?php echo base_url(); ?>/uploads/main/1681367836_logo-3.png" style="width:65px;" class="logo">
		</td>
		<td style="text-align:center;width:50%;">
			<h3 style="margin-bottom:10px;">LEMBAGA WAKAF HINDU NEGERL PULAU PINANG PENANG STATE HINDU ENDOWMENTS BOARD</h3>
		</td>
		<td style="width:15%;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" style="width: 100%;">
			<h3 style="text-align:center;text-transform: uppercase;"> Rental List </h3>
		</td>
	</tr>
</table>
    <table border="1" width="100%" align="center">
        <thead style="background:#edbf22;">
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
		foreach($pdfdata['data'] as $key => $row) {
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



