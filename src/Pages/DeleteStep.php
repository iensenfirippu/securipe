<?php
///// Page Logic /////
if (!Login::IsLoggedIn()) { Site::BackToHome(); }

// Make sure that the ID is set and can be loaded accordingly
$step = null;
if (($id = Site::GetArgumentSafely('id')) && is_numeric($id)) { $step = Recipe::Load($id); }

// Only proceed if the id corresponded to a step AND the logged in user is the owner its recipe
if (is_a($step, 'RecipeStep') && $step->GetRecipe() != null) {
	if (Login::GetId() != $step->GetRecipe()->GetUser()->GetId()) { Site::BackToHome(); }
} else { Site::BackToHome(); }

// Process the form if it has input
if (Value::SetAndNotNull($_POST, 'submit') && Site::CheckSecurityToken()) {
	if ($step->Delete()) {
		Site::Redirect('ViewRecipe'.URLPAGEEXT.'?id='.$step->GetRecipe()->GetId());
	}
}

///// Page Output /////

// Ready strings for output
$page_title = 'Are you sure you want to delete?';
$page_description = 'This action cannot be undone at a later point in time, this recipe will be permanently erased.';

// Include 
include_once('Pages/OnAllPages.php');

$RTK->AddElement(new RTK_Header($page_title));
$RTK->AddElement(new RTK_Textview($page_description));

$form = new RTK_Form('deleterecipeform');
$form->AddButton('submit', 'Delete Forever');
$RTK->AddElement($form);
?>