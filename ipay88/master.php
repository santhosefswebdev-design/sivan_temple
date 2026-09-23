<?php
include_once './ipay88-master/IPay88.class.php';
$final_amount = 1.00
$refno_pay = rand();

$ipay88 = new IPay88('M16072');
$ipay88->setMerchantKey('h7kvzkq9r8');
$ipay88->setField('PaymentId', 233);
$ipay88->setField('RefNo', $refno_pay);
$ipay88->setField('Amount', $final_amount);
$ipay88->setField('Currency', 'MYR');
$ipay88->setField('ProdDesc', 'Booking Details');
$ipay88->setField('UserName', 'Prithivi');
$ipay88->setField('UserEmail', 'prithivitest@gmail.com');
$ipay88->setField('UserContact', '9856734562');
$ipay88->setField('Remark', "");
$ipay88->setField('Lang', 'utf-8');
$ipay88->setField('ResponseURL', 'http://templeganesh.grasp.com.my/responseurl');
$ipay88->setField('BackendURL', 'http://templeganesh.grasp.com.my/response');
$ipay88->generateSignature();

$ipay88_fields = $ipay88->getFields();
?>