<?php
class User
{
		private $useId;
		private $userName;
		private $userNameHashed;
		private $passwordHased;
		private $personalSalt;
		private $firstName;
		private $lastName;
		private $email;
		private $telNo;
		
	  function __construct(){}

		public function getUserName(){ return $this->userName;}
		
		public function setUsername($_userName){ $this->userName = $_userName;}
		
		//public function getPassword(){ return $this->password;}
		//
		//public function setPassword($_password){ $this->password = $_password;}
		
		public function getFirstName(){ return $this->firstName;}
		
		public function setFirstName($_firstName){ $this->firstName  = $_firstName;}
		
		public function getLastName(){ return $this->lastName;}
		
		public function setLastName($_lastName){	$this->lastName = $_lastName;}
		
		public function getEmail(){	return $this->email;}
		
		public function setEmail($_email){ $this->email = $_email;}
		
		public function getTelNo(){ return $this->telNo;}
		
		public function getUserNameHashed(){ return $this->userNameHashed;}
			
		public function getPasswordHashed(){ return $this->passwordHashed;}
		
		public function getPersonalSalt(){return $this->personalSalt;}
		
		
		public function create($_userName, $_password, $_firstName, $_lastName, $_email, $_telNo)
		{
			$this->userName  = $_userName;
			$this->hashUserNameAndPassword($_password);
			$this->firstName = $_firstName;
			$this->lastName  = $_lastName;
			$this->email     = $_email;
			$this->telNo     = $_telNo;
		//	vdd("username: ".$_userName);
		}
		
		public function hashUserNameAndPassword($_password)
		{	
			$md5UserName= md5($this->userName);
			$md5UserNameAndPassword =  md5($this->userName.$_password);//$userName.$password
			$this->userNameHashed = hash('sha512', $md5UserName); //userNameHash $sha512Ofmd5UserName
			$this->personalSalt = hash("sha512", UUID::Create());// dynamic salt personal salt sha512OfUUID
		//	$tempSalt = "e20beaa097ae55e04422e5a54126f9ecee3a24d0ab8ec123f3501d37598909fbe5b3f4ae1b3b7b1db5776535eb036adbb0713a47023a886ab1cd061d1c5e28f8";
			$this->passwordHashed = hash("sha512", STATIC_SALT.$md5UserNameAndPassword.$this->personalSalt.$this->userNameHashed );
			
		}
	
		public static function checkIfExits($_userName)
		{
			$return;
				if($stmt = Database::GetLink()->prepare(" SELECT count(user_name) FROM User WHERE user_name = ? LIMIT 1"))
				{				
					$stmt->bindParam(1, $_userName, PDO::PARAM_STR, 255);
					$stmt->execute();
					$result = $stmt->fetchColumn();
					$stmt->closeCursor();
				}		
				if($result== 1)
				{
					$return = TRUE;
				}
				else
				{
					$return = FALSE;
				}
				return $return;
		}
		
		private function saveHash()
		{
			$userName 		  = $this->getUserNameHashed();
			$passwordHashed = $this->getPasswordHashed();
			$personalSalt	  = $this->getPersonalSalt();
			$disabled 			= 0;
			
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
				echo  "<br /> <br /> <br />All good savehash Error: <br />". $arr1[0] .$arr2[2] .$arr3[2];
				}		
				else
				{
         echo  "<br /> <br /> <br />Not good savehash <br />";
				}	
		}
		
		public function save()
		{
			$_firstname 	= $this->getFirstName();
			$_lastName 		= $this->getLastName();
			$_email 			= $this->getEmail();
			$_telNo				= $this->getTelNo();
			$_userName		=	$this->getUserName();
			
				if($stmt = Database::GetLink()->prepare('INSERT INTO `User`(`fname`, `lname`, `email`, `telno`, `user_name`) VALUES (?,?,?,?,?)'))
				{				
					$stmt->bindParam(1, $_firstname, PDO::PARAM_STR, 255);
				  $stmt->bindParam(2, $_lastName, PDO::PARAM_STR, 255);
					$stmt->bindParam(3, $_email, PDO::PARAM_STR, 255);
					$stmt->bindParam(4, $_telNo, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $_userName,PDO::PARAM_STR, 255);
				  $stmt->execute();
					$this->userId =  Database::GetLink()->lastInsertId();
					$this->saveHash();
			
					$this->load($_userName);
				  echo  "<br /> <br /> <br />All good insertUserDB <br />";
				}			
				else
				{
         echo  "<br /> <br /> <br />Not good insertUserDB <br />";
				}	
		}
	
	public function load($_userName)
	{
		//	vdd($_userName);
				if($stmt = Database::GetLink()->prepare('SELECT * FROM `User` WHERE user_name = ?'))
				{
					$stmt->bindParam(1, $_userId, PDO::PARAM_STR, 255);
				  $stmt->execute();
					$result = $stmt->fetchAll();
				 
					$this->userId 	 = $result[0];
					$this->firstName = $result[1];
					$this->lastName  = $result[2];
					$this->email     = $result[3];
					$this->telNo     = $result[4];
					$this->userName  = $result[5];
					
				echo  "<br /> <br /> <br />All good load <br />";
				
				}			
				else
				{
        echo  "<br /> <br /> <br />Not good load <br />";
				}		
	}
}
?>










