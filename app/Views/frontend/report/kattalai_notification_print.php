<title><?php echo $_SESSION['site_title']; ?></title>
<?php        
$db = db_connect();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
    .text-red {
    color: red;
}
.text-green {
    color: green;
}
.text-orange {
    color: orange;
}
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
</style>

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
            <td colspan="2" style="width: 100%;"> <?php $file_name = "KATTALAI ARCHANAI STATUS";?>
                <h3 style="text-align:center;">  <?php echo strtoupper($file_name).'  '. date("d/m/Y", strtotime($fdate)).' - '.date("d/m/Y", strtotime($tdate)); ?></h3>
            </td>
        </tr>
	</tbody>
</table>

<table border="1" width="100%" align="center">
    <thead>
        <tr>
            <th style="width:1%;  text-align: center;">S.No</th>
			<th style="width:30%; text-align: left;">Start Date</th>
			<th style="width:30%; text-align: left;">End Date</th>
			<th style="width:8%;  text-align: center;">Devotee Name</th>
			<th style="width:3%; text-align: center;">Types</th>
			<th style="width:13%; text-align:center;">Deity Name</th>
			<!-- <th style="width:8%; text-align: center;">Devotee Details</th> -->
            <th style="width:%5; text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>

    <?php
	$from_date= date('Y-m-d',strtotime($fdate));
	$to_date= date('Y-m-d',strtotime($tdate));
    $builder = $db->table('kattalai_archanai_booking as kab')
        ->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
        ->select("(SELECT GROUP_CONCAT(d.deity_name SEPARATOR ', ') 
               FROM kattalai_archanai_deity_details d 
               WHERE d.booking_id = kab.id) as deity_names")
		->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_eng, '-', n.name_eng) SEPARATOR ', ')
		FROM kattalai_archanai_details d2
		JOIN rasi r ON d2.rasi = r.id
		JOIN natchathram n ON d2.natchathiram = n.id
		WHERE d2.booking_id = kab.id) as devotee_details");

    if ($group_filter == 'daily' || $group_filter == 'weekly' || $group_filter == 'years') {
        $builder->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");
    } else if ($group_filter == 'days') {
        $builder->where("(kab.start_date IS NULL OR kab.end_date IS NULL)");
    } else {
        $builder->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");
    }

    if (!empty($group_filter) && $group_filter != '0') {
        $builder->where('kab.daytype', $group_filter);
    }

    $res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();
    $current_date = date('Y-m-d');
    $groupedData = [];

    foreach ($res as $record) {
        $status = '';
        $enddate = $record['end_date'];

        if ($record['start_date'] == null || $record['end_date'] == null) {
            // Check the kattalai_archanai_dates table for the effective end date
            $datesRes = $db->table('kattalai_archanai_dates')
			->select('MAX(date) as end_date')
			->where('booking_id', $record['id'])
			->where('date IS NOT NULL')
    		->where('date !=', '1970-01-01')
			->get()
			->getRowArray();

            // if ($datesRes['end_date']) {
			if (!empty($datesRes['end_date']) && $datesRes['end_date'] > $from_date) {
                $enddate = $datesRes['end_date'];
            } else {
                // Skip this record if both start_date and end_date are null and kattalai_archanai_dates table has no valid end date
                continue;
            }
        }

        if ($enddate <= $current_date) {
            $status = 'COMPLETED';
        } elseif ($enddate < $to_date) {
            $status = 'GOING TO COMPLETE';
        } else {
            $status = 'ONGOING';
        }

        // $startdate = date("d-m-Y", strtotime($record['start_date']));
        $formattedDate = date("d-m-Y", strtotime($record['date']));

		if ($record['daytype'] == 'days') {
			$startdate = "";
		} else {
			$startdate = date("d-m-Y", strtotime($record['start_date']));
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

        $groupedData[] = array(
            // 'Id' => $record['id'],
            'Date' => $formattedDate,
            'Start Date' => $startdate,
            'End Date' => date("d-m-Y", strtotime($enddate)),
            'Devotee Name' => $record['name'],
            'Types' => $daytype,
            'Payment Type' => $record['payment_type'],
            'Amount' => $record['amount'],
            'deity_names' => $record['deity_names'],
            'devotee_details' => $record['devotee_details'],
            'Paid Amount' => $record['paid_amount'],
            'Status' => $status
        );
    }

    $i = 1; 
    foreach ($groupedData as $row):
        ?>
   <tr class="border-b">
       <td class=""><?php echo $i++; ?></td>
       <td class=""><?= $row['Start Date'] ?></td>
        <td class=""><?= $row['End Date'] ?></td>
      
       <td class="capitalize"><?= $row['Devotee Name'] ?></td>
       <td class="capitalize"><?= $row['Types'] ?></td>
       <td class=""><?= $row['deity_names'] ?></td>
        <!-- <td class=""><?= $row['devotee_details'] ?></td> -->
        
        
        <td class="<?php 
            echo $row['Status'] == 'COMPLETED' ? 'text-red' : 
                ($row['Status'] == 'ONGOING' ? 'text-green' : 
                ($row['Status'] == 'GOING TO COMPLETE' ? 'text-orange' : ''));
        ?>">
            <?= htmlspecialchars($row['Status']); ?>
        </td>
   </tr>
   <?php endforeach; ?>
    </tbody>
</table>

<script>
window.print();
</script>


