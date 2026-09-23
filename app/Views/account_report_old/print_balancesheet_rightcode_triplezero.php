<title><?php echo $_SESSION['site_title']; ?></title>
<style>
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.table tr th, .table tr td { text-align:center; }
table td { padding:5px; line-height:1.5em; }
h2 { font-size: 20px; }
</style>
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="max-height: 80px;" align="left"></td>
    <td width="85%" align="center"><h2 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:center; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>
<tr><td colspan="2"><h2 style="text-align:center;">Balance Sheet</h2></td></tr>
<tr><td colspan="2">
	<table style="width:100%;" border="0">
    <thead><tr>
    <th style="text-align: left;">Account Name</th>
    <th style="text-align: right;">Current Year</th>
    <th style="text-align: right;">Previous Year</th>
    </tr></thead>
    <tbody>
    <?php foreach($list as $row) { ?>
		<?php print_r($row); ?>
    <?php } ?>
    </tbody>
    </table>
</td></tr>
</table>
<script>
window.print();
</script>