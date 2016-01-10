<?php
///// Page Logic /////
if (!Login::IsLoggedIn()) { Site::BackToHome(); }

// Make sure that the ID is set and can be loaded accordingly
$step = null;
if (Value::SetAndNotNull($_GET, 'id')) {
	$id = Site::GetArgumentSafely('id');
	if (is_numeric($id)) {
		$step = RecipeStep::Load($id);
	}
} elseif (Value::SetAndNotNull($_GET, 'recipe')) {
	$id = Site::GetArgumentSafely('recipe');
	if (is_numeric($id)) {
		$step = new RecipeStep();
		$step->SetRecipe(Recipe::Load($id));
	}
}

// Only proceed if the id corresponded to a step AND the logged in user is the owner its recipe
if (is_a($step, 'RecipeStep') && $step->GetRecipe() != null) {
	if (Login::GetId() != $step->GetRecipe()->GetUser()->GetId()) { Site::BackToHome(); }
} else { Site::BackToHome(); }
$step->GetRecipe()->LoadSteps();

// Set default values
$description = $step->GetDescription();
$number = $step->GetNumber();
$steps = sizeof($step->GetRecipe()->GetSteps());
if ($step->GetId() == 0) { $steps += 1; }
$oldimage = null;

// Process the form if it has input
if (Value::SetAndNotNull($_POST, 'submit') && Site::CheckSecurityToken()) {
	// Save base information if the step is new
	if ($step->GetId() == 0) { $step->Create(); }
	
	// Update the rest of the information
	if ($step->GetId() != 0) {
		// Save/Update picture
		if ($picture = Picture::LoadFileFromField('imagefile')) {
			if ($step->GetPicture() != null) { $oldimage = $step->GetPicture(); }
			if ($picture->Save()) { $step->SetPicture($picture); }
		}
		
		// Set new values and save
		$description = Site::GetPostValueSafely("description");
		$step->SetDescription($description);
		
		$number = Site::GetPostValueSafely("number");
		if (is_numeric($number)) { $number = intval($number); }
		else { $number = 1; }
		if ($number > $steps) { $number = $steps; }
		$step->SetNumber($number);
		
		if ($step->Save()) {
			if ($oldimage != null) { $oldimage->Delete(); }
			Site::Redirect('ViewRecipe'.URLPAGEEXT.'?id='.$step->GetRecipe()->GetId());
		}
	}
}

///// Page Output /////

// Ready strings for output
$page_title = 'Create a step for your recipe';
$page_description = 'Here you can add a step to your recipe.';
$title_description = 'Description:';
$title_number = 'Order:';
$title_image = 'Image:';
$title_newimage = 'Replace image with:';

// Include 
include_once('Pages/OnAllPages.php');

$RTK->AddElement(new RTK_Header($page_title));
$RTK->AddElement(new RTK_Textview($page_description));

$form = new RTK_Form('stepform');
$form->AddTextField('description', $title_description, $description, 5);
$form->AddFileUpload('imagefile', ($step->GetPicture() == null) ? $title_image : $title_newimage);
$form->AddDropDown('number', $title_number, range(1, $steps), $number);
$form->AddButton('submit', 'Save changes');
$RTK->AddElement($form);
?>