<?php
// Page Logic
$home_text = 'Congratulations! You have made it to the front page of our website! Won&apos;t you also please try to log in?';
$home_link = 'Go to the login page.';

// Page Output
include_once('Pages/OnAllPages.php');

$RTK->AddElement(new RTK_Textview($home_text));
// Links to the login page should maybe contain https for the sake of usability
$RTK->AddElement(new RTK_Link('login/', $home_link, true));
?>
