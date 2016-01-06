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

$form->AddTextField("FirstName", "First Name");
$form->AddTextField("LastName", "Last Name");
$form->AddTextField("email", "Email");
$form->AddTextField("telNo", "Phone No");

$form->AddButton("Submit", "Submit Form");

$box1->AddChild($form);

$RTK->AddElement($box1);
//UserTest::testFunction();

	if (Value::SetAndNotNull($_POST, 'Submit'))
	{
		
		$userName = Site::GetPostValueSafely("UserName");// need to be hashed client-side
		$password =	Site::GetPostValueSafely("Password");// need to be hashed client-side
		$firstName= Site::GetPostValueSafely("FirstName");
		$lastName = Site::GetPostValueSafely("LastName");
		$email    = Site::GetPostValueSafely("email");
		$telNo    = Site::GetPostValueSafely("telNo");
	
		$user = new User($userName, $password, $firstName, $lastName, $email, $telNo);
		
		if(!(UserDBHandler::checkIfUserExits($user->getUserName())))
		{
			new UserDBHandler($user);
		}
	}

?>