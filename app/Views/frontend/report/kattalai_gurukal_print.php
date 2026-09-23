<title><?php echo $_SESSION['site_title']; ?></title>
<?php        
$db = db_connect();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
.tbor, th{
    border: 1px solid;
}
table th
{
    background-color: #ffffff !important;
    color: #000000;

}
table { border-collapse:collapse; }
table td, table th { padding:5px; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.paid_text { color:green; font-weight:600; }
.unpaid_text { color:blue; font-weight:600; }
.cancel_text { color:red; font-weight:600; }
.capitalize{
		text-transform: capitalize;
		text-align: center;
	}
    @media print {
        body {
            font-family: 'Barlow', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 5px;
            text-align: center;
        }

        .table-print {
            page-break-after: auto;
        }

        .table-print tr {
            page-break-inside: avoid; /* Prevent rows from splitting across pages */
            page-break-after: auto;
        }

        .table-print thead {
            display: table-header-group; /* Ensures the header is printed on each page */
        }

        .table-print tfoot {
            display: table-footer-group; /* Ensures the footer is printed on each page */
        }
    }

</style>

<!-- <table align="center"style="width: 100%;max-width: 800px;">
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left"></td>
    <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $temp_details['name']; ?></h2>
    <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1_frend']; ?>, <br><?php echo $_SESSION['address2_frend']; ?>,<br>
	<?php echo $_SESSION['city_frend']; ?> - <?php echo $_SESSION['postcode_frend']; ?><br>
    Tel : <?php echo $_SESSION['telephone_frend']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>

<tr><td colspan="2" style="width: 100%;">
	<?php $file_name = "KATTALAI ARCHANAI REPORT";  ?>
<h3 style="text-align:center;">  <?php echo strtoupper($file_name).' '. date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
</td></tr>
</table> -->

<table border="1" align="center" style="border-collapse: collapse; width: 100%;">
	<tbody>
		<tr>
			<td width="15%" style="border: 1px solid #000; vertical-align: top;">
				<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="left">
			</td>
			<td width="85%" style="padding: 0px; border: 1px solid #000;">
				<table style="width: 100%; border-collapse: collapse;">
					<tr>
						<td>
							<h2 style="text-align:center; margin-bottom: 0; font-size: 18px;">
								<?php echo $temp_details['name']; ?>
							</h2>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								<?php echo $temp_details['city'].'-'.$temp_details['postcode']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-size:16px; margin:0;">
								Tel : <?= $temp_details['telephone']; ?>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
            <td colspan="2" style="width: 100%;"> <?php $file_name = "KATTALAI ARCHANAI REPORT";  ?>
                <h3 style="text-align:center;">  <?php echo strtoupper($file_name).' '. date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
            </td>
        </tr>
	</tbody>
</table>

<table border="1" width="100%" align="center">
    
    <thead>
		<tr>
            <th style="width:5%;text-align: center;">S.No</th>
			<th style="width:20%;text-align: center;">Start Date</th>
			<th style="width:20%;text-align: center;">End Date</th>
			<th style="width:9%;text-align: center;">Devotee Name</th>
			<th style="width:12%;text-align: center;">Types</th>
			<th style="width:15%;text-align:center;">Deity Name</th>
			<th style="width:10%;text-align: center;">Devotee Details</th>
    	</tr>
    </thead>
    <tbody>

    <?php
	$from_date= date('Y-m-d',strtotime($fdate));
	$to_date= date('Y-m-d',strtotime($tdate));
    $period = new \DatePeriod(
        new \DateTime($from_date),
        new \DateInterval('P1D'),
        (new \DateTime($to_date))->modify('+1 day')
    );

    $groupedData = [];

    foreach ($period as $dt) {
        $currentDate = $dt->format("Y-m-d");

        // Select and filter data based on the group filter
        $builder = $db->table('kattalai_archanai_booking as kab')
            ->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
            // ->select("(SELECT GROUP_CONCAT(d.deity_name SEPARATOR ', ') 
            //    FROM kattalai_archanai_deity_details d 
            //    WHERE d.booking_id = kab.id) as deity_names")
            ->select("(SELECT GROUP_CONCAT(ad.name_tamil SEPARATOR ', ')
           FROM kattalai_archanai_deity_details d
           JOIN archanai_diety ad ON ad.id = d.deity_id
           WHERE d.booking_id = kab.id) as deity_names")
		    ->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_tamil, '-', n.name_tamil) SEPARATOR ', ')
            FROM kattalai_archanai_details d2
            JOIN rasi r ON d2.rasi = r.id
            JOIN natchathram n ON d2.natchathiram = n.id
            WHERE d2.booking_id = kab.id) as devotee_details");

        if ($group_filter == 'daily' || $group_filter == 'weekly' || $group_filter == 'years') {
            $builder->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");
        } elseif ($group_filter == 'days') {
            $builder->where("(kab.start_date IS NULL OR kab.end_date IS NULL)");
        } else {
            $builder->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");
        }

        if (!empty($group_filter) && $group_filter != '0') {
            $builder->where('kab.daytype', $group_filter);
        }

        $res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();

        foreach ($res as $record) {
            $matchesDate = false;
            
            // Check if the record matches the current date based on day type
            if ($record['daytype'] == 'days') {
				
                $datesRes1 = $db->table('kattalai_archanai_dates')
                    ->select('date')
                    ->where('booking_id', $record['id'])
                    ->get()
                    ->getResultArray();
					
                foreach ($datesRes1 as $dateRow1) {
					
                    if ($dateRow1['date'] == $currentDate) {
					// 	print_r($record['daytype']) ;
					// print_r($currentDate) ;
					// print_r($dateRow1['date']) ;
					// exit;
					// die;
                        $matchesDate = true;
                        break;
                    }
                }
            } else {
                switch ($record['daytype']) {
                    case 'weekly':
                        $weekday = date('N', strtotime($currentDate)) % 7 + 1;
                        if (($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) && $record['dayofweek'] == $weekday) {
                            $matchesDate = true;
                        }
                        break;
                    case 'years':
                    case 'daily':
                        if ($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) {
                            $matchesDate = true;
                        }
                        break;
                }
            }

            $daytype ="";
            if ($record['daytype'] == 'daily'){
                $daytype = 'Daily';
            } elseif ($record['daytype'] == 'weekly'){
                $daytype = 'Weekly';
            } elseif ($record['daytype'] == 'days'){
                $daytype = 'Multiple Dates';
            } elseif ($record['daytype'] == 'years'){
                $daytype = 'Yearly';
            }

			
            if ($matchesDate) {
                $startdate = $record['daytype'] == 'days' ? "" : date("d-m-Y", strtotime($record['start_date']));
                $enddate = $record['daytype'] == 'days' ? "" : date("d-m-Y", strtotime($record['end_date']));
                $formattedDate = date("d-m-Y", strtotime($currentDate));
                $groupedData[$formattedDate][] = [
                    // 'Id' => $record['id'],
                    'Date' => $formattedDate,
                    'Start Date' => $startdate,
                    'End Date' => $enddate,
                    'Devotee Name' => $record['name'],
                    'Types' => $daytype,
                    'Payment Type' => $record['payment_type'],
                    'Amount' => $record['amount'],
                    'deity_names' => $record['deity_names'],
                    'devotee_details' => $record['devotee_details'],
                    'Paid Amount' => $record['paid_amount']
                ];
            }
        }
    }

    $i = 1;
    foreach ($groupedData as $date => $records) {
        echo '<tr align="center" style="font-size: 24px;" class="date-header"><td colspan="10">' . htmlspecialchars($date) . '</td></tr>';
        foreach ($records as $row) { ?>
            <tr>
                <td style="width:10%;text-align: center;"><?php echo $i++; ?></td>
                <td><?php echo htmlspecialchars($row['Start Date']); ?></td>
                <td><?php echo htmlspecialchars($row['End Date']); ?></td>
                <td class="capitalize"><?php echo htmlspecialchars($row['Devotee Name']); ?></td>
                <td class="capitalize"><?php echo htmlspecialchars($row['Types']); ?></td>
                <td class="capitalize"><?php echo htmlspecialchars($row['deity_names']); ?></td>
                <td class="capitalize"><?php echo htmlspecialchars($row['devotee_details']); ?></td>
                
            </tr>
        <?php }
    } ?>
    </tbody>
</table>

<script>
window.print();
</script>


