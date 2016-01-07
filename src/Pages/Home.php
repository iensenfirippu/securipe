<?php
// Page Logic
$home_text = 'Congratulations! You have made it to the front page of our website! Won&apos;t you also please try to log in?';
$home_link = 'Go to the login page.';

$listheaders = array("Recipe Name");
$recipes = Recipe::LoadNewest(50, 0);

// Page Output
include_once('Pages/OnAllPages.php');

$RTK->AddElement(new RTK_Header("Welcome to securipe"));
$RTK->AddElement(new RTK_Textview($home_text));

// Show newest recipies
if (_array::IsLongerThan($recipes, 0)) {
	$list = new RTK_Listview($listheaders);
	foreach ($recipes as $recipe) {
		$link = new RTK_Link('ViewRecipe'.URLPAGEEXT.'?id='.$recipe->GetId(), $recipe->GetTitle());
		$list->AddRow(array($link));
	}
	$RTK->AddElement($list);
}
?>
