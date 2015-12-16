<?php
define(STARTTIME, microtime(true));
session_start();
define("securipe", true);
include_once("Bootstrap.php");


// output
$output = new RTK("Securipe");
$output->AddStylesheet("style.css");
$output->AddJavascript("jquery-2.1.4.min.js");
$output->AddJavascript("login.js");

$wrapper = new RTK_Box("wrapper");
if (Login::GetStatus()->GetError() != EMPTYSTRING) { $wrapper->AddChild(new RTK_Textview(Login::GetStatus()->GetError())); } 
$wrapper->AddChild(new RTK_LoginForm("loginform"));

$output->AddElement($wrapper);

echo $output;
// output


Database::Disconnect();
//echo "\n".(microtime(true) - STARTTIME);
?>