<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.tab tr th, .tab tr td { text-align:center; }
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
<h3 style="text-align:center;"> CEMETERY REPORT </h3>
<h3 style="text-align:center;"> [From : <?= date('d-m-Y', strtotime($pdfdata['fdate'])); ?> To <?= date('d-m-Y', strtotime($pdfdata['tdate']));?>] </h3>
    <table class="tab" border="1" width="100%" align="center">
        <thead>
            <tr>
                <th style="width:5%;">S.No</th>
                <th style="width:25%;">Name of Dec</th>
                <th style="width:10%;">Age of Dec</th>
                <th style="width:15%;">Date of Cremation</th>
                <th style="width:20%;">Burial No</th>
                <th style="width:25%;">Place of Demise</th>
            </tr>
        </thead>
        <tbody>
            <?php 
			
			// echo '<pre>';
			// print_r(count($data));
			// die;
			$total = 0; 
			$i=1;
			foreach($pdfdata['data'] as $row) 
			{
                ?>
				<tr>
                    <td><?= $i++;?></td>
                    <td><?= $row['name_of_deceased']; ?></td>
                    <td><?= $row['age']; ?></td>
                    <td><?= date('d/m/Y',strtotime($row['date_for_cremation'])); ?></td>
                    <td><?= $row['burial_no']; ?></td>
                    <td><?= $row['place_of_demise']; ?></td>
				</tr>
            <?php 
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