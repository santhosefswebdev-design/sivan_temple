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
$qry1 = $db->table('ubayam')
						->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
						->select('ubayam_setting.name as uname')
						->select('ubayam.*')
						->where('ubayam.id', $ubm_id)
						->get()->getRowArray();
$payment 	= $db->table('ubayam_pay_details')->where('ubayam_id', $ubm_id)->get()->getResultArray();
$terms =  $db->table("terms_conditions")->get()->getRowArray();
$pay_details = $db->table("ubayam_pay_details")->where("ubayam_id", $ubm_id)->get()->getResultArray();
?>
<table style="width:50%;margin:0 auto;background-image: linear-gradient(#2a2728, #e51311);background-size:100% 100%;padding:20px;">
    <tbody>
        <tr>
            <td align="center"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temple_details['image']; ?>" style="width:100px;"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td align="center">
                <h4 style="color:#FFFFFF;font-family: system-ui; margin:0.5em;">Success!</h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p style="color:#ffffffe3;font-family: system-ui;">Congratulations! Your Ubayam has been successfully made</p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <table style="width:50%;" align="center">
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Date :</td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php $date= new DateTime($qry1['dt']) ;  echo $date->format('d-m-Y'); ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Invoice :</td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['ref_no']; ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Event Details :</td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['uname']; ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Name :</td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['name']; ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >Mobile No :</td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $qry1['mobile']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h4 style="color:#ffffff;font-family: system-ui; margin:0.5em;">Payment Summary</h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p style="color:#ffffff;font-family: system-ui; margin:0.5em;">Total Amount : <?php echo number_format($qry1['amount'], '2','.',','); ?>  </p>
            </td>
        </tr>
        <tr>
            <td align="center">
                <p style="color:#ffffff;font-family: system-ui; margin:0.5em;">Paid Amount: <?php echo number_format($qry1['paidamount'], '2','.',','); ?> </p>
            </td>
        </tr>
        <?php
        if($qry1['amount'] > $qry1['paidamount'])
        {
        ?>
        <tr>
            <td align="center">
                <p style="color:#ffffff;font-family: system-ui; margin:0.5em;">Balance Amount: <?php echo ($qry1['balanceamount'] > 0) ? number_format($qry1['balanceamount'], '2','.',',') : 0.00; ?></p>
            </td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <td align="center">
                <h4 style="color:#ffffff;font-family: system-ui; margin:0.5em;">Status Booked</h4>
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