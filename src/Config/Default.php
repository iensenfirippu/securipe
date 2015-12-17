<?php
if (defined('securipe') or exit(1))
{
	if (!defined("DEBUG"))				define("DEBUG",				false);
	if (!defined("DISPLAYERRORS"))		define("DISPLAYERRORS",		false);
	if (!defined("ONELINEOUTPUT"))		define("ONELINEOUTPUT",		false);
	
	if (!defined("TIMEZONE"))			define("TIMEZONE",			"Asia/Tokyo");
	
	if (!defined("DBVENDOR")) 			define("DBVENDOR",			"mysql");
	if (!defined("DBSERVER")) 			define("DBSERVER",			"localhost");
	if (!defined("DBDATABASE"))			define("DBDATABASE",		"securipe");
	if (!defined("DBUSERNAME"))			define("DBUSERNAME",		"root");
	if (!defined("DBPASSWORD"))			define("DBPASSWORD",		"");
	if (!defined("DBENCODING"))			define("DBENCODING",		"utf8");
	
	if (!defined("MAINTENANCEMODE"))	define("MAINTENANCEMODE",	false);
	if (!defined("MAINTENANCEIP"))		define("MAINTENANCEIP",		"127.0.0.1");
}
?>
