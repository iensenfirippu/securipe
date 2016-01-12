<?php
///// Page Logic /////
if (!Login::IsLoggedIn()) { Site::BackToHome(); }

$user = User::Load(Login::GetId());
$recipetypes = RecipeType::LoadAll();
$recipes = Recipe::LoadForUser($user, 50, 0);
//$favorites = Recipe::LoadFavoritesForUser($myuser, 50, 0);
//$messages = Message::LoadForUser($myuser, 50, 0);

///// Page Output /////

// Strings
$title_recipes = "My Recipes";
$headers_recipes = array("Title", "Type", "Is public", "_", "_", "_");
$text_editecipe = "Edit";
$text_viewrecipe = "View";
$text_editsteps = "Edit steps";
$text_deleterecipe = "Delete";
$text_newrecipe = "Create Recipe";
$string_norecipes = "There are no recipes";

/*$title_favorites = "My Recipes";
$headers_favorites = array("Title", "By");
$string_nofavorites = "There are no favorite";*/

/*$title_messages = "My Recipes";
$headers_messages = array("Title", "From", "Time", "_");
$text_replymessage = "Reply";
$string_nomessages = "There are no messages";*/

// Page layout
include_once('Pages/OnAllPages.php');

// Show a list of the users recipes
$RTK->AddElement(new RTK_Header($title_recipes));
$myrecipes = new RTK_Listview($headers_recipes);
if ($recipes != false) {
	foreach ($recipes as $recipe) {
		if (is_a($recipe, 'Recipe')) {
			$myrecipes->AddRow(array(
				$recipe->GetTitle(),
				$recipe->GetType()->GetName(),
				_bool::Display($recipe->GetIsPublic()),
				new RTK_Link('ViewRecipe'.URLPAGEEXT.'?id='.$recipe->GetId(), $text_viewrecipe),
				new RTK_Link('EditRecipe'.URLPAGEEXT.'?id='.$recipe->GetId(), $text_editecipe),
				new RTK_Link('DeleteRecipe'.URLPAGEEXT.'?id='.$recipe->GetId(), $text_deleterecipe)
			));
		}
	}
	$RTK->AddElement($myrecipes);
} else {
	$RTK->AddElement(new RTK_Textview($string_norecipes));
}
$RTK->AddElement(new RTK_Link('EditRecipe'.URLPAGEEXT.'?id=new', $text_newrecipe));

// Show a list of the users favorite recipes
/*$RTK->AddElement(new RTK_Header($title_favorites));
$myfavorites = new RTK_Listview($headers_favorites);
if (sizeof($favorites) > 0) {
	foreach ($favorites as $recipe) {
		if (is_a($recipe, 'Recipe')) {
			$myfavorites->AddRow(array(
				new RTK_Link('ViewRecipe'.URLPAGEEXT.'?id='.$recipe->GetId(), $recipe->GetTitle()),
				$recipe->GetUser()->GetUsername()
			));
		}
	}
	$RTK->AddElement($myfavorites);
} else {
	$RTK->AddElement(new RTK_Textview($string_nofavorites));
}*/

// Show a list of the users messages
/*$RTK->AddElement(new RTK_Header($title_messages));
$mymessages = new RTK_Listview($headers_messagess);
if (sizeof($messages) > 0) {
	foreach ($messages as $message) {
		if (is_a($message, 'Message')) {
			$mymessages->AddRow(array(
				new RTK_Link('ViewMessage'.URLPAGEEXT.'?id='.$message->GetId(), $recipe->GetTitle()),
				$messgae->GetRecipient()->GetUsername(),
				$messgae->GetTimestamp(),
				new RTK_Link('DeleteRecipe'.URLPAGEEXT.'?id='.$recipe->GetId(), $text_delete)
			));
		}
	}
	$RTK->AddElement($mymessages);
} else {
	$RTK->AddElement(new RTK_Textview($string_nomessages));
}
$RTK->AddElement(new RTK_Link('EditRecipe'.URLPAGEEXT.'?id=new', $text_newmessage));*/

// Show a list of all the non-public (or disabled recipes if admin)
if (($privilege = Login::GetPrivilege()) > 1) {
	if ($admin = Recipe::LoadAllForAdmin(50, 0)) {
		$title_admin = "My Administration";
		$headers_admin = array("Title", "Is public", "Is disabled", "_", "_");
		$text_viewrecipe_adm = "View";
		$text_deleterecipe_adm = "Delete";
		$string_noadmin = "There are no recipes to administrate";
	
		$RTK->AddElement(new RTK_Header($title_admin));
		$myadministration = new RTK_Listview($headers_admin);
		if (sizeof($admin) > 0) {
			foreach ($admin as $recipe) {
				if (is_a($recipe, 'Recipe')) {
					$myadministration->AddRow(array(
						$recipe->GetTitle(),
						_bool::Display($recipe->GetIsPublic()),
						_bool::Display($recipe->GetDisabled()),
						new RTK_Link('ViewRecipe'.URLPAGEEXT.'?id='.$recipe->GetId(), $text_viewrecipe),
						new RTK_Link('DeleteRecipe'.URLPAGEEXT.'?id='.$recipe->GetId(), $text_deleterecipe)
					));
				}
			}
			$RTK->AddElement($myadministration);
		} else {
			$RTK->AddElement(new RTK_Textview($string_noadmin));
		}
	}
}

?>