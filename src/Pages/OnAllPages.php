<?php
// Page Logic
$titles = array('Home', '_Login', 'Recipe');
$links = array();
foreach ($titles as $title) { $links[] = '?action='.strtolower($title); }

// Page Output
$RTK->AddStylesheet('style.css');
$wrapper = new RTK_Box('wrapper');
$menu = new RTK_Menu('mainmenu', 'menu', $links, $titles);
$menu->SetSelected(Site::GetArgumentSafely('action'));
$RTK->AddElement($menu);
$RTK->AddElement($wrapper, null, 'wrapper');
?>