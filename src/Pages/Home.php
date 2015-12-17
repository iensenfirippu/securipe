<?php
$home_text = "Congratulations! You have made it to the front page of our website! Won't you also please try to log in?";
$home_link = "Go to the login page.";

$RTK->AddStylesheet("style.css");

$wrapper = new RTK_Box("wrapper");
$wrapper->AddChild(new RTK_Textview($home_text));
// Links to the login page should maybe contain https so for the sake of usability
$wrapper->AddChild(new RTK_Link("/?action=login", $home_link));

$RTK->AddElement($wrapper);
?>