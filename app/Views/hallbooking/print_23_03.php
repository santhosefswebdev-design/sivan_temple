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

    body {
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    h2 {
        text-align: center;
    }

    .sub_table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        border: none;
        /* Remove border lines */
    }

    .sub_head,
    .sub_row {
        padding: 8px;
        text-align: left;
        border: none;
        /* Remove border lines */
    }

    .signature {
        text-align: right;
        margin-top: 30px;
    }

    .roman-list {
        list-style: none;
        counter-reset: roman-counter;
        padding: 0px;
    }

    .roman-list li {
        margin-bottom: 5px;
    }

    .roman-list li:before {
        content: counter(roman-counter, lower-roman) " ";
        counter-increment: roman-counter;
    }

    .lower-roman {
        list-style: lower-roman;
        margin-left: 20px;
    }
</style>
<!--<h2 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
<p style="text-align:center; font-size:12px; margin:5px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
Tel : <?php echo $_SESSION['telephone']; ?></p>-->

<?php
if ($qry1['status'] == 1) {
    $status = "Booked";
} else if ($qry1['status'] == 2) {
    $status = "Completed";
} else {
    $status = "Cancelled";
}
?>
<table align="center" width="100%">
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
                        <p style="text-align:left; font-size:16px; margin:5px;">
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
            <h2 style="text-align:center;"> HALL BOOKING INVOICE </h2>
        </td>
    </tr>
    <tr>
        <td align="left"><b>Date :</b>
            <?php $date = new DateTime($qry1['entry_date']);
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
                    <td width="20%"><b>Event Details</b> </td>
                    <td width="30%">
                        <?php echo $qry1['event_name']; ?>
                    </td>
                    <td width="20%"><b>Event Date</b> </td>
                    <td width="30%">
                        <?php echo date("d-m-Y", strtotime($qry1['booking_date'])); ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Name </b> </td>
                    <td>
                        <?php echo $qry1['name']; ?>
                    </td>
                    <td><b>Total Amount </b> </td>
                    <td>
                        <?php echo $qry1['total_amount']; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Mobile No</b> </td>
                    <td>
                        <?php echo $qry1['mobile_number']; ?>
                    </td>
                    <td><b>Deposit Amount</b> </td>
                    <td>
                        <?php echo $qry1['paid_amount']; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Register By</b> </td>
                    <td>
                        <?php echo $qry1['register_by']; ?>
                    </td>
                    <td><b>Balance Amount</b> </td>
                    <td>
                        <?php echo $qry1['balance_amount']; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Slot Time</b> </td>
                    <td>
                        <?php
                        if (count($hall_booking_slot_details) > 0) {
                            $i = 0;
                            foreach ($hall_booking_slot_details as $hbsd) {
                                if (!empty ($i))
                                    echo '<br>';
                                echo $hbsd['slot_time'];
                                $i++;
                            }
                        }
                        ?>
                    </td>
                    <td><b>Status</b> </td>
                    <td>
                        <?php echo $status; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <?php
    if (count($pay_details) > 0) {
        ?>
        <tr>
            <td colspan="2">
                <h4 style="text-align:center;"> Payment Details </h4>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="1" style="width:100%" align="center">
                    <tr>
                        <th width="50%" style="text-align:left">Payment Date</th>
                        <th width="50%" style="text-align:left">Amount</th>
                    </tr>
                    <?php
                    foreach ($pay_details as $pbd) {
                        ?>
                        <tr>
                            <td>
                                <?php echo date("d/m/Y", strtotime($pbd['date'])); ?>
                            </td>
                            <td>
                                <?php $total_amount = $pbd['amount'];
                                echo number_format((float) $total_amount, 2, '.', '');
                                ; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </td>
        </tr>
        <?php
    }
    ?>
    <?php
    if (count($hall_booking_details) > 0) {
        ?>
        <tr>
            <td colspan="2">
                <h4 style="text-align:center;"> Package Details </h4>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="1" style="width:100%" align="center">
                    <tr>
                        <td width="30%">Name</td>
                        <td width="50%">Description</td>
                        <td width="20%">Amount</td>
                    </tr>
                    <?php
                    foreach ($hall_booking_details as $hbd) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $hbd['service_name']; ?>
                            </td>
                            <td>
                                <?php echo $hbd['service_description']; ?>
                            </td>
                            <td>
                                <?php $total_amount = $hbd['service_amount'];
                                echo number_format((float) $total_amount, 2, '.', '');
                                ; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="2">
            <p><b>Declaration</b></p>
            <p>
                To the best of my knowledge, this Hall booking emanated from a clean source by virtue of any law. This
                booking is done willingly without any duress purported for the Temple use for whatsoever reason.
                Henceforth.
            </p>
            <!-- Insert the provided terms and conditions here -->

            <div class="container">

                <h4 style="text-align:center;text-decoration: underline;">TERMS AND CONDITIONS FOR THE TEMPLE HALL
                    BOOKING <br>FOR WEDDING EVENT
                </h4>


                <p>I, <span class="name">…………………………………………..</span>, NRIC: <span class="nric">………………….......</span>, of
                    <span>…………</span>
                    <span class="address">……………………………………………………………………………………….........<br>…………............</span>, have
                    read
                    and
                    understood
                    the
                    terms and conditions for temple <br>hall booking as stated herein for the <span
                        class="event">…………………………...........</span> event booked <br>on <span
                        class="event-date">…………………………</span>.
                </p>

                <table class="sub_table">
                    <h3>1. Hall Rental</h3>
                    <tr class="sub_row">
                        <td class="sub_head">Wedding hall</td>
                        <td class="sub_head">RM5,000.00</td>
                    </tr>
                    <tr class="sub_row">
                        <td class="sub_head">Cleaning Fee and disposal of waste</td>
                        <td class="sub_head">RM300.00</td>
                    </tr>
                </table>

                <p>The rental is inclusive of:</p>
                <ul class="roman-list">
                    <li>Thavil & Nadeswaram</li>
                    <li>Gurukal (Priest)</li>
                    <li>Valamaram & Thoranam (Only at temple entrance)</li>
                    <li>3 rela members service for 3 hours</li>
                    <li>Wedding settings</li>
                    <li>350 Chairs without cover for wedding in the hall. Separate charges for the cover.</li>
                    <li>PA system in the hall- Outside PA system strictly not allowed. Only classical and religious
                        music are allowed. Movie songs and other music strictly disallowed.</li>
                    <li>Air conditioner will be switched on 1 (one) hour before the wedding time for the hall.</li>
                    <li>Tables and chairs including covers, outside the hall shall be excluded.</li>
                </ul>

                <p>Read and agreed to the above: <span class=" signature">___________________(signature)</span></p>
            </div>
            <div class="container">



                <h3>2. Payment mode</h3>

                <table>
                    <tr>
                        <td>Hall rental</td>
                        <td>RM5,000</td>
                    </tr>
                    <tr>
                        <td>Cleaning fee</td>
                        <td>RM200</td>
                    </tr>
                    <tr>
                        <td>Disposal of left over foods</td>
                        <td>RM300</td>
                    </tr>
                    <tr>
                        <td colspan="5">-----------------</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>RM5,500</td>
                    </tr>
                    <tr>
                        <td colspan="5">==========</td>
                    </tr>
                </table>

                <p>The above fee shall be paid in full on the day the booking is made either via online banking or bank
                    transfer or temple kiosk and the respective transfer slip shall be forwarded to the Temple as proof
                    so that the wedding date can be locked. Cash payment at the counter is strictly prohibited.</p>

                <h3>3. Refund</h3>

                <ol>
                    <li>
                        For the request in change of date for a booked event, a written notice not later than 30 days
                        from the date of booking must be lodged to the Temple requesting for the change. The Temple may
                        provide another available date, if any. Should the written notice lodged to the Temple more than
                        30 days from the booking date the Temple shall forfeit the RM5,000 paid for the first booking.
                        For the new booking date, additional RM5,000 shall be charged.
                    </li>
                    <li>
                        For the cancellation of the booked event, no refund will be granted and whatsoever monies paid
                        for the hall booking, cleaning services and disposal of waste food shall be forfeited.
                    </li>
                </ol>

                <p>Read and agreed to the above: <span class="signature">___________________(signature)</span></p>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
            <h4 style="text-align:center;">Additional Terms and Conditions</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="container">
                <h3>4. Wedding Time</h3>
                <p>Morning 7am- 12pm. Additional charges of RM200 per hour shall be imposed should exceed 12pm.</p>
                <p>Evening 7pm- 10pm. Additional charges of RM200 per hour shall be imposed should exceed 10pm.</p>
                <p>Any delay in the wedding event due to late start of the event caused by the patron, an additional
                    charge of RM200 per hour shall be imposed should exceed the above stated time.</p>

                <h3>5. Act of God</h3>
                <p>The Temple management cannot be held responsible for any unforeseen disruption or any act of God such
                    as flood, fire, earthquake, pandemic and natural disaster whatsoever. Therefore, no refund
                    whatsoever will be entertained.</p>

                <h3>6. Prohibited items</h3>
                <p>Firecrackers inside the temple, alcohol, smoking, any form of weapons are not allowed.</p>

                <h3>7. Panel suppliers or service providers</h3>
                <p>The patron allowed to appoint any outside service providers other than the temple panel except for
                    the below:-</p>
                <ul>
                    <li><strong>Supplier for Chairs and tables Outside the Hall for dinning food</strong></li>
                    <li>Chairs, tables, canopy and covers for the chairs and the tables outside the hall for dinning
                        food is separately charged and is not inclusive in the package. The temple will provide the
                        contact of the supplier and the price to be discussed directly with the supplier.</li>
                </ul>

                <p>Read and agreed to the above: <span class="signature">___________________(signature)</span></p>
            </div>
        </td>

    </tr>
    <tr>
        <td colspan="2">
            <div class="container">
                <h3>b. Supplier for Inside the Hall</h3>
                <p>Chair covers inside the hall are separately charged and are not inclusive in the package. The temple
                    will provide the contact of the supplier, and the price is to be discussed directly with the
                    supplier.</p>

                <h3>c. Hall Decoration</h3>
                <p>The patron is encouraged to use the temple’s panel for hall decoration. However, outside suppliers
                    are allowed to be used with a payment to the Temple of RM500. The temple will provide the contact of
                    the supplier, and the price is to be discussed directly with the supplier.</p>

                <p>Read and Agreed to the Above Terms & Conditions,</p>
                <p>Signature: ___________________</p>
                <p>Name: ___________________</p>
                <p>NRIC: ___________________</p>
            </div>
        </td>
    </tr>

    <!-- <tr>
        <td colspan="2">&nbsp;</td>
    </tr> -->
    <tr>
        <td> Approved By :</td>
        <td>Received By :</td>
    </tr>

    <tr>
        <td>
            <?php if (!empty ($terms['hall'])) { ?>
                <p>
                    <?php echo $terms['hall']; ?>
                </p>
            <?php } ?>
        </td>
    </tr>


</table>
<script>
    window.print();
</script>