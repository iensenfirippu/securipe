<?php
///// Page Logic /////
if (!Login::IsLoggedIn()) { Site::BackToHome(); }

// Make sure that the ID is set and can be loaded accordingly
$id = Site::GetArgumentSafely('id');
$recipe = null;
if ($id == 'new') {
	$recipe = new Recipe();
	$recipe->SetUser(User::Load(Login::GetId()));
} elseif (is_numeric($id)) {
	$recipe = Recipe::Load($id);
}

// Only proceed if the id corresponded to a recipe AND the logged in user is its owner
if (is_a($recipe, 'Recipe')) {
	if (Login::GetId() != $recipe->GetUser()->GetId()) { Site::BackToHome(); }
} else { Site::BackToHome(); }

// Set default values
$types = RecipeType::LoadAll();
$title = $recipe->GetTitle();
$description = $recipe->GetDescription();
$typeid = ($recipe->GetType() != null) ? $recipe->GetType()->GetId() : 1;
$oldimage = null;

// Process the form if it has input
if (Value::SetAndNotNull($_POST, 'submit') && Site::CheckSecurityToken()) {
	// Save base information if the recipe is new
	if ($recipe->GetId() == 0) { $recipe->Create(); }
	
	// Update the rest of the information
	if ($recipe->GetId() != 0) {
		$typeid = Site::GetPostValueSafely("type");
		if ($typeid != null && $type = RecipeType::Load($typeid)) { $recipe->SetType($type); }
		
		// Save/Update picture
		if ($picture = Picture::LoadFileFromField('imagefile')) {
			if ($recipe->GetPicture() != null) { $oldimage = $recipe->GetPicture(); }
			if ($picture->Save()) { $recipe->SetPicture($picture); }
		}
		
		// Set new values and save
		$title = Site::GetPostValueSafely("title");
		$description = Site::GetPostValueSafely("description");
		$public = Value::SetAndNotNull($_POST, 'public');
		$recipe->SetTitle($title);
		$recipe->SetDescription($description);
		$recipe->SetIsPublic($public);
		if ($recipe->Save()) {
			if ($oldimage != null) { $oldimage->Delete(); }
			if (!$recipe->GetIsPublic()) { Site::Redirect('ViewRecipe'.URLPAGEEXT.'?id='.$recipe->GetId()); }
			else { Site::Redirect('MyPage'.URLPAGEEXT); }
		}
	}
}

$public = $recipe->GetIsPublic();
$typeoptions = array();
foreach ($types as $type) { $typeoptions[] = array($type->GetId(), $type->GetName()); }

///// Page Output /////

// Ready strings for output
$page_title = 'Create a recipe';
$page_description = 'Here you can add a recipe to securipe.';
$title_title = 'Recipe title:';
$title_description = 'Description:';
$title_type = 'Type:';
$title_image = 'Image:';
$title_newimage = 'Replace image with:';
$title_public = 'Is public:';

// Include 
include_once('Pages/OnAllPages.php');

$RTK->AddElement(new RTK_Header($page_title));
$RTK->AddElement(new RTK_Textview($page_description));

$form = new RTK_Form('recipeform');
$form->AddTextField('title', $title_title, $title);
$form->AddTextField('description', $title_description, $description, 5);
$form->AddDropDown('type', $title_type, $typeoptions, $typeid);
$form->AddFileUpload('imagefile', ($recipe->GetPicture() == null) ? $title_image : $title_newimage);
if ($recipe->GetId() != 0) { $form->AddCheckBox('public', $title_public, $public); }
$form->AddButton('submit', 'Save changes');
$RTK->AddElement($form);
?>