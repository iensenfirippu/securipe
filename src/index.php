<?php
define(STARTTIME, microtime(true));
session_start();
define("securipe", true);
include_once("Bootstrap.php");


// output
$RTK = new RTK("Securipe");

$action = Site::GetArgumentSafely("action");
if ($action == "login") { include_once("Pages/Login.php"); }
elseif ($action == "somethingelse") { include_once("Pages/SomeOtherPageEntirely.php"); }
else { include_once("Pages/Home.php"); }

echo $RTK;
// output


Database::Disconnect();
//echo "\n".(microtime(true) - STARTTIME);
?>