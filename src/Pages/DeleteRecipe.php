<?php
///// Page Logic /////
if (!Login::IsLoggedIn()) { Site::BackToHome(); }

// Make sure that the ID is set and can be loaded accordingly
$recipe = null;
$owner = false;
if (($id = Site::GetArgumentSafely('id')) && is_numeric($id)) { $recipe = Recipe::Load($id); }

// Only proceed if the id corresponded to a step AND the logged in user is the owner its recipe
if (is_a($recipe, 'Recipe')) {
	$privilege = Login::GetPrivilege();

	// if user is owner
	if ($recipe->GetUser()->GetId() == Login::GetId()) { $owner = true; }
	// if user is admin
	elseif ($privilege == 3) { }
	// if recipe is disabled
	elseif ($recipe->GetDisabled()) { Site::BackToHome(); }
	// if user is moderator
	elseif ($privilege == 2) { }
	else { Site::BackToHome(); }
	
} else { Site::BackToHome(); }

// Process the form if it has input
if (Value::SetAndNotNull($_POST, 'submit') && Site::CheckSecurityToken()) {
	if ($owner || Login::Reauthenticate()) {
		if ($recipe->Delete()) {
			Site::Redirect('MyPage'.URLPAGEEXT);
		}
	}
}

///// Page Output /////

// Ready strings for output
$page_title = 'Are you sure you want to delete?';
$page_description = 'This action cannot be undone at a later point in time, this step will be permanently erased.';

// Include 
include_once('Pages/OnAllPages.php');

$RTK->AddElement(new RTK_Header($page_title));
$RTK->AddElement(new RTK_Textview($page_description));

if ($owner) {
	$form = new RTK_Form('deleterecipeform');
	$form->AddButton('submit', 'Delete Forever');
	$RTK->AddElement($form);
} else {
	$RTK->AddJavascript('/jquery-2.1.4.min.js');
	$RTK->AddJavascript('/login.js');
	$form = new RTK_Form('reathuenticateform');
	$form->AddHiddenField('username', Login::GetUsername());
	$form->AddText('You are about to use godlike abilities and delete another users recipe, please reauthenticate yourself by putting in your password again.');
	$form->AddPasswordField('reauthentication', 'Retype your password: ');
	$form->AddButton('submit', 'Delete Forever');
	$RTK->AddElement($form);
}
?>