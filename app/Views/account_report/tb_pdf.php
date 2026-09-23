<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
@font-face {
font-family: "Baamini";           
src: url('<?php echo base_url(); ?>/assets/font/Baamini.ttf');
font-weight: normal;
font-style: normal;
} 
</style>
</head>
<body>
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
table td, table th { padding:5px; text-align:center; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
</style>
<div style="width: 100%;max-width: 210mm;margin:0 auto;">
<table align="center">
<tr>
	<td colspan="2">
		<table style="width:100%">
			<tr>
				<td width="15%" align="center">
					<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="center">
				</td>
				<td width="85%" align="left">
					<h2 style="text-align:left;margin-bottom: 0;font-family: "Baamini" !important;"><?php echo $_SESSION['site_title']; ?></h2>
					<p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>,
					<br><?php echo $_SESSION['address2']; ?>,
					<br><?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?>
					<br>Tel : <?php echo $_SESSION['telephone']; ?></p>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td colspan="2"><hr></td></tr>
</table>
<div>
 <?php 
	//var_dump($pdfdata['data']);
	//exit;
 ?>
<h3 style="text-align:center;"> Trial Balance <?php echo date("d/m/Y", strtotime($sdate)).' - '.date("d/m/Y", strtotime($tdate)); ?> </h3>
  <table border="1" width="100%" align="center">
        <thead>
            <tr>
                <th>A/C No</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
            </tr>
        </thead>
        <tbody>
			<?php foreach($list as $row) { ?>
            <?php print_r($row); ?>
            <?php
            }
            ?>
        </tbody>
    </table>
  
</div></div>
<script>
//window.print();
</script>
</body>
</html>


 