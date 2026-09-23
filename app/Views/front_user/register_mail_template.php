<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Customer Registration</title>
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
$qry =  $db->table('login')
				->select('login.*')
				->where("login.id", $login_id)
				->get()->getRowArray();
?>
	<table style="width:50%;margin:0 auto;background-image: linear-gradient(#2a2728, #e51311);background-size:100% 100%;padding:20px;">
		<tbody>
			<tr>
				<td align="center"><img src="<?php echo base_url(); ?>/uploads/main/1687090400_514735_logo.jpg" style="width:100px;"></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td align="center">
					<h3 style="color:#FFFFFF;font-family: system-ui;">Welcome <?php echo !empty($qry['name']) ? $qry['name'] : ""; ?>!</h3>
				</td>
			</tr>
			<tr>
				<td align="center">
					<h4 style="color:#FFFFFF;font-family: system-ui;">We are glad that you have decided to join our organisation.</h4>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td align="center">
					<p style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">Congratulations on applying to be a customer!</p>
				</td>
			</tr>
			<tr><td align="center">
				<p style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">Your request is approved, you are a customer now.</p>
			</td></tr>
			<tr>
				<td align="center">
					<p style="color:#ffffffe3;font-family: system-ui; margin:0.5em;">We are glad that you have decided to join us here at Temple Ganesh, and appreciate your effort to make the organization a better place for current and future temples</p>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
		</tbody>
	</table>
</body>
</html>