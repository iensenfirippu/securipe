<?php
// Page Logic
if (!Login::IsLoggedIn()) { Site::BackToHome(); }
/*
$id = Site::GetArgumentSafely('id');
$recipe = null;
if ($id == 'new') { $recipe = new Recipe(); }
elseif (is_numeric($id)) { $recipe = Recipe::Load($id); }

if (!is_a($recipe, 'Recipe')) { Site::BackToHome(); }

$types = Recipe::GetTypes();
$title = null;
$description = null;
$typeid = null;
$image = null;

if (Value::SetAndNotNull($_POST, 'submit') && Site::CheckSecurityToken()) {
	$typeid = Site::GetPostValueSafely("type");
	if ($typeid != null) {
		foreach ($types as $type) { if ($type[0] == $typeid) { $recipe->SetType($type); } }
		if ($recipe->GetType() == null) { Site::BackToHome(); }
	}
	
	$image = Site::GetUploadedImage('pffile');
	if ($typeid != null) {
		$image->Save();
	}
	
	$recipe->SetTitle(Site::GetPostValueSafely("title"));
	$recipe->SetDescription(Site::GetPostValueSafely("description"));
	$recipe->SetType($type);
	if (file_exists('Images/'.$image->GetFileName())) {
		$recipe->SetImage($image->GetFileName());
	}
	$recipe->Save();
	
	//Recipe::createRecipe($imagepath, "1", "1", $title, $description, "9001", "0");
}
*/

// Strings
$text_title = "Create a recipe";
$text_description = "Here you can add a recipe to securipe.";
// Page Output

include_once('Pages/OnAllPages.php');

$RTK->AddElement(new RTK_Header($text_title));
$RTK->AddElement(new RTK_Textview($text_description));

$RTK->AddElement(new RTK_Header("Sorry but this form is still under construction, check back later.", 2));

/*$form = new RTK_Form('testform');
$form->AddTextField('title', 'Recipe title:', $recipe->GetTitle());
$form->AddTextField('description', 'Description:', $recipe->GetDescription(), 5);
$form->AddDropDown('type', 'Type:', $types, $recipe->GetType()[0]);
if ($recipe->GetPicture() == null) { $form->AddFileUpload('imagepath', 'Image: '); }
$form->AddButton('submit', 'Save changes');
$RTK->AddElement($form);*/
?>