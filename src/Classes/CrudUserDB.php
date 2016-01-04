<?php
class CRUD
{
		public static function sanatize($string, $type)
		{		
				$email_filter = FILTER_SANITIZE_EMAIL;
				$string_filter = FILTER_SANITIZE_STRING;
				$string_Strip_Low = FILTER_FLAG_STRIP_LOW;
				$string_Strip_High = FILTER_FLAG_STRIP_HIGH;
				
				
				if($type == "fname" || $type == "lname")
				{
						$sanatized_String= filter_var($string, $string_filter, $string_Strip_Low);
				}
				elseif($type = "email" )
				{
						$sanatized_String  = filter_var($string, $email_filter);
						
				}
				else
				{
					$sanatized_String = filter_var($string, $string_filter, $string_Strip_Low);
					
				}
	
				return $sanatized_String;
				//	Site::GetArgumentSafely('getvariablename');
		}
		
	
		public static function InsertUser()
		{	
		
		$v1 = "\tcafé\n";
		$v2 = "testpasword";
		$email = "'bogus - at - example dot org'";
		$email2 = '(bogus@example.org)';

		$v4 = "testTelno";
		$v5 = "testUsername";
		//$sv1 = CRUD::sanatize($v1, "fname");
		$sv2 = CRUD::sanatize($v1, "user_name");
		$semail = CRUD::sanatize($email, "email");
		$semail2 = CRUD::sanatize($email2, "email");
		$sv1 = CRUD::sanatize($semail, "user_name");
		//echo CRUD::sanatize($v1, "fname");
		//sanatize($testv1, "user_name");

		
		
				if($stmt = Database::GetLink()->prepare('INSERT INTO `User`(`fname`, `lname`, `email`, `telno`, `user_name`) VALUES (?,?,?,?,?)'))
				{
					$stmt->bindParam(1, $firstName, PDO::PARAM_STR, 255);
				    $stmt->bindParam(2, $semail, PDO::PARAM_STR, 255);
					$stmt->bindParam(3, $semail2, PDO::PARAM_STR, 255);
					$stmt->bindParam(4, $v4, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $sv2,PDO::PARAM_STR, 255);
				    $stmt->execute();
				    $stmt->closeCursor();
				    echo "all good";
				}		
				else
				{
                echo "not good";
				}	
		}
}
?>
