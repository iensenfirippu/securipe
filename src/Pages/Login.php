<?php
// Page Logic
$GLOBALS['LOGIN'] = new Login();
if (Value::SetAndEquals('logout', $_GET, 'action')) { Login::LogOut(); }
if (Login::GetStatus()->GetUsername() == EMPTYSTRING) { Login::TryToLogin(); }

// Page Output
include_once('Pages/OnAllPages.php');
$RTK->AddJavascript('jquery-2.1.4.min.js');
$RTK->AddJavascript('login.js');

if (Login::GetStatus()->GetError() != EMPTYSTRING) { $RTK->AddElement(new RTK_Textview(Login::GetStatus()->GetError())); } 
$loginbox = new RTK_Box('loginbox');
if (Login::GetStatus()->IsLoggedIn()) {
	// If a user is logged in
	$loginbox->AddChild(new RTK_Textview('You are logged in as: '.Login::GetStatus()->GetUsername()));
	$loginbox->AddChild(new RTK_Link('https://'.$_SERVER['HTTP_HOST'].'?action=logout', 'click here for log out'));
} elseif (true) {
	// If a user is not logged in, but the site is running secure
	$loginform = new RTK_Form('loginform', EMPTYSTRING, 'POST');
	$loginform->AddTextField('loginname', 'Username:');
	$loginform->AddPasswordField('loginpass', 'Password:');
	$loginform->AddButton('submit', 'log in');
	$loginbox->AddChild($loginform);
} else {
	// If a user is not logged in, and the site is not running secure
	$loginbox->AddChild(new RTK_Textview('You are not running secure and therefore cannot be allowed to log in.'));
	$loginbox->AddChild(new RTK_Link('https://'.$_SERVER['HTTP_HOST'], 'click here for encrypted login'));
}

$RTK->AddElement($loginbox);
?>