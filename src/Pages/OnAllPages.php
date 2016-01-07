<?php
// Page Logic
$pages = array(array('Home'.URLPAGEEXT, 'Home'));
$pages[] = array('ViewRecipe'.URLPAGEEXT.'?id=1', 'Recipe');
$pages[] = array('WidgetTest'.URLPAGEEXT, 'Test');

$mymenu = array();
if (Login::IsLoggedIn()) {
	$mymenu[] = array('MyPage'.URLPAGEEXT, 'My Page');
	$mymenu[] = array('Logout'.URLPAGEEXT, 'Logout');
} else {
	$mymenu[] = array('Login'.URLPAGEEXT, '_Login');
}

// Page Output
$RTK->AddStylesheet('/style.css');
$wrapper = new RTK_Box('wrapper');
$menu = new RTK_Menu('mainmenu', 'menu', $pages);
$menu->SetSelected($currentpage);
$RTK->AddElement($menu);
$RTK->AddElement(new RTK_Menu('mymenu', 'menu', $mymenu));
$RTK->AddElement($wrapper, null, 'wrapper');

if ($currentpage != 'Login') {
	$main = new RTK_Box('main');
	$RTK->AddElement($main, 'wrapper', 'main');
}
?>