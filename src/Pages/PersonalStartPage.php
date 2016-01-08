<?php
// Page Logic
if (!Login::IsLoggedIn())
{
	Site::BackToHome();
}

$string_nofavorites = "There are no favorite";
$string_nomyrecipes = "There are no recipes";
$string_nomymessages = "There are no messages";

$edit = new RTK_Link("bleh/","Edit");
$delete = new RTK_Link("ugh/","Delete");

$recipeLink = new RTK_Link('ViewRecipe'.URLPAGEEXT, "Recipe name blablablabla..........test data!");
$createRecipeLink = new RTK_Link('EditRecipe'.URLPAGEEXT.'?id=new', "Create Recipe");
$myRecipes = array();
//$myRecipes[] = array($recipeLink,$edit,$delete);

$favoriteRecipeLink = new RTK_Link("favorite/");
$myFavoriteRecipes = array();

//$myFavoriteRecipes[] = array($favoriteRecipeLink,$delete);

$myMessageLink = new RTK_Link("message/");
$myMessages = array();




// Page Output
include_once('Pages/OnAllPages.php');

// my recipe list
$columnMylist = array("Recipe Name","Edit","Delete");
$mylistTitle = new RTK_Header("My Recipe");
$mylist = new RTK_Listview($columnMylist);
$RTK->AddElement($mylistTitle);
if (sizeof($myRecipes) > 0)
{
	foreach ($myRecipes as $recipe)
	{
		$mylist->AddRow($recipe);
	}
	$RTK->AddElement($mylist);
}else{
	$RTK->AddElement(new RTK_Textview($string_nomyrecipes));
}
$RTK->AddElement($createRecipeLink);

// my favorite recipes
/*$columnMyFavorite = array("Recipe Name","Delete");
$myfavoriteTitle = new RTK_Header("My Favorite");
$RTK->AddElement($myfavoriteTitle);
if (sizeof($myFavoriteRecipes) > 0) {
	$myfavoriteList = new RTK_Listview($columnMyFavorite);
	foreach ($myFavoriteRecipes as $recipe)
	{
		$myfavoriteList->AddRow($recipe);
	}
	$RTK->AddElement($myfavoriteList);
} else {
	$RTK->AddElement(new RTK_Textview($string_nofavorites));
}*/


// my message
/*$columnMyMessage = array("Message Title","Delete");
$myMessageTitle = new RTK_Header("Messages");
$RTK->AddElement($myMessageTitle);
if (sizeof($myMessages) > 0) {
	$myMessageList = new RTK_Listview($columnMyMessage);
	foreach ($myMessages as $message)
	{
		$myMessageList->AddRow($message);
	}
	$RTK->AddElement($myMessageList);
} else {
	$RTK->AddElement(new RTK_Textview($string_nomymessages));
}*/

?>