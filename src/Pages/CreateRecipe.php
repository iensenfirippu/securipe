<?php
// Page Logic

if (Value::SetAndNotNull($_POST, 'submit2')) {
	$image = Site::GetUploadedImage('pffile');
}

$text1 = "Here you can add a recipe to securipe.";

// Page Output
include_once('Pages/OnAllPages.php');

$box1 = new RTK_Box(null, 'createrecipe');

$box2 = new RTK_Box(null, 'subtest1');
$box2->AddChild(new RTK_Header("Create a recipe"));
$box2->AddChild(new RTK_Textview($text1, true));
$box2->AddChild(new RTK_Box(null, 'clearfix'));

$box3 = new RTK_Box(null, 'subtest3');

$items = array();
$items[] = array('type_opt_1', 'fisk');
$items[] = array('type_opt_2', 'ost');
$items[] = array('type_opt_3', 'ikkefisk');

$box4 = new RTK_Box(null, 'subtest4');
$form = new RTK_Form('testform');
$form->AddTextField('title', 'Recipe title:');
$form->AddTextField('description', 'Description:', null, 5);
$form->AddDropDown('dropdown', 'daun', $items, $items[2][0]);
$form->AddFileUpload('imagepath', 'Image: ');
$form->AddButton('Submit', 'Submit recipe');
$box4->AddChild($form);
$box4->AddChild(new RTK_Box(null, 'clearfix'));


	
$box1->AddChild($box2);
$box1->AddChild($box3);
$box1->AddChild($box4);

$RTK->AddElement($box1);
$recipeId = "1";

if (Value::SetAndNotNull($_POST, 'Submit')){
	echo "submit works";
	
	$recipe = new Recipe()
	vdd(Site::GetPostValueSafely("imagepath");
	$imagepath = Site::GetPostValueSafely("imagepath");
	$title = Site::GetPostValueSafely("title");
	$description = Site::GetPostValueSafely("description");
	recipe::createRecipe($imagepath, "1", "1", $title, $description, "9001", "0");
	echo "inserted succesfully";
}
?>