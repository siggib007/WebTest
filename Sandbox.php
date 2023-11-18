<?php
$CardNum = "5539-7905-3592-8241-5424..=0 ";
//$iCardNum = cleanInt(substr(trim($CardNum),0,20));
$iCardNum = cleanCardnum($CardNum);
print "<p>Card# $iCardNum</p>\n";
date_default_timezone_set('America/Los_Angeles');
$dtFullDate = date('F jS, Y g:i:s A');
print "<p>$dtFullDate</p>\n";
$dateparts=date_parse($dtFullDate);
print "<p>{$dateparts['month']}/{$dateparts['day']}/{$dateparts['year']}</p>\n";
$firstNextMonth = date('F jS Y',mktime(0, 0, 0, $dateparts['month']+1, 1, $dateparts['year']));
print "<p>First of the month is: $firstNextMonth</p>";
$UID = "siggib_ITL";
$PWD = "dgUe4kUSgy4H";
$DBServerName = "localhost";
$DefaultDB = "siggib_ITL";
$dbh= new mysqli ($DBServerName, $UID, $PWD, $DefaultDB);
if ($dbh->connect_errno)
{
    error_log( "Failed to connect to MySQL. Error(" . $dbh->connect_errno . ") " . $dbh->connect_error);
    print "<p>Failed to connect to MySQL. Error(" . $dbh->connect_errno . ") " . $dbh->connect_error. "</p";
}
else
{
    $strQuery = "select now() as a";
    if (!$Result = $dbh->query ($strQuery))
    {
        error_log ('Failed to fetch Configuration data. Error ('. $dbh->errno . ') ' . $dbh->error);
        error_log ($strQuery);
        $DBError="true";
    }
    else
    {
        $Row = $Result->fetch_assoc();
        $dtSQLNow = $Row['a'];
        print "<p>SQL Now: $dtSQLNow</p>\n";
    }
}
$badparam = "txtName=John&txtPhone=8000000000&txtEmail=%3C%0a%0dscript%20a%3D4%3Eqss%3D7%3C%0a%0d%2Fscript%3E&btnSubmit=Submit";
$badparamparts = explode("&",$badparam);
$dtNow = date("Y-m-d H:i:s");
print "<p>PHP Now: $dtNow</p>\n";
//echo date('m', strtotime('November'));
$encode = htmlentities("<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;url=javascript:qss=7\">");
print "<p>encoded:$encode</p>\n";
$InVar = "%3CMETA%20HTTP-EQUIV%3D%22refresh%22%20CONTENT%3D%220%3Burl%3Djavascript%3Aqss%3D7%22%3E&";
$decode = html_entity_decode($InVar);
$decode = urldecode($decode);
print "<p>Decoded:$decode</p>\n";
$InVar = cleanURI($InVar);
print "<p>Cleaned URI: $InVar</p>\n";
foreach ($badparamparts as $val)
{
    $valparts = explode("=", $val);
    $temp = urldecode($valparts[1]);
    $InVar = str_replace("\r","",$temp);
    $InVar = str_replace("\n","",$InVar);
    $clean = strip_tags($InVar);
    print "encoded {$valparts[0]}: {$valparts[1]}<br>\n";
    print "decoded {$valparts[0]}: $temp<br>\n";
    print "trim {$valparts[0]}: $InVar<br>\n";
    print "Clean {$valparts[0]}: $clean<br>\n";
}

$date = DateTime::createFromFormat('F Y', "August 2015");
if (is_object($date))
{
    echo $date->format('F Y');
}
else
{
    echo "Not valid month";
}

$strEmail = "siggi@bjarnason.us";

if (ValidEmail($strEmail))
{
    print "<h1>'$strEmail' is valid</h1>";
}
else
{
    print "<h1>'$strEmail' is totally invalid</h1>";
}

for ($iNum = 1;$iNum<13;$iNum++)
{
    $nMonthobj = DateTime::createFromFormat("n",$iNum);
    $strMonth = $nMonthobj->format('F');
    $strMonthobj = DateTime::createFromFormat("F",$strMonth);
    $iMonth = $strMonthobj->format('n');
    print "<p>$strMonth = $iMonth</p>\n";
}

function ValidEmail($strEmail)
{
    $iAtPos = strpos($strEmail, "@");
    $idotPos = strpos($strEmail,".",$iAtPos);
    if ($iAtPos > 0 and $idotPos > $iAtPos+1)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function cleanURI ($InVar)
{
    $InVar = str_replace("'","",$InVar);
    $InVar = html_entity_decode($InVar);
    $InVar = urldecode($InVar);
    $InVar = CleanReg($InVar);
    $InVar = str_replace(">","",$InVar);
    return str_replace("<","",$InVar);
}
function CleanSQLInput ($InVar)
{
    $InVar = str_replace("\\","",$InVar);
    $InVar = str_replace("'","\'",$InVar);
    return $InVar;
}

function CleanReg ($InVar)
{
    $InVar = strip_tags($InVar);
    $InVar = str_replace("\\","",$InVar);
    $InVar = str_replace("'","\'",$InVar);
    $InVar = str_replace('"',"",$InVar);
    return $InVar;
}

function cleanInt ($InVar)
{
    $InVar = preg_replace("/[^0-9.-]/", "", $InVar);
    return intval($InVar);
}

function cleanCardnum ($InVar)
{
    $InVar = preg_replace("/[^0-9]/", "", $InVar);
    $InVar = substr($InVar, 0, 16);
    return intval($InVar);
}
?>
