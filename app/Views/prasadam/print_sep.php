<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; margin: 10px; }
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
<body>

<?php 
$i=1; foreach($qry1_payfor as $row) 
	{
	$qty = $row['quantity']; 
	for($j=0; $j<$qty; $j++) 
		{ ?>

<div style="width: 80mm; height:275mm; font-weight: 600;font-family: monospace;">
<p style="font-size: 12px;"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:110px;" align="center"></p>
<p style="font-size: 12px;"><?php echo $temp_details['name']; ?></p>
<p style="font-size: 12px;"><?php echo $temp_details['address1']; ?></br><?php echo $temp_details['address2']; ?></br>
<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>
<br>Tel: <?= $temp_details['telephone']; ?></p>
<hr>
<p style="text-align: center;">Date: <?php echo $qry1['date']; ?></p>
<p style="text-align: center;">Mobile No: <?php echo $qry1['mobile_no']; ?></p>
<hr>

<p style="text-align: left;">SNO&nbsp;&nbsp;PARTICULARS</p>
<hr>
    <p style="text-align: left;"><?= $i++; ?>&nbsp;&nbsp;<?= $row['name_eng']; ?><br>&nbsp;&nbsp;
       <?= $row['name_tamil']; ?><br>&nbsp;&nbsp;
       <span style="font-size: 18px;">[RM <?= $row['amount']; ?> x 1 = RM <?= number_format($row['amount'],2); ?>]</span></p>
<?php $row['amount']; ?>
<hr>
<p style="text-align: center; font-size: 24px; padding-bottom: 25px;">Total:  RM <?= number_format($row['amount'],2); ?></p>
<hr>
<br>
<img src="<?php echo $qrcdoee; ?>" style="display:block;margin:0 auto;width:auto;height:auto;">
<p style="text-align:center;font-size:13px;font-weight:bold;">["PLEASE SCAN HERE"]</p>
</div>
 
<?php 
		}
	} 
?>
</body>
<script>
window.print();
</script>