<?php
if (defined('securipe') or exit(1))
{
	$GLOBALS['USERS'] = array();
	
	class User
	{
		private $_userid = 0;
		private $_username = EMPTYSTRING;
		private $_firstname = EMPTYSTRING;
		private $_lastname = EMPTYSTRING;
		private $_email = EMPTYSTRING;
		private $_telephone = EMPTYSTRING;
		
		private $_login_username = null;
		private $_login_password = null;
		private $_login_personalsalt = null;
		
		public function GetId() { return $this->_userid; }
		public function GetUserName(){ return $this->_username;}
		public function GetFirstName() { return $this->_firstname; }
		public function GetLastName() { return $this->_lastname; }
		public function GetEmail() { return $this->_email; }
		public function GetTelNo() { return $this->_telephone; }
		
		/*public function GetUserNameHashed() { return $this->_login_username; }
		public function GetPasswordHashed() { return $this->_login_password; }
		public function GetPersonalSalt() { return $this->_login_personalsalt; }*/
		
		public function SetUsername($_username){ $this->_username = $_username;}
		public function SetFirstName($value) { $this->_firstname  = $value; }
		public function SetLastName($value) { $this->_lastname = $value; }
		public function SetEmail($value) { $this->_email = $value; }
		public function SetTelNo($value) { $this->_telephone = $value; }
		
		function __construct()
		{
		}
		
		public function create($_username, $_password, $_firstname, $_lastname, $_email, $_telephone)
		{
			$this->_username = $_username;
			$this->hashUserNameAndPassword($_password);
			$this->_firstname = $_firstname;
			$this->_lastname = $_lastname;
			$this->_email = $_email;
			$this->_telephone = $_telephone;
		}
		
		public function hashUserNameAndPassword($_password)
		{
			$md5UserName = md5($this->_username);
			$md5UserNameAndPassword = md5($this->_username.$_password); //$userName.$password
			$this->_login_username = hash('sha512', $md5UserName); //userNameHash $sha512Ofmd5UserName
			$this->_login_personalsalt = hash("sha512", UUID::Create()); // dynamic salt personal salt sha512OfUUID
			$this->_login_password = hash("sha512", STATIC_SALT.$md5UserNameAndPassword.$this->_login_personalsalt.$this->_login_username );
		}
		
		public static function checkIfExits($_username)
		{
			$return;
			if($stmt = Database::GetLink()->prepare(" SELECT count(user_name) FROM User WHERE user_name = ? LIMIT 1"))
			{		
				$stmt->bindParam(1, $_username, PDO::PARAM_STR, 255);
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
			$return = false;
			
			$userName = $this->_login_username;
			$passwordHashed = $this->_login_password;
			$personalSalt = $this->_login_personalsalt;
			$disabled = 0;
			
			if($stmt = Database::GetLink()->prepare('INSERT INTO Login(user_id, username_hash, password_hash, personal_salt, disabled) VALUES (?,?,?,?,?)'))
			{
				$stmt->bindParam(1, $this->_userId, PDO::PARAM_INT);
				$stmt->bindParam(2, $userName, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $passwordHashed, PDO::PARAM_STR, 255);
				$stmt->bindParam(4, $personalSalt, PDO::PARAM_STR, 255);
				$stmt->bindParam(5, $disabled, PDO::PARAM_INT);

				if ($stmt->execute()) {
					$return = true;
				}
				
				$stmt->closeCursor();
				//$arr1 = $stmt->errorInfo();
				//$arr2 = $stmt->errorInfo();
				//$arr3 = $stmt->errorInfo();
			}
			
			return $return;
		}
		
		/*public function updateHash()
		{
			$md5UserName = md5($this->_username);
			$md5UserNameAndPassword = md5($this->_username.$_password); //$userName.$password
			$this->_login_username = hash('sha512', $md5UserName); //userNameHash $sha512Ofmd5UserName
			$this->_login_personalsalt = Login::FetchUserSalt($this->_login_username) // dynamic salt personal salt sha512OfUUID
			$this->_login_password = hash("sha512", STATIC_SALT.$md5UserNameAndPassword.$this->_login_personalsalt.$this->_login_username );
			
			$passwordHashed = $this->GetPasswordHashed();
			
			if($stmt = Database::GetLink()->prepare('UPDATE Login SET password_hash=? WHERE user_id=?;'))
			{
				$stmt->bindParam(1, $passwordHashed, PDO::PARAM_STR, 255);
				$stmt->bindParam(2, $this->_userId);
				$stmt->execute();
				
				$stmt->closeCursor();
			}	
		}*/
		
		public function save()
		{
			$result = false;
			
			$_firstname = $this->GetFirstName();
			$_lastname = $this->GetLastName();
			$_email = $this->GetEmail();
			$_telephone = $this->GetTelNo();
			$_username = $this->GetUserName();
			
			if ($stmt = Database::GetLink()->prepare('INSERT INTO `User`(`fname`, `lname`, `email`, `telno`, `user_name`, `privilege_level`) VALUES (?,?,?,?,?,1)'))
			{		
				$stmt->bindParam(1, $_firstname, PDO::PARAM_STR, 255);
				$stmt->bindParam(2, $_lastname, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $_email, PDO::PARAM_STR, 255);
				$stmt->bindParam(4, $_telephone, PDO::PARAM_STR, 255);
				$stmt->bindParam(5, $_username,PDO::PARAM_STR, 255);
			  
				if ($stmt->execute()) {
					$stmt->closeCursor();
					$id = Database::GetLink()->lastInsertId();
					$this->_userId = $id;
					if ($this->saveHash()) {
						$return = true;
					}
				} else { $stmt->closeCursor(); }
				//$this->load($_username);
			}
			
			return $return;
		}
		
		/*public static function LoadFromName($_username)
		{
			$result = false;
			if($stmt = Database::GetLink()->prepare('SELECT `user_id`, `fname`, `lname`, `email`, `telno` FROM `User` WHERE user_name = ?')) {
				$stmt->bindParam(1, $_username, PDO::PARAM_STR, 255);
				$stmt->execute();
				$rows = $stmt->fetchAll();
				
				if (sizeof($rows) == 1) {
					$row = $rows[0];
					if (sizeof($row) == 10) {
						$user = new User();
						$user->userId = $row[0];
						$user->firstName = $row[1];
						$user->lastName = $row[2];
						$user->email = $row[3];
						$user->telNo = $row[4];
						$user->userName = $row[5];
						$result = $GLOBALS['USERS'][$id] = $user;
						//vdd($GLOBALS['USERS']);
					}
				}
			}
			return $result;
		}*/
		
		public static function Load($id)
		{
			$result = false;
			if (array_key_exists($id, $GLOBALS['USERS'])) { $result = $GLOBALS['USERS'][$id]; }
			else {
				if ($stmt = Database::GetLink()->prepare('SELECT `fname`, `lname`, `email`, `telno`, `user_name` FROM `User` WHERE `user_id` = ?'))
				{
					$stmt->bindParam(1, $id, PDO::PARAM_STR, 255);
					$stmt->execute();
					$rows = $stmt->fetchAll();
					
					if (sizeof($rows) == 1) {
						$row = $rows[0];
						if (sizeof($row) == 10) {
							$user = new User();
							$user->_userid = $id;
							$user->_firstname = $row[0];
							$user->_lastname = $row[1];
							$user->_email = $row[2];
							$user->_telephone = $row[3];
							$user->_username = $row[4];
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