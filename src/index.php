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
	elseif ($currentpage == "CreateUser") { include_once("Pages/CreateUser.php"); }
	elseif ($currentpage == "Login") { include_once("Pages/Login.php"); }
	elseif ($currentpage == "MyPage") { include_once("Pages/PersonalStartPage.php"); }
	elseif ($currentpage == "ViewRecipe") { include_once("Pages/ViewRecipe.php"); }
	elseif ($currentpage == "EditRecipe") { include_once("Pages/EditRecipe.php"); }
	elseif ($currentpage == "DeleteRecipe") { include_once("Pages/DeleteRecipe.php"); }
	elseif ($currentpage == "EditStep") { include_once("Pages/EditStep.php"); }
	elseif ($currentpage == "DeleteStep") { include_once("Pages/DeleteStep.php"); }
	else { Site::BackToHome(); }
}

echo $RTK;

Database::Disconnect();
//echo "\n".(microtime(true) - STARTTIME);
?>