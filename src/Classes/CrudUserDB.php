<?php
class CRUD
{
		public static function serverSideHasing($userName, $password, $lastID)//$userName, $password
		{
			$md5UserName = md5($userName);//$userName

			$md5UserNameAndPassword =  md5($userName.$password);//$userName.$password

			$userName_Hash = hash('sha512', $md5UserName); //userNameHash $sha512Ofmd5UserName
			
			$personal_Salt = hash("sha512", UUID::Create());// dynamic salt personal salt sha512OfUUID
			
			$password_Hash = hash("sha512", STATIC_SALT.$md5UserNameAndPassword.$personal_Salt.$userName_Hash);//password hash
			
			CRUD::insertHashToDB($userName_Hash,$password_Hash,$personal_Salt, $disabled= 0, $lastID);
			
		}
		public static function checkIfUserExits($userName)
		{
			$return;
			
				if($stmt = Database::GetLink()->prepare(" SELECT count(user_name) FROM User WHERE user_name = ? LIMIT 1"))
				{				
					$stmt->bindParam(1, $userName, PDO::PARAM_STR, 255);
					$stmt->execute();
					$result = $stmt->fetchColumn();
					$stmt->closeCursor();
					echo  "<br /> <br /> <br />All good checkIfUserExits <br />";
	
				}		
				else
				{
          echo  "<br /> <br /> <br />Not good checkIfUserExits <br />";
				}
				
				if($result== 0)
				{
					echo  "<br /> <br /> <br />Username dosent exits<br />" . $result . "LOL";
					$return = 0;
				}
				else
				{
					echo  "<br /> <br /> <br />Username exits already<br />" . $result . "LOL";
					$return = 1;
				}
				return $return;
		}
		
		public static function insertHashToDB($username_Hash, $password_Hash, $personal_Salt, $lastID)
		{
	//	vdd($lastID);
				if($stmt = Database::GetLink()->prepare('INSERT INTO `Login`(`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) VALUES (?,?,?,?,?)'))
				{
					$stmt->bindParam(1, $lastID, PDO::PARAM_INT);
					$stmt->bindParam(2, $username_Hash, PDO::PARAM_STR, 255);
				  $stmt->bindParam(3, $password_Hash, PDO::PARAM_STR, 255);
					$stmt->bindParam(4, $personal_Salt, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $disabled, PDO::PARAM_INT);
				  $stmt->execute();
					
				  $stmt->closeCursor();
					$arr1 = Database::GetLink()->errorInfo();
						$arr2 = Database::GetLink()->errorInfo();
							$arr3 = Database::GetLink()->errorInfo();
				  echo  "<br /> <br /> <br />All good insertHashToDB Error: <br />. $arr1[0]. $arr2[2]. $arr3[3]";
				}		
				else
				{
         echo  "<br /> <br /> <br />Not good insertHashToDB <br />";
				}	
		
		}
		public static function insertUserDB($userName, $firstName,$lastName, $email, $telNo, $password)
		{
			$lastID;
			
				if($stmt = Database::GetLink()->prepare('INSERT INTO `User`(`fname`, `lname`, `email`, `telno`, `user_name`) VALUES (?,?,?,?,?)'))
				{				
					$stmt->bindParam(1, $firstName, PDO::PARAM_STR, 255);
				  $stmt->bindParam(2, $lastName, PDO::PARAM_STR, 255);
					$stmt->bindParam(3, $email, PDO::PARAM_STR, 255);
					$stmt->bindParam(4, $telNo, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $userName,PDO::PARAM_STR, 255);
				
				  $stmt->execute();
					$lastID =  Database::GetLink()->lastInsertId();

					CRUD::serverSideHasing($userName, $password, $lastID);
				  echo  "<br /> <br /> <br />All good insertUserDB <br />";
				}			
				else
				{
         echo  "<br /> <br /> <br />Not good insertUserDB <br />";
				}	
		}
}

?>










