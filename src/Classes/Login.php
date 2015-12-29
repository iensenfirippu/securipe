<?php
if (defined('securipe') or exit(1))
{
	/**
	 * Contains logic for logging in and out of securipe
	 */
	class Login
	{
		/**
		 * Returns the status of the currently logged in user, if applicable ($GLOBALS['LOGIN'])
		 */
		public static function GetStatus() { return $GLOBALS['LOGIN']; }
		
		private $_id = null;
		private $_username = EMPTYSTRING;
		private $_attempts = EMPTYSTRING;
		private $_error = EMPTYSTRING;
		
		/**
		 * Returns whether there is a user logged in or not.
		 */
		public function IsLoggedIn() { return ($this->_id != null); }
		/**
		 * Returns the id of the user logged in, if applicable.
		 */
		public function GetId() { return $this->_id; }
		/**
		 * Returns the username of the user logged in, if applicable.
		 */
		public function GetUsername() { return $this->_username; }
		/**
		 * Returns error message that was generated during login, if applicable.
		 */
		public function GetError() { return $this->_error; }
		
		/**
		 * Contains logic for logging in and out of securipe
		 */
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
		
		/**
		 * Determines whether or not there is input from the login form.
		 */
		private function HasLoginInput()
		{
			$hasuser = Value::SetAndNotNull($_POST, 'loginname');
			$haspass = Value::SetAndNotNull($_POST, 'loginpass');
			return ($hasuser && $haspass);
		}
		
		/**
		 * Check in the database, if the current client is banned from the site.
		 */
		private function FetchBanStatus()
		{
			$ip = htmlentities($_SERVER['REMOTE_ADDR']);
			$iprox = EMPTYSTRING;
			if (Value::SetAndNotNull($_SERVER, 'HTTP_X_FORWARDED_FOR')) {
				htmlentities($_SERVER['HTTP_X_FORWARDED_FOR']);
			}
			
			$bantime = -1;
			if ($stmt = Database::GetLink()->prepare('SELECT timestamp FROM Ban WHERE ban WHERE ip=? OR ip_proxy=? OR sessionid=?;')) {
				$stmt->bindParam(1, $ip, PDO::PARAM_STR);
				$stmt->bindParam(2, $ip_proxy, PDO::PARAM_STR);
				$stmt->bindParam(3, $session_id, PDO::PARAM_STR);
				$stmt->execute();
				$stmt->bindColumn(1, $result);
				$stmt->fetch();
				$stmt->closeCursor();
				if ($result != null) {
					$bantime = $result;
					$this->_id = $_SESSION['sup3rsEcurevariAble'] = -1;
					$this->_error = $_SESSION['3rr0r'] = 'Oh noes, looks like you were temporarily banned, check back again tomorrow... ';
				}
			}
			return !($bantime < 0 || (time() - $bantime) > ONEDAY);
			//return false;
		}
		
		/**
		 * Get the corresponding salt from the database, for a given username.
		 * @param username, the username_hash for which to get the salt for.
		 */
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
		
		/**
		 * Get the actual username a user with a given id, from the database.
		 * @param userid, the ID of the user for which to get the username.
		 */
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
		
		/**
		 * Tries to login, given that all the prerequisites are fullfilled.
		 */
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
					
					if ($salt['dynamic'] != EMPTYSTRING) {
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
		
		/**
		 * Logs the user out.
		 */
		public static function LogOut()
		{
			$instance = Login::GetStatus();
			$instance->_id = $_SESSION['sup3rsEcurevariAble'] = 0;
			$instance->_username = $_SESSION['supErsecurevAri4bl3'] = EMPTYSTRING;
			Site::BackToHome();
		}
		
		/**
		 * Bans a client (browser), by IP, Proxy IP AND session ID.
		 * @param username, the username that the client provided (in hashed form, but will be translated if possible).
		 */
		private function BanClient($username=EMPTYSTRING)
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
		
		/**
		 * Log a failed login attempt.
		 * @param username, the username that the client provided (in hashed form, but will be translated if possible).
		 */
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