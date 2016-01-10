<?php
// Page Logic

$recipe = null;
$edit = false;
$id = Site::GetArgumentSafely('id');
if (Value::SetAndNotNull($id)) {
	$recipe = Recipe::Load($id);
	if (Value::SetAndNotNull($recipe)) {
		$recipe->LoadSteps();
		if ($recipe->GetUser()->GetId() == Login::GetId()) {
			// is owner
			$edit = $recipe->GetDisabled();
		} elseif ($recipe->GetDisabled()) { Site::BackToHome(); }
		
		if (Value::SetAndNotNull($_POST, 'CommentInput') && Site::CheckSecurityToken()) {
			$message = Site::GetPostValueSafely('CommentInput');
			$commentid = Site::GetPostValueSafely('CommentSelect');
			if (!is_numeric($commentid)) { $commentid = EMPTYSTRING; }
			Comment::Insert($message, $id, $commentid);
			Site::Redirect(EMPTYSTRING);
		}
	}
	else { Site::BackToHome(); }
}
else { Site::BackToHome(); }

// Page Output
include_once('Pages/OnAllPages.php');

$recipebox = new RTK_Box('recipebox');
$recipedescription = new RTK_Box(null, 'recipedescription');
$recipedescription->AddChild(new RTK_Header($recipe->GetTitle()));
if ($recipe->GetPicture() != null) {
	$image = new RTK_Image($recipe->GetPicture()->GetThumbnail(), '[IMG]');
	$image->AddLink($recipe->GetPicture()->GetFile());
	$recipedescription->AddChild($image);
}
$recipedescription->AddChild(new RTK_Textview($recipe->GetDescription()));
$recipedescription->AddChild(new RTK_Box(null, 'clearfix'));
$recipebox->AddChild($recipedescription);
$i = 0;
foreach ($recipe->GetSteps() as $step) {
	$i++;
	$stepbox = new RTK_Box(null, 'stepbox');
	$stepbox->AddChild(new RTK_Header($i.EMPTYSTRING));
	if ($step->GetPicture() != null) {
		$image = new RTK_Image($step->GetPicture()->GetThumbnail(), '[IMG]');
		$image->AddLink($step->GetPicture()->GetFile());
		$stepbox->AddChild($image);
	}
	$stepbox->AddChild(new RTK_Textview($step->GetDescription()));
	$stepbox->AddChild(new RTK_Box(null, 'clearfix'));
	$recipebox->AddChild($stepbox);
	if ($edit) {
		$optionbox = new RTK_Box(null, 'optionbox');
		$optionbox->AddChild(new RTK_Link('EditStep'.URLPAGEEXT.'?id='.$step->GetId(), 'Edit'));
		$optionbox->AddChild(new RTK_Link('DeleteStep'.URLPAGEEXT.'?id='.$step->GetId(), 'Delete'));
		$recipebox->AddChild($optionbox);
	}
}

if ($edit) {
	$recipebox->AddChild(new RTK_Link('EditStep'.URLPAGEEXT.'?recipe='.$id, 'Add Step'));
	$recipebox->AddChild(new RTK_Link('EditRecipe'.URLPAGEEXT.'?id='.$id, 'Edit Recipe'));
	$recipebox->AddChild(new RTK_Link('DeleteRecipe'.URLPAGEEXT.'?id='.$id, 'Delete Recipe'));
}

$RTK->AddElement($recipebox);

if (!$edit && $recipe != null) {
	$commentbox = new RTK_CommentView($recipe);
	$RTK->AddElement($commentbox, 'wrapper', 'comments');
}
?>