<?php
$MerchantCode = "M15137";
$MerchantKey = "Vx7AbhyzGK";
$url = "https://payment.ipay88.com.my/ePayment/WebService/MHGatewayService/GatewayService.svc";
$final_amt = 0.10;
$final_amt_str = '010';
$PaymentId = 'myorder123456';
$signature = hash('sha256', $MerchantKey . $MerchantCode . 'order_' .$PaymentId . $final_amt_str . 'MYR');
$xml_post_string='<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
			<Security xmlns="https://www.mobile88.com">
			  <toEncrypt>string</toEncrypt>
			</Security>
            <Items xmlns="https://www.mobile88.com">
				<Item>
				<Amount>' . $final_amt . '</Amount>
				<MerchantCode>' . $MerchantCode . '</MerchantCode>
				<PaymentId>372</PaymentId>
				<RefNo>' .$PaymentId . '</RefNo>
				<Currency>MYR</Currency>
				<BackendURL>https://rajamariamman.grasp.com.my/ipay88</BackendURL>
				<ProdDesc>Archanai</ProdDesc>
				<Signature>' . $signature . '</Signature>
				<SignatureType>SHA256</SignatureType>
				<UserContact>9856734562</UserContact>
				<UserEmail>prithivitest@gmail.com</UserEmail>
				<UserName>prithivi</UserName>
				</Item>
            </Items>
        </soap:Body>
    </soap:Envelope>';
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
echo $xml_post_string;
die;
$headers = array(
	"Content-Type: text/xml; charset=utf-8",
	"Host: payment.ipay88.com.my",
	"Content-length: ".strlen($xml_post_string),
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
 
echo $response = curl_exec($ch); 
curl_close($ch);