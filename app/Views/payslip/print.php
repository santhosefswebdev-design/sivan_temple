<title><?php echo $_SESSION['site_title']; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
table td { padding:5px; }
</style>
<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
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
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
   $get_paise = ($amount_after_decimal > 0) ? "and ".($change_words[$amount_after_decimal /(($amount_after_decimal > 9) ? 10 : 1)]." 
   ". $change_words[$amount_after_decimal % 10]) .' Cents ' : '';
   //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
   return ($implode_to_Rupees ? 'Ringgit '.$implode_to_Rupees : ''). $get_paise. ' Only' ;
}
?>
<!--<h2 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
<p style="text-align:center; font-size:12px; margin:5px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
Tel : <?php echo $_SESSION['telephone']; ?></p>-->
<table align="center" width="100%">
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
    <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:left; font-size:16px; margin:5px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>
<tr><td colspan="2"><h2 style="text-align:center;"> Pay Slip  </h2></td></tr>
<tr><td colspan="2">
    <table border="1" style="border:1px solid #CCC;" width="90%" align="center">
    <tr><td width="20%"><b>Name</b> </td><td width="30%"><?php echo $staff['name']; ?></td>
    <td width="20%" style="font-weight: bold;">Date<b></b> </td><td width="30%"><?php $date= new DateTime($qry1['date']) ;  echo $date->format('d-m-Y'); ?></td></tr>
    <tr><td><b>Designation</b> </td><td><?php echo $staff['designation']; ?></td>
    <td><b>Ref No</b> </td><td><?php echo $data['ref_no']; ?></td></tr>
    </table>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">
	<table border="1" style="width:60%" align="center">
		<tr style="font-weight: bold;"><td width="33.33%">Description</td><td width="33.33%">Earning</td><td width="33.33%">Deduction</td></tr>
		<?php $tot_ear =0; $tot_ded =0;
		foreach($data_pay as $row){
		?>
		<tr><td><?php echo $row['description']; ?></td><td><?php echo number_format((float)$row['earning'], 2, '.', ''); ?></td><td><?php echo $row['deduction']; ?></td></tr>
		<?php
		$tot_ear += number_format((float)$row['earning'], 2, '.', '');
		$tot_ded += $row['deduction'];
		}
		?>
		<tr><td>Total</td><td><?php echo number_format((float)$tot_ear, 2, '.', ''); ?></td><td><?php  echo number_format((float)$tot_ded, 2, '.', ''); ?></td></tr>
    </table>
	<table border="1" style="width:60%" align="center">
		<tr>
			<td width="66.66%;"><?php echo AmountInWords($data['net_pay']); ?></td>
			<td whdth="33.33%;" >
				<table width="100%;">
					<tr style="text-align: center;"><td>Net Pay</td></tr>
					<tr style="text-align: center;"><td><?php echo $data['net_pay']; ?></td></tr>
				</table>
			</td>
		</tr>
	</table>
    <p class="dot_line" style="bottom:0;position:relative;margin-top: 100px;">
      <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---------------------------------</span>
    </p>
</td>

</table>
<script>
//window.print();
</script>


