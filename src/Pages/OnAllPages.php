<?php
// Page Logic
$titles = glob('Pages/*.php');
_array::Remove($titles, _array::GetIdOf($titles, 'Pages/OnAllPages.php'));
for ($i=0; $i<sizeof($titles); $i++) {
	$titles[$i] = str_replace(array('Pages/', '.php'), array(EMPTYSTRING, EMPTYSTRING), $titles[$i]);
}
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