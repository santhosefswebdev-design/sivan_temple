<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.table tr th, .table tr td { text-align:center; }
table td { padding:5px; line-height:1.5em; }
</style>
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
<tr><td colspan="2"><h2 style="text-align:center;">Profit &amp; Loss</h2></td></tr>
<tr><td colspan="2">
	<table style="width:100%;" border="1">
    <thead><tr>
    <th style="width:80%;">Account Name</th>
    <th>Amount</th>
    </tr></thead>
    <tbody>
    <?php foreach($table as $row) { ?>
		<?php print_r($row); ?>
    <?php } ?>
    </tbody>
    </table>
</td></tr>
</table>
<div calss="row">
    <div class="col-md-12">
        <h1 align="center"><?php echo $profit; ?></h1>
    </div>
</div>
<script>
window.print();
</script>