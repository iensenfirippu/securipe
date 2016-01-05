<?php
// Page Logic

	// Make sure that the session variables are set
	if (!Value::SetAndNotNull($_SESSION, LOGIN_USERID)) { Login::SetId(-1); }
	if (!Value::SetAndNotNull($_SESSION, LOGIN_USERNAME)) { Login::SetUsername(EMPTYSTRING); }
	if (!Value::SetAndNotNull($_SESSION, LOGIN_PRIVILEGE)) { Login::SetPrivilege(0); }
	if (!Value::SetAndNotNull($_SESSION, LOGIN_ATTEMPTS)) { Login::SetAttempts(0); }
	if (!Value::SetAndNotNull($GLOBALS, LOGIN_ERROR)) { Login::SetError(EMPTYSTRING); }
	
	// Handle the login
	if (!Login::IsLoggedIn()) { Login::TryToLogin(); }

// Page Output
include_once('Pages/OnAllPages.php');
$RTK->AddJavascript('/jquery-2.1.4.min.js');
$RTK->AddJavascript('/login.js');

if (Login::GetError() != EMPTYSTRING) { $RTK->AddElement(new RTK_Textview(Login::GetError())); } 
$loginbox = new RTK_Box('loginbox');
if (Login::IsLoggedIn()) {
	// If a user is logged in
	$loginbox->AddChild(new RTK_Textview('You are logged in as: '.Login::GetUsername()));
	$loginbox->AddChild(new RTK_Link('logout/', 'click here for log out', true));
	
} elseif (Site::HasHttps()) {
	// If a user is not logged in, but the site is running secure
	$loginform = new RTK_Form('loginform', EMPTYSTRING, 'POST');
	$loginform->AddTextField('recipeName', 'Recipe Name:');
	$loginform->AddTextField('recipeType', 'Recipe Type:');
	$loginform->AddTextField('recipeImagePath', 'Image:');
	$loginform->AddTextField('step1', 'Step 1:');
	$loginform->AddTextField('step1', 'Step image:');
	$loginform->AddTextField('step2', 'Step 2:');
	$loginform->AddTextField('step1', 'Step image:');
	$loginform->AddTextField('step3', 'Step 3:');
	$loginform->AddTextField('step1', 'Step image:');
	$loginform->AddTextField('step4', 'Step 4:');
	$loginform->AddTextField('step1', 'Step image:');
	$loginform->AddTextField('step5', 'Step 5:');
	$loginform->AddTextField('step1', 'Step image:');
	$loginform->AddButton('submit', 'Submit');
	$loginbox->AddChild($loginform);
	
} else {
	// If a user is not logged in, and the site is not running secure
	$loginbox->AddChild(new RTK_Textview('You are not running secure and therefore cannot be allowed to log in.'));
	$loginbox->AddChild(new RTK_Link('login/', 'click here for encrypted login', true));
}

$RTK->AddElement($loginbox);
?>