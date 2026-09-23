<title><?php echo $_SESSION['site_title']; ?></title>
<?php        
$db = db_connect();
?>
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
<table align="center" style="width: 100%;max-width: 800px;max-height:100%;">
<tr>
	<td colspan="2">
		<table style="width:100%">
			<tr>
				<td width="15%" align="center">
					<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="center">
				</td>
				<td width="85%" align="left">
					<h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
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


<tr><td colspan="2">
<h3 style="text-align:center;"> Pay Slip 
 </h3>

<h3 style="text-align:center;"> [From : <?= date('d-m-Y', strtotime($fdate)); ?> To <?= date('d-m-Y', strtotime($tdate));?>] </h3>
    <table border="1" width="100%" align="center" class="tab">
            <tr>
                <th>SNO</th>
                <th>Date</th>
                <th>Staff Name</th>
                <th>Ref No</th>
                <th>Amount</th>
            </tr>
            <?php 
                $dat = $db->table('pay_slip', 'staff.name as sname')
                    ->join('staff', 'staff.id = pay_slip.staff_id')
                    ->select('staff.name as sname')
                    ->select('pay_slip.*')
                    ->where('pay_slip.date>=',$fdate) 
                    ->where('pay_slip.date<=',$tdate)
                    ->orderBy('pay_slip.date','desc')
                    ->get()->getResultArray();
                    $i=1;
            foreach($dat as $row) { ?>
            <tr>
                    <td><?= $i++;?></td>
                    <td><?= $row['date']; ?></td>
                    <td><?= $row['sname']; ?></td>
                    <td><?= $row['ref_no']; ?></td>
                    <td><?= number_format($row['net_pay'], '2','.',','); ?></td>
            </tr>
            <?php } ?>
    </table>
</td></tr>

</table>
<script>
window.print();
</script>
