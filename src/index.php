<?php
include_once("Bootstrap.php");


// output
$RTK = new RTK("Securipe");

$action = Site::GetArgumentSafely("action");
if (_string::IsOneOf(array("login", "logout"), $action)) { include_once("Pages/Login.php"); }
elseif ($action == "recipe") { include_once("Pages/Recipe.php"); }
elseif ($action == "somethingelse") { include_once("Pages/SomeOtherPageEntirely.php"); }
elseif ($action == "createrecipe") { include_once("Pages/createrecipe.php"); }
else { include_once("Pages/Home.php"); }

echo $RTK;
// output


Database::Disconnect();
//echo "\n".(microtime(true) - STARTTIME);
?>