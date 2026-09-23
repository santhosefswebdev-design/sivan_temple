<title><?php echo $_SESSION['site_title']; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.table tr th, .table tr td { text-align:center;font-size:13px!important; }
table td { padding:2px; line-height:1.5em; }
h2 { font-size: 20px; }
.level_1  { padding-left:20px !important; }
.level_2  { padding-left:40px !important; }
.level_ledger { padding-left:60px !important; }
.level_total { text-align:center !important; }

.table1{ border:1px solid #CCCCCC; }
.table1 tr th { background-color:#EFEFEF; padding:2px; font-size:13px!important; }
.table1 tr td:first-child { padding:2px; text-align:left;font-size:13px!important; }
.table1 tr td { padding:2px; font-size:13px!important;  }
/*.table1 tr td:last-child { font-weight:bold;  }*/ 
</style>
<table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="max-height: 80px;" align="left"></td>
    <td width="85%" align="center"><h2 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:center; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
</table>
<hr>
<?php
if($pdfdata['breakdown'] == 'daily'){
	$file_name = "Income and Expenditure Statement ".date("d/m/Y", strtotime($pdfdata['sdate']))." - ".date("d/m/Y", strtotime($pdfdata['edate']));
}
else{
	$file_name = "Income and Expenditure Statement ".date("m/Y", strtotime($pdfdata['smonthdate']))." - ".date("m/Y", strtotime($pdfdata['emonthdate']));
}
?>
<h2 style="text-align:center;"><?php echo $file_name; ?></h2>
<table class="table1" style="width:100%;" border="1">
    <thead>
		<tr>
			<th align="left" style="width:10%!important;">Account Name</th>
			<?php
			if($pdfdata['breakdown'] == 'monthly'){
				foreach($pdfdata['getMonthsInRange'] as $getmonth){
					// var_dump($getmonth['date']);  
			?>
			<th align="right" style="width:5%!important;"><?php echo date('M, Y',strtotime($getmonth['date'])); ?></th>
			<?php
				}
			?>
			<th align="right" style="width:5%!important;">Total</th>
			<?php
			}
			else{
			?>
			<th align="right" style="width:5%!important;">Amount</th>
			<?php
			}
			?>
		</tr>
	</thead>
    <tbody>
    <?php foreach($pdfdata['table'] as $row) { ?>
		<?php print_r($row); ?>
    <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-md-12">
        <h1 align="center" style="font-size:16px;"><?php echo $pdfdata['profit']; ?></h1>
    </div>
</div>
