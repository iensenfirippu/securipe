<?php
class UserDBHandler
{
		private $userObject;
		private $userId;
	
		function __construct($_userObject)
		{
			$this->userObject = $_userObject;
			$this->insertUserDB();
			$this->insertHashToDB();

		}
		
		public static function checkIfUserExits($_userName)
		{
			$return;
			
				if($stmt = Database::GetLink()->prepare(" SELECT count(user_name) FROM User WHERE user_name = ? LIMIT 1"))
				{				
					$stmt->bindParam(1, $_userName, PDO::PARAM_STR, 255);
					$stmt->execute();
					$result = $stmt->fetchColumn();
				}
				
				if ($result== 0) { $return = 0; }
				else { $return = 1; }
				return $return;
		}
		
		private function insertHashToDB()
		{
			$userName = $this->userObject->getUserNameHashed();
			$passwordHashed = $this->userObject->getPasswordHashed();
			$personalSalt = $this->userObject->getPersonalSalt();
			$disabled = 0;
			
				if($stmt = Database::GetLink()->prepare('INSERT INTO Login(user_id, username_hash, password_hash, personal_salt, disabled) VALUES (?,?,?,?,?)'))
				{
				
					$stmt->bindParam(1, $this->userId, PDO::PARAM_INT);
					$stmt->bindParam(2, $userName, PDO::PARAM_STR, 255);
				  $stmt->bindParam(3, $passwordHashed, PDO::PARAM_STR, 255);
					$stmt->bindParam(4, $personalSalt, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $disabled, PDO::PARAM_INT);
				  $stmt->execute();
					
				  $stmt->closeCursor();
					$arr1 = $stmt->errorInfo();
						$arr2 = $stmt->errorInfo();
							$arr3 = $stmt->errorInfo();
				}	
		
		}
		public function insertUserDB()
		{
			
			$firstname 	= $this->userObject->getFname();
			$lastName 	= $this->userObject->getLname();
			$email 			= $this->userObject->getEmail();
			$telNo			= $this->userObject->getTelNo();
			$userName		=	$this->userObject->getUserName();
			
				if($stmt = Database::GetLink()->prepare('INSERT INTO `User`(`fname`, `lname`, `email`, `telno`, `user_name`) VALUES (?,?,?,?,?)'))
				{				
					$stmt->bindParam(1, $firstname, PDO::PARAM_STR, 255);
				  $stmt->bindParam(2, $lastName, PDO::PARAM_STR, 255);
					$stmt->bindParam(3, $email, PDO::PARAM_STR, 255);
					$stmt->bindParam(4, $telNo, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $userName,PDO::PARAM_STR, 255);
				  $stmt->execute();
					$this->userId =  Database::GetLink()->lastInsertId();
				}	
		}
}
		
?>
