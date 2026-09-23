<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $temple_details['name']; ?></title>
</head>
<body>
<?php $db = db_connect(); ?>
<?php
// Create a function for converting the amount in words
if(!function_exists('AmountInWords')){
	function AmountInWords(float $amount)
	{	$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
			$get_paise = ($amount_after_decimal > 0) ? " and Cents ". trim(NumToWords($amount_after_decimal)):'';
			return (NumToWords($amount) ? 'Ringgit '.trim(NumToWords($amount)).'' : ''). $get_paise. ' Only';
			
	}
}
if(!function_exists('NumToWords')){
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
}
?>
<?php
$qry1 = $db->table('donation')
						->join('donation_setting', 'donation_setting.id = donation.pay_for')
						->select('donation_setting.name as pname')
						->select('donation.*')
						->where('donation.id', $don_id)
						->get()->getRowArray();
?>
<table style="width:50%;margin:0 auto;background-image: linear-gradient(#2a2728, #e51311);background-size:100% 100%;padding:20px;">
    <tbody>
        <tr>
            <td align="center"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temple_details['image']; ?>" style="width:100px;"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td align="center">
                <h4 style="color:#FFFFFF;font-family: system-ui; margin:0.5em;">Thank you for the Donation </h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p><span style="color:#FFFFFF;font-family: system-ui; font-weight:bold; font-style:italic;">Dear <?php echo $qry1['name']; ?>, </span><br><span style="color:#FFFFFF;font-family: system-ui; font-weight:bold; font-style:italic;">We are deeply grateful for your generous donation to <?php echo $qry1['pname']; ?>. Your support means the world to us and helps us continue our mission. Thank you.</span><br><span style="color:#FFFFFF;font-family: system-ui; font-weight:bold; font-style:italic;">With heartfelt thanks, <?php echo $temple_details['name']; ?></span></p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <table style="width:50%;" align="center">
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" align="right">Date : </td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php $date= new DateTime($qry1['date']) ;  echo $date->format('d-m-Y'); ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" align="right">Invoice : </td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['ref_no']; ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" align="right">Name : </td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['name']; ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" align="right">Pay for : </td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['pname']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h4 style="color:#FFFFFF;font-family: system-ui; margin:0.5em;">Donation Summary</h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p style="color:#FFFFFF;font-family: system-ui; margin:0.5em;">Total Amount : <?php echo number_format($qry1['amount'], '2','.',','); ?>  </p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h4 style="color:#FFFFFF;font-family: system-ui; margin:0.5em;">Status Donated</h4>
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