<?php
// Page Logic
if (!Site::HasHttps() || Login::IsLoggedIn()) { Site::BackToHome(); }

$errors = null;
$userName = EMPTYSTRING;
$firstName = EMPTYSTRING;
$lastName = EMPTYSTRING;
$email = EMPTYSTRING;
$telNo = EMPTYSTRING;

if (Value::SetAndNotNull($_POST, 'Submit') && Site::CheckSecurityToken())
{
	$errors = array();
	
	$userName  = Site::GetPostValueSafely("UserName");// need to be hashed client-side
	$password  = Site::GetPostValueSafely("Password");// need to be hashed client-side
	$password2 = Site::GetPostValueSafely("Password2");// need to be hashed client-side
	$firstName = Site::GetPostValueSafely("FirstName");
	$lastName  = Site::GetPostValueSafely("LastName");
	$email     = Site::GetPostValueSafely("email");
	$telNo     = Site::GetPostValueSafely("telNo");
	
	Site::ValidateUserName($userName, $errors);
	Site::ValidatePassword($password, $password2, $errors);
	Site::ValidateEmail($email, $errors);
	Site::ValidatePhoneNo($telNo, $errors);
	
	if (sizeof($errors) == 0) {
		$user = new User();
		$user->create($userName, $password, $firstName, $lastName, $email, $telNo);
		$user->save();
		Site::BackToHome();
	} else  {
		$errors = implode('<br />', $errors);
	}
}

// Page Output
include_once('Pages/OnAllPages.php');
$RTK->AddJavascript('jquery-2.1.4.min.js');
$RTK->AddJavascript('login.js');

$RTK->AddElement(new RTK_Header("Create User"));
$RTK->AddElement(new RTK_Textview("Please fill out this form to recieve your very own user account at our magnificent site.\n".
								  "Please note however that we have a few rules. For instance: Usernames have to be at least 5 characters long.\n".
								  "Passwords have to be at least 8 characters long, and must contain numbers as well as both lower and upper case letters."));

$form= new RTK_Form("createUserForm");
$form->AddTextField("UserName", "User Name", $userName);
$form->AddPasswordField("Password", "Password");
$form->AddPasswordField("Password2", "Password repeat");
$form->AddTextField("FirstName", "First Name", $firstName);
$form->AddTextField("LastName", "Last Name", $lastName);
$form->AddTextField("email", "Email", $email);
$form->AddTextField("telNo", "Phone No", $telNo);
$form->AddButton("Submit", "Create my user account");
$RTK->AddElement($form);

if ($errors != null) { $RTK->AddElement(new RTK_Textview($errors)); }
?>