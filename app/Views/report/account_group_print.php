<title><?php echo $_SESSION['site_title']; ?></title>
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
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
    <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>


<tr>
<td colspan="2">
	<h3 style="text-align:center;"> ACCOUNT GROUP REPORT </h3>
    <table border="1" width="100%" align="center">
        <thead>
            <tr>
                <th>S.No</th>
				<th>Order Code</th>
				<th>Group Name</th>
				<th>Category</th>
            </tr>
        </thead>
        <tbody>
            <?php 
			$db = \Config\Database::connect();
			// echo '<pre>';
			// print_r(count($data));
			// die; 
			$i=1;
			foreach($data as $row) 
			{
                if(!empty($row['name']))
				{
					$groups = $db->table('groups')->select('name')->where('id', $row['parent_id'])->get()->getRowArray();
                ?>
				<tr>
                    <td align="center"><?= $i++;?></td>
                    <td align="center"><?= $row['code']; ?></td>
                    <td align="center"><?= $row['name']; ?></td>
                    <td align="center"><?= $groups['name']; ?></td>
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
window.print();
</script>