<?php
// Page Logic

	if (Value::SetAndNotNull($_POST, 'Submit'))
	{
		
		$userName = Site::GetPostValueSafely("UserName");// need to be hashed client-side
		$password =	Site::GetPostValueSafely("Password");// need to be hashed client-side
		$firstName= Site::GetPostValueSafely("FirstName");
		$lastName = Site::GetPostValueSafely("LastName");
		$email    = Site::GetPostValueSafely("email");
		$telNo    = Site::GetPostValueSafely("telNo");
		
		//echo "<br /><br /><br />ldflgjldfj" .$telNo;
		//$acces = TRUE;
		////vdd("test");
		//	if(Site::validateUserName($userName, $errorUserName)){
		//	$acces = FALSE;
		//	
		//		if((User::checkIfExits($userName))){
		//			$errorUserName = "Username already exits!";
		//			$acces = FALSE;
		//		}
		//	}
		//	//vd("userName:" );
		//	//vd($acces);
		//	if(!Site::validatePassword($password, $error1Password, $error2Password,$error3Password, $error4Password)){ $acces = FALSE;	}
		//	vd("Password");
		//				vd($acces);
		//	if(!Site::validateEmail($email, $errorEmail)){$acces = FALSE;}
		//	//vd("Email: ");
		//	//			vd($acces);
		//	if(!Site::validatePhoneNo($telNo,$errorTelNo)){}
		//	//vdd("phonenr: ");
		//	//			vd($acces);
			

				$user = new User();
				$user->create($userName, $password, $firstName, $lastName, $email, $telNo);
				$user->save();
				$userCreated = "User successfully created!";
			

	}
$GLOBALS['LOGIN'] = new Login();
if (Value::SetAndEqualTo('logout', $_GET, 'action')) { Login::LogOut(); }
if (Login::GetUsername() == EMPTYSTRING) { Login::TryToLogin(); }

// Page Output
include_once('Pages/OnAllPages.php');
$RTK->AddJavascript('jquery-2.1.4.min.js');
$RTK->AddJavascript('login.js');

$box1= new RTK_Box("box1");
$box1->AddChild(new RTK_Header("Create User"));


$form= new RTK_Form("createUserForm");

$form->AddTextField("UserName", "User Name");
$form->AddPasswordField("Password", "Password");
$box2= new RTK_Box("box1");
$box2->AddChild(new RTK_Textview($errorUserName."<br />".$error1Password ."<br />".$error2Password ."<br />".  $error3Password."<br />".$error4Password. "<br />".$errorEmail."<br />".$errorTelNo. "<br />" .$userCreated));

$form->AddTextField("FirstName", "First Name");
$form->AddTextField("LastName", "Last Name");
$form->AddTextField("email", "Email");
$form->AddTextField("telNo", "Phone No");

$form->AddButton("Submit", "Submit Form");

$box1->AddChild($form);

$RTK->AddElement($box1);
$RTK->AddElement($box2);

?>