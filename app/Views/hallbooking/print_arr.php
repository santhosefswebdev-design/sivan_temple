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
	.border_table {
    width: 100%; /* Adjust the width as needed */
    border-collapse: collapse; /* Collapse the border to avoid double lines */
  }

  .border_table, .border_table td {
    border: 1px solid black; /* Add a solid border with a width of 1px and black color */
  }

  .border_table td {
    padding: 8px; /* Add some padding inside the table cells */
    text-align: left; /* Align text to the left; adjust as needed */
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
             <br><br><br><br><br><br>
            <div class="container">

                <h4 style="text-align:center;text-decoration: underline;">TERMS AND CONDITIONS FOR THE TEMPLE HALL BOOKING FOR ARRENGENTHAM/BIRTHDAY
                </h4>
                <p>This rental agreement is made and entered as of date last set forth below, by and between Sree Selva Vinayagar Temple Management, Tepi Sungai and the person then after who is called the HIRER/RENTER, who plays the required booking fee and signs the document.
                </p>

                <table class="sub_table">
                    <h3>1. Hall Rental</h3>
                    <tr class="sub_row">
                        <td class="sub_head">Hall</td>
                        <td class="sub_head">RM 3,000.00</td>
                    </tr>
                    <tr class="sub_row">
                        <td class="sub_head">Security Deposit</td>
                        <td class="sub_head">RM 500.00</td>
                    </tr>
                </table>

                <h5>The rental is inclusive of:</h5>
                <ol type="i">
                    <li>3 Rela members service for 3 hours</li>
                    
					</ol>
					<h5>ii.	Event  settings</h5>
					<ol type="a">
                    
                    <li>350 Chairs without cover for wedding in the hall. Separate charges for the cover.</li>
                    <li>PA system – external PA system strictly not allowed.</li>
                    <li>Air conditioner will be switched on 1 (one) hour before the wedding time for the hall.</li>
                    <li>Tables and chairs including covers, outside the hall shall be excluded.</li>
                
					</ol>
					<div style="text-align: right;">
  <label for="termsRead" style="">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label>
</div>


            </div>
            <div class="container" style="margin-top:-40px";>
				<h3>2. Payment mode</h3>

                <table>
                    <tr>
                        <td>Hall rental</td>
                        <td>RM 3,000</td>
                    </tr>
                    <tr>
                        <td>Security Deposit</td>
                        <td>RM  500</td>
                    </tr>
                    <tr>
                        
                    </tr>
                    <tr>
						<td></td>
                        <td>-----------------</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>RM3,500</td>
                    </tr>
                    <tr>
						<td></td>
                        <td>==========</td>
                    </tr>
                </table>

                <p>The above fee shall be paid in full on the day the booking is made either via online banking or bank
                    transfer or temple kiosk and the respective transfer slip shall be forwarded to the Temple as proof
                    so that the wedding date can be locked. <span style="text-decoration: underline;">Cash payment at the counter is strictly prohibited.</span></p>
					<div style="text-align: right;">
  <label for="termsRead" style="line-height: 48px;">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label>
</div>

                <h3>3. Refund</h3>

                <ol type="i">
                    <li>
                    For the request in change of date for a booked event, a written notice not later than 30 days from the date of booking must be lodged to the Temple requesting for the change. The Temple may provide another available date, if any. Should the written notice lodged to the Temple more than 30 days from the booking date the Temple shall forfeit the RM3,000 paid for the first booking. For the new booking date, additional RM3,000 shall be charged.
                    </li><br>
                    <li>
						For the cancellation of the booked event, no refund will be granted and whatsoever monies paid for the hall booking, cleaning services and disposal of waste food shall be forfeited. 
                    </li>
                </ol>
				<div style="text-align: right;">
  <label for="termsRead" style="line-height: 48px;">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label>
</div>
            </div>
        </td>
    </tr>
   
    <tr>
        <td colspan="2">
            <div class="container" style="margin-top:-40px;">
                <h3>4. Wedding Time</h3>
                <p>Morning 7am- 12pm. Additional charges of RM200 per hour shall be imposed should exceed 12pm.</p>
                <p>Evening 7pm- 10pm. Additional charges of RM200 per hour shall be imposed should exceed 10pm.</p>
                <p>Any delay in the wedding event due to late start of the event caused by the patron,<span style="text-decoration: underline;">an additional
                    charge of RM200 per hour shall be imposed should exceed the above stated time.</span> </p>
					<div style="text-align: right;">
  <label for="termsRead" style="line-height: 48px;">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label>
</div>
                <h3>5. Act of God</h3>
                <p>The Temple management cannot be held responsible for any unforeseen disruption or any act of God such
                    as flood, fire, earthquake, pandemic and natural disaster whatsoever. Therefore, no refund
                    whatsoever will be entertained.</p>

                <h3>6. Prohibited items</h3>
                <p>Firecrackers inside the temple, alcohol, smoking, any form of weapons are not allowed.</p>
              <h3>7.	Rules and Regulation Applied to Refund the Security Deposit</h3>
			  <p>The following rules and regulations are required </p>
			  <ol type="i">
				<li>All activities shall be in keeping with the dignity and respect for the sanctity of a holy place and according to Hindu Traditions. Behaviours in and around the temple facility not conforming to the sanctity of temple, the Hindu traditions and disturbing to the community at large will not be tolerated.</li>
				<li>No alcoholic beverages/smoking/illegal substances allowed. Only vegetarian food to be served on the premises. No food allowed on carpeted areas</li>
				<li>Use of staples and nails are not allowed to décor the rented area. Only use masking tapes that won’t take paint out. All décor should be removed at the end of the event</li>
				<li>
				No footwear inside the hall and temple. Leave all footwear in designated shoe area.
				</li>
				<li>
				 No use of amplified sound/PA system & songs to be played for event.
				</li>
				<li>
				Strictly no outside priest allowed.
				</li>
				<li>
				Photo shooting must be completed within the given grace period of 2 hours. Indecent pose.
				</li>
				<li>
				Air-conditioner and lights will be switched on 1 hour before the event start.
				</li>
				<li>
				 The security deposit RM 500 will be forfeited if the caterers leave the hall or temple sannathi without cleaning the leftover foods including the plastics cups and plates. 
				</li>
				<li>
				  Any other damages to the properties caused by the Deco company will be deducted from the security fees.
				</li>
				<li>
				 The temple management is not liable for any loss of personal properties of the Bride and Bridegroom in their rooms.
				</li>
			  </ol>
			  <div style="text-align: right;">
  <label for="termsRead" style="line-height: 48px;">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label>
</div>
                <h3>8. Panel suppliers or service providers</h3>
                <p>The patron allowed to appoint any outside service providers other than the temple panel <span style="text-decoration: underline;">except for
                    the below:-</span></p>
					<h3>a. Supplier for Chairs and tables Outside the Hall for dinning food</h3>
                <ol type="i">
                    
                   <li>
				   Chairs, tables, canopy and covers for the chairs and the tables Outside/Inside the hall for dinning food is separately charged and is not inclusive in the package. 
				   </li>
				   <li>
				    Chair covers inside the hall is separately charged and is not inclusive in the package.
				   </li>
                </ol>
				<div style="text-align: right;">
  <label for="termsRead" style="line-height: 48px;">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label>
</div>
              
            </div>
        </td>

    </tr>
    <tr>
        <td colspan="2">
            <div class="container" style="margin-top:-40px;">
                <h3>b.	Hall decoration</h3>
                <p>The patron is encouraged to use the temple’s panel for hall decoration.</p>
				<p style="text-decoration: underline;">Optional to select Panel Deco or leave it as blank</p>
				<table class="border_table">
					<tr>
						<td>
						Select Temple In-House Deco Panel – Fine Dream Enterprise
						</td>
						<td>
						<input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
						</td>
						<td>
						SMS to
Mr. Ganesh
0163756753
						</td>
					</tr>
				</table>
				<div style="text-align: right;">
  <label for="termsRead" style="line-height: 48px;">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label></div>
                <h3>c.	Non- Panel Temple Deco</h3>
				<p>In the event if the patron decided to choose the non-panel deco, the following conditions are to be adhered :-</p>
				<ol type="i">
					<li>
					An additional charge of RM 500 will be charged for selecting non-panel deco.
					</li>
					<li>
					The outside deco is required to exercise good behaviour and avoid using abusive language on temple management staff. In the event such incident occurs, the management has the right to blacklist the deco company
					</li>
					<li>
					In the event if non panel deco company is selected, the patron is required to sign off an agreement document of terms and conditions at the temple premise before the decoration is resume.  (*The document can be obtained during the temple office hours)
					</li>
				</ol>
				<div style="text-align: right;">
  <label for="termsRead" style="line-height: 48px;">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label>
</div>

<h3>b.	Hall decoration</h3>
                <p>The patron is encouraged to use the temple’s panel PMP Canopy.</p>
				<p style="text-decoration: underline;">Optional to select 1 (Panel PMP Canopy) or leave it as blank</p>
				<table class="border_table">
					<tr>
						<td>
						Select Temple Panel – PMP Canopy
						</td>
						<td>
						<input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
						</td>
						<td>
						SMS to
Mr. Perashan
0162362895

						</td>
					</tr>
				</table>
				<div style="text-align: right;">
  <label for="termsRead" style="line-height: 48px;">
    Read to the above:
    <input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
  </label></div>
          
			
              <p>
			  I,…………………………………………………NRIC………………………………… ………………of…………………………………………………………………………… …………have read and understood the terms and conditions for temple hall booking as state in for the wedding event booked on ………………...(defaulted booking date)
			  </p>
			  <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
  <tr>
    <td style="padding-bottom:100px;">Read and agreed to the terms and conditions:</td>
  </tr>
  <tr>
    <td>………………</td>
    <td>……………………</td>
  </tr>
  <tr>
    <td>Digital Signature</td>
    <td>Default Booking Date</td>
  </tr>
</table>
<p>Temple Stamp & Signature</p>
<table width="100%">
	<tr>
		<td><img
     src="<?php echo base_url(); ?>/assets/images/President.png?>"
                            style="width:120px;" ></td>
	</tr>
	<tr>
		<td>President</td>
		<td>Secretary</td>
		<td>Treasurer</td>
	</tr>
	<tr>
	<td><img
     src="<?php echo base_url(); ?>/assets/images/selvavinayagar.png?>"
                            style="width:120px;" ></td>
	</tr>
</table>

			</div>
        </td>
    </tr>
	<table class="border_table">
					<tr>
						<td>
						*Note 1: Mandatory Input fields   
						</td>
						<td>
						<input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
						</td>
						
					</tr>
					<tr>
						<td>
						*Note 2 : SMS to temple WhatsApp’s 011-25887114 upon booking completion
						</td>
						<td>
						<input type="checkbox" name="termsRead" id="termsRead" style="width: 24px; height: 24px; vertical-align: middle;">
						</td>
						
					</tr>
				</table>
    <!-- <tr>
        <td colspan="2">&nbsp;</td>
    </tr> -->
	
	<table width="100%">
    <tr>
        <td> Approved By :</td>
        <td>Received By :</td>
    </tr>
	</table>
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