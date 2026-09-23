<title>
  <?php echo $_SESSION['site_title']; ?>
</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Barlow', sans-serif;
  }

  table {
    border-collapse: collapse;
  }

  table td {
    padding: 5px;
  }
</style>
<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
  $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
  $get_paise = ($amount_after_decimal > 0) ? " and Cents " . trim(NumToWords($amount_after_decimal)) : '';
  return (NumToWords($amount) ? 'Ringgit ' . trim(NumToWords($amount)) . '' : '') . $get_paise . ' Only';

}
function NumToWords($num)
{
  $num = floor($num);
  $amt_hundred = null;
  $count_length = strlen($num);
  $x = 0;
  $string = array();
  $change_words = array(
    0 => '',
    1 => 'One',
    2 => 'Two',
    3 => 'Three',
    4 => 'Four',
    5 => 'Five',
    6 => 'Six',
    7 => 'Seven',
    8 => 'Eight',
    9 => 'Nine',
    10 => 'Ten',
    11 => 'Eleven',
    12 => 'Twelve',
    13 => 'Thirteen',
    14 => 'Fourteen',
    15 => 'Fifteen',
    16 => 'Sixteen',
    17 => 'Seventeen',
    18 => 'Eighteen',
    19 => 'Nineteen',
    20 => 'Twenty',
    30 => 'Thirty',
    40 => 'Forty',
    50 => 'Fifty',
    60 => 'Sixty',
    70 => 'Seventy',
    80 => 'Eighty',
    90 => 'Ninety'
  );
  $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
  while ($x < $count_length) {
    $get_divider = ($x == 2) ? 10 : 100;
    $amount = floor($num % $get_divider);
    $num = floor($num / $get_divider);
    $x += $get_divider == 10 ? 1 : 2;
    if ($amount) {
      $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
      $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
      $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
    } else
      $string[] = null;
  }
  //$implode_to_Rupees = implode('', array_reverse($string));
  return (implode('', array_reverse($string)));
}
?>
<table align="center" width="100%">
  <tr>
    <td colspan="2">
      <table style="width:100%">
        <tr>
          <td width="15%" align="left"><img
              src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;"
              align="left"></td>
          <td width="85%" align="left">
            <h2 style="text-align:left;margin-bottom: 0;">
              <?php echo $temp_details['name']; ?>
            </h2>
            <p style="text-align:left; font-size:16px; margin:5px;">
              <?php echo $temp_details['address1']; ?>, <br>
              <?php echo $temp_details['address2']; ?>,<br>
              <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?><br>
              Tel :
              <?= $temp_details['telephone']; ?>
            </p>
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
    <td colspan="2">
      <h2 style="text-align:center;"> Prasadam Voucher </h2>
    </td>
  </tr>
  <tr>
    <td align="left"><b>Date :</b>
      <?php $date = new DateTime($qry1['date']);
      echo $date->format('d-m-Y'); ?>
    </td>
    <td align="right">
      <p style="text-align:right; line-height:1.7em;"><b>Invoice :</b>
        <?php echo $qry1['ref_no']; ?>
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <table border="1" style="border:1px solid #CCC;" width="100%" align="center">
        <tr>
          <td><b>Prasadam Name </b> </td>
          <td>
            <?php
            if (count($qry1_payfor) > 0) {
              foreach ($qry1_payfor as $qry1_payfor_row) {
                ?>
                <p>
                  <?php echo $qry1_payfor_row['name_eng']; ?>
                </p>
                <?php
              }
            }
            ?>
          </td>
        </tr>
        <tr>
          <td><b>Date </b> </td>
          <td>
            <?php echo date("d-m-Y", strtotime($qry1['date'])); ?>
          </td>
        </tr>
        <tr>
          <td><b>Customer Name </b> </td>
          <td>
            <?php echo $qry1['customer_name']; ?>
          </td>
        </tr>
        <tr>
          <td><b>Amount(RM) </b> </td>
          <td>
            <?php echo number_format($qry1['amount'], '2', '.', ','); ?>
          </td>
        </tr>
        <tr>
          <td><b>Collection Date </b> </td>
          <td>
            <?php echo date("d-m-Y", strtotime($qry1['collection_date'])); ?>
          </td>
        </tr>
        <tr>
          <td><b>Estimated Time </b> </td>
          <td>
            <?php
            if (!empty($qry1['start_time'])) {
              echo date('h:i A', strtotime($qry1['collection_date'] . ' ' . $qry1['start_time']));
            } else {
              echo "";
            }
            ?>
          </td>
        </tr>
        <tr>
          <td><b>Amount In words </b> </td>
          <td>
            <?php echo AmountInWords($qry1['amount']); ?>
          </td>
        </tr>
        <?php if($qry1['payment_type'] == 'partial'){ ?>
        <tr>
          <td><b>Paid Amount </b> </td>
          <td>
            <?php echo number_format($qry1['paid_amount'], '2', '.', ','); ?>
          </td>
        </tr>
        <?= $balance = $qry1['amount'] - $qry1['paid_amount']; ?>
        <tr>
          <td><b>Balance Amount </b> </td>
          <td>
          <?= number_format($balance, 2); ?>
          </td>
        </tr>
        <?php } ?>	
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2"><b>Remarks :</b>
      <?php echo $qry1['desciption']; ?>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Prasadam Agreed By :</td>
    <td>Received By :</td>
  </tr>

</table>
<!-- <p class="dot_line" style="bottom:0;position:relative;margin-top: 100px;">
      <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---------------------------------</span>
    </p> -->
<script>
  window.print();
</script>