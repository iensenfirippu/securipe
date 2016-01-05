<?php
if (defined('securipe') or exit(1))
{
	define('LOGIN_USERID', md5(STATIC_SALT.'user_idnumber'));
	define('LOGIN_USERNAME', md5(STATIC_SALT.'user_username'));
	define('LOGIN_ATTEMPTS', md5(STATIC_SALT.'failed_login_attempts'));
	define('LOGIN_PRIVILEGE', md5(STATIC_SALT.'privelege_level'));
	define('LOGIN_ERROR', md5(STATIC_SALT.'error_message'));
	
	/**
	 * Contains logic for logging in and out of securipe
	 */
	class Login
	{
		/**
		 * Returns whether there is a user logged in or not.
		 */
		public static function IsLoggedIn() { return (Login::GetId() > 0); }
		/**
		 * Returns the id of the user logged in, if applicable.
		 */
		public static function GetId() { return $_SESSION[LOGIN_USERID]; }
		/**
		 * Returns the username of the user logged in, if applicable.
		 */
		public static function GetUsername() { return $_SESSION[LOGIN_USERNAME]; }
		/**
		 * Returns amount of failed login attempts, if applicable.
		 */
		public static function GetAttempts() { return $_SESSION[LOGIN_ATTEMPTS]; }
		/**
		 * Returns error message that was generated during login, if applicable.
		 */
		public static function GetError() { return $GLOBALS[LOGIN_ERROR]; }
		
		public static function GetPrivilege() {
			$level = 0;
			$char = substr($_SESSION[LOGIN_PRIVILEGE],-1,1);
			if (is_numeric($char)) {
				$int = intval($char);
				if ($int >= 0 && $int < 4) { $level = $int; }
			}
			return $level;
		}
		
		public static function SetId($value) { $_SESSION[LOGIN_USERID] = $value; }
		public static function SetUsername($value) { $_SESSION[LOGIN_USERNAME] = $value; }
		public static function SetAttempts($value) { $_SESSION[LOGIN_ATTEMPTS] = $value; }
		public static function IncrementAttempts($value=1) { $_SESSION[LOGIN_ATTEMPTS] += $value; }
		public static function SetError($value) { $GLOBALS[LOGIN_ERROR] = $value; }
		public static function SetPrivilege($level) {
			// Obfuscates the privilege level by hiding it inside a random md5 hash
			// "Security through obscurity"
			$rand_str = md5(rand(0,100)."-asdf.".uniqid());
			$obfu_lvl = substr($rand_str,0,-2).$level.substr($rand_str,-1);
			$_SESSION[LOGIN_PRIVILEGE] = $obfu_lvl;
		}
		
		/**
		 * Determines whether or not there is input from the login form.
		 */
		private static function HasLoginInput()
		{
			$hasuser = Value::SetAndNotNull($_POST, 'loginname');
			$haspass = Value::SetAndNotNull($_POST, 'loginpass');
			return ($hasuser && $haspass);
		}
		
		/**
		 * Check in the database, if the current client is banned from the site.
		 */
		public static function FetchBanStatus()
		{
			$ip_adr = htmlentities($_SERVER['REMOTE_ADDR']);
			$ip_prx = EMPTYSTRING;
			if (Value::SetAndNotNull($_SERVER, 'HTTP_X_FORWARDED_FOR')) {
				$ip_prx = htmlentities($_SERVER['HTTP_X_FORWARDED_FOR']);
			}
			$session = session_id();
			
			$bantime = -1;
			if ($stmt = Database::GetLink()->prepare('SELECT banned_until FROM Ban WHERE ip_address=? OR proxy_ip=? OR session_id=?;')) {
				$stmt->bindParam(1, $ip_adr, PDO::PARAM_STR, 45);
				$stmt->bindParam(2, $ip_prx, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $session, PDO::PARAM_STR, 32);
				$stmt->execute();
				$stmt->bindColumn(1, $result);
				$stmt->fetch();
				$stmt->closeCursor();
				if ($result != null && is_numeric($result)) { $bantime = intval($result); }
			}
			return !($bantime < 0 || (time() > $bantime));
		}
		
		/**
		 * Get the corresponding salt from the database, for a given username.
		 * @param username, the username_hash for which to get the salt for.
		 */
		private static function FetchUserSalt($username)
		{
			$result = EMPTYSTRING;
			if ($stmt = Database::GetLink()->prepare('SELECT personal_salt FROM Login WHERE username_hash=? AND disabled=false')) {
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
		 * Get the userid from a given username and password hash.
		 * @param string $username The username hash.
		 * @param string $password (optional) The password hash
		 * @return integer The ID for the requested username hash (or 0 if not found)
		 */
		private static function FetchUserId($username, $password=EMPTYSTRING)
		{
			$result = 0;
			$sql = EMPTYSTRING;
			if (Value::SetAndEqualTo(EMPTYSTRING, $password)) {
				if ($stmt = Database::GetLink()->prepare('SELECT user_id FROM Login WHERE username_hash=?;')) {
					$stmt->bindParam(1, $username, PDO::PARAM_STR, 255);
					$stmt->execute();
					$stmt->bindColumn(1, $id);
					$stmt->fetch();
					$stmt->closeCursor();
					if ($id != null) { $result = $id; }
				}
			} else {
				if ($stmt = Database::GetLink()->prepare('SELECT user_id FROM Login WHERE username_hash=? AND password_hash=?;')) {
					$stmt->bindParam(1, $username, PDO::PARAM_STR, 255);
					$stmt->bindParam(2, $password, PDO::PARAM_STR, 255);
					$stmt->execute();
					$stmt->bindColumn(1, $id);
					$stmt->fetch();
					$stmt->closeCursor();
					if ($id != null) { $result = $id; }
				}
			}
			return $result;
		}
		
		/**
		 * Get the actual username a user with a given id, from the database.
		 * @param userid, the ID of the user for which to get the username.
		 * @return string The username for the requested user ID (or false if not found)
		 */
		private static function FetchUsername($userid)
		{
			$result = false;
			if ($stmt = Database::GetLink()->prepare('SELECT user_name FROM User WHERE user_id=?;')) {
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
		 * Tries to login, given that all the requirements are met.
		 */
		public static function TryToLogin()
		{
			$result = false;
			// Check if the site is connected to via https, and if there is input from the login form
			if (Site::HasHttps() && Login::HasLoginInput()) {
				$username = hash('sha512', $_POST['loginname']);
				$password = $_POST['loginpass'];
				$salt1 = STATIC_SALT; // Static salt
				$salt2 = Login::FetchUserSalt($username); // Dynamic salt
				
				if ($salt2 != EMPTYSTRING) {
					$password = hash('sha512', $salt1.$password.$salt2.$username);
					
					if ($password != EMPTYSTRING) {
						$id = Login::FetchUserId($username, $password);
						
						if ($id > 0) {
							Login::SetId($id);
							Login::SetUsername(Login::FetchUsername($id));
							Login::SetAttempts(0);
							$result = true;
						}
					}
				}
				
				Login::LogAttempt($username, $result);
			}
			return $result;
		}
		
		/**
		 * Logs the user out.
		 */
		public static function LogOut()
		{
			// Clear the session and regenerate the id, on logout
			// ...but make sure that the failed attempts carry over to the new session
			$attempts = Login::GetAttempts();
			session_unset();
			session_regenerate_id();
			Login::SetAttempts($attempts);
			Site::BackToHome();
		}
		
		/**
		 * Bans a client (browser), by IP, Proxy IP AND session ID.
		 * @param username, the username that the client provided (in hashed form, but will be translated if possible).
		 */
		private static function BanClient()
		{
			$now = time();
			$until = $now + ONEDAY;
			$ip_adr = htmlentities($_SERVER['REMOTE_ADDR']);
			$ip_prx = EMPTYSTRING;
			if (Value::SetAndNotNull($_SERVER, 'HTTP_X_FORWARDED_FOR')) {
				$ip_prx = htmlentities($_SERVER['HTTP_X_FORWARDED_FOR']);
			}
			$session = session_id();
			
			if (Value::SetAndNotNull($ip_adr) || Value::SetAndNotNull($ip_prx) || Value::SetAndNotNull($session)) {
				if ($stmt = Database::GetLink()->prepare('INSERT INTO Ban (banned_at, banned_until, ip_address, proxy_ip, session_id) VALUES (?, ?, ?, ?, ?);')) {
					$stmt->bindParam(1, $now, PDO::PARAM_INT);
					$stmt->bindParam(2, $until, PDO::PARAM_INT);
					$stmt->bindParam(3, $ip_adr, PDO::PARAM_STR, 45);
					$stmt->bindParam(4, $ip_prx, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $session, PDO::PARAM_STR, 32);
					$stmt->execute();
					$stmt->closeCursor();
					
					Login::SetAttempts(0);
				}
			}
		}
		
		/**
		 * Log a login attempt to the database (and ban if necessary).
		 * @param string $username The username that the client provided (in hashed form, but will be translated if possible).
		 * @param string $success Whether the login was successful or not.
		 */
		private static function LogAttempt($username, $success)
		{
			$now = time();
			if ($success) { $username = Login::GetUsername(); }
			else {
				$id = Login::FetchUserId($username);
				if ($id > 0) {
					$name = Login::FetchUsername($id);
					if ($name != false) { $username = $name; }
				}
			}
			
			if ($stmt = Database::GetLink()->prepare('INSERT INTO LoginAttempt (occurred_at, username_input, successful) VALUES (?, ?, ?);')) {
				$stmt->bindParam(1, $now, PDO::PARAM_INT);
				$stmt->bindParam(2, $username, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $success, PDO::PARAM_BOOL);
				$stmt->execute();
				$stmt->closeCursor();
			}
			
			if (!$success) {
				Login::IncrementAttempts();
				$tryleft = 3 - Login::GetAttempts();
				
				if ($tryleft <= 0) {
					Login::SetError('You have been banned... have a nice day...');
					Login::BanClient();
				} else {
					Login::SetError('Oh noes, failed to log in... only '.$tryleft.' trys remaining...');
				}
			}
		}
	}
}
?>