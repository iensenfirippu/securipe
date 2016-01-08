<?php
if (defined('securipe') or exit(1))
{	
	define("DEBUG",				true);
	define("DISPLAYERRORS",		true);
	define("ONELINEOUTPUT",		false);
	
	//define("BASEURL",			'localhost/');
	
	define("TIMEZONE",			"Europe/Copenhagen");
	
	//define("DBVENDOR",			"mysql");
	//define("DBSERVER",			"localhost");
	define("DBDATABASE",		"securipe");
	define("DBUSERNAME",		"securipe");
	define("DBPASSWORD",		"");
	//define("DBENCODING",		"utf8");

	//define("MAINTENANCEMODE",	false);
	//define("MAINTENANCEIP",		"127.0.0.1");
}
?>
