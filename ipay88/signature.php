<?php
echo hash('sha256', 'M01230M01230order_12341.00MYR');
die;
try{
	//$apikey = "AQExhmfuXNWTK0Qc+iSGm3I5puqPTYhFHpxGTXFfyXa4nWlGJfnh+XuzwV6dTmmMJv6GnBDBXVsNvuR83LVYjEgiTGAH-09p02SzaBtpvbU0D3ZRFu8cWY44ivj4mqeMXogk0Ogk=-@e*vZIt9AWvaNN:.";
	$MerchantCode = "M01230";
	$url = "https://payment.ipay88.com.my/epayment/testing/testsignature_256.asp";
	$final_amt = 1;
	$PaymentId = rand();
	$data = [
		'MerchantKey' => $$MerchantCode,
		'Amount' => $final_amt,
		'MerchantCode' => $MerchantCode,
		"RefNo"=> "order_".$PaymentId,
		'Currency' => "MYR",
		'Status' => 1,
	];
	$json_data = $data;
	$curlAPICall = curl_init();
	curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($curlAPICall, CURLOPT_URL, $url);
	$result = curl_exec($curlAPICall);
	if($result === false){
		throw new Exception(curl_error($curlAPICall), curl_errno($curlAPICall));
	}
	curl_close($curlAPICall);
	echo 'test';
	echo $result;
	return $result;
}catch(\Exception $e) {
	print_r($e->getMessage());
}
?>