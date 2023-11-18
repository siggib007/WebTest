<?php
	if (isset($_GET['rc']))
	{
	    $iResponse = intval($_GET['rc']);
	}
	else
	{
	    $iResponse=0;
	}
	// Response texts from https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
	// and http://php.net/manual/en/function.http-response-code.php
    switch ($iResponse) {
        case 100: $text = 'Continue'; break;
        case 101: $text = 'Switching Protocols'; break;
        case 102: $text = 'Processing'; break;
        case 200: $text = 'OK'; break;
        case 201: $text = 'Created'; break;
        case 202: $text = 'Accepted'; break;
        case 203: $text = 'Non-Authoritative Information'; break;
        case 204: $text = 'No Content'; break;
        case 205: $text = 'Reset Content'; break;
        case 206: $text = 'Partial Content'; break;
        case 207: $text = 'Multi-Status'; break;
        case 208: $text = 'Already Reported'; break;
        case 226: $text = 'IM Used'; break;
        case 300: $text = 'Multiple Choices'; break;
        case 301: $text = 'Moved Permanently'; break;
        case 302: $text = 'Found'; break;
        case 303: $text = 'See Other'; break;
        case 304: $text = 'Not Modified'; break;
        case 305: $text = 'Use Proxy'; break;
        case 306: $text = 'Switch Proxy'; break;
        case 307: $text = 'Temporarily Redirect'; break;
        case 308: $text = 'Permanently Redirect'; break;
        case 400: $text = 'Bad Request'; break;
        case 401: $text = 'Unauthorized'; break;
        case 402: $text = 'Payment Required'; break;
        case 403: $text = 'Forbidden'; break;
        case 404: $text = 'Not Found'; break;
        case 405: $text = 'Method Not Allowed'; break;
        case 406: $text = 'Not Acceptable'; break;
        case 407: $text = 'Proxy Authentication Required'; break;
        case 408: $text = 'Request Time-out'; break;
        case 409: $text = 'Conflict'; break;
        case 410: $text = 'Gone'; break;
        case 411: $text = 'Length Required'; break;
        case 412: $text = 'Precondition Failed'; break;
        case 413: $text = 'Request Entity Too Large'; break;
        case 414: $text = 'Request-URI Too Large'; break;
        case 415: $text = 'Unsupported Media Type'; break;
        case 416: $text = 'Range Not Satisfiable'; break;
        case 417: $text = 'Expectation Failed'; break;
        case 418: $text = 'I am a teapot'; break;
        case 421: $text = 'Misdirected Request'; break;
        case 422: $text = 'Unprocessable Entity'; break;
        case 423: $text = 'Locked'; break;
        case 424: $text = 'Failed Dependency'; break;
        case 426: $text = 'Upgrade Required'; break;
        case 428: $text = 'Precondition Required'; break;
        case 429: $text = 'Too Many Requests'; break;
        case 431: $text = 'Request Header Fields Too Large'; break;
        case 451: $text = 'Unavailable For Legal Reasons '; break;
        case 500: $text = 'Internal Server Error'; break;
        case 501: $text = 'Not Implemented'; break;
        case 502: $text = 'Bad Gateway'; break;
        case 503: $text = 'Service Unavailable'; break;
        case 504: $text = 'Gateway Time-out'; break;
        case 505: $text = 'HTTP Version not supported'; break;
        case 506: $text = 'Variant Also Negotiates'; break;
        case 507: $text = 'Insufficient Storage'; break;
        case 508: $text = 'Loop Detected'; break;
        case 510: $text = 'Not Extended'; break;
        case 511: $text = 'Network Authentication Required'; break;
        //Unoffical Codes, No RFC backing but common use
        case 0:   $text = 'No Code';
        case 103: $text = 'Checkpoint'; break;
        case 419: $text = 'I am a fox'; break;
        case 420: $text = 'Enhance Your Calm'; break;
        case 450: $text = 'Blocked by Parental Controls'; break;
        case 498: $text = 'Invalid Token'; break;
        case 499: $text = 'Request has been forbidden by antivirus '; break;
        case 509: $text = 'Bandwidth Limit Exceeded'; break;
        case 530: $text = 'Site is frozen'; break;
        case 598: $text = 'Network read timeout error'; break;
        case 599: $text = 'Network connect timeout error'; break;
        case 440: $text = 'Login Time-out'; break;
        case 449: $text = 'Retry with ...'; break;
        case 551: $text = 'Exchange Activesync Redirect'; break;
        case 444: $text = 'No Response'; break;
        case 495: $text = 'SSL Cert Error'; break;
        case 496: $text = 'SSL Cert Required'; break;
        case 497: $text = 'HTTP Request sent to HTTPS port'; break;
        case 499: $text = 'Client Closed Request'; break;
        case 520: $text = 'Unknown Error'; break;
        case 521: $text = 'Web Server Is Down'; break;
        case 522: $text = 'Connection Timed Out'; break;
        case 523: $text = 'Origin Is Unreachable'; break;
        case 524: $text = 'A Timeout Occurred'; break;
        case 525: $text = 'SSL Handshake Failed'; break;
        case 526: $text = 'Invalid SSL Certificate'; break;
        case 527: $text = 'Railgun Error'; break;
        default:  $text = 'Random Status Code'; break;
    }
	if (isset($_GET['sleep']))
	{
	    $iSleep = intval($_GET['sleep']);
	}
	else
	{
	    $iSleep=0;
	}
	if ($iSleep>0)
	{
		sleep($iSleep);
	}
	$PageName = basename($_SERVER['PHP_SELF']);
	$PagebaseName = basename($_SERVER['PHP_SELF'],".php");
	$strURL = $_SERVER["SERVER_NAME"];
	$strURI = $_SERVER["REQUEST_URI"];
    $strURIParts = explode('/',$strURI);
    $HowMany = count($strURIParts);
    $LastIndex = $HowMany - 2;
    $strPath = $strURIParts[$LastIndex];
	$PageURL = $strURL."/".$PageName;
	$Protocol = $_SERVER['SERVER_PROTOCOL'];
	if ($iResponse > 200 and $iResponse < 1000 and $iResponse!=0)
	{
		header("$Protocol $iResponse $text");
	}
	print "<html>\n";
	print "<head>\n";
	print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
	print "<title>API Response Tester</title>\n";
	print "</head>\n";
	print "<body>\n";
	print "<center>\n";
	print "<p><h1>Welcome to API Response Tester</h1></p>\n";
	if ($iResponse!=0)
	{
		if ($iResponse < 200 or $iResponse>999)
		{
			print "<h3>You asked for Response Code $iResponse.".
					" Response codes less than 200 or greater than 999 are not supported</h3>\n";
		}
		else
		{
			print "<h2>This is a test with a response code of $iResponse </h2>\n";
		}
	}
	if ($iSleep>0)
	{
		print "<h2>As requested I took a $iSleep second nap</h2>\n";
	}

	print "</center>\n";
	print "Protocol:$Protocol<br>\n";
	print "URI:$strURI<br>\n";
	print "URI Parts:<br>\n";
	foreach ($strURIParts as $part)
	{
		print "$part<br>\n";
	}
	print "<p>\n";
	print "This page will allow you test your code for abnormal responses from API calls, ";
	print "such as wrong format, slow response, or response codes (aka error codes) ";
	print "such as HTTP 418 :-D<br>\n";
	print "Please contact s@supergeek.us with any questions, comments and complients. ";
	print "If there is demand for it I may implement a feature you can provide ";
	print "the response you want to receive. ";
	print "</p>\n";
	print "Options:<br>\n";
	print "$PageURL?rc=234<br>\n";
	print " - sets the HTTP response code to 234, any number between 200 and 999 supported<br>\n";
	print "<p>$PageURL?sleep=234<br>\n";
	print " - sleeps for 234 seconds before responding</p>\n";
	print "These can of course be chained together as $PageURL?sleep=234&rc=234 etc.";
	print "<p></p>\n";
	print "</body>\n";
	print "</html>\n";
?>