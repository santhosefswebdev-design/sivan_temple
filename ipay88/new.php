<?php
function soap_to_json($soap){
	list($trash,$soap)=explode('',$soap);
	list($soap,$trash)=explode('',$soap);
	unset($trash);
	$soap=str_replace('xmlns="url"','',$soap);

	$result=simplexml_load_string($soap);
	$json_soap=json_encode($result);
	echo $json_soap;
}
$barcode = !empty($_REQUEST['barcode']) ? $_REQUEST['barcode'] : urldecode('00020201021126490014A000000615000101065898360212014107775108030115204000053034585802MY5917GOVINDARAJ+SELVAM6002MY82640362fe1d2be9fd944680b854e2e50bae2314f3f34bcdcf76e59300cab8735c646304DD8A');
$MerchantCode = "M15137";
$MerchantKey = "Vx7AbhyzGK";
$url = "https://payment.ipay88.com.my/ePayment/WebService/MHGatewayService/GatewayService.svc";
$final_amt = 0.10;
// $ref_no = rand();
$final_amt_str = '010';
$ref_no = 'test123fir3255';
$signature = hash('sha256', $MerchantKey . $MerchantCode . $ref_no . $final_amt_str . 'MYR' . $barcode);
/* $soap = '<s:envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:header><activityid correlationid="32662040-b80c-4e74-b6a8-c917782e1111" xmlns="http://schemas.microsoft.com/2004/09/ServiceModel/Diagnostics">00000000-0000-0000-0000-000000000000</activityid></s:header><s:body><entrypagefunctionalityv2response xmlns="https://www.mobile88.com"><entrypagefunctionalityv2result xmlns:a="http://schemas.datacontract.org/2004/07/MHPHGatewayService.Model" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><a:actiontype i:nil="true"><a:amount>0.10</a:amount><a:amountbeforediscount>0.10</a:amountbeforediscount><a:authcode i:nil="true"><a:bankmid i:nil="true"><a:bindcarderrdescc i:nil="true"><a:ccname i:nil="true"><a:ccno i:nil="true"><a:cardtype i:nil="true"><a:currency>MYR</a:currency><a:dccconversionrate i:nil="true"><a:dccstatus>0</a:dccstatus><a:discount>0.00</a:discount><a:errdesc i:nil="true"><a:lang i:nil="true"><a:merchantcode>M15137</a:merchantcode><a:optional><a:originalamount i:nil="true"><a:originalcurrency i:nil="true"><a:paymentid>233</a:paymentid><a:paymenttype i:nil="true"><a:qrcode>https://payment.ipay88.com.my/ePayment/WebService/QR/AliPayOfflineQR/QrAli1698824642.14289-T029585934323.Png</a:qrcode><a:qrvalue>https://qr.alipay.com/bax013506l4ebrlidten30ae</a:qrvalue><a:refno>test123fir2233</a:refno><a:remark>good</a:remark><a:requery i:nil="true"><a:s_bankname i:nil="true"><a:s_country i:nil="true"><a:settlementamount i:nil="true"><a:settlementcurrency i:nil="true"><a:signature>095b90fbbe266f603317092b6bc48ecd928c6a0acf09eb882053455ef4f0cd10</a:signature><a:status>1</a:status><a:tokenid i:nil="true"><a:transid>T029585934323</a:transid><a:xfield1><a:xfield2 i:nil="true"></a:xfield2></a:xfield1></a:tokenid></a:settlementcurrency></a:settlementamount></a:s_country></a:s_bankname></a:requery></a:paymenttype></a:originalcurrency></a:originalamount></a:optional></a:lang></a:errdesc></a:dccconversionrate></a:cardtype></a:ccno></a:ccname></a:bindcarderrdescc></a:bankmid></a:authcode></a:actiontype></entrypagefunctionalityv2result></entrypagefunctionalityv2response></s:body></s:envelope>';
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $soap);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//sBody')[0];
//print_r($body->EntryPageFunctionalityV2Response->EntryPageFunctionalityV2Result->aQRCode);
print_r($xml->sbody->entrypagefunctionalityv2response->entrypagefunctionalityv2result);
print_r($body);
die; */
$xml_post_string='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:mob="https://www.mobile88.com" xmlns:mhp="http://schemas.datacontract.org/2004/07/MHPHGatewayService.Model">
   <soapenv:Header/>
   <soapenv:Body>
      <mob:EntryPageFunctionalityV2>
         <mob:requestModelObj>
            <mhp:Amount>' . $final_amt . '</mhp:Amount>
            <mhp:BackendURL></mhp:BackendURL>
			<mhp:BarcodeNo>' . $barcode .'</mhp:BarcodeNo>
            <mhp:Currency>MYR</mhp:Currency>
            <mhp:MerchantCode>' . $MerchantCode . '</mhp:MerchantCode>
            <mhp:PaymentId>336</mhp:PaymentId>
            <mhp:ProdDesc>Archanai</mhp:ProdDesc>
            <mhp:RefNo>' . $ref_no . '</mhp:RefNo>
            <mhp:Remark>good</mhp:Remark>
            <mhp:Signature>' . $signature . '</mhp:Signature>
            <mhp:SignatureType>SHA256</mhp:SignatureType>
            <mhp:TerminalID></mhp:TerminalID>
            <mhp:UserContact>0179871656</mhp:UserContact>
            <mhp:UserEmail>dd@ipay88.com.my</mhp:UserEmail>
            <mhp:UserName>fira</mhp:UserName>
            <mhp:lang>UTF-8</mhp:lang>
            <mhp:xfield1/>
         </mob:requestModelObj>
      </mob:EntryPageFunctionalityV2>
   </soapenv:Body>
