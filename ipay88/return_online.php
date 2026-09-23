<?php
include_once './ipay88-master/IPay88.class.php';
$MerchantCode = 'M01230';
$MerchantKey = 'HQgUUZLVzg';
$refno_pay = '780694410';
$final_amount = '1.00';
$ipay88 = new IPay88($MerchantCode);
$ipay88->setMerchantKey($MerchantKey);
$requery_arr = array('MerchantCode' => $MerchantCode, 'RefNo' => $refno_pay, 'Amount' => $final_amount);
$validateResponse = $ipay88->validateResponse($requery_arr);
var_dump($validateResponse);