<?php
// load all necessary config and class files, etc.
include_once("Bootstrap.php");
$currentpage = Site::GetArgumentSafely("action");

// create the requested page
$RTK = new RTK("Securipe");
if (Login::FetchBanStatus()) {
	include_once("Pages/Banned.php");
} else {
	if ($currentpage == "logout") { Login::LogOut(); }
	elseif ($currentpage == "login") { include_once("Pages/Login.php"); }
	elseif ($currentpage == "recipe") { include_once("Pages/Recipe.php"); }
	elseif ($currentpage == "widgettest") { include_once("Pages/Widgets.php"); }
	else { include_once("Pages/Home.php"); }
}
echo $RTK;

Database::Disconnect();
//echo "\n".(microtime(true) - STARTTIME);
?>