<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
input[type=date]::-webkit-datetime-edit {
    color: #555 !important;
}
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


<tr><td colspan="2">
<h3 style="text-align:center;"> Vendor Report <?php  
		if($pdfdata['sts'] == 1) 
		echo ' - Booked';
		else if($pdfdata['sts'] == 2)  echo ' - Completed';
		else if($pdfdata['sts'] == 3)  echo ' - Canceled';
	
	?> </h3>
<h3 style="text-align:center;"> [From : <?= date("d-m-Y", strtotime($pdfdata['fdate'])); ?> To <?= date("d-m-Y", strtotime($pdfdata['tdate']));?>] </h3>
    <table border="1" width="100%" align="center" class="tab">
        <thead>
            <tr>
                <th>SNO</th>
                <th>Booking Date</th>
                <th>Event Details</th>
                <th>Name</th>
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Balance Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; $total = 0; $paid = 0; $balance = 0; 
			foreach($pdfdata['data'] as $row) { 
                if($row['status'] == 1) $status = 'Booked';
                else if($row['status'] == 2) $status = 'Completed';
                else $status = 'Canceled';
                ?>
            <tr>
                <td><?= $i++; ?></td>
                    <td><?= date('d-m-Y', strtotime($row['booking_date'])); ?></td>
                    <td><?= $row['event_name']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['total_amount']; ?></td>
                    <td><?= $row['paid_amount']; ?></td>
                    <td><?= $row['balance_amount']; ?></td>
                    <td><?= $status; ?></td>
            </tr>
            <?php $total += $row['total_amount']; $paid += $row['paid_amount']; $balance += $row['balance_amount'];} ?>
            <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= number_format((float)$total, 2, '.', ''); ?></td>
                    <td><?= number_format((float)$paid, 2, '.', '');  ?></td>
                    <td><?= number_format((float)$balance, 2, '.', ''); ?></td>
                    <td></td>
            </tr>
        </tbody>
    </table>
</td></tr></table>
<script>
//window.print();
</script>


