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
	$loginbox->AddChild(new RTK_Link('?action=logout', 'click here for log out', true));
} elseif (Site::HasHttps()) {
	// If a user is not logged in, but the site is running secure
	$recipeform = new RTK_Form('recipeform', EMPTYSTRING, 'POST');
	$recipeform->AddText('If you would like to create a recipe, fill out all the information below.');
	$recipeform->AddTextField('recipeName', 'Recipe name:');
	$recipeform->AddTextField('description', 'Desciption:');
	$recipeform->AddTextField('recipeType', 'Recipe type:');
	$recipeform->AddTextField('step1', 'Step 1:');
	$recipeform->AddTextField('step2', 'Step 2:');
	$recipeform->AddTextField('step3', 'Step 3:');
	$recipeform->AddButton('submit', 'Submit Recipe');
	$loginbox->AddChild($recipeform);
} else {
	// If a user is not logged in, and the site is not running secure
	$loginbox->AddChild(new RTK_Textview('You are not running secure and therefore cannot be allowed to log in.'));
	$loginbox->AddChild(new RTK_Link('?action=login', 'click here for encrypted login', true));
}

$RTK->AddElement($loginbox);
?>