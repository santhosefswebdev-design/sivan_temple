<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Establish database connection
$db = db_connect();

// Retrieve filter values (sanitize input)
$fdt = isset($_REQUEST['fdt']) ? $_REQUEST['fdt'] : '';
$tdt = isset($_REQUEST['tdt']) ? $_REQUEST['tdt'] : '';
$fltername = isset($_POST['fltername']) ? $_POST['fltername'] : '';

// Fetch site details from session
$site_title = $_SESSION['site_title'];
$logo_img = $_SESSION['logo_img'];
$name_tamil = $_SESSION['name_tamil'];
$city_tamil = $_SESSION['city_tamil'];
$since_tamil = $_SESSION['since_tamil'];
$city = $_SESSION['city'];
$since_eng = $_SESSION['since_eng'];
$address1 = $_SESSION['address1'];
$address2 = $_SESSION['address2'];
$postcode = $_SESSION['postcode'];
$telephone = $_SESSION['telephone'];

// Initialize query builder
$builder = $db->table('prasadam')
    ->select('prasadam.id, prasadam.date, prasadam.customer_name, prasadam.collection_date, prasadam.amount');

// Apply date range filter if both dates are provided
if ($fdt && $tdt) {
    $builder->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d") >=', $fdt)
            ->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d") <=', $tdt);
}

// Apply customer name filter if provided
if ($fltername) {
    $builder->where('prasadam.customer_name', $fltername);
}

// Fetch the filtered results
$dat = $builder->orderBy('prasadam.collection_date', 'asc')->get()->getResultArray();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Barlow', sans-serif;
        }
        .tbor,
        th {
            border: 1px solid;
        }
        table th {
            /* background-color: #444242 !important; */
            color: black;
        }
        table {
            border-collapse: collapse;
        }
        table td,
        table th {
            padding: 5px;
        }
        .inner_table tr:nth-child(even) {
            background: #F3F3F3;
        }
        .inner_table tr:last-child {
            background: #e2dfdf;
        }
        .paid_text {
            color: green;
            font-weight: 600;
        }
        .unpaid_text {
            color: red;
            font-weight: 600;
        }
    </style>
</head>
<body>

<table align="center" style="width: 100%;max-width: 800px;">
    <tr>
        <td colspan="2">
            <table style="width:100%">
                <tr>
                    <td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $logo_img; ?>" style="width:120px;" align="left"></td>
                    <td width="85%" align="left">
                        <h3 style="text-align:center;margin-bottom: 0;"><?php echo $name_tamil; ?></h3>
                        <p style="text-align:center; font-size:16px; margin:0;"><?php echo $city_tamil; ?> <?php echo $since_tamil; ?></p>
                        <h2 style="text-align:center;margin-bottom: 0; margin-top:8px;"><?php echo $site_title; ?></h2>
                        <p style="text-align:center; font-size:16px; margin:0px;"><?php echo $city; ?> <?php echo $since_eng; ?><br><?php echo $address1; ?>, <?php echo $address2; ?>, <?php echo $postcode; ?> <?php echo $city; ?> <br>Tel : <?php echo $telephone; ?></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="width: 100%;">
            <h3 style="text-align:center;"> PRASADAM Collection
                <?php echo date("d/m/Y", strtotime($fdt)) . ' - ' . date("d/m/Y", strtotime($tdt)); ?>
            </h3>
        </td>
    </tr>
</table>

<table border="1" width="100%" align="center">
    <thead>
        <tr>
            <th style="width:5%;">S.No</th>
            <th style="width:8%;">Date</th>
            <th style="width:9%;">Customer Name</th>
            <th style="width:12%;">Collection Date</th>
            <th style="width:15%;text-align:left;">Pay for</th>
            <th style="width:10%;">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        $i = 1;
        foreach ($dat as $row) {
            // Get associated payfor items
            $payfors = $db->table('prasadam_booking_details')
                ->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
                ->select('prasadam_setting.name_eng, prasadam_setting.name_tamil')
                ->where('prasadam_booking_details.prasadam_booking_id', $row['id'])
                ->get()->getResultArray();
            
            $html = "";
            foreach ($payfors as $payfor) {
                $html .= "&#x2022; " . $payfor['name_eng'] . " / " . $payfor['name_tamil'] . "<br>";
            }
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $i++; ?></td>
                <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                <td style="text-align: center;"><?php echo $row['customer_name']; ?></td>
                <td style="text-align: center;"><?php echo date('d-m-Y', strtotime($row['collection_date'])); ?></td>
                <td style="text-align: left;"><?php echo $html; ?></td>
                <td style="text-align: center;">
                    <?php echo $row['amount'] ? number_format($row['amount'], 2, '.', ',') : '-'; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    window.print();
</script>

</body>
</html>
