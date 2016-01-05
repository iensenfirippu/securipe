<?php
define("STARTTIME", microtime(true));
session_start();
define("securipe", true);

// if running from outside "src" folder (i.e. for inclusion in phpunit)
//if (!file_exists("index.php")) { chdir("src"); }

if (file_exists("Config/Config.php")) { include_once("Config/Config.php"); }
include_once("Config/Default.php");

if (DISPLAYERRORS) {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

date_default_timezone_set(TIMEZONE);

// Neatness constants, for often repeated values
define("ZERO",				0);
define("EMPTYSTRING",		"");
define("SINGLESPACE",		" ");
define("SINGLECOMMA",		",");
define("SINGLEDOT",			".");
define("SINGLESLASH",		"/");
define("NEWLINE",			"\n");
define("INDENT",			"\t");
define("COMMASPACE",		SINGLECOMMA.SINGLESPACE);

// Number of seconds in specified interval
define("ONEMINUTE",			60);
define("-ONEMINUTE",		-60);
define("ONEHOUR",			3600);
define("-ONEHOUR",			-3600);
define("ONEDAY",			86400);
define("-ONEDAY",			-86400);
define("ONEWEEK",			604800);
define("-ONEWEEK",			-604800);
define("ONEMONTH",			2592000); // not actually a month but 30 days
define("-ONEMONTH",			-2592000);
define("ONEYEAR",			31536000); // not actually a year but 365 days
define("-ONEYEAR",			-31536000);

// Number of seconds that has passed on the current day
define("TODAYSTIME",	((date('G', STARTTIME) * ONEMINUTE) * ONEMINUTE) +
						(date('i', STARTTIME) * ONEMINUTE) +
						date('s', STARTTIME));

foreach (glob("Classes/Types/*.php") as $datatype) { include_once($datatype); }
include_once("Classes/Functions.php");
include_once("Classes/RTK/RTK.php");
include_once("Classes/Database.php");
include_once("Classes/Login.php");
include_once("Classes/CrudUserDB.php");
include_once("Classes/Image.php");

?>
