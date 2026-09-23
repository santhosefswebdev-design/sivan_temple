<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cemetery</title>
</head>

<body>
<style>
body { font-size:14px; }
h2, h3, h4 { margin:0px; text-align:center; line-height:1.2em; }
.bottomline{
  border-bottom:1px dotted #333333;
  min-width:100px;
  display:inline-block;
  max-width:700px;
  margin-left:15px;
}
table tr td { padding:0px 0; }
.box { border:2px solid #333333; padding:10px 3px; margin-right:10px; }
.table { border-collapse:collapse; border:1px solid #666666; }
.table tr td { border:1px solid #666666; padding:3px !important; }
.tamil { font-size:12px; }
</style>
<h2 style="text-align:center;">LEMBAGA WAKAF HINDU NEGERI PULAU PINANG </h2>
<h3 style="text-align:center;">பினாங்கு இந்து அறப்பணி வாரியம் </h3>
<h2 style="text-align:center;">PENANG HINDU ENDOWMENTS BOARD</h2>
<h3 style="text-align:center;">Batu Lanchang Cemetery</h3>
<h4 style="margin-top:5px;">விண்ணப்பம் / அனுமதி / ரசீது </h4><h3><u>APPLICATION / PRINT / RECEIPT</u></h3>
<?php //foreach($cemetery as $row) ?>
<table style="width:100%;"> 
<tr><td style="width:70%"></td><td style="width:30%;"><span class="tamil">எண் </span>/ No : <span class="bottomline"> <?php echo $cemetery['num']; ?></span></td></tr>
<tr><td></td><td><span class="tamil">தேதி </span>/ Date : <span class="bottomline"> <?php echo date('d/m/Y',strtotime($cemetery['date'])); ?></span></td></tr>
<tr><td colspan="2"><span class="tamil">இறந்தவரின் பெயர் </span></td></tr>
<tr><td colspan="2">Name of Deceased :<span class="bottomline"> <?php echo $cemetery['name_of_deceased']; ?></span> </td></tr>
<tr><td colspan="2"><span class="tamil">விலாசம்  </span></td></tr>
<tr><td colspan="2">Address :<span class="bottomline"> <?php echo $cemetery['address_of_deceased']; ?></span> </td></tr>
<tr><td colspan="2"> 
    <table style="width:100%;">
    <tr><td style="width:30%;"><span class="tamil">குடியுரிமை </span></td><td style="width:30%;"><span class="tamil">வயது</span> </td>
    <td style="width:30%;"><span class="tamil">இறந்த தேதி </span></td></tr>
    <tr><td>Nationality :<span class="bottomline"> <?php echo $cemetery['nationality']; ?></span></td>
    <td>Age :<span class="bottomline"> <?php echo $cemetery['age']; ?></span> Years</td>
    <td>Date of Demise :<span class="bottomline"> <?php echo date('d/m/Y',strtotime($cemetery['date_of_demise'])); ?></span></td></tr>
    </table>
</td></tr> 
<tr><td colspan="2"> 
    <table style="width:100%;">
    <tr><td style="width:10%"><span class="tamil">ஆண் </span><td style="width:20%"><span class="tamil">பெண்</span></td>
    <td style="width:20%"><span class="tamil">திருமணம் ஆனவர் </span><td style="width:40%"><span class="tamil">ஆகாதவர் </span></td></tr>
    <tr><td style="width:10%"><input name="sex" disabled="disabled" type="radio"<?php if($cemetery['sex'] == 'Male') { echo ' checked="checked"'; } ?> > Male
    <td style="width:20%"><input name="sex" disabled="disabled" type="radio"<?php if($cemetery['sex'] == 'Female') { echo ' checked="checked"'; } ?> > Female</td>
    <td style="width:15%"><input name="marital_status" disabled="disabled" type="radio" <?php if($cemetery['marital_status'] =='Married') { echo ' checked="checked"'; } ?> > Married
    <td style="width:45%"><input name="marital_status" disabled="disabled" type="radio" <?php if($cemetery['marital_status'] == 'Single') { echo ' checked="checked"'; } ?> > Single</td></tr>
    </table>
</td></tr> 
<tr><td colspan="2"><span class="tamil">தகனம் செய்யும் நாள் - நேரம்</span></td></tr>
<tr><td colspan="2">Date/Time for Cremation : <span class="bottomline"> <?php echo date('d/m/Y h:i',strtotime($cemetery['date_for_cremation'])); ?></span> </td></tr>
<tr><td colspan="2">
	<table style="width:100%;">
    <tr><td style="width:50%;"><span class="tamil">புதைக்கும் அனுமதி எண்</span></td><td style="width:50%;"><span class="tamil">இறந்த இடம்  </span></td></tr>
    <tr><td style="width:50%;">Burial Permit Number : <span class="bottomline"> <?php echo $cemetery['burial_no']; ?></span></td>
    <td style="width:50%;">Place of Demise :  <span class="bottomline"> <?php echo $cemetery['place_of_demise']; ?></span></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><span class="tamil">இறப்பு பதிவு இடம் </span></td></tr>
<tr><td colspan="2">Demise Registered at :<span class="bottomline"> <?php echo $cemetery['demise_registered']; ?></span> </td></tr>
<tr><td colspan="2"><span class="tamil">அடக்க ஏற்பாட்டாளர் </span></td></tr>
<tr><td colspan="2">Funeral arrangements entrusted to :<span class="bottomline"> <?php echo $cemetery['funeral_arrangements']; ?></span> </td></tr>
<tr><td colspan="2">
	<table style="width:100%;">
    <tr><td style="width:50%;"><span class="tamil">மனுதாரரின் பெயர் </span></td><td style="width:50%;"><span class="tamil">இறந்தவருக்கு என்ன உறவு </span></td></tr>
    <tr><td style="width:50%;">Name of Applicant : <span class="bottomline"> <?php echo $cemetery['name_of_applicant']; ?></span></td>
    <td style="width:50%;">Relationship of deceased :  <span class="bottomline"> <?php echo $cemetery['relationship']; ?></span></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><span class="tamil">விலாசம்  </span></td></tr>
<tr><td colspan="2">Address : <span class="bottomline"> <?php echo $cemetery['address_of_applicant']; ?></span> </td></tr>
<tr><td colspan="2">
	<table style="width:100%;">
    <tr><td style="width:15%"><span class="tamil">குறிப்பு </span></td>
    <td style="width:85%">1) <span class="tamil">இந்த மனுபாரத்தில் இறந்தவரின் உறவினர் கையொப்பம் இடவேண்டும் </span><br>
    This Application form to be signed by a relative of the deceased.</td></tr>
    <tr><td></td>
    <td>2) <span class="tamil">பிற்பகல் 4.00 மணிக்கு மேல் தகனம் செய்யப்பட்டால் மிகுதிநேர கட்டணம் RM  <span class="bottomline" style="min-width:50px;"> <?php echo $cemetery['overtime_fee']; ?></span>  கொடுக்கவேண்டும் </span><br>
    For Cremation after 4.00 PM overtime fee RM <span class="bottomline"> <?php echo $cemetery['overtime_fee']; ?></span> will be charged.
    </table>
</td></tr>
<tr><td colspan="2">
	<table style="width:100%;">
    <tr><td style="width:55%;"><div class="box"><span class="tamil">செலுத்தப்பட்ட பணம் திரும்ப கொடுக்கப்பட மாட்டாது </span><br>All payment made are non refundable</div></td>
    <td style="width:45%;"><img src="<?php echo $cemetery['signature']; ?>" style="height:50px; width:auto;" />
	<p style="border-bottom:1px dotted #333333; width:100%; margin:0;"></p>
    <span class="tamil"> மனுதாரரின் கையொப்பம் </span>/ Signature of Applicant<br>
    <span class="tamil">அ. கார்டு எண் </span>/ I.C. No : <span class="bottomline"> <?php echo $cemetery['ic_no']; ?></span></td></tr>
    </table>
</td></tr>
<tr><td colspan="2">
	<table class="table" style="width:70% !important; margin:0 auto;">
	<?php
    $db = \Config\Database::connect();
    $check_cemetery_settings = $db->table('cemetery_fee_details')->where('cemetery_id', $cemetery['id'])->get()->getResultArray();
    if(count($check_cemetery_settings) > 0)
    {
        foreach($check_cemetery_settings as $cemesett_row)
        {
    ?>
    <tr>
        <td style="width:75%;">
            <?php echo $cemesett_row['fee_text']; ?>
        </td>
        <td style="width:25%;">
            <?php echo $cemesett_row['fee_amount']; ?>
        </td>
    </tr>
    <?php
        $total += $cemesett_row['fee_amount'];
		} 
    }
	
    ?>
    <tr>
        <td style="width:75%;">
            மொத்தம்  / Total
        </td>
        <td style="width:25%;">
            <?php echo number_format($total, '2','.',','); ?>
        </td>
    </tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>
<tr><td colspan="2"><span class="tamil">அலுவலக உபயோகத்திற்கு மட்டும் </span>/ FOR OFFICE USE ONLY</td></tr>
<tr><td colspan="2"><span class="tamil">மனுபாரம் எண் </span>/ Application No. <span class="bottomline"> </span></td></tr>
<tr><td colspan="2"><span class="tamil">அலுவலக ரசீது எண் </span>/ Official Receipt No.  <span class="bottomline"> </span></td></tr>
<tr><td colspan="2"><span class="tamil">தகனம் தொகை </span>/ Cremation/Burial Fee <span class="bottomline"> </span></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">
	<table style="width:100%;">
    <tr><td style="width:50%;"><span class="tamil">சரிபார்த்தவர் </span>/ Checked by :  <span class="bottomline"> </span></td>
    <td style="width:50%;"><p style="border-bottom:1px dotted #333333; width:100%;"></p> </td></tr>
    <tr><td align="center"><span class="tamil">பொறுப்பாளர்</span> / Clerk in charge</td><td align="center"><span class="tamil">மேல் அதிகாரி /</span> Officer in charge</td></tr>
    </table>
</td></tr>
</table>
<script>
window.print();
</script>
</body>
</html>
