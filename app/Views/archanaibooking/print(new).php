<style>
table { border-collapse:collapse; }
table td { padding:5px; line-height:2em; font-size:14px; }
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
   $get_paise = ($amount_after_decimal > 0) ? "and " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' sens' : '';
   //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
   return ($implode_to_Rupees ? $implode_to_Rupees  : '') . $get_paise;
}
?>
<!--<div style="margin:0 auto; text-align:center;"><img src="<?php echo base_url(); ?>/assets/images/logo.png" style="width:70px;"></div>-->
<table style="width:70%;" align="center">
<tr><td width="20%"></td>
<td width="60%">
    <h2 style="margin-bottom:0;">SREE SELVA VINAYAGAR TEMPLE</h2>
    <p style="text-align:left; line-height:1.5em; margin:5px 0;">LOT 5976, JLN. TEPI SUNGAI,<br>KLANG 41100-SELANGORT<br>el.No:03-33710909,Mobile No:<br> GST:,E-Mail:,Web Site:</p>
</td>
<td width="20%"></td></tr>

<tr><td colspan="3">

	<table style="width:100%;" border="1">
    <tr><td width="40%" rowspan="3">Staff name : <br>65,JLN. LIMAU KASTURI TMN.WANGI<br>KLANG<br>SRLANGOR<br>Tel.</td>
    <td width="30%" rowspan="2">Delivery To : <br>SREE SELVA VINAYAGAR TEMPLE</td>
    <td width="30%">STOCK INWARD</td></tr>
    
    <tr><td>Date : <?php $date= new DateTime($qry1['date']) ; echo $date->format('d-m-Y'); ?></td></tr>
    
    <tr><td>Person Incharge:<br>G.SUBRAMANIAM</td>
    <td>REF. NO:<br><?php echo $qry1['ref_no']; ?></td></tr>
    </table>

</td></tr>

<tr><td colspan="3">
	
    <table border="1" align="center" width="100%">
    <tr><td>SNO</td>
    <td>PRODUCT</td>
    <td align="center">UOM</td>
    <td align="right">PRICE</td>
    <td align="right">DISC.</td>
    <td align="right">QTY</td>
    <td align="right">AMOUNT [RM]</td></tr>
    <?php foreach($booking as $row) { ?>
    <tr><td>1</td>
    <td><?php echo $row['name_eng']; ?><br><?php echo $row['name_tamil']; ?></td>
    <td align="center"></td>
    <td align="right"><?php echo $row['amount']; ?></td>
    <td align="right">0.00</td>
    <td align="right"><?php echo $row['quantity']; ?></td>
    <td align="right"><?php echo $row['quantity'] * $row['amount']; ?></td></tr>
    <?php } ?>
    </table>
    
</td></tr>
<tr><td colspan="3">
	<table style="width:100%;">
    <tr><td width="70%"><b>Amount In Words :</b> <br><?php echo AmountInWords($qry1['amount']); ?></td>
    <td width="30%" align="right"><b>Item Amount :</b> <span style="text-align:right;"><?php echo $qry1['amount']; ?></span></td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td><p style="border-bottom:1px dashed #000000; width:200px;"></p>SIGNATURE OF SUPPLIER </td>
    <td align="right"><p style="border-bottom:1px dashed #000000; width:200px;"></p>AUTHORISED SIGNATURE</td></tr>
    </table>
</td>

</table>


<script>
//window.print();
</script>


