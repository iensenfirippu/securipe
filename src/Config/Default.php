<?php
if (defined('securipe') or exit(1))
{
	if (!defined("DEBUG"))					define("DEBUG",					false);
	if (!defined("DISPLAYERRORS"))			define("DISPLAYERRORS",			false);
	if (!defined("ONELINEOUTPUT"))			define("ONELINEOUTPUT",			false);
	
	if (!defined("BASEURL"))				define("BASEURL",				"localhost/");
	
	if (!defined("TIMEZONE"))				define("TIMEZONE",				"Asia/Tokyo");
	
	if (!defined("DBVENDOR")) 				define("DBVENDOR",				"mysql");
	if (!defined("DBSERVER")) 				define("DBSERVER",				"localhost");
	if (!defined("DBDATABASE"))				define("DBDATABASE",			"securipe");
	if (!defined("DBUSERNAME"))				define("DBUSERNAME",			"root");
	if (!defined("DBPASSWORD"))				define("DBPASSWORD",			"");
	if (!defined("DBENCODING"))				define("DBENCODING",			"utf8");
	
	if (!defined("MAINTENANCEMODE"))		define("MAINTENANCEMODE",		false);
	if (!defined("MAINTENANCEIP"))			define("MAINTENANCEIP",			"127.0.0.1");
	
	// Visual configurtion:
	if (!defined("PAGINATIONLINKS"))		define("PAGINATIONLINKS",		3);			// amount of page-links in either direction
	if (!defined("PAGINATIONFIRST"))		define("PAGINATIONFIRST",		'&Lt;');	// text on button for: first page
	if (!defined("PAGINATIONLAST"))			define("PAGINATIONLAST",		'&Gt;');	// text on button for: last page
	if (!defined("PAGINATIONPREV"))			define("PAGINATIONPREV",		'&lt;');	// text on button for: previous page
	if (!defined("PAGINATIONNEXT"))			define("PAGINATIONNEXT",		'&gt;');	// text on button for: next page
	if (!defined("PAGINATIONSHOWEMPTY"))	define("PAGINATIONSHOWEMPTY",	false);		// determines weither or not to display an empty pagination 
}
?>
