<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $temple_details['name']; ?></title>
</head>
<body>
<?php $db = db_connect(); ?>
<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{	$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        $get_paise = ($amount_after_decimal > 0) ? " and Cents ". trim(NumToWords($amount_after_decimal)):'';
        return (NumToWords($amount) ? 'Ringgit '.trim(NumToWords($amount)).'' : ''). $get_paise. ' Only';
        
}
function NumToWords($num){
	$num=floor($num);
	$amt_hundred = null;
	$count_length = strlen($num);
	$x = 0;
	$string = array();
	$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
		3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
		7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
		10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
		13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
		16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
		19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
		40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
		70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
		$here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
		while( $x < $count_length ) {
			$get_divider = ($x == 2) ? 10 : 100;
			$amount = floor($num % $get_divider);
			$num = floor($num / $get_divider);
			$x += $get_divider == 10 ? 1 : 2;
			if ($amount) {
				$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
				$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
				$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
			}else $string[] = null;
	}
	//$implode_to_Rupees = implode('', array_reverse($string));
	return(implode('', array_reverse($string)));
}
?>
<?php
$qry1 = $db->table("hall_booking")->where("id", $hall_id)->get()->getRowArray();
$hall_booking_slot_details = $db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $hall_id)->get()->getResultArray();
/* $hall_booking_details = $db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name,booking_addonn.description')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $hall_id)->get()->getResultArray(); */
/* $pay_details = $db->table("hall_booking_pay_details")->where("hall_booking_id", $hall_id)->get()->getResultArray(); */
/* $terms =  $db->table("terms_conditions")->get()->getRowArray(); */
if($qry1['status'] == 1) { $status = "Booked"; }
else if($qry1['status'] == 2) { $status = "Completed"; }
else { $status = "Cancelled"; }
?>
<table style="width:50%;margin:0 auto;background-image: linear-gradient(#2a2728, #e51311);background-size:100% 100%;padding:20px;">
    <tbody>
		<tr>
            <td align="center"><h3><?php echo $temple_details['name']; ?></h3></td>
        </tr>
        <tr>
            <td align="center"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo (!empty($temple_details['image']) ? $temple_details['image'] : '1687090400_514735_logo.jpg'); ?>" style="width:100px;"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td align="center">
                <h4 style="color:#FFFFFF;font-family: system-ui; margin:0.5em;">Success!</h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p style="color:#ffffffe3;font-family: system-ui;">Congratulations! Hall has been booked successfully</p>
            </td>
        </tr>
        <tr><td align="center">
        <table style="width:50%;" align="center">
            <tr>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Date :</td>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php $date= new DateTime($qry1['entry_date']) ;  echo $date->format('d-m-Y'); ?></td>
            </tr>
            <tr>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Event Details :</td>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['event_name']; ?></td>
            </tr>
            <tr>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Slot Time :</td>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >
                <?php 
                if(count($hall_booking_slot_details) > 0){
                    $i = 0;
                    foreach($hall_booking_slot_details as $hbsd){
                        if(!empty($i)) echo '<br>';
                        echo $hbsd['slot_time'];
                        $i++;
                    }
                }
                ?></td>
            </tr>
            <tr>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Invoice :</td>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['ref_no']; ?></td>
            </tr>
            <tr>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Event Date :</td>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo date("d-m-Y", strtotime($qry1['booking_date'])); ?></td>
            </tr>
            <tr>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Mobile No :</td>
                <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['mobile_number']; ?></td>
            </tr>
        </table>
        </td></tr>
        <tr>
            <td align="center">
                <h4 style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">Name: <?php echo $qry1['name']; ?> </h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h4 style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">Payment Summary</h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">Total Amount : <?php echo $qry1['total_amount']; ?>  </p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">Deposit Amount : <?php echo $qry1['paid_amount']; ?> </p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">Balance Amount : <?php echo $qry1['balance_amount']; ?></p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h4 style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">Status : <?php echo $status; ?></h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <img src="<?php echo $qr_image; ?>" style="width:100px;">
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </tbody>
</table>
</body>
</html>