</soapenv:Envelope>';
/* '<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:tns="http://schemas.datacontract.org/2004/07/MHPHGatewayService.Model" elementFormDefault="qualified" targetNamespace="http://schemas.datacontract.org/2004/07/MHPHGatewayService.Model">
<xs:complexType name="ClientRequestModel">
<xs:sequence>
<xs:element minOccurs="0" name="ActionType" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="Amount" value="' . $final_amt . '" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="BackendURL" value="https://rajamariamman.grasp.com.my/ipay88" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="BarcodeNo" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="CCCId" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="CCCOriTokenId" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="CCMonth" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="CCName" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="CCNo" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="CCYear" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="CVV2" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="Currency" value="MYR" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="DiscountedAmount" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="Host" value="payment.ipay88.com.my" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="MTLogId" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="MTVersion" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="MerchantCode" value="' . $MerchantCode . '" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="PaymentId" value="337" type="xs:int"/>
<xs:element minOccurs="0" name="ProdDesc" value="Archanai" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="PromoCode" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="RefNo" value="order_' .$PaymentId . '"nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="Referer" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="Remark" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="Signature" value="' . $signature . '"nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="SignatureType" value="SHA256" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="TerminalID" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="TokenId" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="UserContact" value="9836142084" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="UserEmail" value="prithivitest@gmail.com" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="UserName" value="Prithivi" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="forexRate" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="lang" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="orderTerminalType" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="xfield1" nillable="true" type="xs:string"/>
<xs:element minOccurs="0" name="xfield2" nillable="true" type="xs:string"/>
</xs:sequence>
</xs:complexType>
</xs:schema>'; */
$headers = array(
	"Accept-Encoding: gzip,deflate",
	"Content-Type: text/xml; charset=utf-8",
	"Host: payment.ipay88.com.my",
	"Content-length: ".strlen($xml_post_string),
	"SOAPAction: https://www.mobile88.com/IGatewayService/EntryPageFunctionalityV2"
);
//print_r($headers);

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 
$response = curl_exec($ch);
//print_r($response);
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//sBody')[0];
print_r($body->EntryPageFunctionalityV2Response);
$aQRCode = $body->EntryPageFunctionalityV2Response->EntryPageFunctionalityV2Result[0]->aQRCode;
//echo ($aQRCode);
//print_r($body->EntryPageFunctionalityV2Response->EntryPageFunctionalityV2Result[0]->aQRCode);
if(!empty($aQRCode)) echo '<img src ="' . $aQRCode . '" />';
curl_close($ch);