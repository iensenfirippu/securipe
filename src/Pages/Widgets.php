<?php
// Page Logic
$text1 = "Normally, both your asses would be dead as fucking fried chicken, but you happen to pull this shit while I&apos;m in a transitional period so I don&apos;t wanna kill you, I wanna help you. But I can&apos;t give you this case, it don&apos;t belong to me. Besides, I&apos;ve already been through too much shit this morning over this case to hand it over to your dumb ass.";
$text2 = "Look, just because I don&apos;t be givin&apos; no man a foot massage don&apos;t make it right for Marsellus to throw Antwone into a glass motherfuckin&apos; house, fuckin&apos; up the way the nigger talks. Motherfucker do that shit to me, he better paralyze my ass, &apos;cause I&apos;ll kill the motherfucker, know what I&apos;m sayin&apos;?";
$text3 = "Your bones don&apos;t break, mine do. That&apos;s clear. Your cells react to bacteria and viruses differently than mine. You don&apos;t get sick, I do. That&apos;s also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We&apos;re on the same curve, just on opposite ends.";
$text4 = "Now that we know who you are, I know who I am. I&apos;m not a mistake! It all makes sense! In a comic, you know how you can tell who the arch-villain&apos;s going to be? He&apos;s the exact opposite of the hero. And most times they&apos;re friends, like you and me! I should&apos;ve known way back when... You know why, David? Because of the kids. They called me Mr Glass";

// Page Output
include_once('Pages/OnAllPages.php');
$RTK->AddStylesheet('style.css');

$box1 = new RTK_Box(null, 'widgettest');
$box1->AddChild(new RTK_Pagination(EMPTYSTRING, 100, 10, 1));

$box2 = new RTK_Box(null, 'subtest1');
$box2->AddChild(new RTK_Header("Example Recipe #".rand(100,1000)));
$box2->AddChild(new RTK_Image('/Images/imgtest.png'));
$box2->AddChild(new RTK_Textview($text1.$text4));
$box2->AddChild(new RTK_Box(null, 'clearfix'));

$box3 = new RTK_Box(null, 'subtest2');
$box3->AddChild(new RTK_Button('test', 'Not a test'));
$box3->AddChild(new RTK_DropDown('dd', array('option1', array('OPTION2','option2')), 'option2'));
$box3->AddChild(new RTK_Link('woop', 'a link'));
$box3->AddChild(new RTK_Box(null, 'clearfix'));

$box4 = new RTK_Box(null, 'subtest3');
$box4->AddChild(new RTK_ListView(array('woop', 'test', 'wahoo', 'pebkac', 'kesmit')));
$box4->AddChild(new RTK_Box(null, 'clearfix'));

$box5 = new RTK_Box(null, 'subtest4');
$form = new RTK_Form('testform');
$form->AddText($text2.$text3);
$form->AddHiddenField('supersecret', 2);
$form->AddTextField('pfffth', 'Pfft!', null);
$form->AddPasswordField('passw0rds', 'A password: ');
$form->AddCheckBox('check', 'Please: ', true, 'salmon', 'Has salmon');
$form->AddRadioButtons('radio', '_buttons: ', array(array('opt_1', 'fisk'), 'opt_2', array('opt_3', 'ikkefisk')), 'opt_2');
$form->AddDropDown('DROP', 'daun', array(array('opt_1', 'fisk'), 'opt_2', array('opt_3', 'ikkefisk')), 'opt_3');
$form->AddPasswordField('passw0rds', 'A password: ');
$form->AddElement(new RTK_Image('/Images/imgtest.png', 'bleh', array('customarg1' => 'nisser')));
$form->AddButton('submit2', 'Submit2: ');
$box5->AddChild($form);
$box5->AddChild(new RTK_Box(null, 'clearfix'));

$box1->AddChild($box2);
$box1->AddChild($box3);
$box1->AddChild($box4);
$box1->AddChild($box5);

$RTK->AddElement($box1);
?>