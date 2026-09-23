<body>
    <?php $db = db_connect(); ?>
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
    <div style="width: 150mm; font-weight: 600;font-family: monospace;" id="daily_closing">
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

            hr {
                border: none;
                border-top: 1px dashed #000;
                color: #fff;
                background-color: #fff;
                height: 1px;
            }

            #daily_closing {
                color: #000;
                background: #fff;
                padding: 5px;

            }

            .daily_closing_loader {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                height: 100%;
            }

            p {
                font-size: 14px;
                font-family: monospace;
                margin: 0px
            }
        </style>
        <p style="text-align:center;"><img
                src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;"
                align="center"></p>
        <p style="font-size:16px;text-align:center;">
            <?php echo $temp_details['name']; ?>
        </p>
        <p style="text-align:center;">
            <?php echo $temp_details['address1']; ?></br>
            <?php echo $temp_details['address2']; ?></br>
            <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>
            <br>Tel:
            <?= $temp_details['telephone']; ?>
        </p>
        <hr>
        <p style="text-align:center; font-size:13px;text-transform: uppercase;"> ARCHANAI SELLING DETAILS </p>
        <hr>
        <table style="width:100%;">
            <tr>
                <th align="left">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Archanai</p>
                </th>
                <th align="center">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Quantity</p>
                </th>
                <th align="right">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
                </th>
            </tr>
            <?php
            $archanai_total = 0;
            if (count($archanai_details) > 0) {
                foreach ($archanai_details as $archanai_detail) {
                    $archanai_total = $archanai_total + $archanai_detail['amount'];
                    ?>
                            <tr>
                                <td align="left">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
                                        <?php echo $archanai_detail['name_in_english'] . "<br>" . $archanai_detail['name_in_tamil']; ?>
                                    </p>
                                </td>
                                <td align="center">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
                                        <?php echo $archanai_detail['qty']; ?>
                                    </p>
                                </td>
                                <td align="right">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
                                        <?php echo number_format($archanai_detail['amount'], 2); ?>
                                    </p>
                                </td>
                            </tr>
                            <?php
                }
            }
            ?>
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="text-align:left;text-transform: uppercase;font-weight:bold;">SUB-TOTAL</p>
                </td>
                <td align="right">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;">
                        <?php echo number_format($archanai_total, 2); ?>
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <p style="text-align:center; font-size:13px;text-transform: uppercase;"> Hall Booking Details </p>
        <hr>
        <table style="width:100%;">
            <tr>
                <th align="left">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Package Name
                    </p>
                </th>
                <th align="left">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Name</p>
                </th>
                <th align="right">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
                </th>
            </tr>
            <?php
            $hallbooking_total = 0;
            if (count($hallbooking_details) > 0) {
                foreach ($hallbooking_details as $hallbooking_detail) {
                    $hallbooking_total = $hallbooking_total + $hallbooking_detail['paidamount'];
                    ?>
                            <tr>
                                <td align="left">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
                                        <?php echo $hallbooking_detail['package_name']; ?>
                                    </p>
                                </td>
                                <td align="left">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
                                        <?php echo $hallbooking_detail['person_name']; ?>
                                    </p>
                                </td>
                                <td align="right">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
                                        <?php echo number_format($hallbooking_detail['paidamount'], 2); ?>
                                    </p>
                                </td>
                            </tr>
                            <?php
                }
            }
            ?>
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="text-align:left;text-transform: uppercase;font-weight:bold;">SUB-TOTAL</p>
                </td>
                <td align="right">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;">
                        <?php echo number_format($hallbooking_total, 2); ?>
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <p style="text-align:center; font-size:13px;text-transform: uppercase;"> Ubayam Details </p>
        <hr>
        <table style="width:100%;">
            <tr>
                <th align="left">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Type</p>
                </th>
                <th align="left">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Name</p>
                </th>
                <th align="right">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
                </th>
            </tr>
            <?php
            $ubayam_total = 0;
            if (count($ubayam_details) > 0) {
                foreach ($ubayam_details as $ubayam_detail) {
                    $ubayam_total = $ubayam_total + $ubayam_detail['paidamount'];
                    ?>
                            <tr>
                                <td align="left">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
                                        <?php echo $ubayam_detail['package_name']; ?>
                                    </p>
                                </td>
                                <td align="left">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
                                        <?php echo $ubayam_detail['person_name']; ?>
                                    </p>
                                </td>
                                <td align="right">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
                                        <?php echo number_format($ubayam_detail['paidamount'], 2); ?>
                                    </p>
                                </td>
                            </tr>
                            <?php
                }
            }
            ?>
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="text-align:left;text-transform: uppercase;font-weight:bold;">SUB-TOTAL</p>
                </td>
                <td align="right">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;">
                        <?php echo number_format($ubayam_total, 2); ?>
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <p style="text-align:center; font-size:13px;text-transform: uppercase;"> Cash Donation Details</p>
        <hr>
        <table style="width:100%;">
            <tr>
                <th align="left" colspan="2">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Name</p>
                </th>
                <th align="right">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
                </th>
            </tr>
            <?php
            $donation_total = 0;
            if (count($donation_details) > 0) {
                foreach ($donation_details as $donation_detail) {
                    $donation_total = $donation_total + $donation_detail['paidamount'];
                    ?>
                            <tr>
                                <td align="left" colspan="2">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
                                        <?php echo $donation_detail['person_name']; ?>
                                    </p>
                                </td>
                                <td align="right">
                                    <p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
                                        <?php echo number_format($donation_detail['paidamount'], 2); ?>
                                    </p>
                                </td>
                            </tr>
                            <?php
                }
            }
            ?>
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="text-align:left;text-transform: uppercase;font-weight:bold;">SUB-TOTAL</p>
                </td>
                <td align="right">
                    <p style="margin:2px 0px;font-size:11px;font-weight:bold;">
                        <?php echo number_format($donation_total, 2); ?>
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <table style="width:100%;">
            <tr>
                <td align="left" colsapn="2">
                    <p style="text-align:left; font-size:13px;font-weight:bold;text-transform: uppercase;">GRAND TOTAL
                        (RM) </p>
                </td>
                <td align="right">
                    <p style="text-align: right;margin:2px 0px;font-size:13px;font-weight:bold;">
                        <?php
                        $float_cash = $floating_cash['amount'];
                        
                        $total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total - $float_cash;
                        echo number_format($total, '2', '.', ',');
                        ?>
                    </p>
                </td>
                
            </tr>
        </table>

        <hr>
        <br>
        <br>
        <br>
        <br>
        <p class="dot_line"><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p>
    </div>
    <div class="daily_closing_loader">
        <img src="<?php echo base_url(); ?>/assets/images/loader.gif" />
    </div>
    <script>
        //var vConsole = new VConsole();
        function printDiv() {

            var divToPrint = document.getElementById('daily_closing');

            var newWin = window.open('', 'Print-Window');

            newWin.document.open();

            newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

            newWin.document.close();

            setTimeout(function () { newWin.close(); }, 1500);

        }
        $(document).ready(function () {
            $(document).on('click', '#web_print', function () {
                printDiv();
            });
            /* var node = document.getElementById('daily_closing');
            domtoimage.toJpeg(node).then(function (dataUrl) {
                $('#test_img').attr('src', dataUrl);
            }); */
        });
        var IminPrintInstance = new IminPrinter();

        IminPrintInstance.connect().then(async (isConnect) => {
            if (isConnect) {
                $('.daily_closing_loader').hide();
                $('#daily_closing').show();
                console.log(await IminPrintInstance.getPrinterStatus());
                var QrCodeSize;
                //mui('body').on('tap', '#imin_print', async function (e) {
                IminPrintInstance.initPrinter();
                console.log(await IminPrintInstance.getPrinterStatus());
                var node = document.getElementById('daily_closing');
                domtoimage.toJpeg(node).then(function (dataUrl) {
                    IminPrintInstance.printSingleBitmap(dataUrl).then(() => {
                        console.log(' sucess');
                        IminPrintInstance.printAndFeedPaper(100);
                        IminPrintInstance.partialCut();
                        //setTimeout(function(){window.close();}, 1500);
                    });

                });
                //});
            } else {
                alert('error printer');
            }
        });
    </script>
</body>