<?php

$CCPostURL = "https://apitest.authorize.net/xml/v1/request.api";
//$CCPostURL = "https://developer.authorize.net/tools/paramdump/index.php";
$MerchantID = '86NT9f9v6';
$MerchantKey = '3yY6n84847eyG2T9';
$refID = 'Mem65-Credit55';
$InvNum = 'ITL6506282034';
$iAmount = 55;
$CardNum = '4012888818888';
$CardExp = '0919';
$strDescr = "Event Membership and credit";
$iMemberID = 65;
$Email = "tester@majorgeek.us";
$Name = "Vaughan Henderson";
$testRequest = FALSE;
$strRemoteIP = $_SERVER["REMOTE_ADDR"];
$bErr = FALSE;

$xmlData = AuthCapXML($refID, $iAmount, $CardNum, $CardExp, $strDescr, $iMemberID, $Email, $Name, $InvNum);
$strXML = $xmlData->asXML();

$Result = SendAuthCap($strXML);

if (array_key_exists('paramdump', $Result))
{

    print "<p>{$Result['paramdump']}</p>\n";
    $bErr=TRUE;
}

if (array_key_exists('error', $Result))
{

    print "<p>Error during authorization: {$Result['error']}</p>\n";
    $bErr=TRUE;
}
if (array_key_exists('CurlErr', $Result))
{

    print "<p>Error with URL operation: {$Result['CurlErr']}</p>\n";
    $bErr=TRUE;
}

if(!$bErr)
{
    switch($Result['responseCode'])
    {
        case 1:
            print "<p><b>Approved</b></p>";
            break;
        case 2:
            print "<p><b>Declined</b></p>";
            break;
        case 3:
            print "<p><b>Error</b></p>";
            break;
        case 4:
            print "<p><b>Held for Review</b></p>";
            break;
        default:
            print "<p><b>unknown response code {$Result['responseCode']}</b></p>";
            break;
    }
    print "<p>{$Result['accountType']} {$Result['accountNumber']}</p>";
    print "<p>RefID: {$Result['refID']}<br>Result: {$Result['resultcode']}<br>";
    print "Transaction ID: {$Result['transid']}<br>AuthCode: {$Result['authcode']}</p>";
}

function SendAuthCap($strXML)
{
    $resultcode ="";
    $url = $GLOBALS['CCPostURL'];
    $pos = strpos($url,"paramdump");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: text/xml'));
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $strXML);

    $data = curl_exec($ch);

    if(curl_errno($ch))
    {
        $ResultArray['CurlErr'] = curl_error($ch);
    }
    else
    {
        curl_close($ch);
        if ($pos===false)
        {
            $xmlResult = @new SimpleXMLElement($data);
            $refID = $xmlResult->refId;
            $ResultArray ['refID'] = $refID;
            $resultcode = $xmlResult->messages->resultCode;
            $ResultArray ['resultcode'] = $resultcode;
        }
        else
        {
           $ResultArray['paramdump'] = $data;
           $resultcode = "paramdump";
        }
    }
    if ($resultcode=="Error")
    {
        if (is_object($xmlResult->transactionResponse->errors->error))
        {
            $ErrCode = $xmlResult->transactionResponse->errors->error->errorCode;
            $Errtext = $xmlResult->transactionResponse->errors->error->errorText;
            $msgcode = $xmlResult->messages->message->code;
            $msgtext = $xmlResult->messages->message->text;
            $ResultArray['error'] = "RefID: $refID ; Result: $resultcode $msgcode $msgtext ; "
                . "Error: $ErrCode : $Errtext";
        }
        else
        {
            $ErrCode = $xmlResult->messages->message->code;
            $Errtext = $xmlResult->messages->message->text;
            $ResultArray['error'] =  "$resultcode $ErrCode : $Errtext";
        }
    }
    if ($resultcode=="Ok")
    {
        $ResultArray['transid'] = $xmlResult->transactionResponse->transId;
        $ResultArray['authcode'] =  $xmlResult->transactionResponse->authCode;
        $ResultArray['accountNumber'] =  $xmlResult->transactionResponse->accountNumber;
        $ResultArray['accountType'] =  $xmlResult->transactionResponse->accountType;
        $ResultArray['responseCode'] =  $xmlResult->transactionResponse->responseCode;
    }
    return $ResultArray;
}

function AuthCapXML($refID, $iAmount,$CardNum,$CardExp, $description, $iMemberID, $Email, $Name,$Invoice)
{
    $MerchantID = $GLOBALS['MerchantID'];
    $MerchantKey = $GLOBALS['MerchantKey'];
    $testRequest = $GLOBALS['testRequest'];
    $IPAddr = $GLOBALS['strRemoteIP'];
    $nameparts = split(" ",$Name);
    $FirstName = $nameparts[0];
    $LastName = $nameparts[count($nameparts)-1];

    $strXML_base = '<?xml version="1.0" encoding="utf-8"?>
    <createTransactionRequest
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"
    >
    </createTransactionRequest>
    ';

    $xmlData = @new SimpleXMLElement($strXML_base);
    $merchant = $xmlData->addchild('merchantAuthentication');
    $merchant->addchild('name',$MerchantID);
    $merchant->addchild('transactionKey',$MerchantKey);
    $xmlData->addchild('refId',$refID);
    $tran = $xmlData->addchild('transactionRequest');
    $tran->addchild('transactionType','authCaptureTransaction');
    $tran->addchild('amount',$iAmount);
    $payment = $tran->addchild('payment');
    $card = $payment->addchild('creditCard');
    $card->addchild('cardNumber',$CardNum);
    $card->addchild('expirationDate',$CardExp);
    $order = $tran->addchild('order');
    $order->addchild('invoiceNumber', $Invoice);
    $order->addchild('description', $description);
    $customer = $tran->addchild('customer');
    $customer->addchild('id',$iMemberID);
    $customer->addchild('email',$Email);
    $BillTo = $tran->addchild('billTo');
    $BillTo->addchild('firstName',$FirstName);
    $BillTo->addchild('lastName',$LastName);
//    $BillTo->addchild('zip',46282);
    $tran->addchild('customerIP',$IPAddr);
    $TranSetting = $tran->addchild('transactionSettings');
    $Setting = $TranSetting->addchild('setting');
    $Setting->addchild("settingName","testRequest");
    $Setting->addchild("settingValue",$testRequest);
    return $xmlData;
}

?>
