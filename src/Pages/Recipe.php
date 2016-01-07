<?php
// Page Logic
$edit = Value::SetAndEqualTo(true, $GLOBALS, 'EDIT', true);
$steps = array(	"Normally, both your asses would be dead as fucking fried chicken, but you happen to pull this shit while I&apos;m in a transitional period so I don&apos;t wanna kill you, I wanna help you. But I can&apos;t give you this case, it don&apos;t belong to me. Besides, I&apos;ve already been through too much shit this morning over this case to hand it over to your dumb ass.",
				"Look, just because I don&apos;t be givin&apos; no man a foot massage don&apos;t make it right for Marsellus to throw Antwone into a glass motherfuckin&apos; house, fuckin&apos; up the way the nigger talks. Motherfucker do that shit to me, he better paralyze my ass, &apos;cause I&apos;ll kill the motherfucker, know what I&apos;m sayin&apos;?",
				"Your bones don&apos;t break, mine do. That&apos;s clear. Your cells react to bacteria and viruses differently than mine. You don&apos;t get sick, I do. That&apos;s also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We&apos;re on the same curve, just on opposite ends.",
				"Now that we know who you are, I know who I am. I&apos;m not a mistake! It all makes sense! In a comic, you know how you can tell who the arch-villain&apos;s going to be? He&apos;s the exact opposite of the hero. And most times they&apos;re friends, like you and me! I should&apos;ve known way back when... You know why, David? Because of the kids. They called me Mr Glass");

if (Value::SetAndNotNull($_POST, 'CommentInput')) {
	$message = Site::GetPostValueSafely('CommentInput');
	$id = Site::GetPostValueSafely('CommentSelect');
	if (!is_numeric($id)) { $id = EMPTYSTRING; }
	Comment::Insert($message, 1, $id);
	Site::Redirect('');
}

// Page Output
include_once('Pages/OnAllPages.php');

$recipebox = new RTK_Box('recipebox');
$recipedescription = new RTK_Box(null, 'recipedescription');
$recipedescription->AddChild(new RTK_Header("Example Recipe #".rand(100,1000)));
if (!$edit) { $recipedescription->AddChild(new RTK_Link('EditRecipe'.URLPAGEEXT, 'Edit')); }
$recipedescription->AddChild(new RTK_Image('/imgtest.png'));
$recipedescription->AddChild(new RTK_Textview($steps[2].$steps[1]));
$recipedescription->AddChild(new RTK_Box(null, 'clearfix'));
$recipebox->AddChild($recipedescription);
$i = 0;
if ($edit) { $recipebox->AddChild(new RTK_Link('CreateStep'.URLPAGEEXT.'?index=1', 'Add Step Before')); }
foreach ($steps as $step) {
	$i++;
	$stepbox = new RTK_Box(null, 'stepbox');
	$stepbox->AddChild(new RTK_Header($i.EMPTYSTRING));
	for ($j=rand(0,3); $j>0; $j--) {
		$stepbox->AddChild(new RTK_Image('/imgtest.png'));	
	}
	$stepbox->AddChild(new RTK_Textview($step));
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
	$commentbox = new RTK_CommentView(1);
	$RTK->AddElement($commentbox, 'wrapper', 'comments');
}
?>