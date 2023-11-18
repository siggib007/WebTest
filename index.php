<?php
	print "<html>\n";
	print "<head>\n";
	print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
	print "<title>PHP Dev main page</title>\n";
	print "</head>\n";
	print "<body>\n";
	print "<center>\n";
	print "<h1>PHP Development, Test and production sites</h1>\n";
	$strURL = $_SERVER["SERVER_NAME"];
	$DocRoot = $_SERVER["DOCUMENT_ROOT"];
	$ServerFQDN = strtoupper(php_uname($mode = "n"));
	$ServerFQDNParts = explode (".",$ServerFQDN);
	$Server = $ServerFQDNParts[0];
	$Protocol = $_SERVER["SERVER_PROTOCOL"];
	$ProtPart = explode('/',$Protocol);
	$OS = PHP_OS;
	$OSName = php_uname($mode = "s");
	$OSRelease = php_uname($mode = "r");
	$OSVersion = php_uname($mode = "v");
	$MachineType = php_uname($mode = "m");
	$phpVersion = phpversion();
	$ApacheVersion = apache_get_version();
	$pos = stripos($ApacheVersion, "php");
	if ($pos === false)
	{
		$ApacheVersion = "$ApacheVersion  and PHP Version $phpVersion";
	}
	print "<p>This PHP Development and Test sites is being hosted on server '$Server' via alias $ProtPart[0]://$strURL/</p>\n";
	print "$Server is running $ApacheVersion.<br>\nThe document directory root is $DocRoot";//.\n";
	print "<p></p>";
	print "<p><a href=\"APIResponse.php\">API Response Tester</a></p>";
	print "<p><a href=\"APITest.php\">API Tester</a></p>";
	print "<p><a href=\"swift.php\">Email Tester</a></p>";
	print "<p><a href=\"swiftsmpt.php\">Email Tester 2</a></p>";
	print "<p><a href=\"test.php\">PHP settings</a></p>";
	print "</center>\n";
	print "</body>\n";
	print "</html>\n";
?>