<?php
if (defined('securipe') or exit(1))
{
	class Login
	{
		public static function GetStatus() { return $GLOBALS['LOGIN']; }
		
		private $_id = null;
		private $_username = EMPTYSTRING;
		private $_attempts = EMPTYSTRING;
		private $_error = EMPTYSTRING;
		
		public function IsLoggedIn() { return ($this->_id != null); }
		public function GetId() { return $this->_id; }
		public function GetUsername() { return $this->_username; }
		public function GetError() { return $this->_error; }
		
		public function __construct()
		{
			if (Value::SetAndNotNull($_SESSION, "sup3rsEcurevariAble")) {
				$this->_id = $_SESSION["sup3rsEcurevariAble"];
			} else { $this->_id = $_SESSION['sup3rsEcurevariAble'] = 0; }
			
			if (Value::SetAndNotNull($_SESSION, "supErsecurevAri4bl3")) {
				$this->_username = $_SESSION["supErsecurevAri4bl3"];
			} else { $this->_username = $_SESSION['supErsecurevAri4bl3'] = 0; }
			
			if (Value::SetAndNotNull($_SESSION, "fail3d4ttempt5")) {
				$this->_attempts = $_SESSION["fail3d4ttempt5"];
			} else { $this->_attempts = $_SESSION['fail3d4ttempt5'] = 0; }
		}
		
		private function HasLoginInput()
		{
			$hasuser = Value::SetAndNotNull($_POST, 'loginname');
			$haspass = Value::SetAndNotNull($_POST, 'loginpass');
			return ($hasuser && $haspass);
		}
		
		private function FetchBanStatus()
		{
			//$ip = htmlentities($_SERVER['REMOTE_ADDR']);
			//$iprox = EMPTYSTRING;
			//if (Value::SetAndNotNull($_SERVER, 'HTTP_X_FORWARDED_FOR')) {
			//	htmlentities($_SERVER['HTTP_X_FORWARDED_FOR']);
			//}
			//
			//$bantime = -1;
			//if ($stmt = Database::GetLink()->prepare('SELECT timestamp FROM users WHERE ban WHERE ip=? OR ip_proxy=? OR sessionid=?;')) {
			//	$stmt->bindparam($username);
			//	$stmt->execute();
			//	$stmt->bindresult($salt);
			//	$stmt->fetch();
			//	$stmt->close();
			///*if ($stmt = Database::GetLink()->prepare('SELECT timestamp FROM ban WHERE ip=? OR ip_proxy=? OR sessionid=?;')) {
			//	$stmt->bind_param('sss', $ip, $iprox, session_id());
			//	$stmt->execute();
			//	$stmt->bind_result($result);
			//	$stmt->fetch();
			//	$stmt->close();*/
			//	if ($result != null) {
			//		$bantime = $result;
			//		$this->_id = $_SESSION['sup3rsEcurevariAble'] = -1;
			//		$this->_error = $_SESSION['3rr0r'] = 'Oh noes, looks like you were temporarily banned, check back again tomorrow... ';
			//	}
			//}
			//return !($bantime < 0 || (time() - $bantime) > 86400);
			return false;
		}
		
		private function FetchUserSalt($username)
		{
			$result = EMPTYSTRING;
			if ($stmt = Database::GetLink()->prepare('SELECT personal_salt FROM login WHERE username_hash=?')) {
				$stmt->bindParam(1, $username, PDO::PARAM_STR, 255);
				$stmt->execute();
				$stmt->bindColumn(1, $salt);
				$stmt->fetch();
				$stmt->closeCursor();
				if ($salt != null) { $result = $salt; }
			}
			return $result;
		}
		
		private function FetchUsername($userid)
		{
			$result = false;
			if ($stmt = Database::GetLink()->prepare('SELECT user_name FROM users WHERE user_id=?;')) {
				$stmt->bindParam(1, $userid, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->bindColumn(1, $username);
				$stmt->fetch();
				$stmt->closeCursor();
				if ($username != null) {
					$result = $username;
				}
			}
			return $result;
		}
		
		public static function TryToLogin()
		{
			$instance = Login::GetStatus();
			
			$result = false;
			// Check https and ban status
			if ($instance->FetchBanStatus() === false) {
				// Try login
				if ($instance->HasLoginInput()) {
					$username = hash('sha512', $_POST['loginname']);
					$salt = array('static' => '92bf5/624073"e03_6eA 98$6a83e.76', 'dynamic' => $instance->FetchUserSalt($username));
					
					if ($salt['dynamic'] != '') {
						$password = hash('sha512', $salt['static'].$_POST['loginpass'].$salt['dynamic'].$username);
						
						if ($stmt = Database::GetLink()->prepare('SELECT user_id FROM login WHERE username_hash=? AND password_hash=?;')) {
							$stmt->bindParam(1, $username, PDO::PARAM_STR, 255);
							$stmt->bindParam(2, $password, PDO::PARAM_STR, 255);
							$stmt->execute();
							$stmt->bindColumn(1, $success);
							$stmt->fetch();
							$stmt->closeCursor();
							
							if (Value::SetAndNotNull($success)) {
								$instance->_id = $_SESSION['sup3rsEcurevariAble'] = $success;
								$instance->_username = $_SESSION['supErsecurevAri4bl3'] = $instance->FetchUsername($success);
								$instance->_error = $_SESSION['fail3d4ttempt5'] = 0;
								$result = true;
							} else {
								$instance->LogFailedAttempt($username);
							}
						}
					} else {
						$instance->LogFailedAttempt($username);
					}
				}
			}
			return $result;
		}
		
		public static function LogOut()
		{
			$instance = Login::GetStatus();
			$instance->_id = $_SESSION['sup3rsEcurevariAble'] = 0;
			$instance->_username = $_SESSION['supErsecurevAri4bl3'] = EMPTYSTRING;
			Site::BackToHome();
		}
		
		private function BanClient($username)
		{
			// Banning not yet implemented
			/*$ip = htmlentities($_SERVER['REMOTE_ADDR']);
			$iprox = EMPTYSTRING;
			if (Value::SetAndNotNull($_SERVER, 'HTTP_X_FORWARDED_FOR')) {
				htmlentities($_SERVER['HTTP_X_FORWARDED_FOR']);
			}
			
			if ($stmt = Database::GetLink()->prepare('INSERT INTO ban (ip, ip_proxy, sessionid, username, timestamp) VALUES (?, ?, ?, ?, ?);')) {
				$stmt->bind_param('ssssi', $ip, $iprox, session_id(), $username, time());
				$stmt->execute();
				$stmt->close();
			}*/
		}
		
		private function LogFailedAttempt($username=EMPTYSTRING)
		{
			// Banning not yet implemented
			/*$this->_attempts = $_SESSION['fail3d4ttempt5']++;
			$tryleft = 3 - $_SESSION['fail3d4ttempt5'];
			
			if ($tryleft <= 0) {
				$this->BanClient($username);
			} else {
				$this->_error = $_SESSION['3rr0r'] = 'Oh noes, failed to log in... only '.$tryleft.' trys remaining...';
			}*/
		}
	}
	
	//$GLOBALS['LOGIN'] = new Login();
	//if (Value::SetAndEquals('logout', $_GET, 'action')) { Login::LogOut(); }
	//if (Login::GetStatus()->GetUsername() == EMPTYSTRING) { Login::TryToLogin(); }
}
?>