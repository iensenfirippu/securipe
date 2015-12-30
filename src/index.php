<?php

include_once("Bootstrap.php");


// output
$RTK = new RTK("Securipe");

if (Login::FetchBanStatus()) {
	include_once("Pages/Banned.php");
} else {
	$action = Site::GetArgumentSafely("action");
	if ($action == "logout") { Login::LogOut(); }
	elseif ($action == "login") { include_once("Pages/Login.php"); }
	elseif ($action == "recipe") { include_once("Pages/Recipe.php"); }
	elseif ($action == "mypage") { include_once("Pages/PersonalStartPage.php"); }
	//elseif ($action == "widgettest") { include_once("Pages/Widgets.php"); }
	else { include_once("Pages/Home.php"); }
}


echo $RTK;
// output


Database::Disconnect();
//echo "\n".(microtime(true) - STARTTIME);
?>