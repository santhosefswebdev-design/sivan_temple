<?php
include_once './ipay88-master/IPay88.class.php';
$MerchantCode = 'M01236';
$MerchantKey = 'HQgUUZLVzg';
$refno_pay = rand();
$final_amount = '1.00';
$final_amt_str = '1000';
$ipay88 = new IPay88($MerchantCode);
$ipay88->setMerchantKey($MerchantKey);
$ipay88->setField('ApiVersion', '2.0.0');
$ipay88->setField('PaymentId', 16);
$ipay88->setField('RefNo', $refno_pay);
$ipay88->setField('Amount', $final_amount);
$ipay88->setField('Currency', 'MYR');
$ipay88->setField('ProdDesc', 'Booking Details');
$ipay88->setField('UserName', 'Prithivi');
$ipay88->setField('UserEmail', 'prithivitest@gmail.com');
$ipay88->setField('UserContact', '9856734562');
$ipay88->setField('Remark', "Test");
$ipay88->setField('Lang', 'utf-8');
$ipay88->setField('ResponseURL', 'https://templeganesh.grasp.com.my/ipay88/ipay88-master/response.php');
$ipay88->setField('BackendURL', 'https://templeganesh.grasp.com.my/ipay88/ipay88-master/response.php');
$ipay88->generateSignature();

/* $json_data = $data;
$curlAPICall = curl_init();
curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($curlAPICall, CURLOPT_URL, $url);
$result = curl_exec($curlAPICall); */
$ipay88_fields = $ipay88->getFields();
echo '|| ' . $MerchantKey . ' || ' . $MerchantCode . ' || ' . $refno_pay . ' || ' . $final_amt_str . ' || ' . 'MYR ||';
echo '<br>';
echo '||' . $MerchantKey . '||' . $MerchantCode . '||' . $refno_pay . '||' . $final_amt_str . '||' . 'MYR||';
echo '<br>';
echo $MerchantKey . $MerchantCode . $refno_pay . $final_amt_str . 'MYR';
$signature = hash('sha256', '|| ' . $MerchantKey . ' || ' . $MerchantCode . ' || ' . $refno_pay . ' || ' . $final_amt_str . ' || ' . 'MYR ||');
echo $signature;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>iPay88 - Test - Request</title>
</head>

<body>
  <h1>iPay88 payment gateway</h1>

  <?php if (!empty($ipay88_fields)): ?>
    <form action="<?php echo Ipay88::$epayment_url; ?>" method="post">
      <table>
        <?php foreach ($ipay88_fields as $key => $val):
		//if($key != 'Amount' && $key != 'Signature'){
		?>
          <tr>
            <td><label><?php echo $key; ?></label></td>
            <td><input type="text" name="<?php echo $key; ?>" value="<?php echo $val; ?>" /></td>
          </tr>
        <?php
		//} 
		endforeach; ?>
		<?php /* <tr>
            <td><label><?php echo 'Amount'; ?></label></td>
            <td><input type="text" name="Amount" value="<?php echo $final_amount; ?>" /></td>
          </tr>
		  <tr>
            <td><label><?php echo 'Signature'; ?></label></td>
            <td><input type="text" name="Signature" value="<?php echo $signature; ?>" /></td>
          </tr> */ ?>
		<?php /* <tr>
            <td><label>ShippingAddress</label></td>
        </tr>
		<tr>
            <td><label><?php echo 'FirstName'; ?></label></td>
            <td><input type="text" name="ShippingAddress[FirstName]" value="TestSupp" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'FirstName'; ?></label></td>
            <td><input type="text" name="ShippingAddress[FirstName]" value="TestSupp" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'LastName'; ?></label></td>
            <td><input type="text" name="ShippingAddress[LastName]" value="Alpha" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'Address'; ?></label></td>
            <td><input type="text" name="ShippingAddress[Address]" value="J1 Test Block" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'City'; ?></label></td>
            <td><input type="text" name="ShippingAddress[City]" value="Jakarta" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'State'; ?></label></td>
            <td><input type="text" name="ShippingAddress[State]" value="DKI JAKARTA" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'PostalCode'; ?></label></td>
            <td><input type="text" name="ShippingAddress[PostalCode]" value="18800" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'Phone'; ?></label></td>
            <td><input type="text" name="ShippingAddress[Phone]" value="78567456565" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'CountryCode'; ?></label></td>
            <td><input type="text" name="ShippingAddress[CountryCode]" value="1" /></td>
          </tr>
		<tr>
            <td><label>BillingAddress</label></td>
        </tr>
		<tr>
            <td><label><?php echo 'FirstName'; ?></label></td>
            <td><input type="text" name="BillingAddress[FirstName]" value="TestSupp" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'LastName'; ?></label></td>
            <td><input type="text" name="BillingAddress[LastName]" value="Alpha" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'Address'; ?></label></td>
            <td><input type="text" name="BillingAddress[Address]" value="J1 Test Block" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'City'; ?></label></td>
            <td><input type="text" name="BillingAddress[City]" value="Jakarta" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'State'; ?></label></td>
            <td><input type="text" name="BillingAddress[State]" value="DKI JAKARTA" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'PostalCode'; ?></label></td>
            <td><input type="text" name="BillingAddress[PostalCode]" value="18800" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'Phone'; ?></label></td>
            <td><input type="text" name="BillingAddress[Phone]" value="78567456565" /></td>
          </tr>
		<tr>
            <td><label><?php echo 'CountryCode'; ?></label></td>
            <td><input type="text" name="BillingAddress[CountryCode]" value="1" /></td>
         </tr> */ ?>
        <tr>
          <td colspan="2"><input type="submit" value="Submit" name="Submit" /></td>
        </tr>
      </table>
    </form>
  <?php endif; ?>
</body>

</html>