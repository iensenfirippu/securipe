<?php
// Page Logic
$titles = array('Home', '_Login', 'Recipe');
$links = array('home/', 'login/', 'recipe/');

// Page Output
$RTK->AddStylesheet('/style.css');
$wrapper = new RTK_Box('wrapper');
$menu = new RTK_Menu('mainmenu', 'menu', $links, $titles);
$menu->SetSelected($currentpage);
$RTK->AddElement($menu);
$RTK->AddElement($wrapper, null, 'wrapper');

if ($currentpage != 'login') {
	$main = new RTK_Box('main');
	$RTK->AddElement($main, 'wrapper', 'main');
}
?>