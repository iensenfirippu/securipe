<?php
if (defined('securipe') or exit(1))
{
	$GLOBALS['USERS'] = array();
	
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
		
		//public function GetId() { return $this->useId; }
		public function getUserName(){ return $this->userName;}
		public function setUsername($_userName){ $this->userName = $_userName;}
		
		//public function getPassword(){ return $this->password;}
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
		}
		
		public function hashUserNameAndPassword($_password)
		{
			$md5UserName = md5($this->userName);
			$md5UserNameAndPassword = md5($this->userName.$_password); //$userName.$password
			$this->userNameHashed = hash('sha512', $md5UserName); //userNameHash $sha512Ofmd5UserName
			$this->personalSalt = hash("sha512", UUID::Create()); // dynamic salt personal salt sha512OfUUID
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
			
			if ($result== 1) { $return = TRUE; }
			else { $return = FALSE; }
			return $return;
		}
		
		private function saveHash()
		{
			$userName 	  = $this->getUserNameHashed();
			$passwordHashed = $this->getPasswordHashed();
			$personalSalt	  = $this->getPersonalSalt();
			$disabled 		= 0;
			
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
		
		/*public function updateHash()
		{
			$md5UserName = md5($this->userName);
			$md5UserNameAndPassword = md5($this->userName.$_password); //$userName.$password
			$this->userNameHashed = hash('sha512', $md5UserName); //userNameHash $sha512Ofmd5UserName
			$this->personalSalt = Login::FetchUserSalt($this->userNameHashed) // dynamic salt personal salt sha512OfUUID
			$this->passwordHashed = hash("sha512", STATIC_SALT.$md5UserNameAndPassword.$this->personalSalt.$this->userNameHashed );
			
			$passwordHashed = $this->getPasswordHashed();
			
			if($stmt = Database::GetLink()->prepare('UPDATE Login SET password_hash=? WHERE user_id=?;'))
			{
				$stmt->bindParam(1, $passwordHashed, PDO::PARAM_STR, 255);
				$stmt->bindParam(2, $this->userId);
				$stmt->execute();
				
				$stmt->closeCursor();
			}	
		}*/
		
		public function save()
		{
			$result = false;
			
			$_firstname = $this->getFirstName();
			$_lastName 	= $this->getLastName();
			$_email 	= $this->getEmail();
			$_telNo		= $this->getTelNo();
			$_userName	= $this->getUserName();
			
			if ($stmt = Database::GetLink()->prepare('INSERT INTO `User`(`fname`, `lname`, `email`, `telno`, `user_name`, `privilege_level`) VALUES (?,?,?,?,?,1)'))
			{		
				$stmt->bindParam(1, $_firstname, PDO::PARAM_STR, 255);
				$stmt->bindParam(2, $_lastName, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $_email, PDO::PARAM_STR, 255);
				$stmt->bindParam(4, $_telNo, PDO::PARAM_STR, 255);
				$stmt->bindParam(5, $_userName,PDO::PARAM_STR, 255);
				$stmt->execute();
			  
				$this->userId = Database::GetLink()->lastInsertId();
				$this->saveHash();
				
				//$this->load($_userName);
			}	
		}
		
		public static function LoadFromName($_userName)
		{
			$result = false;
				if($stmt = Database::GetLink()->prepare('SELECT `user_id`, `fname`, `lname`, `email`, `telno` FROM `User` WHERE user_name = ?'))
				{
						$stmt->bindParam(1, $_userName, PDO::PARAM_STR, 255);
						$stmt->execute();
						$rows = $stmt->fetchAll();
						
						if (sizeof($rows) == 1) {
							$row = $rows[0];
							if (sizeof($row) == 10) {
								$user = new User();
								$user->userId 	 = $id;
								$user->firstName = $row[0];
								$user->lastName  = $row[1];
								$user->email     = $row[2];
								$user->telNo     = $row[3];
								$user->userName  = $row[4];
								$result = $GLOBALS['USERS'][$id] = $user;
								vdd($GLOBALS['USERS']);
							}
						}
				}
			return $result;
		}
		
		public static function Load($id)
		{
			$result = false;
				if (array_key_exists($id, $GLOBALS['USERS'])) { $result = $GLOBALS['USERS'][$id]; }
				else {
						if($stmt = Database::GetLink()->prepare('SELECT `fname`, `lname`, `email`, `telno`, `user_name` FROM `User` WHERE `user_id` = ?'))
						{
							$stmt->bindParam(1, $id, PDO::PARAM_STR, 255);
							$stmt->execute();
							$rows = $stmt->fetchAll();
							
							if (sizeof($rows) == 1) {
								$row = $rows[0];
								if (sizeof($row) == 10) {
									$user = new User();
									$user->userId 	 = $id;
									$user->firstName = $row[0];
									$user->lastName  = $row[1];
									$user->email     = $row[2];
									$user->telNo     = $row[3];
									$user->userName  = $row[4];
									$result = $GLOBALS['USERS'][$id] = $user;
								}
							}
						}
				}
			return $result;
		}
	}
}
?>