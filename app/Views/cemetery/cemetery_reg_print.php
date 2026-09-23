<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_SESSION['site_title']; ?></title>
</head>
<style>
table { width:100%; border-collapse:collapse; }
.main { border: 2px solid #152a55; width:100%; page-break-after: always; }
p { text-align:justify; }
h4 { color:#FFFFFF; text-align:center; margin:4px; }
p,h5,h3 { margin:3px; }
.first td { padding-left:5px; padding-right:5px; }
.inline { display:inline; }
.second td { padding-left:0; border:0 !important; }
.second tr { border:0 !important; }
.particular td { border-right:1px solid #152a55; vertical-align:top; }
.particular tr {border-bottom:1px solid #152a55; }
.particular tr:last-child { border-bottom:1px solid #fff; }
</style>
<body>
<table class="main">
<tr><td align="center">
<h3>HINDU CREMATORIUM JOHOR BAHRU</h3>
<h3>ஜோகூர் பாரு இந்து மின்  	சுடலை</h3>
<p style="text-align:center;">LOT 1140, Jalan Kebun Teh, 80250 Johor Bahru</p>
<h5>MANAGED BY ARULMIGU RAJA MARIAMMAN DEVASTHANAM <span style="font-size:14px;">Reg.No.66(Melaka)</span></h5>
<p style="text-align:center;">No.IA, Jalan Ungku Puan, 80000 Johor Bahru</p>
</td></tr>
<tr><td style="background:#152a55">
<h4>APPLICATION TO CREMATE THE BODY OF A DECEASED PERSON<br>மரணம் எய்தவரின்  உடலை தகனம் செய்ய அனுமதி பாரம்</h4>
</td></tr>
<tr><td>
	<table class="first">
    <tr><td style="width:50%; border-right:1px solid #152a55;">
    <p>Time & Date on which it is desired<br>
    to cremate the deceased person</p>
	<p style="font-size:12px">தகனம் செய்ய தீர்மானிக்கப்பட்ட நாள் & நேரம்</p>
	<p>Date/ <span style="font-size:12px">தேதி</span> : <?php echo date('d/m/Y',strtotime($cemetery['date'])); ?></p>
        <table class="second"><tr>
        <td><input style="width:45px; text-align:center;" <?php if($cemetery['slot'] == '1') { echo 'value="&#10004;"';  } ?> ></td>
        <td><input style="width:45px; text-align:center;" <?php if($cemetery['slot'] == '2') { echo 'value="&#10004;"';  } ?> ></td>
        <td><input style="width:45px; text-align:center;" <?php if($cemetery['slot'] == '3') { echo 'value="&#10004;"';  } ?> ></td></tr>
        <tr><td>a.m / <span style="font-size:12px">காலை</span></td>
        <td>p.m / <span style="font-size:12px">மாலை</span></td>
        <td>Day / <span style="font-size:12px">நாள்</span></td></tr>
        </table>
    </td>
    <td style="width:50%">
    <p>For Office Use Only / <span style="font-size:12px">அலுவலகப் பயனுக்கு மட்டும்</span></p>
    <p class="inline">Date/ <span style="font-size:12px">தேதி : </span></p><p class="inline" style="border-bottom:1px dotted #333333; width:120px; position:absolute;">&nbsp; <?php echo date('d/m/Y',strtotime($cemetery['date'])); ?></p>
        <table class="second"><tr><td style="width:70%"><p>Register No / <span style="font-size:12px">பதிவு எண்</span></p></td><td style="width:30%"><input value="<?php echo $cemetery['reg_no']; ?>" style="width:120px;"></td></tr>
        <tr><td><p>Receipt No / <span style="font-size:12px">ரசீது எண்</span></p></td><td><input value="<?php echo $cemetery['receipt_no']; ?>" style="width:120px;"></td></tr>
        </table>
    </td></tr>
    </table>
</td></tr>
<tr><td style="background:#152a55">
<h4>PARTICULARS OF THE DECEASED PERSON TO BE CREMATED<br>மரணம் எய்தவரின் விபரங்கள்</h4>
</td></tr>
<tr><td>
	<table class="first particular">
    <tr><td style="width:30%;" rowspan="3">Name / <span style="font-size:12px">பெயர்</span>
    <p><?php echo $cemetery['name_of_deceased']; ?></p></td>
    <td style="width:8%;" rowspan="3">Race / <span style="font-size:12px">இனம்</span>
    <p><?php echo $cemetery['nationality']; ?></p></td>
    <td style="width:7%;" rowspan="3">Age/<span style="font-size:12px"> வயது </span>
    <p><?php echo $cemetery['age']; ?></p></td>
    <td style="width:7%;">Sex/<span style="font-size:12px">பால்</span></td>
    <td style="width:27%;">NRIC No/<span style="font-size:12px">அடையாள கார்டு எண்</span></td>
    <td style="width:21%;" rowspan="3">Date Of Demised/<span style="font-size:12px">மரணம் எய்திய நாள்</span>
    <p><?php echo date('d/m/Y',strtotime($cemetery['date_of_demise'])); ?></p></td></tr>
    <tr><td>M <?php if($cemetery['sex'] == 'Male') { ?> &#10004; <?php } ?></td>
    <td>New/<span style="font-size:12px">புதிது</span> : <?php echo $cemetery['nric_new']; ?></td></tr>
    <tr><td>F <?php if($cemetery['sex'] == 'Female') { ?> &#10004; <?php } ?></td>
    <td>Old/<span style="font-size:12px">பழைய</span> : <?php echo $cemetery['nric_old']; ?></td></tr>
    <tr><td colspan="2">Address / <span style="font-size:12px">முகவரி</span>
    <p><?php echo $cemetery['address_of_deceased']; ?></p></td>
    <td colspan="3"><p style="text-align:center;">Marital Status/<span style="font-size:12px">திருமண நிலை</span></p>
    	<table class="second"><tr><td style="width:45%;" align="center"><input style="width:45px; text-align:center;" <?php if($cemetery['marital_status'] == 'Married') { echo 'value="&#10004;"';  } ?> > <br>Married/ <span style="font-size:12px">திருமணமான நபர் </span></td>
        <td style="width:10%">&nbsp;</td>
        <td style="width:45%" align="center"><input style="width:45px; text-align:center;" <?php if($cemetery['marital_status'] == 'Single') { echo 'value="&#10004;"';  } ?> ><br>Single/ <span style="font-size:12px">திருமணமாகாத நபர்</span></td></tr></table>
    </td>
    <td>Occupation/<span style="font-size:12px">உத்தியோகம்</span>
    <p><?php echo $cemetery['occupation']; ?></p></td></tr>
    <tr><td colspan="3">Date Certificate No /<span style="font-size:12px">இறந்த பத்திரத்தின் எண்</span>
    <p><?php echo $cemetery['d_certif_no']; ?></p></td>
    <td colspan="2">Issued by / <span style="font-size:12px">கொடுத்தவர்</span>
    <p><?php echo $cemetery['d_certif_issue']; ?></p></td>
    <td>Date of Issue /<span style="font-size:12px">வழங்கப்பட்ட நாள்</span>
    <p><?php echo date('d/m/Y',strtotime($cemetery['d_certif_date'])); ?></p></td></tr>
     <tr><td colspan="3">Burial Certificate No /<span style="font-size:12px">சவ அடக்க பத்திரத்தின் எண்</span>
     <p><?php echo $cemetery['b_certif_no']; ?></p></td>
    <td colspan="2">Issued by / <span style="font-size:12px">கொடுத்தவர்</span>
    <p><?php echo $cemetery['b_certif_issue']; ?></p></td>
    <td>Date of Issue /<span style="font-size:12px">வழங்கப்பட்ட நாள்</span>
    <p><?php echo date('d/m/Y',strtotime($cemetery['b_certif_date'])); ?></p></td></tr>
     <tr><td colspan="6"><p>Note : A certificate of registration of death issued by a Register of Births and Deaths or other approved document authorising the cremation must be submitted with this application.</p>
<p style="font-size:12px"> குறிப்பு : இறப்பு பத்திரமும் மற்றும் அதைச் சார்ந்த மற்ற ஆவணங்களையும் இவ்விண்ணப்பத்துடன் சமர்ப்பிக்க வேண்டும்.</p></td></tr>
    </table>
</td></tr>
<tr><td style="background:#152a55">
<h4>PARTICULARS OF APPLICANT<br />விண்ணப்பம் செய்பவரின் விபரங்கள்</h4>
</td></tr>
<tr><td>
	<table class="first particular">
    <tr><td style="width:40%;">Name / <span style="font-size:12px">பெயர்</span>
    <p><?php echo $cemetery['name_of_applicant']; ?></p></td>
    <td style="width:30%;">NRIC No <br><span style="font-size:12px">அடையாள கார்டு எண்</span></td>
    <td style="width:30%;" rowspan="3">Address / <span style="font-size:12px">முகவரி</span>
    <p><?php echo $cemetery['address_of_applicant']; ?></p></td></tr>
    <tr><td rowspan="2">Contact No/ <span style="font-size:12px">தொடர்பு எண்</span>
    <p><?php echo $cemetery['app_phone']; ?></p></td>
    <td>New/<span style="font-size:12px">புதிது</span> : <?php echo $cemetery['app_nric_new']; ?></td></tr>
    <tr><td>Old/<span style="font-size:12px">பழைய </span> : <?php echo $cemetery['app_nric_old']; ?></td></tr>
    <tr><td>Relationship with deceased person <br><span style="font-size:12px">இறந்த நபருக்கு என்ன உறவு</span>
    <p><?php echo $cemetery['relationship']; ?></p></td>
    <td>whether the applicant is an exetor of the estate of the deceased person<br> <span style="font-size:12px">அல்லது இறந்தவரின் இறுதி சடங்கை நிறைவேற்றுபவரா</span>
    	<table class="second"><tr><td style="width:30%;" align="center"><input style="width:45px; text-align:center;" <?php if($cemetery['exetor_of_estate'] == 'Yes') { echo 'value="&#10004;"';  } ?> ><br>Yes/ <span style="font-size:12px">ஆம்</span></td>
        <td style="width:40%">&nbsp;</td>
        <td style="width:30%" align="center"><input style="width:45px; text-align:center;" <?php if($cemetery['exetor_of_estate'] == 'No') { echo 'value="&#10004;"';  } ?> ><br>No/ <span style="font-size:12px">இல்லை</span></td></tr></table>
    </td>
    <td>Whether the applicant is the nearest surviving relative of the deceased person<br> <span style="font-size:12px">அல்லது இறந்தவரின் நெருங்கிய உறவினரா</span>
    	<table class="second"><tr><td style="width:30%;" align="center"><input style="width:45px; text-align:center;" <?php if($cemetery['nearest_relative'] == 'Yes') { echo 'value="&#10004;"';  } ?> ><br>Yes/ <span style="font-size:12px">ஆம்</span></td>
        <td style="width:40%">&nbsp;</td>
        <td style="width:30%" align="center"><input style="width:45px; text-align:center;" <?php if($cemetery['nearest_relative'] == 'No') { echo 'value="&#10004;"';  } ?> ><br>No/ <span style="font-size:12px">இல்லை</span></td></tr></table>
    </td></tr>
    <tr><td colspan="3"><p>If the applicant is not executor or the nearest surviving relative of the deceased person he or she should state here the reason for making this application</p></td></tr>
    <tr style="border-bottom:0px !important;"><td colspan="3"><p>I hereby apply to have the body of the deceased person name above cremated. I declare to the best of my kowladge the above name deceased person has left no written instruction that  
he/her should not be cremated. I also have not received any objection from the family of the deceased person regarding my above decision.
I undertake to indemnify the management committee against all claims, lost of valuable, demands, proceedings and any expenses thereof which my be made against the management
committee on accepting my application to cremate the deceased.</p>
<p style="font-size:12px"> மேற்கண்ட இறந்தவரின் பிரேதத்தை  தகனம் செய்ய நாள் அனுமதி கோருகிறேன். இதன் மூலம் நான் உறுதிப்படுத்துவது என்னவென்றால், மேற்கண்ட 
 பெயருள்ளவர் தன் இறப்பிற்குப் பிறகு தன் பிரேதத்தை தகனம் செய்யக்கூடாது என்று எந்தவொரு பத்திரத்தையும் விட்டுச் செல்லவில்லை. அதோடு 
 அன்னாரின் குடும்பத்தினரிடமிருந்து எந்தவொரு மறுப்பும் எனக்கு கொடுக்கவில்லை. எல்லாவித நஷ்டங்களும், செலவுகளும், காரியங்களும் மற்றும்  
 இதர செலவுகள் அனைத்திற்கும் நான் பொறுப்பு ஏற்றுக்கொள்கிறேன்.</p></td></tr>
    <tr><td style="border-right:0;"><br><p class="inline">Date/ <span style="font-size:12px">தேதி : </span></p><p class="inline" style="border-bottom:1px dotted #333333; width:120px; position:absolute;">&nbsp; <?php echo date('d/m/Y',strtotime($cemetery['date'])); ?></p></td>
    <td style="border-right:0;"><p style="text-align:center;"><img src="<?php echo $cemetery['signature']; ?>" style="height:50px; width:auto;" /></p><p style="text-align:center;">Signature of Applicant<br><span style="font-size:12px">விண்ணப்பம் செய்பவரின் கையொப்பம்</span></p></td>
    <td style="border-right:0;"><p style="text-align:center;"><?php echo $cemetery['management']; ?></p><p style="text-align:center;">Management<br><span style="font-size:12px">அலுவலகத்தோர்</span></p></td></tr>
    </table>
</td></tr>
<tr><td style="background:#152a55">
<h4>ASH COLLECTION<br>அஸ்தி பெற்றுக்கொள்ளுதல்</h4>
</td></tr>
<tr><td>
	<table class="first" border="0" style="margin-bottom:10px;">
    <tr><td style="width:50%"><p class="inline">Date/ <span style="font-size:12px">தேதி : </span></p><p class="inline" style="border-bottom:1px dotted #333333; width:120px; position:absolute;">&nbsp;<?php echo date('d/m/Y',strtotime($cemetery['ash_collect_dete'])); ?></p></td>
    <td style="width:50%"><p class="inline">Collected by / <span style="font-size:12px">பெற்றுக்கொண்டவர்</span></p><p class="inline" style="border-bottom:1px dotted #333333; position:absolute;">&nbsp;<?php echo $cemetery['ash_collect_by']; ?></p></td></tr>
    <tr><td></td>
    <td><p class="inline">Signature / <span style="font-size:12px">கையொப்பம்</span></p><p class="inline" style="border-bottom:1px dotted #333333; width:120px; position:absolute;">&nbsp; <img src="<?php echo $cemetery['ash_signature']; ?>" style="height:30px; width:auto;" /></p></td></tr>
    <?php $time = date('A',strtotime($cemetery['ash_collect_dete'])); ?>
    <tr><td colspan="2"><p class="inline">Time / <span style="font-size:12px">நேரம்</span>:</p><p class="inline" style="border-bottom:1px dotted #333333; width:55px; position:absolute;">&nbsp;<?php if($time=='AM') echo date('h:i',strtotime($cemetery['ash_collect_dete'])); ?></p>
    <p class="inline" style="margin-left: 60px;">a.m/<span style="font-size:12px">காலை</span></p><p class="inline" style="border-bottom:1px dotted #333333; width:55px; position:absolute;">&nbsp;<?php if($time=='PM') echo date('h:i',strtotime($cemetery['ash_collect_dete'])); ?></p>
    <p class="inline" style="margin-left: 60px;">p.m/<span style="font-size:12px">மாலை</span></p></td></tr>
    </table>
</td></tr>

<?php
$db = \Config\Database::connect();
$check_cemetery_settings = $db->table('cemetery_fee_details')->where('cemetery_id', $cemetery['id'])->get()->getResultArray();
$total_amt = 0.00;
if(count($check_cemetery_settings) > 0)
{
?>
<tr><td style="background:#152a55">
<h4>PAYMENT DETAIL<br>கட்டண விவரம்</h4>
</td></tr>
<tr><td>
<table class="first" border="0" style="margin-bottom:10px;">
<?PHP
    foreach($check_cemetery_settings as $cemesett_row)
    {
        $total_amt = $total_amt + $cemesett_row['fee_amount'];
?>
<tr>
    <td style="width:75%;">
        <?php echo $cemesett_row['fee_text']; ?>
    </td>
    <td style="width:25%;text-align: right;">
        <?php echo $cemesett_row['fee_amount']; ?>
    </td>
</tr>

<?php
    }
?>
<tr>
<td colspan="2"><hr style="border: 1px solid #8080800f;"></td>
</tr>
<tr>
    <td style="text-align:left;font-weight:bold;">TOTAL AMOUNT (RM)</td>
    <td style="text-align: right;font-weight:bold;"><?php echo number_format((float)$total_amt, 2, '.', ''); ?></td>
</tr>
</table>
</td></tr>
<?php
}
?>
</table>


<h3>RULES AND REGULATIONS OF CREMATION</h3>
<p>I hereby request to have the body of (deceased) Mr /Ms / Madam <input type="text" value="<?php echo $cemetery['name_of_applicant']; ?>" style="width:200px; border:0; border-bottom:1px dotted #333333;"> be cremated. I undertake to abide the following Rules and Regulations.</p><br>

<p>1. Casket containing the remains of the deceased shall be wood or other material approved by the Management Committee and shall have no glass or metal grip lining, fastening or other similar attachments or and other form of packing, No explosive items, no metal, no batteries, mechanical items, coconuts or lighters are allowed to be in the casket. Failure to comply with the above requirement may result in the breakdown of the cremator and henceforth further attempts to continue with the cremation my not be successful and the Management Committee shall not be responsible for such failure.</p>

<p>2. The body of the deceased shall be taken to the crematorium's ceremony hall for religious rites, after which the casket shall be sent to be cremated. Family members and others shall be prohibited to enter the Committal room where the cremation is being carried out henceforth</p>

<p>3. The Management Committee shall not be responsible for any delay or inconvenience caused by any breakdown during the course of cremation due to power failure, technical and mechanical fault of the cremator. However the Management Committee shall endeavour to restore in the soonest possible time.</p>

<p>4. The ashes may be collected by the applicant on the next day of the cremation. In the event of ashes being not collected or claimed after fourteen (14) days from the date of cremation, the Management Committee will at his own discretion dispose ofthem in any way that the Management Committee deems reasonable and the Management Committee shall neither be held responsible or nor be obligated in any way to any person concern with the deceased.</p>

<p>5. The Management Committee reserves the sole right to reject the application for cremation without acquiring any reason whatsoever.</p>

<p>6. Keep the crematorium center clean at all times and all comments must be made directly the Management Committee.</p>

<table border="0" style="margin-top:5px;"><tr>
<td style="width:40%" align="left"><p class="inline">Date : </p><p class="inline" style="border-bottom:1px dotted #333333; width:120px; position:absolute;">&nbsp; <?php echo date('d/m/Y',strtotime($cemetery['date'])); ?></p></td>
<td style="width:20%">&nbsp;</td>
<td style="width:40%" align="center"><img src="<?php echo $cemetery['signature']; ?>" style="height:50px; width:auto;" /><br><span style="border-top:1px dotted #333333;">Signature of Applicant</span></td>
</tr></table>
<br>
<h3>மின்சுடலை சட்ட விதிமுறைகள் </h3>
<p style="font-size:12px;">நான், குறிப்பிட்டுள்ள நபரின் பிரேதத்தை (<input value="<?php echo $cemetery['name_of_applicant']; ?>" type="text" style="width:200px; border:0; border-bottom:1px dotted #333333;">) தகனம் செய்ய அனுமதி கோருகிறேன். கீழ்கண்ட எல்லா சட்ட விதிமுறைகளுக்கும் நான் கட்டுப்படுகிறேன்.  </p><br>

<p style="font-size:12px;">1. சவப்பெட்டி பலகையால் நிர்வாகத்தினரால் அனுமதிக்கப்பட்டிருத்தல் வேண்டும். கண்ணாடி இரும்பு போன்றவை பயன்படுத்தப்பட்டிருக்கக்கூடாது. உலோகம், பேட்டரி, மின் பொருட்கள், தேங்காய், தீப்பெட்டியில் அனுமதிக்கப்படாது. மேற்கண்ட பொருட்களை பயன்படுத்தினாலோ அல்லது உபயோகிக்கப்பட்டாலோ அதனால் ஏற்படும் எல்லா தடங்களுக்கும் தாமத்திற்கும் நிர்வாகத்தினர் பொறுப்பேற்கமாட்டார்கள்.</p>

<p style="font-size:12px;">2. இறந்தவரின் உடல் தகனம் செய்வதற்கு முன், தங்கள் சமயத்திற்கு எட்டவாறு இறுதி சடங்குகள் செய்வதற்கு ஓர் அறைக்கு கொண்டு சென்று,  பிறகு தகனம் செய்ய எடுத்துச்செல்லப்படும். இறந்தவரின் குடும்பத்தார் தகன அறைக்குள் அனுமதிக்கப்படமாட்டார்கள்.</p>

<p style="font-size:12px;">3. மின்சார தடையினால் அல்லது மின்பொருள் தடையினால் ஏற்படும் எல்லாவித தாமதத்திற்கும் நிர்வாகத்தினர் பொறுப்பேற்கமாட்டார்கள். இருப்பினும் ஆவன செய்ய நிர்வாகத்தினர் முயற்சி எடுப்பார்கள்.</p>

<p style="font-size:12px;">4. இறந்தவரின் அஸ்தி தகனம் செய்ய மறுநாள் பெற்றுக்கொள்ளலாம். தகனம் செய்த நாளிலிருந்து பதினான்கு நாட்களுக்குப்பிறகு பெற்றுக்கொள்ளப்படாத அஸ்தி நிர்வாகத்தினரால் நியமிக்கப்பட்ட முறையான வழியில் அகற்றப்படும்.</p>

<p style="font-size:12px;">5. கரணங்கள் அறிவிக்காமல் விண்ணப்பங்கள் நிராகரிப்பதற்கு நிர்வாகத்திற்கு எல்லா உரிமையும் உண்டு.</p>

<p style="font-size:12px;">6. தயவு செய்து இவ்விடத்தை எல்லா காலங்களிலும் மிகவும் சுத்தமாக பயன்படுத்த வேண்டுமாய் கேட்டுக்கொள்கிறோம். எல்லா விதமான குறைநிறைகளையும் நிர்வாகம் வாவேர்க்கின்றது.</p>

<table border="0" style="margin-top:5px;"><tr>
<td style="width:40%" align="left"><p class="inline" style="font-size:12px;">திகதி : </p><p class="inline" style="border-bottom:1px dotted #333333; width:120px; position:absolute;">&nbsp; <?php echo date('d/m/Y',strtotime($cemetery['date'])); ?></p></td>
<td style="width:20%">&nbsp;</td>
<td style="width:40%" align="center"><img src="<?php echo $cemetery['signature']; ?>" style="height:50px; width:auto;" /><br><span style="border-top:1px dotted #333333;font-size:12px;">விண்ணப்பதாரரின் கையொப்பம் </span></td>
</tr></table>

<script>
window.print();
</script>

</body>
</html>
