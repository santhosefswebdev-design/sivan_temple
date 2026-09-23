<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
table td { padding:5px; }
hr {
  border:none;
  border-top:1px dashed #000;
  color:#fff;
  background-color:#fff;
  height:1px;
}
p{font-size: 13px;text-align: center;font-weight: 600;font-family: monospace;margin: 0px}
</style>
<body style="max-width: 80mm;max-height: 355px;font-weight: 600;font-family: monospace;" >
<p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="center"></p>
<p><?php echo $temp_details['name']; ?></p>
<p><?php echo $temp_details['address1']; ?></br><?php echo $temp_details['address2']; ?></br>
<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>
<br>Tel: <?= $temp_details['telephone']; ?></p>
<hr>
<p style="text-align: center;">Date: <?php echo $qry1['created']; ?></p>
<p style="text-align: center;">Bill NO: <?php echo $qry1['ref_no']; ?></p>
<hr>

<p style="text-align: left;">SNO&nbsp;&nbsp;PARTICULARS</p>
<hr>
<?php 
$total = 0; $i=1; foreach($booking as $row) { ?>
    <p style="text-align: left;"><?= $i++; ?>&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
       <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
       <span style="font-size: 20px;">[RM <?= $row['amount']; ?> x <?= $row['quantity']; ?> = RM <?= number_format($row['quantity'] * $row['amount'],2); ?>]</span></p>
<?php $total += $row['quantity'] * $row['amount']; } ?>
<hr>
<table style="width:100%;">
<tr><th align="left">Name</th><th align="left">Rasi</th><th align="left">Natchathram</th></tr>
<?php foreach($rasi as $res) { ?>
<tr><td><?= $res['name']; ?></td>
<td><?= $res['rasi_name_tamil']; ?><br><?= $res['rasi_name_eng']; ?></td>
<td><?= $res['nat_name_tamil']; ?><br><?= $res['nat_name_eng']; ?></td></tr>
<?php } ?>
</table>
<?php if(!empty($vehicles)) {  ?>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left">Name</th>
				<th align="left">Vehicle No</th>
			</tr>
			<?php foreach($vehicles as $vehicle) { ?>
				<tr>
					<td><?= $vehicle['name']; ?></td>
					<td><?= $vehicle['vehicle_no']; ?></td>
				</tr>
			<?php } ?>
		</table>
		<?php } ?>
<p style="text-align: center; font-size: 24px;">Total:  RM <?= number_format($total,2); ?></p>

<br>
<br>
<img src="<?php echo $qrcdoee; ?>" style="display:block;margin:0 auto;" width="150" height="150">
<p style="text-align:center;font-size:13px;font-weight:bold;">["PLEASE SCAN HERE"]</p>
<br>
<br>
</body>
<script>
window.print();
</script>


