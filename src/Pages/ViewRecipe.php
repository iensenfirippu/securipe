<?php
// Page Logic

$recipe = null;
$id = Site::GetArgumentSafely('id');
if (Value::SetAndNotNull($id)) {
	$recipe = Recipe::Load($id);
	if (Value::SetAndNotNull($recipe)) {
		$recipe->LoadSteps();
		$edit = false;//Value::SetAndEqualTo($recipe->GetUsertrue, $GLOBALS, 'EDIT', true);
		
		if (Value::SetAndNotNull($_POST, 'CommentInput')) {
			$message = Site::GetPostValueSafely('CommentInput');
			$id = Site::GetPostValueSafely('CommentSelect');
			if (!is_numeric($id)) { $id = EMPTYSTRING; }
			Comment::Insert($message, 1, $id);
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
//if (!$edit) { $recipedescription->AddChild(new RTK_Link('EditRecipe'.URLPAGEEXT, 'Edit')); }
if ($recipe->GetPicture() != null) { $recipedescription->AddChild(new RTK_Image('/'.$recipe->GetPicture()->GetFileName())); }
$recipedescription->AddChild(new RTK_Textview($recipe->GetDescription()));
$recipedescription->AddChild(new RTK_Box(null, 'clearfix'));
$recipebox->AddChild($recipedescription);
$i = 0;
if ($edit) { $recipebox->AddChild(new RTK_Link('CreateStep'.URLPAGEEXT.'?index=1', 'Add Step Before')); }
foreach ($recipe->GetSteps() as $step) {
	$i++;
	$stepbox = new RTK_Box(null, 'stepbox');
	$stepbox->AddChild(new RTK_Header($i.EMPTYSTRING));
	for ($j=rand(0,3); $j>0; $j--) {
		$stepbox->AddChild(new RTK_Image('/'.$step->GetImage()->GetFileName()));	
	}
	$stepbox->AddChild(new RTK_Textview($step->GetDescription()));
	$stepbox->AddChild(new RTK_Box(null, 'clearfix'));
	if ($edit) {
		$optionbox = new RTK_Box(null, 'optionbox');
		if ($i > 1) {
			$recipebox->AddChild(new RTK_Link('CreateStep'.URLPAGEEXT.'?index='.$i, 'Add Step Between'));
			$optionbox->AddChild(new RTK_Link('MoveStep'.URLPAGEEXT.'?id='.$i.'&direction=up', 'MOVE UP'));
		}
		$optionbox->AddChild(new RTK_Link('EditStep'.URLPAGEEXT.'?id='.$i, 'EDIT'));
		if ($i < sizeof($steps)) { $optionbox->AddChild(new RTK_Link('MoveStep'.URLPAGEEXT.'?id='.$i.'&direction=down', 'MOVE DOWN')); }
		$stepbox->AddChild($optionbox);
	}
	$recipebox->AddChild($stepbox);
}
if ($edit) { $recipebox->AddChild(new RTK_Link('CreateStep'.URLPAGEEXT.'?index='.($i+1), 'Add Step After')); }

$RTK->AddElement($recipebox);

if (!$edit) {
	$commentbox = new RTK_CommentView($recipe->GetId());
	$RTK->AddElement($commentbox, 'wrapper', 'comments');
}
?>