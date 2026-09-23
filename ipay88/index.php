<?php
try{
	//$apikey = "AQExhmfuXNWTK0Qc+iSGm3I5puqPTYhFHpxGTXFfyXa4nWlGJfnh+XuzwV6dTmmMJv6GnBDBXVsNvuR83LVYjEgiTGAH-09p02SzaBtpvbU0D3ZRFu8cWY44ivj4mqeMXogk0Ogk=-@e*vZIt9AWvaNN:.";
	$MerchantCode = "M01230";
	$url = "https://payment.ipay88.com.my/ePayment/WebService/MHGatewayService/GatewayService.svc";
	$final_amt = 1.00;
	$PaymentId = rand();
	$data = [
		'Amount' => $final_amt,
		'MerchantCode' => $MerchantCode,
		"PaymentId"=> '234',
		"RefNo"=> "order_".$PaymentId,
		'Currency' => "MYR",
		'BackendURL' => 'https://rajamariamman.grasp.com.my/ipay88',
		'ProdDesc' => "Archanai",
		'Signature' => "60d8888af8808f1f2b59e9892ae7e23aac41902530072e4f9d3bb3da1cb95a59",
		'SignatureType' => "SHA256",
		'UserContact' => "9856734562",
		'UserEmail' => "prithivitest@gmail.com",
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