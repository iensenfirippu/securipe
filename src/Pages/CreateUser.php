<?php
// Page Logic
$GLOBALS['LOGIN'] = new Login();
if (Value::SetAndEqualTo('logout', $_GET, 'action')) { Login::LogOut(); }
if (Login::GetUsername() == EMPTYSTRING) { Login::TryToLogin(); }

// Page Output
include_once('Pages/OnAllPages.php');
$RTK->AddJavascript('jquery-2.1.4.min.js');
$RTK->AddJavascript('login.js');

$box1= new RTK_Box("box1");
//$box1->AddChild(new RTK_Header("titletitle"));
$box1->AddChild(new RTK_Textview("Create User"));

$form= new RTK_Form("createUserForm");

$form->AddTextField("UserName", "User Name");
$form->AddPasswordField("Password", "Password");

$form->AddTextField("FirstName", "First Name555888");
$form->AddTextField("LastName", "Last Name");
$form->AddTextField("email", "Email");
$form->AddTextField("telePhoneNo", "Phone No");


$form->AddButton("Submit", "Submit Form");

$box1->AddChild($form);


$RTK->AddElement($box1);

if (Value::SetAndNotNull($_POST, 'Submit')) {
     
   // vdd(false); 
   $firstName = Site::GetPostValueSafely("FirstName");
    
    Crud::InsertUser();
    //echo $firstName;
   // $test = new CRUD("");

//$test->InsertUser();
//
}


?>