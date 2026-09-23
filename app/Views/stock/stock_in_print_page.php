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

    .inner_table tr:nth-child(even) {
        background: #F3F3F3;
    }

    .inner_table tr:last-child {
        background: #e2dfdf;
    }

    .table tr th,
    .table tr td {
        text-align: center;
    }

    table td {
        padding: 5px;
        line-height: 1.5em;
    }
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
            $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
       ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
       ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
        } else
            $string[] = null;
    }
    $implode_to_Rupees = implode('', array_reverse($string));
    /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
    " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
    $get_paise = ($amount_after_decimal > 0) ? "and " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Cents' : '';
    //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    return ($implode_to_Rupees ? 'Ringgit ' . $implode_to_Rupees : '') . $get_paise . ' Only';
}
?>
<table align="center" style="width: 100%;">
    <tr>
        <td colspan="2">
            <table style="width:100%">
                <tr>
                    <td width="15%" align="left"><img
                            src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
                            style="width:120px;" align="left"></td>
                    <td width="85%" align="left">
                        <h2 style="text-align:left;margin-bottom: 0;">
                            <?php echo $_SESSION['site_title']; ?>
                        </h2>
                        <p style="text-align:left; font-size:16px; margin:5px 0px;">
                            <?php echo $_SESSION['address1']; ?>, <br>
                            <?php echo $_SESSION['address2']; ?>,<br>
                            <?php echo $_SESSION['city']; ?> -
                            <?php echo $_SESSION['postcode']; ?><br>
                            Tel :
                            <?php echo $_SESSION['telephone']; ?>
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
            <h3 style="text-align: center; text-transform: uppercase;">Stock Inward</h3>
        </td>
    </tr>


    <tr>
        <td colspan="2">
            <table style="width:100%;" border="1">
                <tr>
                    <td width="40%" rowspan="3">
                        Staff name :
                        <?php echo $data['name']; ?><br>
                        <?php
                        if (!empty($data['address1']) || !empty($data['address2'])) {
                            echo $data['address1'] . ", " . $data['address2'] . "<br>";
                        }
                        if (!empty($data['city'])) {
                            echo $data['city'] . "<br>";
                        }
                        ?>
                        Mobile :
                        <?php echo !empty($data['mobile_no']) ? $data['mobile_no'] : ""; ?>
                    </td>
                    <td width="30%" rowspan="2">Delivery To : <br><span style="text-transform: uppercase;">
                            <?php echo $_SESSION['site_title']; ?>
                        </span></td>
                    <td width="30%">STOCK INWARD</td>
                </tr>

                <tr>
                    <td>Date :
                        <?php echo $data['date']; ?>
                    </td>
                </tr>

                <tr>
                    <td>Person Incharge:<br>
                        <?php echo $data['name']; ?>
                    </td>
                    <td>REF. NO:<br>
                        <?php echo $data['invoice_no']; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table border="1" align="center" width="100%">
                <tr>
                    <td>SNO</td>
                    <td>TYPE</td>
                    <td>ITEM</td>
                    <td align="center">UOM</td>
                    <td align="right">PRICE</td>
                    <td align="right">QTY</td>
                    <td align="right">AMOUNT [RM]</td>
                </tr>
                <?php
                $total = 0;
                $i = 1;
                foreach ($sto as $row) { ?>
                    <tr>
                        <td>
                            <?php echo $i++; ?>
                        </td>
                        <td>
                            <?php
                            if ($row['item_type'] == 1) {
                                echo "Product";
                            } else if ($row['item_type'] == 2) {
                                echo "Raw Material";
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $row['item_name']; ?>
                        </td>
                        <td align="center">
                            <?php echo $row['symbol']; ?>
                        </td>
                        <td align="right">
                            <?php echo number_format($row['rate'], '2', '.', ','); ?>
                        </td>
                        <td align="right">
                            <?php echo $row['quantity']; ?>
                        </td>
                        <td align="right">
                            <?php echo number_format($row['amount'], '2', '.', ','); ?>
                        </td>
                    </tr>
                    <?php $gtotal = $total += $row['amount'];
                } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table style="width:100%;">
                <tr>
                    <td width="70%"><b>Amount In Words : <br>
                            <?php if ($gtotal == '') {
                                echo "Zero";
                            } else {
                                echo AmountInWords($gtotal);
                            } ?>
                        </b> <br></td>
                    <td width="30%" align="right"><b>Item Amount :</b> <span style="text-align:right;">
                            <?= number_format((float) $total, 2, '.', ''); ?>
                        </span></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <p style="border-bottom:1px dashed #000000; width:200px;"></p>SIGNATURE OF SUPPLIER
                    </td>
                    <td align="right">
                        <p style="border-bottom:1px dashed #000000; width:200px;"></p>AUTHORISED SIGNATURE
                    </td>
                </tr>
            </table>
            <!-- <p class="dot_line" style="bottom:0;position:relative;margin-top: 100px;">
      <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---------------------------------</span>
    </p> -->
        </td>
    </tr>

</table>

<script>
    window.print();
</script>