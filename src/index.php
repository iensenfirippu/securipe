<?php
// load all necessary config and class files, etc.
include_once("Bootstrap.php");
$currentpage = Site::GetArgumentSafely("action");

// create the requested page
$RTK = new RTK("Securipe");
if (Login::FetchBanStatus()) {
	include_once("Pages/Banned.php");
} else {
	if ($currentpage == "Logout") { Login::LogOut(); }
	elseif ($currentpage == "Home") { include_once("Pages/Home.php"); }
	elseif ($currentpage == "Login") { include_once("Pages/Login.php"); }
	elseif ($currentpage == "Recipe") { include_once("Pages/Recipe.php"); }
	elseif ($currentpage == "WidgetTest") { include_once("Pages/Widgets.php"); }
	else { Site::BackToHome(); }
}
echo $RTK;

Database::Disconnect();
//echo "\n".(microtime(true) - STARTTIME);
?>