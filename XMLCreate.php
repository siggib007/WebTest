<?php
$MerchantID = '86NT9f9v6';
$MerchantKey = '3yY6n84847eyG2T9';
$refID = 'Mem65-Credit85';
$InvNum = 'ITL6506282034';
$iAmount = 85;
$CardNum = '4012888818888';
$CardExp = '0516';
$strDescr = "Event Membership and credit";
$iMemberID = 65;
$Email = "tester@majorgeek.us";
$Name = "Vaughan Henderson";
$testRequest = FALSE;
$strRemoteIP = $_SERVER["REMOTE_ADDR"];
$bErr = FALSE;
$iLength = 1;
$Unit = "months";
$dtNextMonth = date('Y-m-d', strtotime('first day of next month'));
$iMemLen = 3;
$iMembership = 13.50;
$strEmail = "test@majorgeek.us";
$strName = "Joe Diffy ";


//$xmlData = AuthCapXML($refID, $iAmount, $CardNum, $CardExp, $strDescr, $iMemberID, $Email, $Name, $InvNum);
$xmlData = ARBCreateXML($InvNum, $iLength, $Unit, $dtNextMonth, $iMemLen, $iMembership, 0, $CardNum,
                $CardExp, $iCVV, $iZip, "Testing ABR with multiple names", $iMemberID, $strEmail, $strName, $InvNum);

$strXML=$xmlData->asXML();
Header('Content-type: text/xml');
print $strXML;

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

function ARBCreateXML($SubName, $iLength, $Unit, $dtStart, $Count, $iAmount, $iFirst, $CardNum, $CardExp, $iCVV, $iZip, $description, $iMemberID, $Email, $Name, $Invoice)
{
    $MerchantID = $GLOBALS['MerchantID'];
    $MerchantKey = $GLOBALS['MerchantKey'];
    $Name = trim($Name);
    $nameparts = explode(" ",$Name);
    $FirstName = $nameparts[0];
    $LastName = $nameparts[count($nameparts)-1];

    $strXML_base = '<?xml version="1.0" encoding="utf-8"?>
    <ARBCreateSubscriptionRequest
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
    </ARBCreateSubscriptionRequest>
    ';

    $xmlData = @new SimpleXMLElement($strXML_base);
    $merchant = $xmlData->addchild('merchantAuthentication');
    $merchant->addchild('name',$MerchantID);
    $merchant->addchild('transactionKey',$MerchantKey);
    $sub = $xmlData->addchild('subscription');
    $sub->addchild('name',$SubName);
    $Sched = $sub->addchild('paymentSchedule');
    $interval = $Sched->addchild('interval');
    $interval->addchild('length',$iLength);
    $interval->addchild('unit',$Unit);
    $Sched->addchild('startDate',$dtStart);
    $Sched->addchild('totalOccurrences',$Count);
    if ($iFirst>0)
    {
        $Sched->addchild('trialOccurrences',1);
    }
    $sub->addchild('amount',$iAmount);
    if ($iFirst>0)
    {
        $sub->addchild('trialAmount',$iFirst);
    }
    $payment = $sub->addchild('payment');
    $card = $payment->addchild('creditCard');
    $card->addchild('cardNumber',$CardNum);
    $card->addchild('expirationDate',$CardExp);
    $card->addchild('cardCode',$iCVV);
    $order = $sub->addchild('order');
    $order->addchild('invoiceNumber', $Invoice);
    $order->addchild('description', $description);
    $customer = $sub->addchild('customer');
    $customer->addchild('id',$iMemberID);
    $customer->addchild('email',$Email);
    $BillTo = $sub->addchild('billTo');
    $BillTo->addchild('firstName',$FirstName);
    $BillTo->addchild('lastName',$LastName);
    $BillTo->addchild('zip',$iZip);
    return $xmlData;
}


?>
