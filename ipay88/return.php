<?php
$MerchantCode = "M15137";
$MerchantKey = "Vx7AbhyzGK";
$url = "https://payment.ipay88.com.my/ePayment/Webservice/TxInquiryCardDetails/TxDetailsInquiry.asmx";
$final_amt = 0.10;
// $ref_no = rand();
$final_amt_str = '010';
$ref_no = 'test123fir3255';
$signature = hash('sha256', $MerchantKey . $MerchantCode . $ref_no . $final_amt_str . 'MYR');
/* $soap = '<s:envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:header><activityid correlationid="32662040-b80c-4e74-b6a8-c917782e1111" xmlns="http://schemas.microsoft.com/2004/09/ServiceModel/Diagnostics">00000000-0000-0000-0000-000000000000</activityid></s:header><s:body><entrypagefunctionalityv2response xmlns="https://www.mobile88.com"><entrypagefunctionalityv2result xmlns:a="http://schemas.datacontract.org/2004/07/MHPHGatewayService.Model" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><a:actiontype i:nil="true"><a:amount>0.10</a:amount><a:amountbeforediscount>0.10</a:amountbeforediscount><a:authcode i:nil="true"><a:bankmid i:nil="true"><a:bindcarderrdescc i:nil="true"><a:ccname i:nil="true"><a:ccno i:nil="true"><a:cardtype i:nil="true"><a:currency>MYR</a:currency><a:dccconversionrate i:nil="true"><a:dccstatus>0</a:dccstatus><a:discount>0.00</a:discount><a:errdesc i:nil="true"><a:lang i:nil="true"><a:merchantcode>M15137</a:merchantcode><a:optional><a:originalamount i:nil="true"><a:originalcurrency i:nil="true"><a:paymentid>233</a:paymentid><a:paymenttype i:nil="true"><a:qrcode>https://payment.ipay88.com.my/ePayment/WebService/QR/AliPayOfflineQR/QrAli1698824642.14289-T029585934323.Png</a:qrcode><a:qrvalue>https://qr.alipay.com/bax013506l4ebrlidten30ae</a:qrvalue><a:refno>test123fir2233</a:refno><a:remark>good</a:remark><a:requery i:nil="true"><a:s_bankname i:nil="true"><a:s_country i:nil="true"><a:settlementamount i:nil="true"><a:settlementcurrency i:nil="true"><a:signature>095b90fbbe266f603317092b6bc48ecd928c6a0acf09eb882053455ef4f0cd10</a:signature><a:status>1</a:status><a:tokenid i:nil="true"><a:transid>T029585934323</a:transid><a:xfield1><a:xfield2 i:nil="true"></a:xfield2></a:xfield1></a:tokenid></a:settlementcurrency></a:settlementamount></a:s_country></a:s_bankname></a:requery></a:paymenttype></a:originalcurrency></a:originalamount></a:optional></a:lang></a:errdesc></a:dccconversionrate></a:cardtype></a:ccno></a:ccname></a:bindcarderrdescc></a:bankmid></a:authcode></a:actiontype></entrypagefunctionalityv2result></entrypagefunctionalityv2response></s:body></s:envelope>';
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $soap);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//sBody')[0];
//print_r($body->EntryPageFunctionalityV2Response->EntryPageFunctionalityV2Result->aQRCode);
print_r($xml->sbody->entrypagefunctionalityv2response->entrypagefunctionalityv2result);
print_r($body);
die; */
$xml_post_string='<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:web="https://www.mobile88.com/epayment/webservice">
   <soap:Header/>
   <soap:Body>
      <web:TxDetailsInquiryCardInfo>
         <web:MerchantCode>' . $MerchantCode . '</web:MerchantCode>
         <web:ReferenceNo>' . $ref_no . '</web:ReferenceNo>
         <web:Amount>' . $final_amt . '</web:Amount>
         <web:Version>5</web:Version>
      </web:TxDetailsInquiryCardInfo>
   </soap:Body>
</soap:Envelope>';
$headers = array(
	"Accept-Encoding: gzip,deflate",
	"Content-Type: text/xml; charset=utf-8",
	"Host: payment.ipay88.com.my",
	"Content-length: ".strlen($xml_post_string)
);
/* print_r($headers); */

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 
$response = curl_exec($ch);
print_r($response);
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//sBody')[0];
print_r($body);
curl_close($ch);