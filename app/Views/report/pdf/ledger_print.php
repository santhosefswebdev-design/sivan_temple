<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
</style>
<table align="center"style="width: 100%;max-width: 800px;">
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="center"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="center"></td>
    <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>


<tr>
<td colspan="2">
	<h3 style="text-align:center;"> LEDGER REPORT </h3>
	<?php
	if(!empty($pdfdata['group_name']))
	{
		$db = \Config\Database::connect();
		$groups = $db->table('groups')->select('name')->where('id', $pdfdata['group_name'])->get()->getRowArray();
	?>
		<h3 style="text-align:center;"> [<?= $groups['name']; ?>] </h3>
	<?php
	}
	?>
    <table border="1" width="100%" align="center">
        <thead>
            <tr>
                <th>S.No</th>
				<th>Name</th>
				<th>Code</th>
				<th>Group Name</th>
            </tr>
        </thead>
        <tbody>
            <?php 
			
			// echo '<pre>';
			// print_r(count($data));
			// die; 
			
			$i=1;
			foreach($pdfdata['data'] as $row) 
			{
                if(!empty($row['ledger_name']))
				{
                ?>
				<tr>
                    <td align="center"><?= $i++;?></td>
                    <td align="center"><?= $row ['ledger_name']; ?></td>
                    <td align="center"><?= $row ['ledger_code']; ?></td>
                    <td align="center"><?= $row ['group_name']; ?></td>
				</tr>
            <?php 
				}
			} 
			?>
        </tbody>
    </table>
</td>
</tr>
</table>
<script>
//window.print();
</script>